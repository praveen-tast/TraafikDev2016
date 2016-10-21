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
						'actions'=>array('update', 'search','create','acceptInvitation','rejectInvitation'),
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
	
	public function actionCreate()
	{
		
		$arr = array('controller'=>$this->id, 'action'=>$this->action->id,'status' =>'NOK');
		$model = new Invitation();

		if(isset($_POST['Invitation']))
		{
			//var_dump($_POST['Invitation'] ["contact_details"]);die;
			//	$model->contact_details = $_POST['Invitation']['contact_details'];
			$records = array(array("id"=>0, "name"=>"aditffggi", "email"=>"aditi.tdfgfdguffgeekers@gmail.com","contact_no"=>"1254253456"));
			//$records = json_decode($_POST['Invitation']['contact_details']);

			//$arr['json_send'] = $records;

			foreach($records as $record)
			{					
				$issent = Invitation::check($record);
					
				if($issent)
				{
					$arr['success'] = "You have already send invitation";
					//$arr['status'] =  'OK';					
				}
				else {
					$model = new Invitation();
					//	$model->contact_details = $_POST['Invitation']['contact_details'];
					$model->to_user_id = $record['to_user_id'];
					$model->name = $record['name'];
					$model->email = $record['email'];
					$model->contact_no = $record['contact_no'];
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
	
	public function actionAcceptInvitation($id)
	{
		$arr = array("controller"=>$this->id,"action"=>$this->action->id,"status"=>"NOK");
		$invitation = $this->loadModel($id, 'Invitation');
		if($invitation)
		{
		
			$group = Group::model ()->findByPk ( $invitation->create_user_id );
			$user = User::model ()->findByPk ( $invitation->create_user_id );
			
			if (!$group) {
				$model = new Group ();
				$model->user_id = $invitation->create_user_id;
				$model->name = $user->full_name;
				if ($model->save ()) {

					$usergroup_criteria = UserGroup::model()->findByAttributes(array('user_id'=>$invitation->to_user_id,'group_id'=>$model->id));
				
					if(!$usergroup_criteria)
					{
					$addUser = new UserGroup ();
					$addUser->user_id = $to_user_id;
					$addUser->group_id = $model->id;
					$addUser->state_id = 1; // Active
					$addUser->type_id = 0; // Friend List type
					if ($addUser->save ()) {
						$arr ['message'] = "Invitation Accepted";
					$arr ['status'] = "OK";
					} else {
							
						$err2 = '';
						foreach ( $addUser->getErrors () as $error )
							$err2 .= implode ( ",", $error );
						$arr ['error'] = $err2;
					}
				}
				else {
					
					$arr ['message'] = "Yor have already  accepted invitation";
				
				}
				} else {
					$err = '';
					foreach ( $model->getErrors () as $error )
						$err .= implode ( ".", $error );
					$arr ['error'] = $err;
				}
			} else {
				
				$usergroup_criteria = UserGroup::model()->findByAttributes(array('user_id'=>$invitation->to_user_id,'group_id'=>$group->id));
				//var_dump($usergroup_criteria);die;
				if(!$usergroup_criteria){
				$addUser = new UserGroup ();
				$addUser->user_id = $invitation->to_user_id;
				$addUser->group_id = $group->id;
				$addUser->state_id = 1; // Active
				$addUser->type_id = 0; // Friend List type
				if ($addUser->save ()) {
					$arr ['message'] = "Invitation Accepted";
					$arr ['status'] = "OK";
				} else {
			
					$err2 = '';
					foreach ( $addUser->getErrors () as $error )
						$err2 .= implode ( ",", $error );
					$arr ['error'] = $err2;
				}
				
			}
				else {
					
					$arr ['message'] = "Yor have already  accepted invitation";
					
				}
				
			}		
			
		}
		else {
			$arr["message"] = "No Invitation found";
		}
		
		$this->sendJSONResponse($arr);
		
	}
}