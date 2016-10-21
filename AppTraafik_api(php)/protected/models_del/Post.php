<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
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
 */
Yii::import('application.models._base.BasePost');
class Post extends BasePost
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	public function toArray()
	{
		$json_entry = array();
		$json_entry['id'] = $this->id;
	
		$json_entry['report_id'] = $this->report_id;
		$json_entry['report_name'] =  GxHtml::encode(GxHtml::valueEx($this->report_id)) ;	
	
		$json_entry['report_cause_id'] = $this->report_cause_id;
		$json_entry['reportCause_name'] = GxHtml::encode(GxHtml::valueEx($this->report_cause_id)) ;

		$json_entry['side_id'] = $this->side_id;		
		$json_entry['content'] = $this->content;
		
		
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
		//---------image-url--------------end--------
		//$json_entry['file_path'] = $this->file_path;		
		$json_entry['file_ext_type'] = $this->file_ext_type;
		
		
		$json_entry['latitude'] = $this->latitude;
		$json_entry['longitude'] = $this->longitude;
		$json_entry['address'] = $this->getCurrentAddress($this->latitude,$this->longitude);
		//$json_entry['address'] = $this->getCurrentAddress(30.7333148,76.7794179);
				
		//$json_entry['note_send_time'] = $this->note_send_time;
						
		//$json_entry['state_id'] = $this->state_id;
		//$json_entry['type_id'] = $this->type_id;
		
		$json_entry['expiry_duration'] = $this->expiry_duration;
	
		//$json_entry['create_user_id'] = $this->create_user_id;
		//$json_entry['username'] = $this->createUser->full_name;
		//$json_entry['user'] = $this->createUser->toArray();
	
		$user = User::model()->findByPk($this->create_user_id);
		$json_entry['create_user_id'] = $user->toArrayLogin();
		
		$json_entry['create_time'] = $this->create_time;
		$json_entry['update_time'] = $this->update_time;
	
		return $json_entry;
	}
	
	
	
	public function toArrayCount($result)
	{
		$json_entry = array();
		$json_entry['id'] = $result->id;
	
		$json_entry['report_id'] = $result->report_id;
		$json_entry['report_title'] = $result->report->title;
		$json_entry['report'] = $result->report->toArray();
		
		//$json_entry['counts'] = $result->counts;
	}
	
	/**
	 * Returns address from Google by passing lat/long
	 * @param numeric $latitude
	 * @param numeric $longitude
	 * @return string
	 */
	public static function getCurrentAddress($latitude, $longitude)
	{
		/* Pass Lat Long to this URL*/
		$url  = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false';
		$json  = @file_get_contents($url);
		$data  = json_decode($json, true);
	
		/* Specify Postion for formatted address array index */
		$current_address = $data['results']?$data['results'][0]['formatted_address']:"No address found";
	
		return $current_address;
	}
}