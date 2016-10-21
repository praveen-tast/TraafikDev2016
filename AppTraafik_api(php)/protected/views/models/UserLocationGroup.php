<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property string $duration
 * @property integer $duration_type
 * @property integer $state_id
 * @property integer $type_id
 * @property string $create_time
 */
Yii::import('application.models._base.BaseUserLocationGroup');
class UserLocationGroup extends BaseUserLocationGroup
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
public function toArray()
{
	$json_entry = array();
	$to_user = User::model()->findByPk($this->user_id);	
	
	$user_group = LocationGroup::model()->findByPk($this->group_id);
	$from_user = User::model()->findByPk($user_group->user_id);
	
// 	/var_dump($this->user_id);die;
	$json_entry['duration'] =  $this->duration;
	$json_entry['duration_type'] =  $this->duration_type;
	$json_entry['user_to'] =  $to_user->toArray();
	$json_entry['user_from'] =  $from_user->toArray();
	return $json_entry;	
	
}
	
	
}