<?php

class UserController extends GxController {
	public $loginForm = null;
	public $caseSensitiveUsers = true;
	public $returnAdminUrl = null;
	// LoginType :
	const LOGIN_BY_USERNAME		= 1;
	const LOGIN_BY_EMAIL		= 2;
	const LOGIN_BY_LDAP			= 32;
	// Allow login only by username by default.

	public $loginType = 2;
	//public $layout = 'column3';
	public $defaultAction = 'dashboard';
	public function filters() {
		return array(
				'accessControl',
		);
	}

	public function accessRules() {
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('create','recover','login', 'thumbnail','uploadCsv', 'groups','download'),
						'users'=>array('*'),
						'expression'=>'Yii::app()->user->isGuest',
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('update','view','logout','changepassword','addFriend','unFriend','dashboard',
								'block','unblock','download'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform
						'actions'=>array('create','index','admin','delete','update','adminUser'),
						'expression'=>'Yii::app()->user->isAdmin',
				),
				array('deny',
						'users'=>array('*'),
				),
		);
	}
	public function isAllowed($model)
	{
		return $model->isAllowed();
	}
	public function actionGroups()
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		$groups = Group::model()->findAll();
		if($groups)
		{
			$stationlist = array();
			foreach($groups as $group){
				$grouplist[] = $group->toArray();
			}
			$arr['list'] = $grouplist;
			$arr['status'] = 'OK';
		}else{
			$arr['error'] = 'No record found!';
		}
		$this->render('//station/index', array(
				'dataProvider' => new CArrayDataProvider($groups),
		));
	}

	public function actionGetPost($id = null)
	{
		if($id == null ) $id = Yii::app()->user->id;
		$model = $this->loadModel($id, 'User');
		$this->renderPartial('_text', array(
				'model' => $model,
				'contact'=>$contact));
	}

	
	public function actionView($id)
	{
		$this->layout = 'column4';
		$model = $this->loadModel($id, 'User');
		
		$radius = 10000;
		$criteria = new CDbCriteria ();
		$criteria->select = "*,( 6371 * acos( cos( radians({$model->work_lat}) ) * cos( radians( `work_lat` ) ) * cos( radians( `work_long` ) - radians({$model->work_long}) ) + sin( radians({$model->work_lat}) ) * sin( radians( `work_lat` ) ) ) ) AS distance";
		$criteria->having = "distance <= $radius";
		$criteria->addCondition ( 'id !="' . $id . '"' );
		$criteria->addCondition ('role_id !='.User::ROLE_MANAGER);
		$criteria->addCondition ('role_id !='.User::ROLE_ADMIN);
		$criteria->order = 'distance ASC';
		$users = User::model()->findAll($criteria);
		//if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));
// 		/var_dump($users);die;
		//$this->processActions($model);
		$this->updateMenuItems($model);
		$this->render('view', array(
				'model' => $model,
				'users' => $users,
				'count' => count($users)
		));
	}
	public function actionUpdate($id = null)
	{
		if($id == null)
			$id = Yii::app()->user->id;
		$model = $this->loadModel($id, 'User');
		$model->scenario = 'update';
		$this->performAjaxValidation($model, 'user-form');
		if (isset($_POST['User'])) {
			$model->setAttributes($_POST['User']);
			$model->saveUploadedFile($model,'image_file');

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->updateMenuItems($model);
		$model->password = null;
		$this->render('update', array(
				'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id, 'Post');
		if ($model)
		{
			$model->delete();

			$this->redirect(array('profile'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex()
	{

		$model = new User('search');
		$model->unsetAttributes();
		$this->updateMenuItems($model);

		if (isset($_GET['User']))
			$model->setAttributes($_GET['User']);

		$this->render('index', array(
				'model' => $model,
		));
	}

	public function actionAccount($id)
	{
		$model = $this->loadModel($id, 'User');
		
		$criteria=new CDbCriteria;
		$criteria->addCondition('from_id ='.$id);
		$dataProvider = new CActiveDataProvider('Message',array('criteria'=>$criteria));
		$this->render('my_account', array(
				'model' => $model,
				'dataProvider'=>$dataProvider,
		));
	}
		
/* 	public function actionAdmin()
	{
		
		$this->layout = 'column3';
		$model = new User('search');
		if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));
		$model->unsetAttributes();
		$this->updateMenuItems($model);

		if (isset($_GET['User']))
			$model->setAttributes($_GET['User']);

		$this->render('admin', array(
				'model' => $model,
		));
	} */
		
public function actionAdmin()
{

	//$this->layout = 'column3';
	$model = new User('search');
	if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));
	$model->unsetAttributes();
	$this->updateMenuItems($model);
	
	$user = User::model()->findByPk(Yii::app()->user->id);

	if (isset($_GET['User']))
		$model->setAttributes($_GET['User']);

	$this->render('admin', array(
			'model' => $model,
			'user' => $user
	));
}
public function actionAdminUser()
{

	//$this->layout = 'column3';
	$model = new User('searchUser');
	if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));
	$model->unsetAttributes();
	$this->updateMenuItems($model);

	$user = User::model()->findByPk(Yii::app()->user->id);

	if (isset($_GET['User']))
		$model->setAttributes($_GET['User']);

	$this->render('adminUser', array(
			'model' => $model,
			'user' => $user
	));
}
	public function actionCreate()
	{
		$this->layout = 'column2';
		$model = new User('create');
		$this->performAjaxValidation($model, 'user-form');
		if (isset($_POST['User']))
		{
			var_dump($_POST['User']);die;
			$model->setAttributes($_POST['User']);
			$user = User::getUserByEmail( $model->email);
			if (! $user )
			{
				if($model->save())
				{
					$model->saveUploadedFile ( $model, 'image_file' );
					if ( isset($_POST['User']['password']) && $model->setPassword($_POST['User']['password']))
					{
						if ( $model-> state_id == 1)
						{
							Yii::app()->user->setFlash('success','Thank you for registering with us. Please check your email for activation link.');

							if (Yii::app()->getRequest()->getIsAjaxRequest())
								Yii::app()->end();
							else
								$this->redirect(array('view', 'id' => $model->id));
						}
						else {
							Yii::app()->user->setFlash('register','Thank you for registering with us. You can login now using your email ID and password');
						}
					}
					$this->redirect(array('view', 'id' => $model->id));
				}
			}else{
				$model->addError('email', 'Email Already Exits');
			}
		}
		$this->updateMenuItems($model);
		$this->render('create', array( 'model' => $model));

	}

	public function actionAddFriend($id)
	{
		$groups = Yii::app()->user->getModel()->userGroups;
		if(empty($groups))
		{
			$group = new group();
			$group->name = Yii::app()->user->getModel()->full_name . "'s Friends";
			$group->limits = 100;
			$group->save();
		}
		else
		{
			$group = $groups[0];
		}
		$saved = false;

		if ($group)
		{
			$mygroup = new UserGroup();
			$mygroup->user_id = $id;
			$mygroup->group_id =  $group->id;
			$mygroup->state_id =  0;
			if ( $mygroup->save())
				Yii::app()->user->setFlash('User',"Friend added.");
			else Yii::app()->user->setFlash('User',"Friend not added.");

		}
		else{
			$model->addError('email', 'User Already Exits');
		}
		$this->redirect(array('userlist'));
	}
	
	public function actionUnFriend($id)
	{
		$groups = Yii::app()->user->getModel()->userGroups;
		if($groups)
		{
			$criteria=new CDbCriteria;
			$criteria->addCondition('user_id ='.$id);
			//$criteria->addCondition('state_id = 0');
			$criteria->addCondition('group_id = '.$groups[0]->id);
			$user = UserGroup::model()->find($criteria);
			if($user)
			{
				$user->state_id = 2;
				$user->saveAttributes(array('state_id'));
			}
		}
		$this->redirect(array('userlist'));
	}
	
	public function actionBlock($id)
	{
		$groups = Yii::app()->user->getModel()->userGroups;
		if($groups)
		{
			$criteria=new CDbCriteria;
			$criteria->addCondition('user_id ='.$id);
			//$criteria->addCondition('state_id = 0');
			$criteria->addCondition('group_id = '.$groups[0]->id);
			$user = UserGroup::model()->find($criteria);
			if($user)
			{
				$user->state_id = 2;
				$user->saveAttributes(array('state_id'));
			}
		}
		$this->redirect(array('userlist'));
	}
	public function actionUnblock($id)
	{
		$groups = Yii::app()->user->getModel()->userGroups;
		if($groups)
		{
			$criteria=new CDbCriteria;
			$criteria->addCondition('user_id ='.$id);
			//$criteria->addCondition('state_id = 0');
			$criteria->addCondition('group_id = '.$groups[0]->id);
			$user = UserGroup::model()->find($criteria);
			if($user)
			{
				$user->state_id = 1;
				$user->saveAttributes(array('state_id'));
			}
		}
		$this->redirect(array('userlist'));
	}
	
	protected function updateMenuItems($model = null)
	{
		// create static model if model is null
		if ( $model == null ) $model = User::model();

		switch( $this->action->id)
		{
			case 'update':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'View') . ' ' . $model->label(), 'url'=>array('view','id'=>$model->id),'visible'=> Yii::app()->user->isAdmin);
				}
			case 'create':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin'), 'visible'=> Yii::app()->user->isAdmin);
					//$this->menu[] = array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index'));
				}
				break;
			case 'admin':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id));
					$this->menu[] = array('label'=>Yii::t('app', 'Change Password') , 'url'=>array('changepassword', 'id' => $model->id));
					//$this->menu[] = array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index'));
				}
				break;				
	
			case 'index':
				{
					$this->menu[] = array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin'), 'visible'=> Yii::app()->user->isAdmin);
					//$this->menu[] = array('label'=>Yii::t('app', 'Register') . ' ' . $model->label(), 'url'=>array('create'),'visible'=> Yii::app()->user->isAdmin);
				}
				break;
			default:
			case 'view':
				{
					//$this->menu[] = array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index'));
					$this->menu[] = array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin'),'visible'=> Yii::app()->user->isAdmin);
					//$this->menu[] = array('label'=>Yii::t('app', 'Register') . ' ' . $model->label(), 'url'=>array('create'),'visible'=> Yii::app()->user->isAdmin);
					$this->menu[] = array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id));
					$this->menu[] = array('label'=>Yii::t('app', 'Change Password') , 'url'=>array('changepassword', 'id' => $model->id));

				}
				break;
		}

				// Add SEO headers
		$this->processSEO($model);
		
		//merge actions with menu
		$this->actions = array_merge( $this->actions, $this->menu);
	}
	public function actionActive()
	{
		if(isset($_GET['term'])&&($keyword=trim($_GET['term']))!=='')
		{
			$models = User::searchByName($keyword);
			$suggest=array();
			foreach($models as $model)
			{
				$suggest[] = array(
						'label'=>$model->full_name, // label for dropdown list
						'value'=>$model->username, // value for input field
						'id'=>$model->id, // return values from autocomplete
				);
			}
			echo CJSON::encode($suggest);
		}
		Yii::app()->end();
	}

	public function actionChangepassword($expired = false)
	{
		$id = Yii::app()->user->id;
		$model = $this->loadModel($id, 'User');
		$model->scenario = 'create';
		$this->updateMenuItems();
		$this->performAjaxValidation($model, 'user-form');

		if (isset($_POST['User']) && isset($_POST['User']['password']))
		{
			if ($model->setPassword($_POST['User']['password'], $_POST['User']['password_2']))
			{
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$model->password = null; // empty it
		$this->render('changepassword', array(
				'model' => $model,
		));
	}
	public function actionPasswordExpired($id)
	{
		$this->actionChangePassword($id,$expired = true);
	}

	public function actionActivate($id, $key, $mode)
	{
		$model = $this->loadModel($id, 'User');

		if ( $mode == 'recover')
			$model->status_id = User::STATUS_INACTIVE;

		$ret = $model->activate( $model->email, $key);

		if ( $mode == 'login')
		{
			if ( $ret == 1 )
			{
				Yii::app()->user->setFlash('register','Congratulations! Your account is activated.');
			}
			else if ( $ret == -2 )
			{
				Yii::app()->user->setFlash('register','Invalid activation key.');
				$this->redirect(array('login'));
			}
			else
			{
				Yii::app()->user->setFlash('register','Your account is already activated.');
			}
			$this->redirect(array('create'));
		}
		else
		{
			if ( $ret == 1 )
			{
				$model->fakeLogin();
				Yii::app()->user->setFlash('recover','Please change your password.');
				$this->redirect(array('changepassword', 'id'=>$model->id));
			}
			else if ( $ret == -2 )
			{
				Yii::app()->user->setFlash('recover','Invalid activation key.');
				$this->redirect(array('login'));
			}
			$this->render('recover', array( 'model' => $model));
		}
	}

	public function actionRecover()
	{
		$model = new User;
		$this->layout = 'column2';
		$this->performAjaxValidation($model, 'user-form');

		if (isset($_POST['User']))
		{
			$email = $_POST['User']['email'];
			$user = User::model()->findByAttributes(array('email'=>$email));
			if ( $user )
			{
				$user->sendPassword();
				Yii::app()->user->setFlash('recover','Please check your email to reset your password.');
			}
			else
			{
				$model->addError('email', "Email is not registered");
				Yii::app()->user->setFlash('recover','Email is not registered.');
			}
		}

		$this->render('recover', array( 'model' => $model));
	}

	public function actionUserlist()
	{
		$model = new User('search');
		$model->unsetAttributes();
		$this->updateMenuItems($model);

		if (isset($_GET['User']))
			$model->setAttributes($_GET['User']);

		$this->render('userlist', array(
				'model' => $model,
		));
	}

	public function actionAddedFriends($id)
	{
		$model = $this->loadModel($id, 'User');
		$this->updateMenuItems($model);
		$this->render('addedFriends', array(
				'model' => $model
		));
	}
	//-------------------------
	public function loginByUsername() {
		if($this->caseSensitiveUsers)
			$user = User::model()->find('username = :username', array(
					':username' => $this->loginForm->username));
		else
			$user = User::model()->find('upper(username) = :username', array(
					':username' => strtoupper($this->loginForm->username)));

		if($user)
			return $this->authenticate($user);
		else {
			Yii::log( Yii::t('app',
			'Non-existent user {username} tried to log in (Ip-Address: {ip})', array(
			'{ip}' => Yii::app()->request->getUserHostAddress(),
			'{username}' => $this->loginForm->username)), 'error');

			$this->loginForm->addError('password',
					Yii::t('app','Username or Password is incorrect'));
		}

		return false;
	}
	public function authenticate($user,$flag=null) {
		if($flag)
			$identity = new UserIdentity($user->email, $this->loginForm->contact_no);
		else
			$identity = new UserIdentity($user->email, $this->loginForm->password);
		$identity->authenticate($this->loginType);
		switch($identity->errorCode) {
			case UserIdentity::ERROR_NONE:
				$duration = $this->loginForm->rememberMe ? 3600*24*30 : 0; // 30 days
				Yii::app()->user->login($identity,$duration);
				return $user;
				break;
			case UserIdentity::ERROR_EMAIL_INVALID:
				$this->loginForm->addError("password",Yii::t('app','Username or Password is incorrect'));
				break;
			case UserIdentity::ERROR_STATUS_INACTIVE:
				$this->loginForm->addError("status",Yii::t('app','This account is not activated.'));
				break;
			case UserIdentity::ERROR_STATUS_BANNED:
				$this->loginForm->addError("status",Yii::t('app','This account is blocked.'));
				break;
			case UserIdentity::ERROR_STATUS_REMOVED:
				$this->loginForm->addError('status', Yii::t('app','Your account has been deleted.'));
				break;

			case UserIdentity::ERROR_PASSWORD_INVALID:
				Yii::log( Yii::t('app',
				'Password invalid for user {username} (Ip-Address: {ip})', array(
				'{ip}' => Yii::app()->request->getUserHostAddress(),
				'{username}' => $this->loginForm->username)), 'error');

				if(!$this->loginForm->hasErrors())
					$this->loginForm->addError("password",Yii::t('app','Username or Password is incorrect'));
				break;
				return false;
		}
	}
	public function loginByEmailPhone() {

		$user = User::model()->findByAttributes(array('email'=>$this->loginForm->username,'contact_no'=>$this->loginForm->contact_no));
		if($user){
			$flag= 1;
			return $this->authenticate($user,$flag);
		}
		else{
			return null;
		}
		//throw new CException('The profile submodule must be enabled to allow login by Email');
	}

	public function loginByEmail(){
		if($this->caseSensitiveUsers)
			$user = User::model()->find('email = :email', array(
					':email' => $this->loginForm->username));
		else
			$user = User::model()->find('upper(email) = :email', array(
					':email' => strtoupper($this->loginForm->username)));
		if($user)
		{
			return $this->authenticate($user);
		}

		else
			return null;

	}
	
	
	public function actionLogin() {
		// If the user is already logged in send them to the users logged homepage

		$this->layout = 'column1';
		$this->loginForm = new LoginForm();
		$success = false;
		$action = 'login';
		$login_type = null;
		if (isset($_POST['LoginForm'])) {
			$this->loginForm->attributes = $_POST['LoginForm'];

			// validate user input for the rest of login methods
			if ($this->loginForm->validate())
			{
				$emal1 = $_POST['LoginForm']['username'];
				if ($this->loginType & self::LOGIN_BY_USERNAME) {
					$success = $this->loginByUsername();
					if ($success)
						$login_type = 'username';
				}
				if ($this->loginType & self::LOGIN_BY_EMAIL && !$success) {
					if($this->loginForm->password){
						$success = $this->loginByEmail();
					}else{
						$success = $this->loginByEmailPhone();
					}
					if ($success)
						$login_type = 'email';
				}
				if($this->loginType & self::LOGIN_BY_LDAP && !$success) {
					$success = $this->loginByLdap();
					$action = 'ldap_login';
					$login_type = 'ldap';
				}
			}

			if ($success instanceof User) {
				//cookie with login type for later flow control in app
				if( !Yii::app()->user->isAdmin){
					$this->actionLogout();
				}
				if ($login_type) {
					$cookie = new CHttpCookie('login_type', serialize($login_type));
					$cookie->expire = time() + (3600*24*30);
					Yii::app()->request->cookies['login_type'] = $cookie;
				}

				/*if(YII_ENV == 'prod')
				 {
				$data = User::getgoogleAddress();
				$success->lat = $data->latitude;
				$success->long = $data->longitude;
				$success->city = $data->city;
				$success->country = $data->country_name;
				$success->saveAttributes(array('lat','long','city','country'));
				}*/

				$this->redirect(array('user/dashboard'));
			}
			else
			{
				if(!$this->loginForm->hasErrors())
					$this->loginForm->addError('username','Login is not possible with the given credentials');
			}
		}

		$this->render('login', array(
				'model' => $this->loginForm,
				'loginType' => $this->loginType,
		) );
	}

	public function redirectUser($user) {
		if(isset($_POST) && isset($_POST['returnUrl']))
			$this->redirect(array($_POST['returnUrl']));
		$this->redirect(Yii::app()->user->returnUrl);

	}
	
	
	public function actionLogout() {
		// If the user is already logged out send them to returnLogoutUrl
		if (Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);

		//let's delete the login_type cookie
		$cookie=Yii::app()->request->cookies['login_type'];
		if ($cookie) {
			$cookie->expire = time() - (3600*72);
			Yii::app()->request->cookies['login_type'] = $cookie;
		}

		if($user = User::model()->findByPk(Yii::app()->user->id)) {
			$username = $user->full_name;

			$user->last_visit_time  = date("Y-m-d H:i:s");//new CDbExpression('NOW()');
			$user->save();
			$user->logout();

			Yii::log(Yii::t('app','User {username} logged off', array('{username}' => $username)));

			Yii::app()->user->logout();
		}
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function beforeAction($event)
	{
		if( Yii::app()->user->isGuest) $this->layout='column1';
		return parent::beforeAction($event);
	}
	
	/*
	public function actionTerms()
	{
		$this->render('terms');
	}
	*/
	
	
	//----------------------TRUNCATE---------------------
	
	protected function getPath()
	{
		if ( isset ($this->module->path )) $this->_path = $this->module->path;
		else $this->_path = Yii::app()->basePath .'/../_backup/';
	
		if ( !file_exists($this->_path ))
		{
			mkdir($this->_path );
			chmod($this->_path, '777');
		}
		return $this->_path;
	}
	
	public function StartBackup($addcheck = true)
	{
		$this->file_name =  $this->path . $this->back_temp_file . date('Y.m.d_H.i.s') . '.sql';
	
		$this->fp = fopen( $this->file_name, 'w+');
	
		if ( $this->fp == null )
			return false;
		fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
		if ( $addcheck )
		{
			fwrite ( $this->fp,  'SET AUTOCOMMIT=0;' .PHP_EOL );
			fwrite ( $this->fp,  'START TRANSACTION;' .PHP_EOL );
			fwrite ( $this->fp,  'SET SQL_QUOTE_SHOW_CREATE = 1;'  .PHP_EOL );
		}
		fwrite ( $this->fp, 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;'.PHP_EOL );
		fwrite ( $this->fp, 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;'.PHP_EOL );
		fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
		$this->writeComment('START BACKUP');
		return true;
	}
	
	public function actionTruncate($redirect = true)
	{
		$ignore = array('tbl_user','tbl_location_group','tbl_user_location_group', 'tbl_report','tbl_report_cause',);
		$tables = $this->getTables();
	
		if(!$this->StartBackup())
		{
			//render error
			return;
		}
	
		$message = '';
	
		foreach($tables as $tableName)
		{
			if( in_array($tableName, $ignore)) continue;
			fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
			fwrite ( $this->fp, 'TRUNCATE ' .addslashes($tableName) . ';'.PHP_EOL );
			fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
	
			$message  .=  $tableName . ',';	
		}
		$this->EndBackup();
	
		// logout so there is no problme later .
		//Yii::app()->user->logout();
	
		$this->execSqlFile($this->file_name);
		$message .= ' are deleted.';
			
		Yii::app()->user->setFlash('success', $message);
		if ( $redirect == true) $this->redirect(array('index'));
	}
	
	public function EndBackup($addcheck = true)
	{
		fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
		fwrite ( $this->fp, 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;'.PHP_EOL );
		fwrite ( $this->fp, 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;'.PHP_EOL );
	
		if ( $addcheck )
		{
			fwrite ( $this->fp,  'COMMIT;' .PHP_EOL );
		}
		fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
		$this->writeComment('END BACKUP');
		fclose($this->fp);
		$this->fp = null;
	}
	
	public function getTables($dbName = null)
	{
		$sql = 'SHOW TABLES';
		$cmd = Yii::app()->db->createCommand($sql);
		$tables = $cmd->queryColumn();
		return $tables;
	}
	
	public function writeComment($string)
	{
		fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
		fwrite ( $this->fp, '-- '.$string .PHP_EOL );
		fwrite ( $this->fp, '-- -------------------------------------------'.PHP_EOL );
	}
	
	public function execSqlFile($sqlFile)
	{
		$message = "ok";
	
		if ( file_exists($sqlFile))
		{
			$sqlArray = file_get_contents($sqlFile);
	
			$cmd = Yii::app()->db->createCommand($sqlArray);
			try	{
				$cmd->execute();
			}
			catch(CDbException $e)
			{
				$message = $e->getMessage();
			}
		}
		return $message;
	}
	
	
	public  function actionRemoveDirectory()
	{
		$directory = Yii::app()->basePath .'/../uploads/';	
		if (!is_dir($directory)) {
			mkdir($directory);
			chmod($directory, '777');
		}
		//	rmdir($directory);
		//chmod($directory, '777');
	}
	public function actionDashboard()
	{
		$this->layout = 'column4';
		$managers = User::model()->roleManagers() ;
		$users= User::model()->roleUsers() ;
		$reports = User::model()->reports() ;
		$visitors = User::model()->visitors();
		//var_dump($visitors);die;
		$this->render('dashboard',array('managers'=>$managers,'users'=>$users,'reports'=>$reports,'visitors'=>$visitors));
	}
}