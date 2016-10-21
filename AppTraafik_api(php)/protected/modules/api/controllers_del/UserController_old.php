<?php
class UserController extends GxController {
	public $loginForm = null;
	public $caseSensitiveUsers = true;
	public $returnAdminUrl = null;
	// LoginType :
	const LOGIN_BY_USERNAME = 1;
	const LOGIN_BY_EMAIL = 2;
	const LOGIN_BY_LDAP = 32;
	// Allow login only by username by default.
	public $loginType = 2;
	public $defaultAction = 'admin';
	public function filters() {
		return array (
				'accessControl' 
		);
	}
	public function accessRules() {
		return array (
				array (
						'allow', // allow all users to perform 'index' and 'view' actions
						'actions' => array (
								'search',
								'accountVerify',
								'create',
								'login',
								'view',
								'recover',
								'download',
								'signup',
								'search',
								'check',
								'reports',
								'reportCauses' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow', // allow authenticated user to perform
						'actions' => array (
								'logout',
								'update',
								'profile',
								'start',
								'invite',
								'inviteFriends',
								'getInvitedList',
								'updateInvitation',
								'getInvitee',
								'userFriends' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'allow', // allow admin user to perform
						'actions' => array (
								'admin',
								'delete' 
						),
						'expression' => 'Yii::app()->user->isAdmin' 
				),
				array (
						'deny',
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	
	/**
	 * API to Check Server connection
	 */
	public function actionCheck() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		if (! Yii::app ()->user->isGuest) {
			$id = Yii::app ()->user->id;
			$model = User::model ()->findByPk ( $id );
			$arr ['status'] = 'OK';
			$arr ['profile'] = $model->toArray ();
		}
		if (isset ( $_POST ['AuthSession'] )) {
			$headers = getallheaders ();
			$auth_code = isset ( $headers ['auth_code'] ) ? $headers ['auth_code'] : null;
			if ($auth_code == null)
				$auth_code = Yii::app ()->request->getQuery ( 'auth_code' );
			if ($auth_code) {
				$auth_session = AuthSession::model ()->findByAttributes ( array (
						'auth_code' => $auth_code 
				) );
				if ($auth_session)
					$auth_session->device_token = $_POST ['AuthSession'] ['device_token'];
				if ($auth_session->saveAttributes ( array (
						'device_token' 
				) ))
					$arr ['auth_session'] = 'Auth Session updated';
				else {
					$err = '';
					foreach ( $model->getErrors () as $error )
						$err .= implode ( ".", $error );
					$arr ['error'] = $err;
				}
			} else
				$arr ['error'] = 'Auth code not found';
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionChangepassword($id = null) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		if ($id == null)
			$id = Yii::app ()->user->id;
		
		$model = User::model ()->findByPk ( $id );
		if ($model) {
			if (isset ( $_POST ['User'] ) && isset ( $_POST ['User'] ['password'] )) {
				if ($model->setPassword ( $_POST ['User'] ['password'], $_POST ['User'] ['password_2'] )) {
					$model->password = null; // empty it
					$arr ['success'] = 'Password successfully changed!';
					$arr ['status'] = 'OK';
				} else
					$arr ['error'] = "Failed to change password!";
			} else
				$arr ['error'] = "New password not set!";
		} else
			$arr ['error'] = "User not found !";
		
		$this->sendJSONResponse ( $arr );
	}
	public function actionSearch() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$model = new User ( 'search' );
		$model->unsetAttributes ();
		if (isset ( $_POST ['User'] )) {
			$model->setAttributes ( $_POST ['User'] );
			$results = $model->search ();
			if ($results) {
				$json_entry = array ();
				foreach ( $results->getData () as $entry ) {
					$json_entry [] = $entry->toArray ();
				}
				$arr ['list'] = $json_entry;
				$arr ['status'] = 'OK';
			} else {
				$arr ['error'] = 'No results found..!';
			}
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionReportCauses($id) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		if ($id) {
			$report = Report::model ()->findByPk ( $id );
			if ($report) {
				$causes = $report->reportCauses;
				if ($causes) {
					$jsonlist = array ();
					foreach ( $causes as $cause ) {
						$jsonlist [] = $cause->toArray ();
					}
					$arr ['list'] = $jsonlist;
					$arr ['status'] = 'OK';
				} else {
					$arr ['error'] = 'No Category found..!';
				}
			} else {
				$arr ['error'] = 'No Station found..!';
			}
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionReports() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$reports = Report::model ()->findAll ();
		if ($reports) {
			$reportlist = array ();
			foreach ( $reports as $report ) {
				$reportlist [] = $report->toArray ();
			}
			$arr ['list'] = $reportlist;
			$arr ['status'] = 'OK';
		} else {
			$arr ['error'] = 'No record found!';
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionSignup($fb = 0) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		$model = new User ();
		
		if (isset ( $_POST ['User'] )) {
			$model->attributes = $_POST ['User'];
			
			if ($fb == 0) {
				// ===================Email,contact_no,Full_name--signup===================
				
				// contact_no,email = 0, full_name =1
				$signup_check = 0;
				
				// if contact_no or email exist then merge
				$user = User::getUserByEmail ( $model->email );
				if (! $user)
					$user = User::getUserBycontact_no ( $model->mobile );
					
					// if username ie full_name exist then show error
					// if (!$user)
				{
					$user1 = User::getUserByName ( $model->full_name );
					if ($user1)
						$signup_check = 1;
				}
				
				if ($signup_check == 0) {
					
					if ($user)
						$model = $user;
						// $model->attributes = $_POST['User'];
					
					try {
						if ($model->save ()) {
							if (isset ( $_POST ['User'] ['password'] ) && $model->setPassword ( $_POST ['User'] ['password'] )) {
								$arr ['status'] = 'OK';
								if ($model->state_id == User::STATUS_INACTIVE) {
									$arr ['success'] = 'Thank you for registering with us. Please check your email to activate your account.';
								} else {
									$arr ['success'] = 'Thank you for registering with us. You can login now using your email ID and password.';
								}
							} else {
								$arr ['error'] = "password not set";
							}
						} else {
							$err = '';
							foreach ( $model->getErrors () as $error )
								$err .= implode ( ".", $error );
							$arr ['error'] = $err;
						}
					} catch ( Exception $e ) {
						$arr ['error'] = "Email/contact_no ID already in use. Try recovering from Web if you lost the password.";
					}
				}  // email/moble exit will merge, and-if username already not-exist
else
					$arr ['error'] = "Username already exist";
			}  // if Email,contact_no,Full_name--signup
else {
				// ===================Facebook-signup===================
				// fb_id,fb_token(changed),first,last,email
				
				if ($_POST ['User'] ['email'] != '') {
					$user = User::getUserByEmail ( $model->email );
					if ($user)
						$model = $user;
				}
				// ----
				try {
					if ($model->save ()) {
						$arr ['status'] = 'OK';
						if ($model->state_id == User::STATUS_INACTIVE) {
							$arr ['success'] = 'Thank you for registering with us. Please check your email to activate your account.';
						} else {
							$arr ['success'] = 'Thank you for registering with us. You can login now using your email ID and password.';
						}
					} else {
						$err = '';
						foreach ( $model->getErrors () as $error )
							$err .= implode ( ".", $error );
						$arr ['error'] = $err;
					}
				} catch ( Exception $e ) {
					$arr ['error'] = "Email/contact_no ID already in use. Try recovering from Web if you lost the password.";
				}
			} // else facebook signup
		} // if POST method
		$this->sendJSONResponse ( $arr );
	}
	public function actionProfile($id = null) // UserDetail
{
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		if ($id == null)
			$id = Yii::app ()->user->id;
		$result = User::model ()->findByPk ( $id );
		if ($result) {
			$arr ['list'] = $result->toArray ();
			$arr ['status'] = 'OK';
		} else {
			$arr ['error'] = 'No detail found';
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionUpdate() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$id = Yii::app ()->user->id;
		$model = $this->loadModel ( $id, 'User' );
		if (isset ( $_POST ['User'] )) {
			$model->setAttributes ( $_POST ['User'] );
			if ($model->save ()) {
				$model->saveUploadedFile ( $model, 'image_file' );
				$arr ['profile'] = $model->toArray ();
				$arr ['status'] = 'OK';
			} else {
				$err = '';
				foreach ( $model->getErrors () as $error )
					$err .= implode ( ".", $error );
				$arr ['error'] = $err;
			}
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionLogin() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$model = new LoginForm ();
		
		if (isset ( $_POST ['LoginForm'] )) {
			//var_dump($_POST);die;
			$model->attributes = $_POST ['LoginForm'];
			
			// validate user input and redirect to the previous page if valid
			if ($model->validate () && $this->authenticate ( $model )) {
				$auth_session = AuthSession::newSession ( $model );
				$arr ['auth_code'] = $auth_session->auth_code;
				$arr ['id'] = Yii::app ()->user->id;
				$arr ['status'] = 'OK';
				$arr ['success'] = 'you have successfully Login';
				
				/*
				 * if($_POST['LoginForm']['invitation_email'])
				 * {
				 * $invitation = Invitation::model()->findByAttributes(array('email' => $invite['email'] ));
				 * if($invitation)
				 * {
				 * $invitation->to_user_id = Yii::app()->user->id;
				 * $invitation->save();
				 * }
				 * }
				 */
			} else {
				$err = '';
				foreach ( $model->getErrors () as $error )
					$err .= implode ( ".", $error );
				$arr ['error'] = $err;
			}
		}
		$this->sendJSONResponse ( $arr );
	}
	public function authenticate($user) {
		// var_dump($user->username);die;
		$identity = new UserIdentity ( $user->username, $user->password );
		$identity->authenticateApi ();
		switch ($identity->errorCode) {
			case UserIdentity::ERROR_NONE :
				$duration = 3600 * 24 * 30; // 30 days
				Yii::app ()->user->login ( $identity, $duration );
				return $user;
				break;
			case UserIdentity::ERROR_EMAIL_INVALID :
				$user->addError ( "password", Yii::t ( 'app', 'Username or Password is incorrect' ) );
				break;
			case UserIdentity::ERROR_STATUS_INACTIVE :
				$user->addError ( "status", Yii::t ( 'app', 'This account is not activated.' ) );
				break;
			case UserIdentity::ERROR_STATUS_BANNED :
				$user->addError ( "status", Yii::t ( 'app', 'This account is blocked.' ) );
				break;
			case UserIdentity::ERROR_STATUS_REMOVED :
				$user->addError ( 'status', Yii::t ( 'app', 'Your account has been deleted.' ) );
				break;
			case UserIdentity::ERROR_STATUS_USER_DOES_NOT_EXIST :
				$user->addError ( 'status', Yii::t ( 'app', 'User doesnt exits.' ) );
				break;
			case UserIdentity::ERROR_PASSWORD_INVALID :
				Yii::log ( Yii::t ( 'app', 'Password invalid for user {username} (Ip-Address: {ip})', array (
						'{ip}' => Yii::app ()->request->getUserHostAddress (),
						'{username}' => $user->username 
				) ), 'error' );
				
				if (! $user->hasErrors ())
					$user->addError ( "password", Yii::t ( 'app', 'Password is incorrect' ) );
				break;
		}
		return false;
	}
	public function actionLogout() {
		$id = Yii::app ()->user->id;
		$model = $this->loadModel ( $id, 'User' );
		$model->last_visit_time = date ( "Y-m-d H:i:s" ); // new CDbExpression('NOW()');
		$model->save ();
		
		Yii::app ()->user->logout ();
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'OK' 
		);
		$this->sendJSONResponse ( $arr );
	}
	public function actionInvite() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		if (isset ( $_POST ['Invitation'] )) {
			$invitation = new Invitation ();
			$invitation->setAttributes ( $_POST ['Invitation'] );
			
			$invitation->type_id = Invitation::TYPE_FACEBOOK;
			
			if ($invitation->save ()) {
				$arr ['status'] = 'OK';
			} else {
				$arr ['post'] = $_POST;
				foreach ( $invitation->getErrors () as $error )
					$err = implode ( ".", $error );
				$arr ['error'] = $err;
			}
		} else {
			$arr ['error'] = 'Post data not received..!';
		}
		
		$this->sendJSONResponse ( $arr );
	}
	
	/**
	 * Invitation[email]
	 * Invitation[name]
	 * Invitation[contact_no]
	 * Invitation[contact_details]
	 */
	public function actionInviteFriends() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		if (isset ( $_POST ['Invitation'] )) {
			foreach ( $_POST ['Invitation'] as $invite ) {
				$search_email = Invitation::model ()->findByAttributes ( array (
						'email' => $invite ['email'] 
				) );
				if (! $search_email) {
					$invitation = new Invitation ();
					
					// $invitation->setAttributes($_POST['Invitation']);
					$invitation->email = $invite ['email']; // $_POST['Invitation']['email'];
					$invitation->name = $invite ['name']; // $_POST['Invitation']['name'];
					                                     // $invitation->contact_no = $invite['contact_no'];//$_POST['Invitation']['contact_no'];
					                                     // $invitation->contact_details = $invite['contact_details'];//$_POST['Invitation']['contact_details'];
					
					$invitation->type_id = Invitation::TYPE_FACEBOOK;
					
					if ($invitation->save ()) {
						$arr ['status'] = 'OK';
					} else {
						$arr ['post'] = $_POST;
						foreach ( $invitation->getErrors () as $error )
							$err = implode ( ".", $error );
						$arr ['error'] = $err;
					}
				}
			}
		} else {
			$arr ['error'] = 'post data not found..!';
		}
		
		$this->sendJSONResponse ( $arr );
	}
	public function actionGetInvitedList() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$results = Invitation::model ()->findAllByAttributes ( array (
				'create_user_id' => Yii::app ()->user->id 
		) );
		if ($results) {
			$json_entry = array ();
			foreach ( $results as $result ) {
				$json_entry [] = $result->toArray ();
			}
			$arr ['list'] = $json_entry;
			$arr ['status'] = 'OK';
		} else {
			$arr ['error'] = 'No results found..!';
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionUpdateInvitation() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		if ($_POST ['Invitation'] ['email']) {
			$invitation = Invitation::model ()->findByAttributes ( array (
					'email' => $_POST ['Invitation'] ['email'] 
			) );
			if ($invitation) {
				$invitation->to_user_id = Yii::app ()->user->id;
				if ($invitation->save ()) {
					$arr ['data'] = $invitation->toArray ();
					$arr ['status'] = 'OK';
					$arr ['message'] = 'You are invited by ' . $invitation->name;
				} else {
					$arr ['post'] = $_POST;
					foreach ( $invitation->getErrors () as $error )
						$err = implode ( ".", $error );
					$arr ['error'] = $err;
				}
			} else {
				$arr ['error'] = 'No results found..!';
			}
		} else {
			$arr ['error'] = 'No data on POST ..!';
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionGetInvitee() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		if (isset ( $_POST ['Invitation'] )) {
			$invitation = Invitation::model ()->findByAttributes ( array (
					'email' => $_POST ['Invitation'] ['email'],
					'type_id' => Invitation::TYPE_FACEBOOK 
			) );
			
			if ($invitation) {
				$arr ['data'] = $invitation->toArray ();
				$arr ['status'] = 'OK';
			} else {
				$arr ['error'] = 'Invitee not found..!';
			}
		} else {
			$arr ['error'] = 'post data not found..!';
		}
		
		$this->sendJSONResponse ( $arr );
	}
	public function actionUserFriends($id) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => "NOK" 
		);
		$json_entry = array();
		$userGroup = Group::model ()->findByAttributes ( array (
				'user_id' => $id 
		) );
		
		if ($userGroup) {
			$userFriends = UserGroup::model ()->findAllByAttributes ( array (
					'group_id' => $userGroup->id 
			) );
			if ($userFriends) {
				foreach ($userFriends as $userFriend)
				{
					$json_entry [] = $userFriend->toArray ();
					
				}
				$arr ['list'] = $json_entry;
				$arr ['status'] = 'OK';
								
			} else {
				$arr ["message"] = "No Friend Found";
			}
		} else {
			$arr ["message"] = "No User Found";
		}
		
		$this->sendJSONResponse ( $arr );
	}
}