<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */

/**
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $mobile
 *
 * @property string $password
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $status_msg
 *
 * @property string $date_of_birth
 * @property integer $gender
 *
 * @property string $contact_address
 * @property string $city
 * @property string $country
 * @property integer $zipcode
 * @property string $image_file
 *
 *
 * @property string $facebook_id
 *
 *
 * @property string $distance
 * @property integer $distance_type
 * @property string $event_radius
 * @property string $home_location
 * @property string $home_lat
 * @property string $home_long
 * @property string $work_location
 * @property string $work_lat
 * @property string $work_long
 *
 *
 * @property integer $tos
 * @property integer $news_letters
 *
 *
 * @property integer $role_id
 * @property integer $state_id
 * @property integer $type_id
 *
 *
 * @property integer $is_busy
 * @property string $last_visit_time
 * @property string $last_action_time
 * @property string $last_password_change
 * @property string $activation_key
 * @property integer $login_error_count
 * @property integer $create_user_id
 * @property string $create_time
 */
Yii::import ( 'application.models._base.BaseUser' );
class User extends BaseUser {
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_BANNED = 2;
	const STATUS_REMOVED = 3;
	
	/*
	 * const STATUS_OFFLINE 	= 0;
	 * const STATUS_ONLINE		= 1;
	 * const STATUS_INVISIBLE	= 2;
	 */
	
