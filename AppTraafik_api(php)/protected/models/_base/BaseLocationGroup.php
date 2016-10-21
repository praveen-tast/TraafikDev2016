<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * This is the model base class for the table "{{location_group}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "LocationGroup".
 *
 * Columns in table "{{location_group}}" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property integer $limits
 * @property integer $user_id
 * @property integer $type_id
 * @property string $create_time
 *
 */
abstract class BaseLocationGroup extends GxActiveRecord {
	
	const TYPE_FRIEND_LIST_TYPE = 0;
	const TYPE_GROUP_TYPE = 1;

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
			if ( !isset( $this->user_id )) $this->user_id = Yii::app()->user->id;			
		if ( !isset( $this->create_time )) $this->create_time = new CDbExpression('NOW()');
		}else{
				}
		return parent::beforeValidate();
	}
	
	public function beforeSave()
	{
		if($this->isNewRecord)
		{
			if ( !isset( $this->user_id )) $this->user_id = Yii::app()->user->id;
			//if ( !isset( $this->create_time )) $this->create_time = new CDbExpression('NOW()');
		}else{
		}
		return parent::beforeSave();
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{location_group}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'LocationGroup|LocationGroups', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('user_id, create_time', 'required'),
			array('limits, user_id, type_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('limits, type_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, limits, user_id, type_id, create_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'limits' => Yii::t('app', 'Limits'),
			'user_id' => Yii::t('app', 'User'),
			'type_id' => Yii::t('app', 'Type'),
			'create_time' => Yii::t('app', 'Create Time'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('limits', $this->limits);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('type_id', $this->type_id);
		$criteria->compare('create_time', $this->create_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}