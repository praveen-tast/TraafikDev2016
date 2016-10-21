<?php

class PostController extends GxController {

	public function filters() {
		return array(
				'accessControl', 
				);
	}

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('index','view', /* 'download', 'thumbnail' */),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('create','update','delete', 'search'),
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


	/**
	 * Insert the new Post with, Report_id, Report-Cause_id, side_id(on/off=0/1), content, file_path, file_ext_type, latitude, longitude
	 * Method : POST
	 */		
	public function actionCreate()
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
	
		if(isset($_POST['Post']))
		{
			$post = new Post();
			$post->setAttributes($_POST['Post']);
	
			//$post->type_id = ;
	
			if ($post->save()) {
				$arr['list'] = $result->toArray();
				$arr['status'] = 'OK';
			}else{
				$arr['sent_to_server'] = $_POST;
				foreach( $post->getErrors() as $error)
					$err = implode( ".",$error);
				$arr['error'] = $err;
			}
		}else{
			$arr['error'] = 'Post data not received..!';
		}
	
		$this->sendJSONResponse($arr);
	}

	/**
	 * Update the post by ID
	 * Method : POST
	 * @param int $id
	 */
	public function actionUpdate($id) 
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
	
		if(isset($_POST['Post']) && isset($id))
		{
			$post = $this->loadModel($id, 'Post');
			$post->setAttributes($_POST['Post']);
	
			//$post->type_id = ;
	
			if ($post->save()) {
				$arr['status'] = 'OK';
			}else{
				$arr['sent_to_server'] = $_POST;
				foreach( $post->getErrors() as $error)
					$err = implode( ".",$error);
				$arr['error'] = $err;
			}
		}else{
			$arr['error'] = 'Post data not received..!';
		}
	
		$this->sendJSONResponse($arr);

	}

	/**
	 * Method : GET
	 * @param int $id
	 */
	public function actionDelete($id) 
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
	
		if(isset($id))
		{				
			$this->loadModel($id, 'Post')->delete();
			$arr['status'] = 'OK';
			
		}else{
			$arr['error'] = 'Post data not received..!';
		}
	
		$this->sendJSONResponse($arr);
	}


	/**
	 * Method : GET 
	 * @param int $id
	 */
	public function actionView($id=null)
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		if($id != null && id != '')
		{
			$result = Post::model()->findByPk($id);
			if($result){
				$arr['list'] = $result->toArray();
				$arr['status'] = 'OK';
			}else{
				$arr['error'] = 'No detail found';
			}
		}
		$this->sendJSONResponse($arr);
	}
	
	
	/**
	 * Method : GET
	 * @param int $id
	 * id here is 'report_id'
	 */
	public function actionReportCount($id=null)
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		if($id)
		{
			// count by single report_id
			$resultCount = Post::model()->countByAttributes(array('report_id'=> $id, 'create_user_id'=> Yii::app()->user->id));
			if($resultCount){
				$arr['counts'] = $resultCount;
				$arr['status'] = 'OK';
			}else{
				$arr['error'] = 'No detail found';
			}
		}
		else
		{			
			// count by report_id's group 
			$criteria= new CDbCriteria();
			$criteria=array(
					'group'=>'report_id',
					'select'=>'id,report_id,count(*) AS counts',
					'distinct'=>true,
			);
							
			$results = Post::model()->findAll($criteria);
			if($results){
				
				$jsonlist = array();
				foreach ($results as $result)
				{
					$jsonlist[] = $result->toArrayCount($result);
				}
				$arr['list'] = $jsonlist;
				//$arr['list'] = $result->toArrayCount($result);
				
				
				$arr['status'] = 'OK';
			}else{
				$arr['error'] = 'No detail found';
			}
		}
		$this->sendJSONResponse($arr);
	}
	
	
	/**
	 * 
	 * @param string $rid = report_id
	 */
	public function actionGetAllTraffic($rid = null)
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		
		if(isset($_POST['From']) && isset($_POST['To']) && $rid != null)
		{

			$from_lat = $_POST['From']['latitude'];
			$from_lng =  $_POST['From']['longitude'];
			
			$to_lat = $_POST['To']['latitude'];
			$to_lng =  $_POST['To']['longitude'];
			
			/*$query_radius = "SELECT *, ( 3959 * acos( cos( radians(-27.46794) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(153.02809) ) + sin( radians(-27.46794) ) * sin( radians( latitude ) ) ) ) AS distance FROM `tbl_post` `t` 
								HAVING distance <= 20 
							ORDER BY distance ASC, id DESC "; */
			
			
			
			
			
			
			$arr['status'] = 'OK';

		}else{
			$arr['error'] = 'From/To location data not received..!';
		}
		
		$this->sendJSONResponse($arr);
	}
	
}