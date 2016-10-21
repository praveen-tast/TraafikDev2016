<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * @property integer $id
 * @property string $title
 * @property integer $state_id
 * @property integer $type_id
 * @property string $expiry_duration
 */
Yii::import('application.models._base.BaseReport');
class Report extends BaseReport
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	public function toArray()
	{	
		$json_entry = array();
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('report_id ='.$this->id);
		$reportCauses = ReportCause::model()->findAll($criteria);
		
		
		$json_entry['id'] = $this->id;
	
		$json_entry['title'] = $this->title;
	
		$json = array();
		foreach ($reportCauses as $reportCause)
		{
			$json[] = $reportCause->toArrayReport();
			
		}
		
	    $json_entry['report_causes'] = $json;
		
		$json_entry['state_id'] = $this->state_id;
		$json_entry['type_id'] = $this->type_id;
	
		$json_entry['expiry_duration'] = $this->expiry_duration;
		return $json_entry;
	}
}