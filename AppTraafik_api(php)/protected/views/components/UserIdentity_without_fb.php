<?php

class UserIdentity extends CUserIdentity {
	public $id;
	public $user;
	const ERROR_EMAIL_INVALID	= 3;
	const ERROR_STATUS_INACTIVE	= 4;
	const ERROR_STATUS_BANNED	= 5;
	const ERROR_STATUS_REMOVED	= 6;
	const ERROR_PHONE = 7;
	const ERROR_STATUS_USER_DOES_NOT_EXIST = 7;

	public function authenticateSession($user)
	{
		if(!$user)
			return self::ERROR_STATUS_USER_DOES_NOT_EXIST;
		$this->id = $user->id;
		$this->setState('id', $user->id);
		$this->username = $user->full_name;
		$this->user = $user;
		$this->errorCode=self::ERROR_NONE;

		return!$this->errorCode = self::ERROR_NONE;
	}

	public function authenticate($loginByEmail = false)
	{
		$user =  null;
		// try to authenticate via email
		if( $loginByEmail){
			$user = User::model()->find('email = :email', array(':email' => $this->username));
		}else{
			$user = User::model()->find('username = :username', array(':username' => $this->username));
		}
		if(!$user)
			return self::ERROR_STATUS_USER_DOES_NOT_EXIST;
		else if(!User::validate_password($this->password,$user->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($user->state_id == User::STATUS_INACTIVE)
			$this->errorCode=self::ERROR_STATUS_INACTIVE;
		else if($user->state_id == User::STATUS_BANNED)
			$this->errorCode=self::ERROR_STATUS_BANNED;
		else if($user->state_id == User::STATUS_REMOVED)
			$this->errorCode=self::ERROR_STATUS_REMOVED;
		else {
			$this->id = $user->id;
			$this->setState('id', $user->id);
			$this->username = $user->full_name;
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	public function authenticateApi($loginByFB = false)
	{
		$user =  null;
		//---old
		//$user = User::model()->find('email = :email', array(':email' => $this->username));
		//--new
		if($loginByFB){	
			$user = User::model()->find('facebook_id = :username', array(':username' => $this->username));
		}
		else{
			/*if($loginBy==1){
			 $user = User::model()->find('email = :email', array(':email' => $this->username));
			 }elseif($loginBy==2){
			 $user = User::model()->find('full_name = :email', array(':full_name' => $this->username));
			 }else{
			 $user = User::model()->find('contact_no = :email', array(':contact_no' => $this->username));
			 }*/
			$user = User::model()->find('email=:username OR full_name=:username OR mobile=:username', array(':username' => $this->username));			
		}
		
		//$arr_loginBy = array(1,2,3);
		if(!$user)
			//return self::ERROR_STATUS_USER_DOES_NOT_EXIST;
			$this->errorCode=self::ERROR_STATUS_USER_DOES_NOT_EXIST;
		//-----praveen---s--
		else if(!User::validate_password($this->password,$user->password) && ($loginByFB == false) )
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		//-----praveen---e--
						
		else if($user->state_id == User::STATUS_INACTIVE)
			$this->errorCode=self::ERROR_STATUS_INACTIVE;
		else if($user->state_id == User::STATUS_BANNED)
			$this->errorCode=self::ERROR_STATUS_BANNED;
		else if($user->state_id == User::STATUS_REMOVED)
			$this->errorCode=self::ERROR_STATUS_REMOVED;
		else {
			$this->id = $user->id;
			$this->setState('id', $user->id);
			$this->username = $user->full_name;
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->id;
	}

	public function getRoles()
	{
		return $this->Role;
	}

}