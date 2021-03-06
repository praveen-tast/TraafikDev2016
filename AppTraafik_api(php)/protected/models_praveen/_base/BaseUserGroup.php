<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * This is the model base class for the table "{{user_group}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "UserGroup".
 *
 * Columns in table "{{user_group}}" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $state_id
 * @property integer $type_id
 * @property string $create_time
 *
  * @property User $user
  * @property Group $group
 */
abstract class BaseUserGroup extends GxActiveRecord {

	
	public static function getStatusOptions($id = null)
	{
		$list = array("In-Active","Active");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}	
	public static function getTypeOptions($id = null)
	{
		$list = array("Friend-list","Group");
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

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{user_group}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'UserGroup|UserGroups', $n);
	}

	public static function representingColumn() {
		return 'create_time';
	}

	public function rules() {
		return array(
			array('user_id, group_id', 'required'),
			array('user_id, group_id, state_id, type_id', 'numerical', 'integerOnly'=>true),
			array('create_time', 'safe'),
			array('state_id, type_id, create_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, user_id, group_id, state_id, type_id, create_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
				'user' => array(self::BELONGS_TO, 'User', 'user_id'),
				'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'user_id' => Yii::t('app', 'User'),
			'group_id' => Yii::t('app', 'Group'),
			'state_id' => Yii::t('app', 'State'),
			'type_id' => Yii::t('app', 'Type'),
			'create_time' => Yii::t('app', 'Create Time'),
		);
	}

	
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('group_id', $this->group_id);
		$criteria->compare('state_id', $this->state_id);
		$criteria->compare('type_id', $this->type_id);
		$criteria->compare('create_time', $this->create_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}