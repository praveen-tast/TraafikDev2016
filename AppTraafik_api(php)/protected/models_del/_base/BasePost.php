<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * This is the model base class for the table "{{post}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Post".
 *
 * Columns in table "{{post}}" available as properties of the model,
 * followed by relations of table "{{post}}" available as properties of the model.
 *
 * @property integer $id
 * @property integer $report_id
 * @property integer $report_cause_id
 * @property integer $side_id
 * @property string $content
 * @property string $file_path
 * @property string $file_ext_type
 * @property string $latitude
 * @property string $longitude
 * @property string $note_send_time
 * @property integer $state_id
 * @property integer $type_id
 * @property string $expiry_duration
 * @property integer $create_user_id
 * @property string $create_time
 * @property string $update_time
 *
 * @property User $createUser
 * @property Report $report
 * @property ReportCause $reportCause
 */
abstract class BasePost extends GxActiveRecord {

	
	public static function getStatusOptions($id = null)
	{
		$list = array("UnApproved","Approved");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}	
	public static function getTypeOptions($id = null)
	{
		$list = array("Text","File:Image","File:Video");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}
	
	
	public static function getSideOptions($id = null)
	{
		$list = array("On-side","Off-Side");
		if ($id == null )	return $list;
		if ( is_numeric( $id )) return $list [ $id ];
		return $id;
	}
	
 	public function beforeValidate()
	{
		if($this->isNewRecord)
		{
				if ( !isset( $this->create_user_id )) $this->create_user_id = Yii::app()->user->id;			
		if ( !isset( $this->create_time )) $this->create_time =  date( 'Y-m-d H:i:s');//new CDbExpression('NOW()');
			}else{
						}
		return parent::beforeValidate();
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{post}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Post|Posts', $n);
	}

	public static function representingColumn() {
		return 'expiry_duration';
	}

	public function rules() {
		return array(
			array('report_id, side_id, expiry_duration', 'required'),
			array('report_id, report_cause_id, side_id, state_id, type_id, create_user_id', 'numerical', 'integerOnly'=>true),
			array('file_path', 'length', 'max'=>255),
			array('file_ext_type, latitude, longitude', 'length', 'max'=>32),
			array('note_send_time', 'length', 'max'=>50),
			array('expiry_duration', 'length', 'max'=>128),
			array('content, create_time, update_time', 'safe'),
			array('content, file_path, file_ext_type, latitude, longitude, note_send_time, state_id, type_id, create_time, update_time', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, report_id, report_cause_id, side_id, content, file_path, file_ext_type, latitude, longitude, note_send_time, state_id, type_id, expiry_duration, create_user_id, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
				'report' => array(self::BELONGS_TO, 'Report', 'report_id'),
				'reportCause' => array(self::BELONGS_TO, 'ReportCause', 'report_cause_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'report_id' => Yii::t('app', 'Report'),
			'report_cause_id' => Yii::t('app', 'Report Cause'),
			'side_id' => Yii::t('app', 'Side'),
			'content' => Yii::t('app', 'Content'),
			'file_path' => Yii::t('app', 'File Path'),
			'file_ext_type' => Yii::t('app', 'File Ext Type'),
			'latitude' => Yii::t('app', 'Latitude'),
			'longitude' => Yii::t('app', 'Longitude'),
			'note_send_time' => Yii::t('app', 'Note Send Time'),
			'state_id' => Yii::t('app', 'State'),
			'type_id' => Yii::t('app', 'Type'),
			'expiry_duration' => Yii::t('app', 'Expiry Duration'),
			'create_user_id' => null,
			'create_time' => Yii::t('app', 'Create Time'),
			'update_time' => Yii::t('app', 'Update Time'),
			'createUser' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('report_id', $this->report_id);
		$criteria->compare('report_cause_id', $this->report_cause_id);
		$criteria->compare('side_id', $this->side_id);
		$criteria->compare('content', $this->content, true);
		$criteria->compare('file_path', $this->file_path, true);
		$criteria->compare('file_ext_type', $this->file_ext_type, true);
		$criteria->compare('latitude', $this->latitude, true);
		$criteria->compare('longitude', $this->longitude, true);
		$criteria->compare('note_send_time', $this->note_send_time, true);
		$criteria->compare('state_id', $this->state_id);
		$criteria->compare('type_id', $this->type_id);
		$criteria->compare('expiry_duration', $this->expiry_duration, true);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}