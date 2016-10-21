<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
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
 */
Yii::import('application.models._base.BaseNotification');
class Notification extends BaseNotification
{

	const STATUS_NEW 	= 0;
	const STATUS_READ 	= 1;
	
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function defaultScope()
	{
		if($this->hasAttribute('id'))	return array( 'order'=> 'id DESC');
		//if($this->hasAttribute('create_user_id'))	return array( 'condition'=> 'state_id < 1 AND create_user_id= ' . Yii::app()->user-id );
	
		return array();
	}
	
	
	/**
	 * Send values with --> (controller_name, table_id, defined message and action_name) in Notification
	 * @param unknown_type $model
	 * @param unknown_type $users
	 * @param unknown_type $msg
	 * @param unknown_type $api_action
	 * @return boolean|Notification
	 */
	
	public static function newNote($model, $users, $msg , $api_action)
	{
		
		$users = array_filter($users);
		$users =  is_array($users)? $users : array($users);
	
		foreach ($users as $user)
		{
			$notify = new Notification();
	
			$notify->message =  $msg;
			$notify->model_id = $model->id;
	
			$model_name = get_class($model);
			$notify->model_type = $model_name;
			$notify->model_action = $api_action;
	
			$notify->state_id = Notification::STATUS_NEW; 				
	
			$notify->to_user_id =  is_object($user)? $user->id : $user;
			$notify->create_user_id =  Yii::app()->user->id;				
	
			$notify->save();
				
			/*if ( $notify->toUser)
			{
				if($notify->isNewRecord && !(isset($msg)))
					$msg = 'New Notification' ;
	
				$arr1 = array('controller' => strtolower($model_name), 'id'=> $notify->model_id, "msg" => $msg, "action" => $api_action);
	
				$ret = $notify->toUser->sendGCM($arr1);
	
				if( $ret == "OK") $notify->state_id = 1;
	
				return true;
			}*/
		}
		return $notify;
	}

	public function toArray()
	{
		$model = $this;
		$json_entry = null;
		if ( $model )
		{
			$json_entry = array();
			$json_entry['id'] = $model->id;
			$json_entry['to_user_id'] = $model->to_user_id;
			$json_entry['message'] = $model->message;

			$json_entry['model_id'] = $model->model_id;
			$json_entry['model_type'] = $model->model_type;
			
			$class = $model->model_type;
			
			$model = $class::model()->findByPk( $model->model_id );
			
			$json_entry['model'] = $model->toArray();
			$json_entry['model_type'] =$class;

		//	$json_entry['model_action'] = $model->model_action;
			$json_entry['state_id'] = $model->state_id;
			$json_entry['type_id'] = $model->type_id;
			
			$json_entry['create_user_id'] = $model->create_user_id;
			$json_entry['username'] = $model->user->full_name;
			
			$json_entry['create_time'] = $model->create_time;						
		}
		return $json_entry;
	}
}