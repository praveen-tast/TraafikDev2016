<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
				),
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page'=>array(
						'class'=>'CViewAction',
				),
		);
	}
	
	public function actionHelp()
	{

		$this->render('help');
	}
	
	public function actionIndex()
	{
		if(!Yii::app()->user->isGuest)
		{
			$this->redirect(array('user/account','id'=>Yii::app()->user->id));
		}else{
			$this->redirect(array('user/login'));			
		}
		$this->render('index');
	}
	
	public function actionSearch($q = null)
	{
		$criteria = new CDbCriteria;
		$criteria->addSearchCondition('title', $q );
		$criteria->addSearchCondition('content', $q );
		$this->render('search',
				array('video'=> new CActiveDataProvider('Video',array('criteria' => $criteria)),
				)
		);
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		//	Yii::app()->sms->send(array('to'=>'0918591102402', 'message'=>'Hello world!'));

		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionDownload()
	{
		$this->render('download');
	}

}