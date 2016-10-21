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
								'report',
								'reportCauses',
								'reports',
								'logout',
								'update',
								'profile',
								'changepassword',
								'posts',
								'nearByPosts',
								'nearByUsers',
								'addUser',
								'getAlluser',
								'createLocation',
								'viewAllLocation' 
						),
						'users' => array (
								'*' 
						) 
				),
				array (
						'allow', // allow authenticated user to perform
						'actions' => array (
								'userFriends',
								'logout',
								'update',
								'profile',
								'updateProfileImg',
								'changepassword',
								'start',
								'invite',
								'inviteFriends',
								'getInvitedList',
								'updateInvitation',
								'getInvitee',
								'addUser',
								'getAlluser' 
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
	
	// ============================================
	/**
	 * test-API to Check Server connection
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
	
	// ============================================
	/**
	 * Change password of an user/ logged in user
	 *
	 * @param int $id        	
	 */
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
				if (! User::validate_password ( $_POST ['User'] ['password'], $model->password ))
					$arr ['error'] = "Current Password is incorrect";
				else {
					if ($model->setPassword ( $_POST ['User'] ['password_2'] )) {
						$model->password = null; // empty it
						$arr ['success'] = 'Password successfully changed!';
						$arr ['status'] = 'OK';
					} else
						$arr ['error'] = "Failed to change password!";
				}
			} else
				$arr ['error'] = "New password not set!";
		} else
			$arr ['error'] = "User not found !";
		
		$this->sendJSONResponse ( $arr );
	}
	
	// ============================================
	/**
	 * Search User
	 */
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
	
	// ============================================
	/**
	 * Get a Report causes list by passing the Report_id param in GET
	 *
	 * @param int $id
	 *        	(report_id)
	 */
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
					$arr ['count'] = count ( $causes );
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
	
	// ============================================
	/**
	 * Get Report types List
	 */
	public function actionReport() {
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
	
	// ============================================
	/**
	 *
	 * @param int $fb
	 *        	if fb = 0 signup by Email,Mobile,Full_name
	 *        	else signup by facebook
	 */
	public function actionSignup($fb = 0) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		$model = new User ( 'create' );
		
		if (isset ( $_POST ['User'] )) {
			// var_dump($_POST);die;
			if ($fb == 0) {
				// ===================Email,Mobile,Full_name--signup===================
				// mobile, email = 0, full_name =1
				$signup_check = 0;
				
				// if mobile or email exist then merge
				$user = User::getUserByEmail ( $model->email );
				if (! $user) {
					$user = User::getUserByMobile ( $model->mobile );
					// if username ie full_name exist then show error
					// if (!$user)
					$user1 = User::getUserByName ( $model->full_name );
					if ($user1)
						$signup_check = 1;
				}
				
				if ($signup_check == 0) {
					
					if ($user)
						$model = $user;
					$model->attributes = $_POST ['User'];
					$model->state_id = User::STATUS_ACTIVE;
					
					try {
						if ($model->save ()) {
							if (isset ( $_POST ['User'] ['password'] ) && $model->setPassword ( $_POST ['User'] ['password'] )) {
								$model->saveUploadedFile ( $model, 'image_file' );
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
						$arr ['error'] = "Email/mobile ID already in use. Try recovering from Web if you lost the password.";
					}
				}  // email/moble exit will merge, and-if username already not-exist
else
					$arr ['error'] = "Username already exist";
			}  // if Email,Mobile,Full_name--signup
else {
				// ===================Facebook-signup===================
				// fb_id,fb_token(changed),first,last,email
				
				if ($_POST ['User'] ['email'] != '') {
					$user = User::getUserByEmail ( $model->email );
					if ($user)
						$model = $user;
					$model->attributes = $_POST ['User'];
					$model->state_id = User::STATUS_ACTIVE;
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
					$arr ['error'] = "Email/mobile ID already in use. Try recovering from Web if you lost the password.";
				}
			} // else facebook signup
		} // if POST method
		$this->sendJSONResponse ( $arr );
	}
	
	// ============================================
	/**
	 * Get User Profile
	 *
	 * @param int $id        	
	 */
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
	
	// ============================================
	/**
	 * User Profile update
	 */
	public function actionUpdate($id) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		// $id = Yii::app()->user->id;
		$model = User::model ()->findByPk ( $id ); // $this->loadModel($id, 'User');
		                                           // $model->scenario = 'update';
		if (isset ( $_POST ['User'] )) {
			// var_dump($_POST['User']);
			$model->setAttributes ( $_POST ['User'] );
			// var_dump($model->setAttributes($_POST['User']));
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
		} else {
			$arr ['error'] = 'User[] params not set';
			$arr ['user_id'] = $id;
		}
		$this->sendJSONResponse ( $arr );
	}
	// ============================================
	/**
	 * User Profile update
	 */
	public function actionUpdateProfileImg() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$id = Yii::app ()->user->id;
		$model = User::model ()->findByPk ( $id );
		// $model->scenario = 'update';
		if (isset ( $_POST ['User'] ['image_file'] )) {
			$model->saveUploadedFile ( $model, 'image_file' );
			$arr ['profile'] = $model->toArray ();
			$arr ['status'] = 'OK';
		} else {
			$arr ['error'] = 'Value not set';
		}
		$this->sendJSONResponse ( $arr );
	}
	// ============================================
	/**
	 */
	public function actionLogin() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$model = new LoginForm ();
		$json = array ();
		if (isset ( $_POST ['LoginForm'] )) {
			$model->attributes = $_POST ['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate () && $this->authenticate ( $model )) {
				// var_dump($user);die;
				$auth_session = AuthSession::newSession ( $model );
				$arr ['auth_code'] = $auth_session->auth_code;
				$arr ['id'] = Yii::app ()->user->id;
				$arr ['status'] = 'OK';
				$arr ['success'] = 'you have successfully Login';
				$user = User::model ()->findByPk ( Yii::app ()->user->id );
				// var_dump($user);
				// $json[] = $user->toArray();
				$json [] = $user->toArrayLogin ();
			} else {
				$err = '';
				foreach ( $model->getErrors () as $error )
					$err .= implode ( ".", $error );
				$arr ['error'] = $err;
			}
		}
		$arr ['user'] = $json;
		$this->sendJSONResponse ( $arr );
	}
	public function authenticate($user) { // var_dump($user->username);die;
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
				//$user->addError ( 'status', Yii::t ( 'app', 'User doesnt exits.' ) );
				$user->addError ( 'status', Yii::t ( 'app', "Ooops !!! Seems like the user account you entered doesn't exist. Would you like to try again or create the account?" ) );
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
	// ============================================
	/**
	 */
	public function actionLogout() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'OK' 
		);
		$id = Yii::app ()->user->id;
		if ($id) {
			$model = $this->loadModel ( $id, 'User' );
			$model->last_visit_time = date ( "Y-m-d H:i:s" ); // new CDbExpression('NOW()');
			$model->save ();
			Yii::app ()->user->logout ();
		} else {
			$arr ['message'] = 'You are logged out';
		}
		$this->sendJSONResponse ( $arr );
	}
	
	// ============================================
	/**
	 */
	public function actionInvite() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$_POST ['Invitation'] ['email'] = "mcmcnc@gmail.com";
		if (isset ( $_POST ['Invitation'] )) {
			$search_invite = Invitation::model ()->findByAttributes ( array (
					'email' => $_POST ['Invitation'] ['email'],
					'create_user_id' => Yii::app ()->user->id 
			) );
			if (! $search_invite) {
				$invitation = new Invitation ();
				$invitation->setAttributes ( $_POST ['Invitation'] );
				
				$invitation->type_id = Invitation::TYPE_FACEBOOK;
				
				if ($invitation->save ()) {
					$arr ['user'] = $invitation->toArray ();
					$arr ['status'] = 'OK';
				} else {
					$arr ['post'] = $_POST;
					foreach ( $invitation->getErrors () as $error )
						$err = implode ( ".", $error );
					$arr ['error'] = $err;
				}
			} else {
				$arr ['error'] = "You have already invited this user";
			}
		} else {
			$arr ['error'] = 'Post data not received..!';
		}
		
		$this->sendJSONResponse ( $arr );
	}
	
	// ============================================
	/**
	 * Invitation[email]
	 * Invitation[name]
	 * Invitation[mobile]
	 * Invitation[contact_details]
	 */
	public function actionInviteFriends() {
		$arr = array ('controller' => $this->id,'action' => $this->action->id,'status' => 'NOK' );
		
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
					                                      // $invitation->mobile = $invite['mobile'];//$_POST['Invitation']['mobile'];
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
	
	// ============================================
	/**
	 */
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
	
	// ============================================
	/**
	 */
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
	
	// ============================================
	/**
	 */
	public function actionGetInvitee() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$_POST ['Invitation'] ['email'] = "mcmcnc@gmail.com";
		
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
	
	// ============================================
	/**
	 * Get the list of friends of an User
	 *
	 * @param int $id
	 *        	(user_id)
	 */
	public function actionUserFriends($id) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => "NOK" 
		);
		$json_entry = array ();
		$userGroup = Group::model ()->findByAttributes ( array (
				'user_id' => $id 
		) );
		
		if ($userGroup) {
			$userFriends = UserGroup::model ()->findAllByAttributes ( array (
					'group_id' => $userGroup->id 
			) );
			if ($userFriends) {
				foreach ( $userFriends as $userFriend ) {
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
	
	// ============================================
	/**
	 * Recover User by email and send new password
	 */
	public function actionRecover() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$model = new User ();
		if (isset ( $_POST ['User'] )) {
			$email = $_POST ['User'] ['email'];
			$user = User::model ()->findByAttributes ( array (
					'email' => $email 
			) );
			if ($user) {
				$password = User::model ()->randomPassword ();
				$user->setPassword ( $password, $password );
				$arr ['email'] = $user->email;
				$arr ['new_password'] = $password;
				$arr ["success"] = "Please check your email to reset your password.";
				$arr ["status"] = "OK";
			} else {
				$arr ["error"] = "Email is not registered";
			}
		}
		$this->sendJSONResponse ( $arr );
	}
	
	// ============================================
	/**
	 * Add a friend by passing user_id in GET
	 *
	 * @param int $id
	 *        	(user_id)
	 */
	public function actionAddUser($id) {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		if ($id != Yii::app ()->user->id) {
			$search_group = Group::model ()->findByAttributes ( array (
					'name' => Yii::app ()->user->name,
					'user_id' => Yii::app ()->user->id 
			) );
			
			if (! $search_group) {
				$group = new Group ();
				$group->name = Yii::app ()->user->name;
				$group->user_id = Yii::app ()->user->id;
				
				if ($group->save ()) {
					$search_usergroup = UserGroup::model ()->findByAttributes ( array (
							'user_id' => $id,
							'group_id' => $group->id 
					) );
					if (! $search_usergroup) {
						$add_usergroup = UserGroup::model ()->saveUser ( $id, $group->id );
						
						if ($add_usergroup == true) {
							$arr ['success'] = " User Added";
							$arr ['status'] = "OK";
						} else
							$arr ['error'] = $add_usergroup;
					} else
						$arr ['error'] = " User already added";
				} else {
					$err = '';
					foreach ( $group->getErrors as $error )
						$err = implode ( ',', $error );
					$arr ['error'] = $err;
				}
			} else {
				$search_usergroup = UserGroup::model ()->findByAttributes ( array (
						'user_id' => $id,
						'group_id' => $search_group->id 
				) );
				if (! $search_usergroup) {
					$add_usergroup = UserGroup::model ()->saveUser ( $id, $search_group->id );
					
					if ($add_usergroup == true) {
						$arr ['success'] = " User Added";
						$arr ['status'] = "OK";
					} else {
						$arr ['error'] = $add_usergroup;
					}
				} else {
					$arr ['error'] = " User already added";
				}
			}
		} else {
			$arr ['error'] = "You can not add yourself";
		}
		$this->sendJSONResponse ( $arr );
	}
	
	// ============================================
	/**
	 */
	public function actionGetAlluser() {
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		
		$users = User::model ()->findAll ();
		$json = array ();
		if ($users) {
			foreach ( $users as $user ) {
				$json [] = $user->toArray ();
			}
			$arr ['Users'] = $json;
			$arr ['status'] = "OK";
		} else {
			$arr ['error'] = "No user registered";
		}
		$this->sendJSONResponse ( $arr );
	}
	public function actionPosts($id) {
		// $id = Yii::app()->user->id;
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$json_array = array ();
		$posts = Post::model ()->findAllByAttributes ( array (
				'create_user_id' => $id 
		) );
		
		if ($posts) {
			foreach ( $posts as $post ) {
				$json_array [] = $post->toArray ();
			}
			$arr ['list'] = $json_array;
			$arr ['status'] = 'OK';
		} else
			$arr ['message'] = 'No post found';
		$this->sendJSONResponse ( $arr );
	}
	public function actionNearByPosts($radius = null, $lat = null, $long = null, $id) {
		// $id = Yii::app()->user->id;
		$arr = array (
				'controller' => $this->id,
				'action' => $this->action->id,
				'status' => 'NOK' 
		);
		$json_array = array ();
		
		if ($lat == null || $long == null) {
			$user = User::model ()->findByPk ( $id );
			$lat = $user->work_lat;
			$long = $user->work_long;
		}
		
		if ($radius == null)
			$radius = 0.2;
		
		$criteria = new CDbCriteria ();
		$criteria->select = "*,( 6371 * acos( cos( radians({$lat}) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians({$long}) ) + sin( radians({$lat}) ) * sin( radians( `latitude` ) ) ) ) AS distance";
		$criteria->having = "distance <= $radius";
		$criteria->order = 'distance ASC';
		
		$posts = Post::model ()->findAll ( $criteria );
		
		if ($posts) {
			foreach ( $posts as $post ) {
				$json_array [] = $post->toArray ();
			}
			$arr ['list'] = $json_array;
			$arr ['status'] = 'OK';
		} else
			$arr ['message'] = 'No post found';
		$this->sendJSONResponse ( $arr );
	}
	public function actionNearByUsers($radius = null) {
		
		$arr = array ('controller' => $this->id,'action' => $this->action->id,'status' => 'NOK' );
		
		$id = Yii::app()->user->id;
		
		if($id == null)
			$id = $_REQUEST['User']['id']; 
		
		$json_array = array ();		
		$user = User::model ()->findByPk ( $id );
		
		if($user)
		{
		//var_dump($id,$user);die;
		$lat = $user->work_lat;
		$long = $user->work_long;
		
		if ($radius == null)
			$radius = 0.2;
		
		$criteria = new CDbCriteria ();
		$criteria->select = "*,( 6371 * acos( cos( radians({$lat}) ) * cos( radians( `work_lat` ) ) * cos( radians( `work_long` ) - radians({$long}) ) + sin( radians({$lat}) ) * sin( radians( `work_lat` ) ) ) ) AS distance";
		$criteria->having = "distance <= $radius";
		$criteria->addCondition ( 'id !="' . $id . '"' );
		$criteria->order = 'distance ASC';
		
		$users = User::model ()->findAll ( $criteria );
		// var_dump($posts);die;
		
		if ($users) {
			foreach ( $users as $user ) {
				$json_array [] = $user->toArray ();
			}
			$arr ['list'] = $json_array;
			$arr ['status'] = 'OK';
		} else {
			
			$arr ['status'] = 'OK';
			$arr ['message'] = 'No user found';
		}
		}
		else 
		{
			
			$arr['message'] = ' No user found'; 
		}
		$this->sendJSONResponse ( $arr );
	}
	
	public function actionCreateLocation($from_user, $to_user_email, $duration,$type) {
		$arr = array (
				'controller' => $this->action->id,
				'action' => $this->id,
				'status' => 'NOK' 
		);
		$user = User::model ()->findByAttributes ( array (
				'email' => $to_user_email 
		) );
		if ($user) {
			$location_group = LocationGroup::model ()->saveLocationGroup ( $from_user, $user->id, $duration ,$type);
			$arr ['status'] = 'OK';
			$arr ['Locations'] = $location_group;
		} else {
			
			$arr ['message'] = 'No user found';
		}
		
		$this->sendJSONResponse ( $arr );
	}
	public function actionViewAllLocation($id) {
		$arr = array (
				'controller' => $this->action->id,
				'action' => $this->id,
				'status' => 'NOK' 
		);
		if ($id) {
			$json = array ();
			$location_group = LocationGroup::model ()->findByAttributes ( array (
					'user_id' => $id 
			) );
			if ($location_group) {
				$user_group_locations = UserLocationGroup::model ()->findAllByAttributes ( array (
						'group_id' => $location_group->id 
				) );
				if ($user_group_locations) {
					foreach ( $user_group_locations as $location ) {
						$user = User::model ()->findByPk ( $location->user_id );
						$json [] = $user->toArray ();
					}
					$arr ['user'] = $json;
					$arr ['status'] = "OK";
				} else {
					
					$arr ['message'] = "No user found";
					$arr ['status'] = "OK";
				}
			} else {
				$arr ['message'] = "No location shared";
				$arr ['status'] = "OK";
			}
		} else {
			$arr ['error'] = "Please pass user id";
		}
		$this->sendJSONResponse ( $arr );
	}
}