<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * This is the model base class for the table "{{invitation}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Invitation".
 *
 * Columns in table "{{invitation}}" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $to_user_id
 * @property string $email
 * @property string $name
 * @property string $mobile
 * @property string $contact_details
 * @property integer $state_id
 * @property integer $type_id
 * @property integer $invitation_count
 * @property string $create_time
 * @property integer $create_user_id
 *
 */
abstract class BaseInvitation extends GxActiveRecord {

	
	public static function getStatusOptions($id = null)
	{
		$list = array("Draft","Published","Archive");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}	
	public static function getTypeOptions($id = null)
	{
		$list = array("FACEBOOK","TWITTER","TYPE3");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}
 	public function beforeValidate()
	{
		if($this->isNewRecord)
		{
			if ( !isset( $this->to_user_id )) $this->to_user_id = Yii::app()->user->id;			
		if ( !isset( $this->create_time )) $this->create_time = new CDbExpression('NOW()');
			if ( !isset( $this->create_user_id )) $this->create_user_id = Yii::app()->user->id;			
	}else{
					}
		return parent::beforeValidate();
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{invitation}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Invitation|Invitations', $n);
	}

	public static function representingColumn() {
		return 'email';
	}

	public function rules() {
		return array(
			array('to_user_id, state_id, type_id, invitation_count, create_user_id', 'numerical', 'integerOnly'=>true),
			array('email, name', 'length', 'max'=>255),
			array('mobile', 'length', 'max'=>32),
			array('contact_details, create_time', 'safe'),
			array('to_user_id, email, name, mobile, contact_details, state_id, type_id, invitation_count, create_time, create_user_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, to_user_id, email, name, mobile, contact_details, state_id, type_id, invitation_count, create_time, create_user_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
				'inviteeUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'to_user_id' => Yii::t('app', 'To User'),
			'email' => Yii::t('app', 'Email'),
			'name' => Yii::t('app', 'Name'),
			'mobile' => Yii::t('app', 'Ph No'),
			'contact_details' => Yii::t('app', 'Contact Details'),
			'state_id' => Yii::t('app', 'State'),
			'type_id' => Yii::t('app', 'Type'),
			'invitation_count' => Yii::t('app', 'Invitation Count'),
			'create_time' => Yii::t('app', 'Create Time'),
			'create_user_id' => Yii::t('app', 'Create User'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('to_user_id', $this->to_user_id);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('mobile', $this->mobile, true);
		$criteria->compare('contact_details', $this->contact_details, true);
		$criteria->compare('state_id', $this->state_id);
		$criteria->compare('type_id', $this->type_id);
		$criteria->compare('invitation_count', $this->invitation_count);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('create_user_id', $this->create_user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}