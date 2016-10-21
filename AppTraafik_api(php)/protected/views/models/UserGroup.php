<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property integer $state_id
 * @property integer $type_id
 * @property string $create_time
 */
Yii::import('application.models._base.BaseUserGroup');
class UserGroup extends BaseUserGroup
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	public function toArray()
	{	
		$json_entry = array();
		$json_entry['id'] = $this->id;
	
		$json_entry['user_id'] = $this->user_id;
		$json_entry['user'] = $this->user->full_name;
	
		$json_entry['group_id'] = $this->group_id;
		$json_entry['group'] = $this->group->name;
	
		$json_entry['state_id'] = $this->state_id;
		$json_entry['type_id'] = $this->type_id;
	
		$json_entry['create_time'] = $this->create_time;
		return $json_entry;
	}
	
	public static  function saveUser($id,$group_id)
	{
		$addUser = new UserGroup();
		$addUser->user_id = $id;
		$addUser->group_id = $group_id;
		$addUser->state_id = 1;
		if($addUser->save())
		{
				return true;			
		}
		else
		{
			$err = '';
			foreach ($addUser->getErrors as $error)						
				$err = implode(',', $error);				
			return $err;
		}				
	}
}