<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * This is the model base class for the table "{{notification}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Notification".
 *
 * Columns in table "{{notification}}" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $to_user_id
 * @property string $message
 * @property integer $model_id
 * @property string $model_type
 * @property string $model_action
 * @property integer $state_id
 * @property integer $type_id
 * @property integer $create_user_id
 * @property string $create_time
 *
 */
abstract class BaseNotification extends GxActiveRecord {

	
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
			if ( !isset( $this->to_user_id )) $this->to_user_id = Yii::app()->user->id;			
		if ( !isset( $this->create_user_id )) $this->create_user_id = Yii::app()->user->id;			
		if ( !isset( $this->create_time )) $this->create_time = date( 'Y-m-d H:i:s');
		}else{
					}
		return parent::beforeValidate();
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{notification}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Notification|Notifications', $n);
	}

	public static function representingColumn() {
		return 'message';
	}

	public function rules() {
		return array(
			array('to_user_id, create_user_id', 'required'),
			array('to_user_id, model_id, state_id, type_id, create_user_id', 'numerical', 'integerOnly'=>true),
			array('model_type, model_action', 'length', 'max'=>100),
			array('message, create_time', 'safe'),
			array('message, model_id, model_type, model_action, state_id, type_id, create_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, to_user_id, message, model_id, model_type, model_action, state_id, type_id, create_user_id, create_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
				'toUser' => array(self::BELONGS_TO, 'User', 'to_user_id'),
				'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
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
			'message' => Yii::t('app', 'Message'),
			'model_id' => Yii::t('app', 'Model'),
			'model_type' => Yii::t('app', 'Model Type'),
			'model_action' => Yii::t('app', 'Model Action'),
			'state_id' => Yii::t('app', 'State'),
			'type_id' => Yii::t('app', 'Type'),
			'create_user_id' => Yii::t('app', 'Create User'),
			'create_time' => Yii::t('app', 'Create Time'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('to_user_id', $this->to_user_id);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('model_id', $this->model_id);
		$criteria->compare('model_type', $this->model_type, true);
		$criteria->compare('model_action', $this->model_action, true);
		$criteria->compare('state_id', $this->state_id);
		$criteria->compare('type_id', $this->type_id);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('create_time', $this->create_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}