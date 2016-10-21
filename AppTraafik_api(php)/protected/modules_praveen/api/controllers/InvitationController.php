<?php

class InvitationController extends GxController {

	public function filters() {
		return array(
				'accessControl',
		);
	}

	public function accessRules() {
		return array(
				array('allow',
						'actions'=>array('index','view','timerSync' /* 'download', 'thumbnail' */),
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

	/*
	public function actionCreate()
	{
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		$model = new Invitation();

		if(isset($_POST['Invitation']))
		{
			//	$model->contact_details = $_POST['Invitation']['contact_details'];

			$records = json_decode($_POST['Invitation']['contact_details']);

			$arr['json_send'] = $records;

			foreach($records as $record)
			{					
				$issent = Invitation::check($record);
					
				if($issent)
				{
					$arr['success'] = "You have already send invitation";
					$arr['status'] =  'OK';					
				}
				else {
					$model = new Invitation();
					//	$model->contact_details = $_POST['Invitation']['contact_details'];
					$model->name = $record->name;
					$model->email =$record->email;
					$model->mobile = $record->mobile;
					if($model->save())
					{
						Invitation::checkUser($model);
						if(isset($model->email) && !empty($model->email))
						{
							$model->sendInvitationEmail();
							$arr['success'] =  'Invitation Send Successfully';
							$arr['status'] =  'OK';
						}
						else {
							//	$model->sendInvitationMobile($record);
						}
					}
					else
					{
						$err = '';
						foreach( $model->getErrors() as $error)
							$err .= implode( ".",$error);
						$arr['error'] = $err;
					}
				}						
			}
		}
		$this->sendJSONResponse($arr);
	}*/
}