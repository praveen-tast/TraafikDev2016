<?php

class LocationGroupController extends GxController {

	public function filters() {
		return array(
				'accessControl', 
				);
	}

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('index','view', /* 'download', 'thumbnail' */							
							'create',
							'viewAll',
							'viewAllActive',
					),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('update', 'search'),
					'users'=>array('@'),
					),
				array('allow', 
					'actions'=>array('admin','delete'),
					'expression'=>'Yii::app()->user->isAdmin',
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function isAllowed($model) 
	{
		return $model->isAllowed();
	}

	
	
	//-----------------------------
	public function actionCreate() {
		
		$arr = array ('controller' => $this->action->id,'action' => $this->id,'status' => 'NOK');
		
		if($_REQUEST['from_user'])
			$id = $_REQUEST['from_user'];
		else
			$id = Yii::app ()->user->id;
		
		if($_REQUEST['to_user_email'] && $_REQUEST['duration'] &&  $_REQUEST['type']){
			
			$to_user_email = $_REQUEST['to_user_email'];
			$duration = $_REQUEST['duration'];
			$type = $_REQUEST['type'];
			
			$model_user = User::model ()->findByAttributes ( array ('email' => $to_user_email) );
			
			if ($model_user) {
				$location_group = LocationGroup::model ()->saveLocationGroup ( $id, $model_user->id, $duration, $type );
				if($location_group){
					$arr ['status'] = 'OK';
					$arr ['Locations'] = $location_group;
				}
			} else {			
				$arr ['message'] = 'No user found with the define email '. $to_user_email;
			}
		}
		else {		
			$arr ['error'] = 'Params error';			
		}
		$arr['params'] = $_REQUEST;
		
		$this->sendJSONResponse ( $arr );
	}
	
	
//-----------------------------
	public function actionUpdate() {
		/*
		$arr = array ('controller' => $this->action->id,'action' => $this->id,'status' => 'NOK');
		
		if($_REQUEST['from_user'])
			$id = $_REQUEST['from_user'];
		else
			$id = Yii::app ()->user->id;
		
		if($_REQUEST['to_user_email'] && $_REQUEST['duration'] &&  $_REQUEST['type']){
			
			$to_user_email = $_REQUEST['to_user_email'];
			$duration = $_REQUEST['duration'];
			$type = $_REQUEST['type'];
			
			$model_user = User::model ()->findByAttributes ( array ('email' => $to_user_email) );
			
			if ($model_user) {
				$location_group = LocationGroup::model ()->saveLocationGroup ( $id, $model_user->id, $duration, $type );
				if($location_group){
					$arr ['status'] = 'OK';
					$arr ['Locations'] = $location_group;
				}
			} else {			
				$arr ['message'] = 'No user found with the define email '. $to_user_email;
			}
		}
		else {
			$arr ['error'] = 'Params error';			
		}
		$arr['params'] = $_REQUEST;
		
		$this->sendJSONResponse ( $arr );
		*/
	}
		
		
	//-----------------------------
	/**
	 * 
	 * @param int $id
	 * @param int $active
	 */
	public function actionViewAll($id, $active = null) {
	
		$arr = array ('controller' => $this->action->id,'action' => $this->id,'status' => 'NOK');
	
		$user_id = Yii::app ()->user->id;
		if(!$user_id)
			$user_id = $id;
		
	
		if ($user_id) {
			$json = array ();
			$location_group = LocationGroup::model ()->findByAttributes ( array (
					'user_id' => $user_id
			) );
			if ($location_group) {
				
				if($active == UserLocationGroup::STATE_ACTIVE){
					$user_group_locations = UserLocationGroup::model ()->findAllByAttributes ( array (
							'group_id' => $location_group->id, 'state_id' =>  UserLocationGroup::STATE_ACTIVE
					) );
				}else {
					$user_group_locations = UserLocationGroup::model ()->findAllByAttributes ( array (
							'group_id' => $location_group->id 
					) );
				}
								
				if ($user_group_locations) {
					foreach ( $user_group_locations as $location ) {
						$user = User::model ()->findByPk ( $location->user_id );
						$json [] = $user->toArray ();
					}
					$arr ['user'] = $json;					
				} else {
					$arr ['message'] = "No user found";	
				}
									
			} else {
				$arr ['message'] = "No Record shared";				
			}
			$arr ['status'] = "OK";
			
		} else {
			$arr ['error'] = "User id is not defined";
		}
		$this->sendJSONResponse ( $arr );
	}
	
}