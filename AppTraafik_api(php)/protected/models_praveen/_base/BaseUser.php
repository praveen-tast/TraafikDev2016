<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */

/**
 * This is the model base class for the table "{{user}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "{{user}}" available as properties of the model,
 * followed by relations of table "{{user}}" available as properties of the model.
 *
 * @property integer $id
 * @property string $full_name
 * @property string $email
 * @property string $mobile
  
 * @property string $password
  
 * @property string $first_name
 * @property string $last_name
 * @property string $status_msg
  
 * @property string $date_of_birth
 * @property integer $gender
  
 * @property string $contact_address
 * @property string $city
 * @property string $country
 * @property integer $zipcode
 * @property string $image_file
  
    
 * @property string $facebook_id
 
 
 * @property string $distance
 * @property integer $distance_type
 * @property string $event_radius
 * @property string $home_location
 * @property string $home_lat
 * @property string $home_long
 * @property string $work_location
 * @property string $work_lat
 * @property string $work_long
  
  
 * @property integer $tos
 * @property integer $news_letters
  
  
 * @property integer $role_id
 * @property integer $state_id
 * @property integer $type_id
  
  
 * @property integer $is_busy
 * @property string $last_visit_time
 * @property string $last_action_time
 * @property string $last_password_change
 * @property string $activation_key
 * @property integer $login_error_count
 * @property integer $create_user_id
 * @property string $create_time
 *
 * @property AuthSession[] $authSessions
 * @property Post[] $posts
 * @property Group[] $groups
 * @property Message[] $to_messages
 * @property Message[] $from_messages
 */
abstract class BaseUser extends GxActiveRecord {


