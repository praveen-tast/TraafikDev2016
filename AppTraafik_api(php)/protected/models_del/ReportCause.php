<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */
 
/**
 * @property integer $id
 * @property string $title
 * @property integer $report_id
 * @property integer $state_id
 * @property integer $type_id
 */
Yii::import('application.models._base.BaseReportCause');
class ReportCause extends BaseReportCause
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	
	public function toArray()
	{

	
		$json_entry = array();
		$json_entry['id'] = $this->id;
	
		$json_entry['title'] = $this->title;
		
		$json_entry['report_id'] = $this->report_id;
		$json_entry['report_title'] = $this->report->title;
		$json_entry['report'] = $this->report->toArray();	
	
		$json_entry['state_id'] = $this->state_id;
		$json_entry['type_id'] = $this->type_id;	
		
		return $json_entry;
	}
	
	
	
	public function toArrayReport()
	{
	
		$json_entry = array();
		$json_entry['id'] = $this->id;	
		$json_entry['title'] = $this->title;	
		$json_entry['report_id'] = $this->report_id;
		$json_entry['report_title'] = $this->report->title;		
		$json_entry['state_id'] = $this->state_id;
		$json_entry['type_id'] = $this->type_id;
	
		return $json_entry;
	}
}