	// const IS_OFFLINE = 0;
	const IS_FREE = 1;
	const IS_BUZY = 2;
	const ROLE_ADMIN = 0;
	const ROLE_MANAGER = 1;
	const ROLE_USER = 2;
	
	
	
	
	// -------traafik----praveen---s
	const SIGNUP_BY_FULLNAME = 0;
	const SIGNUP_BY_EMAIL = 1;
	const SIGNUP_BY_MOBILE = 2;
	// -------traafik----praveen---s
	public $layout = 'column3';
	public $file;
	private static $password_expiration_day = 90;
	protected static $salt1 = "";
	protected static $hashFunc = 'md5';
	public static $offline_indication_time = 300;
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function logout() {
		if (! Yii::app ()->user->isGuest) {
			$this->last_action_time = date ( "Y-m-d H:i:s" );
			$this->saveAttributes ( array (
					'last_action_time' 
			) );
		}
	}
	public function updateLastVisit() {
		if (! Yii::app ()->user->isGuest) {
			$this->last_visit_time = date ( "Y-m-d H:i:s" ); // new CDbExpression('NOW()');
			$this->saveAttributes ( array (
					'last_visit_time' 
			) );
		}
	}
	public function isActive() {
		return ($this->state_id == User::STATUS_ACTIVE);
	}
	public static function getUsers() {
		$users = User::model ()->active ()->findAll ();
		return $users;
	}
	public static function getUserByEmail($name) {
		$user = User::model ()->findByAttributes ( array (
				'email' => $name 
		) );
		return $user;
	}
	public static function getUserByMobile($name) {
		$user = User::model ()->findByAttributes ( array (
				'mobile' => $name 
		) );
		return $user;
	}
	public static function getUserByName($name) {
		$user = User::model ()->active ()->findByAttributes ( array (
				'full_name' => $name 
		) );
		return $user;
	}
	public static function getUserById($id) {
		$user = User::model ()->active ()->findByPk ( $id );
		return $user;
	}
	public function recover() {
		$to = $this->email;
		$subject = 'Recover Your Account at: ' . Yii::app ()->params ['company'];
		$body = ' Please click on below given link to Recover your Password. ' . "\r\n";
		// $body .= CHtml::link ( 'Recover', $this->getActivationUrl('recover'));
		$body .= $this->getActivationUrl ( 'recover' );
		$body .= ' ' . "\r\n";
		$body .= 'Thanks' . "\r\n";
		$body .= 'Admin' . "\r\n";
		$headers = 'From: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 'Reply-To: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 
		// 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		@mail ( $to, $subject, $body, $headers );
		
		if (YII_ENV == 'dev' && ! isset ( Yii::app ()->controller->module ))
			
			echo $body;
	}
	public function register() {
		$to = $this->email;
		
		$subject = 'Confirm Your Account at: ' . Yii::app ()->params ['company'];
		
		$body = 'Thank you for registering with us. Please click on below given link to activate. ' . "\r\n";
		// $body .= CHtml::link ( 'Activate', $this->getActivationUrl());
		$body .= $this->getActivationUrl ();
		$body .= ' ' . "\r\n";
		$body .= 'Thanks' . "\r\n";
		$body .= 'Admin' . "\r\n";
		
		$headers = 'From: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 'Reply-To: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 
		// 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		@mail ( $to, $subject, $body, $headers );
		
		if (YII_ENV == 'dev' && ! isset ( Yii::app ()->controller->module ))
			echo $body;
	}
	public function sendPassword() {
		$password = self::randomPassword ();
		
		$this->setPassword ( $password, $password );
		
		$to = $this->email;
		
		$subject = 'Password for : ' . Yii::app ()->params ['company'];
		
		$body = 'Email ID: ' . $this->email . "\r\n";
		$body .= 'Password: ' . $password . "\r\n";
		$body .= ' ' . "\r\n";
		$body .= 'Thanks' . "\r\n";
		$body .= 'Admin' . "\r\n";
		
		$headers = 'From: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 'Reply-To: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 
		// 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		@mail ( $to, $subject, $body, $headers );
		
		if (YII_ENV == 'dev' && ! isset ( Yii::app ()->controller->module ))
			echo $body;
	}
	public static function randomCode($count = 4) {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
		$pass = array (); // remember to declare $pass as an array
		$alphaLength = strlen ( $alphabet ) - 1; // put the length -1 in cache
		for($i = 0; $i < $count; $i ++) {
			$n = rand ( 0, $alphaLength );
			$pass [] = $alphabet [$n];
		}
		return implode ( $pass );
		; // turn the array into a string
	}
	public function sendCode($code) {
		$to = $this->email;
		$subject = 'Code for : ' . Yii::app ()->params ['company'];
		
		$body = 'Email ID: ' . $this->email . "\r\n";
		$body .= 'Code: ' . $password . "\r\n";
		$body .= ' ' . "\r\n";
		$body .= 'Thanks' . "\r\n";
		$body .= 'Admin' . "\r\n";
		
		$headers = 'From: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 'Reply-To: ' . Yii::app ()->params ['adminEmail'] . "\r\n" . 
		// 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		@mail ( $to, $subject, $body, $headers );
		
		if (YII_ENV == 'dev' && ! isset ( Yii::app ()->controller->module ))
			echo $body;
	}
	public static function randomPassword($count = 8) {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$alphabet = "abcdefghijklmnopqrstuwxyz0123456789";
		$pass = array (); // remember to declare $pass as an array
		$alphaLength = strlen ( $alphabet ) - 1; // put the length -1 in cache
		for($i = 0; $i < $count; $i ++) {
			$n = rand ( 0, $alphaLength );
			$pass [] = $alphabet [$n];
		}
		return implode ( $pass );
		; // turn the array into a string
	}
	public function generateActivationKey($activate = false) {
		$this->activation_key = $activate ? User::encrypt ( microtime () ) : User::encrypt ( microtime () . $this->password );
		$this->saveAttributes ( array (
				'activation_key' 
		) );
		return $this->activation_key;
	}
	public function getActivationUrl($mode = 'login') {
		$this->generateActivationKey ();
		return Yii::app ()->createAbsoluteUrl ( 'user/activate', array (
				'id' => $this->id,
				'key' => $this->activation_key,
				'mode' => $mode 
		) );
	}
	public function activate($email, $key) {
		if ($this->email == $email) {
			if ($this->state_id != self::STATUS_INACTIVE)
				return - 1;
			if ($this->activation_key == $key) {
				$this->state_id = self::STATUS_ACTIVE;
				if ($this->saveAttributes ( array (
						'state_id' 
				) )) {
					return 1;
				}
			} else
				return - 2;
		}
		return false;
	}
	public function getIsAdmin() {
		if ($this->role_id == self::ROLE_ADMIN)
			return true;
		return false;
	}
	public function getIsManager() {
		if ($this->role_id == self::ROLE_ADMIN)
			return true;
		return false;
	}
	public function getIsUser() {
		if ($this->role_id == self::ROLE_USER)
			return true;
		return false;
	}
	public function setPassword($password) {
		if ($password != '') {
			$this->password = User::encrypt ( $password );
			return $this->save ( false, 'password' );
		}
		return false;
	}
	public static function encrypt($string = "") {
		$salt = self::$salt1;
		$hashFunc = self::$hashFunc;
		$string = sprintf ( "%s%s%s", $salt, $string, $salt );
		
		if (! function_exists ( $hashFunc ))
			throw new CException ( 'Function `' . $hashFunc . '` is not a valid callback for hashing algorithm.' );
		
		return $hashFunc ( $string );
	}
	public static function encrypt2($string = "") {
		$out = create_hash ( $string );
		return $out;
	}
	public static function validate_password($password_under_test, $password_real) {
		return (User::encrypt ( $password_under_test ) == $password_real);
	}
	public function scopes() {
		return array (
				'active' => array (
						'condition' => 'state_id=' . self::STATUS_ACTIVE 
				),
				'inactive' => array (
						'condition' => 'state_id=' . self::STATUS_INACTIVE 
				),
				'banned' => array (
						'condition' => 'state_id=' . self::STATUS_BANNED 
				) 
		);
	}
	public function isLoggedIn() {
		if (Yii::app ()->user->isAdmin || $this->id == (Yii::app ()->user->id))
			return true;
		return false;
	}
	public function isChatEnabled() {
		if ($this->state_id == User::STATUS_ACTIVE)
			return 1;
		return 0;
	}
	public static function getNewMessage($id = null) {
		if ($id == null)
			$id = Yii::app ()->user->id;
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( ' to_id=\'' . $id . '\'' );
		$msg = Message::model ()->new ()->findAll ( $criteria );
		
		return $msg;
	}
	public static function getOnlineUsers() {
		$criteria = new CDbCriteria ();
		$online_end = date ( 'Y-m-d H:i:s', time () - self::offline_time );
		$criteria->addCondition ( 'last_action_time > \'' . $online_end . '\'' );
		$criteria->addInCondition ( 'state_id', array (
				User::STATUS_ACTIVE 
		) );
		$models = User::model ()->findAll ( $criteria );
		return $models;
	}
	public static function getOnlineUsersIds() {
		$users = self::getOnlineUsers ();
		$models = array ();
		foreach ( $users as $user ) {
			$models = $user->id;
		}
		return $models;
	}
	public static function setUserOnline() {
		if (! Yii::app ()->user->isGuest) {
			$user = User::model ()->findByPk ( Yii::app ()->user->id );
			if ($user) {
				$user->last_action_time = date ( "Y-m-d H:i:s" );
				// echo $user->last_action_time;
				
				$user->saveAttributes ( array (
						'last_action_time' 
				) );
			}
		}
	}
	protected function beforeDelete() 

