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
					'actions'=>array('index','view', /* 'download', 'thumbnail' */
										'getAllTraffic','allPosts','postsByRole',
										'create','update','delete', 'search', 'reportCount','reports'
									),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('create','update','delete', 'search', 'reportCount'),
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
				$post->saveUploadedFile($post,'file_path');
				$arr['list'] = $post->toArray();
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
	
		if(isset($_POST['Post']))
		{
			$post = $this->loadModel($id, 'Post');
			$post->setAttributes($_POST['Post']);
	
			//$post->type_id = ;
			$post->saveUploadedFile($post,'file_path');
			if ($post->save()) {
				$arr['post'] = $post->toArray();
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
	public function actionView($id)
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		if($id)
		{
			$result = Post::model()->findByPk($id);
			
			if($result){
				$arr['list'] = $result->toArray();
				$arr['status'] = 'OK';
			}else{
				$arr['error'] = 'No detail found';
			}
		}
		else 
			$arr['error'] = 'No post found';
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
					'select'=>'id, report_id, count(*) AS counts',
					'distinct'=>true,
			);
							
			$results = Post::model()->findAll($criteria);
			if($results){
				
				$jsonlist = array();
				foreach ($results as $result)
				{
					$jsonlist[] = $result->toArrayCount();
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
	 * $rid here is report-type id 
	 * @param string $rid = report_id
	 */
	public function actionGetAllTraffic($rid = null)
	{
		
		//rid here is report-type id
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		$json = array();	

		$center_lat	= $_POST['Post']['latitude'];
		$center_lng =  $_POST['Post']['longitude'];
		if(isset($center_lat) && isset($center_lng))
		{
			
			/*$center_lat = 23.139422;
			$center_lng = -82.382617;*/
			$criteria = new CDbCriteria;			
			$criteria->select = " *, ( 3959 * acos( cos( radians($center_lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($center_lng) ) + sin( radians($center_lat) ) * sin( radians( latitude ) ) ) ) AS distance";
			$criteria->having = "distance <= $rid";
			$criteria->order = 'distance ASC';
			
			if($rid != null)			
			$posts = Post::model()->findAll($criteria);	
			else 
			$posts = Post::model()->findAll();
			
			
			if($posts){
			foreach ($posts as $post)
			{
				$json[] =  $post->toArray();				
			}
			
			$arr['posts'] = $json ;			
			$arr['status'] = 'OK';
			}
			else 
			{
				$arr['error'] = "No post found with given lat long" ;
				
			}

		}else{
			$arr['error'] = 'From/To location data not received..!';
		}
		
		$this->sendJSONResponse($arr);
	}
	
	public function actionAllPosts()
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
	
	
			$posts = Post::model()->findAll();
			if($posts){
				
					$jsonlist = array();
					foreach ($posts as $post)
					{
						$jsonlist[] = $post->toArray();
					}
					$arr['count'] = count($posts);
					$arr['list'] = $jsonlist;
					$arr['status'] = 'OK';
			
			}else{
				$arr['error'] = 'No Station found..!';
			}
	
		$this->sendJSONResponse($arr);
	}
	
	public function actionPostsByRole($role=null)
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		if($role)
		$users = User::model()->findAllByAttributes(array('role_id'=>$role));
		if($users)
		{
			$jsonuserlist = array();
			foreach ($users as $user)
			{
				$jsonuserlist[] = $user->id;
				
			}
			$criteria = new CDbCriteria();
			$criteria->addInCondition('create_user_id',$jsonuserlist);
			$posts = Post::model()->findAll($criteria);
			if($posts){
		
				$jsonlist = array();
				foreach ($posts as $post)
				{
					$jsonlist[] = $post->toArray();
				}
				$arr['count'] = count($posts);
				$arr['list'] = $jsonlist;
				$arr['status'] = 'OK';
					
			}else{
				$arr['error'] = 'No Report found..!';
			}
		}
		else 
		{			
			$arr['error'] = 'No Report Found';
		}
		$this->sendJSONResponse($arr);
	}
}