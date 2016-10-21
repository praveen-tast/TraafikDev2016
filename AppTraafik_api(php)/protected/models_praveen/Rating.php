<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * @property integer $id
 * @property integer $post_id
 * @property integer $points
 * @property integer $state_id
 * @property integer $type_id
 * @property integer $create_user_id
 * @property string $create_time
 */
Yii::import('application.models._base.BaseRating');
class Rating extends BaseRating
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	
	public function toArray()
	{
		$json_entry = array();
		$json_entry['id'] = $this->id;
	
		$json_entry['post_id'] = $this->post_id;	
		$json_entry['post'] = $this->post->toArray;
	
		$json_entry['points'] = $this->points;
	
		$json_entry['state_id'] = $this->state_id;
		$json_entry['type_id'] = $this->type_id;
	
		$json_entry['create_user_id'] = $this->create_user_id;
		$json_entry['username'] = $this->createUser->full_name;
		$json_entry['user'] = $this->createUser->toArray();
		
		$json_entry['create_time'] = $this->create_time;
		
		return $json_entry;
	}
}