	{
		Message::model ()->deleteAllByAttributes ( array (
				'from_id' => $this->id 
		) );
		
		return parent::beforeDelete ();
	}
	public function toArray() {
		$json_entry = array ();
		$json_entry ['id'] = $this->id;
		$json_entry ['full_name'] = $this->full_name;
		$json_entry ['email'] = $this->email;
		
		$json_entry ['mobile'] = $this->mobile;
		
		$json_entry ['password'] = $this->password;
		
		$json_entry ['first_name'] = $this->first_name;
		$json_entry ['last_name'] = $this->last_name;
		$json_entry ['status_msg'] = $this->status_msg;
		
		$json_entry ['date_of_birth'] = $this->date_of_birth;
		$json_entry ['gender'] = $this->gender;
		
		$json_entry ['contact_address'] = $this->contact_address;
		$json_entry ['city'] = $this->city;
		$json_entry ['country'] = $this->country;
		$json_entry ['zipcode'] = $this->zipcode;
		
		// $json_entry['image_file'] = $this->image_file;
		// ---------image-url--------------start--------
		$img_default = 'user.png';
		$random_time = time ();
		
		// $filename_Path = Yii::app()->createAbsoluteUrl(UPLOAD_PATH.$this->image_file);
		$filename_Path = Yii::app ()->basePath . '/..' . UPLOAD_PATH . $this->image_file;
		if (file_exists ( $filename_Path )) {
			$update_time = '';
			$update_time = date ( "Y-m-d H:i:s", filemtime ( $filename_Path ) );
			$json_entry ['image_time'] = $update_time;
		} else
			$json_entry ['image_time'] = '';
		
		$image_url = isset ( $this->image_file ) ? Yii::app ()->createAbsoluteUrl ( 'user/download', array (
				'file' => $this->image_file 
		) ) : Yii::app ()->createAbsoluteUrl ( 'user/download', array (
				'file' => $img_default 
		) );
		
		$json_entry ['image_file'] = $image_url;
		// ---------image-url--------------end--------
		
		$json_entry ['facebook_id'] = $this->facebook_id;
		
		// $json_entry['distance'] = $this->distance;
		// $json_entry['distance_type'] = $this->distance_type;
		// $json_entry['event_radius'] = $this->event_radius;
		// $json_entry['home_location'] = $this->home_location;
		// $json_entry['home_lat'] = $this->home_lat;
		// $json_entry['home_long'] = $this->home_long;
		// $json_entry['work_location'] = $this->work_location;
		$json_entry ['work_lat'] = $this->work_lat;
		$json_entry ['work_long'] = $this->work_long;
		
		$json_entry ['tos'] = $this->tos;
		$json_entry ['news_letters'] = $this->news_letters;
		
		$json_entry ['role_id'] = $this->role_id;
		$json_entry ['state_id'] = $this->state_id;
		$json_entry ['type_id'] = $this->type_id;
		
		$json_entry ['is_busy'] = $this->is_busy;
		$json_entry ['last_visit_time'] = $this->last_visit_time;
		$json_entry ['last_action_time'] = $this->last_action_time;
		$json_entry ['last_password_change'] = $this->last_password_change;
		$json_entry ['activation_key'] = $this->activation_key;
		$json_entry ['login_error_count'] = $this->login_error_count;
		$json_entry ['create_user_id'] = $this->create_user_id;
		$json_entry ['create_time'] = $this->create_time;
		
		$json_entry ['is_online'] = $this->isOnline () ? '1' : '0';
		$json_entry ['last_visit_time'] = $this->last_visit_time;
		return $json_entry;
	}
	public function toArrayLogin() {
		$json_entry = array ();
		$json_entry ['id'] = $this->id;
		$json_entry ['full_name'] = $this->full_name;
		$json_entry ['email'] = $this->email;
		$json_entry ['mobile'] = $this->mobile;
		$json_entry ['password'] = $this->password;
		
		$json_entry ['first_name'] = $this->first_name;
		$json_entry ['last_name'] = $this->last_name;
		$json_entry ['status_msg'] = $this->status_msg;
		
		// $json_entry['date_of_birth'] = $this->date_of_birth;
		// $json_entry['gender'] = $this->gender;
		
		// $json_entry['contact_address'] = $this->contact_address;
		// $json_entry['city'] = $this->city;
		// $json_entry['country'] = $this->country;
		// $json_entry['zipcode'] = $this->zipcode;
		
		// $json_entry['image_file'] = $this->image_file;
		// ---------image-url--------------start--------
		$img_default = 'user.png';
		$random_time = time ();
		
		// $filename_Path = Yii::app()->createAbsoluteUrl(UPLOAD_PATH.$this->image_file);
		$filename_Path = Yii::app ()->basePath . '/..' . UPLOAD_PATH . $this->image_file;
		if (file_exists ( $filename_Path )) {
			$update_time = '';
			$update_time = date ( "Y-m-d H:i:s", filemtime ( $filename_Path ) );
			// $json_entry['image_update_time'] = $update_time;
		} else
			$json_entry ['image_time'] = '';
		
		$image_url = isset ( $this->image_file ) ? Yii::app ()->createAbsoluteUrl ( 'user/download', array (
				'file' => $this->image_file 
		) ) : Yii::app ()->createAbsoluteUrl ( 'user/download', array (
				'file' => $img_default 
		) );
		
		$json_entry ['image_file'] = $image_url;
		// ---------image-url--------------end--------
		
		$json_entry ['facebook_id'] = $this->facebook_id;
		
		// $json_entry['distance'] = $this->distance;
		// $json_entry['distance_type'] = $this->distance_type;
		// $json_entry['event_radius'] = $this->event_radius;
		// $json_entry['home_location'] = $this->home_location;
		// $json_entry['home_lat'] = $this->home_lat;
		// $json_entry['home_long'] = $this->home_long;
		// $json_entry['work_location'] = $this->work_location;
		// $json_entry['work_lat'] = $this->work_lat;
		// $json_entry['work_long'] = $this->work_long;
		
		// $json_entry['tos'] = $this->tos;
		// $json_entry['news_letters'] = $this->news_letters;
		
		$json_entry ['role_id'] = $this->role_id;
		$json_entry ['role_name'] = GxHtml::encode ( GxHtml::valueEx ( $this->role_id ) );
		$json_entry ['state_id'] = $this->state_id;
		// $json_entry['type_id'] = $this->type_id;
		
		$json_entry ['is_busy'] = $this->is_busy;
		// $json_entry['last_visit_time'] = $this->last_visit_time;
		$json_entry ['last_action_time'] = $this->last_action_time;
		// $json_entry['last_password_change'] = $this->last_password_change;
		// $json_entry['activation_key'] = $this->activation_key;
		// $json_entry['login_error_count'] = $this->login_error_count;
		// $json_entry['create_user_id'] = $this->create_user_id;
		// $json_entry['create_time'] = $this->create_time;
		
		$json_entry ['is_online'] = $this->isOnline () ? '1' : '0';
		// $json_entry['last_visit_time'] = $this->last_visit_time;
		return $json_entry;
	}
	public function isOnline() {
		$minutes = User::$offline_indication_time / 60;
		
		$aftertime = date ( 'Y-m-d H:i:s', strtotime ( "-" . $minutes . " minutes", time () ) );
		
		// $aftertime = date("Y-m-d H:i:s",strtotime("-1 minutes",time()));
		
		if ($this->last_action_time > $aftertime) {
			return true;
		}
		return false;
	}
	
