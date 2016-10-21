<?php

class ReportController extends GxController {

	public function filters() {
		return array(
				'accessControl', 
				);
	}

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('index','view','count' /* 'download', 'thumbnail' */),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('create','update', 'search'),
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
	public function actionView($id) 
	{
		$model = $this->loadModel($id, 'Report');
	
		//if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));

		//$this->processActions($model);	
		$this->updateMenuItems($model);
		$this->render('view', array(
			'model' => $model
		));
	}

	public function actionCreate() 
	{
		$model = new Report;

		$this->performAjaxValidation($model, 'report-form');

		if (isset($_POST['Report'])) {
			$model->setAttributes($_POST['Report']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->updateMenuItems($model);
		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) 
	{
		$model = $this->loadModel($id, 'Report');
		
		//if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));
		
		$this->performAjaxValidation($model, 'report-form');

		if (isset($_POST['Report'])) {
			$model->setAttributes($_POST['Report']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->updateMenuItems($model);
		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) 
	{
		$model = $this->loadModel($id, 'Report');
		
		//if( !($this->isAllowed ( $model)))	throw new CHttpException(403, Yii::t('app','You are not allowed to access this page.'));
	
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Report')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() 
	{
		$this->updateMenuItems();
		$dataProvider = new CActiveDataProvider('Report');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}
	
	public function actionSearch()
	{
		$model = new Job('search');
		$model->unsetAttributes();
		$this->updateMenuItems($model);
	
		if (isset($_GET['Report']))
		{
			$model->setAttributes($_GET['Report']);
			$this->renderPartial('_list', array(
					'dataProvider' => $model->search(),
					'model' => $model,
			));
		}
			
		$this->renderPartial('_search', array(
				'model' => $model,
		));
	}
	public function actionAdmin() 
	{
		$model = new Report('search');
		$model->unsetAttributes();
		$this->updateMenuItems($model);
		
		if (isset($_GET['Report']))
			$model->setAttributes($_GET['Report']);-

		$this->render('admin', array(
			'model' => $model,
		));
	}
	public function actionCount()
	{
		$arr = array('controller' => $this->id , 'action' => $this->action->id , 'status' => 'NOK');
		$reports = Report::model()->findAll();	
		$json_array = array();		
		foreach ($reports as $report)
		{
			$posts = Post::model()->findAllByAttributes(array('report_id' => $report->id));				
			$json_array [$report->title] =count($posts) ;
	
		}
		$arr['count'] = $json_array;
		$arr['status'] = 'OK';
		$this->sendJSONResponse($arr);
	}
}