<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * @property integer $id
 * @property string $content
 * @property integer $to_id
 * @property integer $from_id
 * @property string $file_path
 * @property string $file_type
 * @property integer $group_id
 * @property string $session_id
 * @property string $latitude
 * @property string $longitude
 * @property integer $type_id
 * @property integer $state_id
 * @property string $received_time
 * @property string $create_time
 */
Yii::import('application.models._base.BaseMessage');
class Message extends BaseMessage
{

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	const STATUS_NEW_UNREAD = 0;
	const STATUS_READ  = 1;
	const STATUS_REMOVED  = 3;
	
	
	
	public function toArrayNewMessages()
	{
		$json_entry = array();
		$json_entry['id'] = $this->id;
		$json_entry['content'] = $this->content;
	
		$json_entry['to_id'] = $this->to_id;
		$json_entry['to_username'] = $this->to->full_name;
		$json_entry['to'] = $this->to->toArray();
	
		$json_entry['from_id'] = $this->from_id;
		$json_entry['from_username'] = $this->from->full_name;
		$json_entry['from'] = $this->from->toArray();
	
		$json_entry['session_id'] = $this->session_id;
	
		$json_entry['type_id'] = $this->type_id;
		$json_entry['state_id'] = $this->state_id;
			
		$json_entry['received_time'] = $this->received_time;
		$json_entry['create_time'] = $this->create_time;
	
		$this->received_time = date( 'Y-m-d H:i:s');
		$this->state_id = Message::STATUS_READ;
		$this->save();
	
		return $json_entry;
	}
	
	public function toArray()
	{
		$json_entry = array();
		$json_entry['id'] = $this->id;
	
		$json_entry['content'] = $this->content;
		
		$json_entry['to_id'] = $this->to_id;
		$json_entry['to_username'] = $this->to->full_name;
		$json_entry['to'] = $this->to->toArray();
	
		$json_entry['from_id'] = $this->from_id;
		$json_entry['from_username'] = $this->from->full_name;
		$json_entry['from'] = $this->from->toArray();		
		//---------image-url--------------start--------
		$img_default = 'user.png';
		$random_time = time();
		
		//$filename_Path = Yii::app()->createAbsoluteUrl(UPLOAD_PATH.$this->file_path);
		$filename_Path = Yii::app()->basePath .'/..' .UPLOAD_PATH. $this->file_path;
		if (file_exists($filename_Path)) {
			$update_time = '';
			$update_time = date ("Y-m-d H:i:s", filemtime($filename_Path));
			$json_entry['image_time'] = $update_time;
		}
		else $json_entry['image_time'] = '';		
		$image_url = isset($this->file_path) ? Yii::app()->createAbsoluteUrl('user/download',array('file'=>$this->file_path)) :
		Yii::app()->createAbsoluteUrl('user/download',array('file'=>$img_default));		
		$json_entry['file_path'] = $image_url;
	/*	//---------image-url--------------end--------
		//$json_entry['file_path'] = $this->file_path;
		//$json_entry['file_type'] = $this->file_type;
		 //  'image/jpg, image/png, video/mp4';			
		
		$json_entry['group_id'] = $this->group_id;
		 $json_entry['latitude'] = $this->latitude;
		$json_entry['longitude'] = $this->longitude;
		$json_entry['group'] = $this->group->toArray();	
		$json_entry['session_id'] = $this->session_id;		
		$json_entry['type_id'] = $this->type_id;
		$json_entry['state_id'] = $this->state_id;*/
			
		$json_entry['received_time'] = $this->received_time;
	
		return $json_entry;
	}
	
}