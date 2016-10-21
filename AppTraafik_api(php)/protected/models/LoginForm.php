<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	
	public $username;
	public $email;
	public $password;
	public $rememberMe;
	private $_identity;
	public $device_token;
	public $device_type;
	public $lat;
	public $long;
	public $city;
	public $contact_no;
	public $facebook_id;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		if(!isset($this->scenario))
			$this->scenario = 'login';

		return array(
		// username and password are required
				array('username', 'required'),
				array('device_token,password,device_type,contact_no,email,facebook_id', 'safe'),
				array('device_type', 'numerical', 'integerOnly'=>true),
		// rememberMe needs to be a boolean
		array('rememberMe', 'boolean'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
				'username'=>'Email',
				'rememberMe'=>'Remember me next time',
		);
	}
}
