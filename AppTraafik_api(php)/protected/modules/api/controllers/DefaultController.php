<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		$this->sendJSONResponse($arr);
	}
}