	public static function getStatusOptions($id = null)
	{
		$list = array("Draft","Published","Archive");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}
	public static function getTypeOptions($id = null)
	{
		$list = array("TYPE1","TYPE2","TYPE3");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}
	public function beforeValidate()
	{
		if($this->isNewRecord)
		{
			$this->state_id = User::STATUS_ACTIVE;
			if ( !isset( $this->create_time )) $this->create_time = date( 'Y-m-d H:i:s');

		}
		return parent::beforeValidate();
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{user}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'User|Users', $n);
	}

	public static function representingColumn() {
		return 'full_name';
	}

	public function rules() {
		return array(
				array('full_name, email, password', 'required'),
				array('role_id, state_id, type_id, is_busy, login_error_count', 'numerical',  'integerOnly'=>true),
				array('full_name', 'length', 'max'=>256),
				array('email', 'length', 'max'=>128),
				array('password,  activation_key', 'length', 'max'=>512),
				array('date_of_birth,  last_visit_time, last_action_time, last_password_change, create_time', 'safe'),
				array('date_of_birth,  role_id, state_id, type_id, last_visit_time, last_action_time, last_password_change, activation_key, login_error_count, create_time', 'default', 'setOnEmpty' => true, 'value' => null),
				
				//array('id, full_name, email, password, date_of_birth, role_id, state_id, type_id, is_busy, last_visit_time, last_action_time, last_password_change, activation_key, login_error_count, create_time', 'safe', 'on'=>'search'),
				array('id, full_name,email,mobile, password,first_name,last_name,status_msg,date_of_birth,gender,contact_address,city,country,zipcode,image_file,facebook_id,
distance,distance_type,event_radius,home_location,home_lat,home_long,work_location,work_lat,work_long,tos,news_letters,role_id,state_id,type_id,
is_busy,last_visit_time,last_action_time,last_password_change,activation_key,login_error_count,create_user_id,create_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
				'authSessions' => array(self::HAS_MANY, 'AuthSession', 'create_user_id'),
				'posts' => array(self::HAS_MANY, 'Post', 'create_user_id'),
				'groups' => array(self::HAS_MANY, 'Group', 'create_user_id'),
				'to_messages' => array(self::HAS_MANY, 'Message', 'to_id'),
				'from_messages' => array(self::HAS_MANY, 'Message', 'from_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
				'id' => Yii::t('app', 'ID'),
				'full_name' => Yii::t('app', 'Full Name'),
				'email' => Yii::t('app', 'Email'),
				'mobile' => Yii::t('app', 'Mobile'),
				  
				'password' => Yii::t('app', 'Password'),
				'password_2' => Yii::t('app', 'Repeat Password'),
				  
				'first_name' => Yii::t('app', 'First Name'),
				'last_name' => Yii::t('app', 'Last Name'),
				'status_msg' => Yii::t('app', 'Status Message'),
				  
				'date_of_birth' => Yii::t('app', 'Date of Birth'),
				'gender' => Yii::t('app', 'Gender'),
				  
				'contact_address' => Yii::t('app', 'Contact Address'),
				'city' => Yii::t('app', 'City'),
				'country' => Yii::t('app', 'Country'),
				'zipcode' => Yii::t('app', 'Zipcode'),
				'image_file' => Yii::t('app', 'Image File'),
				  
				    
				'facebook_id' => Yii::t('app', 'Facebook Id'),
				 
				 
				'distance' => Yii::t('app', 'Distance'),
				'distance_type' => Yii::t('app', 'Distance Type'),
				'event_radius' => Yii::t('app', 'Event Radius'),
				'home_location' => Yii::t('app', 'Home Location'),
				'home_lat' => Yii::t('app', 'Home latitute'),
				'home_long' => Yii::t('app', 'Home longitute'),
				'work_location' => Yii::t('app', 'Work Location'),
				'work_lat' => Yii::t('app', 'Work latitute'),
				'work_long' => Yii::t('app', 'Work longitute'),
				  
				  
				'tos' => Yii::t('app', 'TOS'),
				'news_letters' => Yii::t('app', 'News letters'),
				  
				  
				'role_id' => Yii::t('app', 'Role'),
				'state_id' => Yii::t('app', 'State'),
				'type_id' => Yii::t('app', 'Type'),
				  
				  
				'is_busy' => Yii::t('app', 'Busy Status'),
				'last_visit_time' => Yii::t('app', 'Last Visit Time'),
				'last_action_time' => Yii::t('app', 'Last Action Time'),
				'last_password_change' => Yii::t('app', 'Last Password Change'),
				'activation_key' => Yii::t('app', 'Activation Key'),
				'login_error_count' => Yii::t('app', 'Login Error Count'),
				'create_user_id' => Yii::t('app', 'Create User id'),
				'create_time' => Yii::t('app', 'Create Time'),
				'authSessions' => null,
				'groups' => null,
				'to_messages' => null,
				'from_messages' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('full_name', $this->full_name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('mobile', $this->mobile);
		
		$criteria->compare('password', $this->password, true);
		
		$criteria->compare('first_name', $this->first_name, true);
		$criteria->compare('last_name', $this->last_name, true);
		$criteria->compare('status_msg', $this->status_msg, true);
		
		
		$criteria->compare('date_of_birth', $this->date_of_birth, true);
		$criteria->compare('gender', $this->gender);

		$criteria->compare('contact_address', $this->contact_address, true);
		$criteria->compare('city', $this->city, true);
		$criteria->compare('country', $this->country, true);
		$criteria->compare('zipcode', $this->zipcode);
		$criteria->compare('image_file', $this->image_file, true);
		
		$criteria->compare('facebook_id', $this->facebook_id, true);
		
		$criteria->compare('distance', $this->distance, true);
		$criteria->compare('distance_type', $this->distance_type);
		$criteria->compare('event_radius', $this->event_radius, true);
		$criteria->compare('home_location', $this->home_location, true);
		$criteria->compare('home_lat', $this->home_lat, true);
		$criteria->compare('home_long', $this->home_long, true);
		$criteria->compare('work_location', $this->work_location, true);
		$criteria->compare('work_lat', $this->work_lat, true);
		$criteria->compare('work_long', $this->work_long, true);
		
		
		$criteria->compare('tos', $this->tos);
		$criteria->compare('news_letters', $this->news_letters);
		
		$criteria->compare('role_id', $this->role_id);
		$criteria->compare('state_id', $this->state_id);
		$criteria->compare('type_id', $this->type_id);


		$criteria->compare('is_busy', $this->is_busy);
		$criteria->compare('last_visit_time', $this->last_visit_time, true);
		$criteria->compare('last_action_time', $this->last_action_time, true);
		$criteria->compare('last_password_change', $this->last_password_change, true);
		$criteria->compare('activation_key', $this->activation_key, true);
		$criteria->compare('login_error_count', $this->login_error_count);
		$criteria->compare('create_user_id', $this->create_user_id, true);
		$criteria->compare('create_time', $this->create_time, true);		
		
		
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}
}