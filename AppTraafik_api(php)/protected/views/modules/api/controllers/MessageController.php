<?php

class MessageController extends GxController {

 public function filters() {
  return array(
    'accessControl', 
    );
 }

 public function accessRules() {
  return array(
    array('allow',
     'actions'=>array('index','view', /* 'download', 'thumbnail' */
       
       'create','update', 'search',
        
       'getNew',
       'getAll',
	   'getAllMessage',
     ),
     'users'=>array('*'),
     ),
    array('allow', 
     'actions'=>array( 
       // 'create','update', 'search',        
     ),
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

 public function isAllowed($model){
  return $model->isAllowed();
 }

 
 
 
 
 /**
  * Method : REQUEST(get/post)
  * Save a message (from a user) - (to a user)
  */
 public function actionCreate()
 {
  $arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
 
  if(isset($_REQUEST['Message']))
  {
   $post = new Message();
   $post->setAttributes($_REQUEST['Message']);
 
   //$post->type_id = ;
 
   if ($post->save()) {
 
    $arr['list'] = $post->toArray();
    $arr['status'] = 'OK';
   }else{
    $arr['sent_to_server'] = $_REQUEST;
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
  * @param integer $toid
  * @param integer $fromid
  */
 public function actionGetNew($toid,$fromid)
 {
  $arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
  $json = array();
  
  if(isset($fromid) && isset($toid))
  {
   //$result = Message::model()->findByPk($id);
   /*
   $results = Message::model()->findAllByAttributes(
     array('to_id'=>$toid, 'from_id' => $fromid, 'state_id'=>Message::STATUS_NEW_UNREAD ), 
       array('order' => 'id desc',));   
   */
   
   $criteria = new CDbCriteria;
   $criteria->condition = "(to_id=$toid AND from_id=$fromid) OR (to_id=$fromid AND from_id=$toid)";
   $criteria->order = "create_time asc";
   $results = Message::model()->findAll($criteria);
   
   if($results){
    foreach ($results as $result)
    {      
     $json[] = $result->toArrayNewMessages();//$result->toArray();            
    }
    $arr['list'] = $json;
    $arr['status'] = 'OK';
   }else{
    $arr['error'] = 'No record found';
   }    
  }
  else
  {
   $arr['toid'] = $toid;
   $arr['fromid'] = $fromid;
   $arr['error'] = 'No post found';
  }
  $this->sendJSONResponse($arr);
 }
 
 /**
  * Method : GET
  * @param integer $toid
  * @param integer $fromid
  */
 public function actionGetAll($toid,$fromid)
 {
  $arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
  $json = array();
  
  if(isset($fromid) && isset($toid))
  {
   //$result = Message::model()->findByPk($id);
   //$results = Message::model()->findAllByAttributes(array('to_id'=>$toid, 'from_id' => $fromid ), array('order' => 'id desc',));
   $criteria = new CDbCriteria;
   $criteria->condition = "(to_id=$toid AND from_id=$fromid) OR (to_id=$fromid AND from_id=$toid)";
   $criteria->order = "create_time asc";
   $results = Message::model()->findAll($criteria);
   if($results){
    foreach ($results as $result)
    {      
     $json[] = $result->toArray();            
    }
    $arr['list'] = $json;
    $arr['status'] = 'OK';
   }else{
    $arr['error'] = 'No record found';
   }
  }
  else
  {
   $arr['toid'] = $toid;
   $arr['fromid'] = $fromid;
   $arr['error'] = 'No post found';
  }
  $this->sendJSONResponse($arr);
 }
  public function actionGetAllMessage($fromid)
 {
  $arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
  $json = array();
  
  if(isset($fromid))
  {
   //$result = Message::model()->findByPk($id);
   //$results = Message::model()->findAllByAttributes(array('to_id'=>$toid, 'from_id' => $fromid ), array('order' => 'id desc',));
   $criteria = new CDbCriteria;
   $criteria->addCondition('to_id='.$fromid);
   $criteria->addCondition('from_id='.$fromid,'OR');
  // $criteria->condition = "(to_id=$fromid OR from_id=$fromid)";
  // $criteria->order = "create_time asc";
   $results = Message::model()->findAll($criteria);
   if($results){
    foreach ($results as $result)
    {      
     $json[] = $result->toArray();            
    }
    $arr['list'] = $json;
    $arr['status'] = 'OK';
   }else{
    $arr['error'] = 'No record found';
   }
  }
  else
  {
   $arr['fromid'] = $fromid;
   $arr['error'] = 'No post found';
  }
  $this->sendJSONResponse($arr);
 }
 
 
}