	/**
	 * using ip trace the user address by google api
	 */
	public static function getgoogleAddress() {
		$pageContent = file_get_contents ( 'http://freegeoip.net/json/' . $_SERVER ['REMOTE_ADDR'] );
		$parsedJson = json_decode ( $pageContent );
		return $parsedJson;
	}
	
	/**
	 * Sends notification to GCM and ACM device
	 * 
	 * @param unknown_type $arr1        	
	 * @return string
	 */
	public function sendGCM($arr1) {
		$push_status = "NOK";
		foreach ( $this->authSessions as $session ) {
			/*
			 * if(trim($session->device_token) == '(null)'){
			 * $push_status = "NOK";
			 * }
			 * else{
			 */
			$class = $session->type_id == 2 ? 'ACM' : 'GCM';
			Yii::import ( 'ext.push.' . $class );
			$push = new $class ();
			$push->send_notification ( $session->device_token, $arr1 );
			$push_status = "OK";
			// }
		}
		return $push_status;
	}
	public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		$theta = $lon1 - $lon2;
		$dist = sin ( deg2rad ( $lat1 ) ) * sin ( deg2rad ( $lat2 ) ) + cos ( deg2rad ( $lat1 ) ) * cos ( deg2rad ( $lat2 ) ) * cos ( deg2rad ( $theta ) );
		$dist = acos ( $dist );
		$dist = rad2deg ( $dist );
		$miles = $dist * 60 * 1.1515;
		
		$unit = strtoupper ( $unit );
		
		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
	public function userAddress($lat1, $lon1,$count) {
	
	$url  = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat1).','.trim($lon1).'&sensor=false';
		$json  = @file_get_contents($url);
			$data  = json_decode($json, true);
			$current_address = '';
			if($data['results'])
			$current_address = $data['results'][0]['formatted_address'];
					//$current_address = $data['results'][$count]['formatted_address'];
		
		return $current_address;
	}
	public function roleManagers() {
	
		$managers = User::model()->findAllByAttributes(array('role_id'=>User::ROLE_MANAGER));
		return count($managers);
	}
	public function roleUsers() {
	
		$users = User::model()->findAllByAttributes(array('role_id'=>User::ROLE_USER));
		return count($users);
	}
	public function reports() {
	
		$posts = Post::model()->findAll();
		return count($posts);
	}
	public function visitors() {
	
		$today = date('Y-m-d');
		
		$visitiors = User::model()->findAll();
		$visits = 0;
		foreach ($visitiors as $visitior)
		{
			if(	date('Y-m-d',strtotime($visitior->last_visit_time)) == $today )
			{
				$visits++;
			}
		}
		return $visits;
	}
	
}