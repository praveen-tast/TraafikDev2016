<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */

/**
 * @property integer $id
 * @property integer $to_user_id
 * @property string $email
 * @property string $name
 * @property string $mobile
 * @property string $contact_details
 * @property integer $state_id
 * @property integer $type_id
 * @property integer $invitation_count
 * @property string $create_time
 * @property integer $create_user_id
 */
Yii::import('application.models._base.BaseInvitation');
class Invitation extends BaseInvitation
{

	const TYPE_FACEBOOK	= 1;
	const TYPE_TWITTER	= 2;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function toArray()
	{

		$json_entry = array();
		$json_entry['id'] = $this->id;

		$json_entry['to_user_id'] = $this->to_user_id;
		$json_entry['email'] = $this->email;

		$json_entry['name'] = $this->name;
		$json_entry['mobile'] = $this->mobile;

		$json_entry['contact_details'] = $this->contact_details;
		$json_entry['state_id'] = $this->state_id;
		$json_entry['type_id'] = $this->type_id;

		$json_entry['invitation_count'] = $this->invitation_count;

		$json_entry['create_user_id'] = $this->create_user_id;

		$json_entry['create_time'] = $this->create_time;
		return $json_entry;
	}


	//----
	public static function checkContact($model)
	{
		$email = $model->email;
		$mobile = $model->mobile;
		$invitation = Invitation::model()->findByAttributes(array('mobile'=>$mobile));
		if(!$invitation)
		{
			$invitation = Invitation::model()->findByAttributes(array('email'=>$email));

		}
		if($invitation)
		{
				
		}
	}


	public static function checkUser($model)
	{
		$curuser = User::model()->findByPk(Yii::app()->user->id);

		$email = $model->email;
		$mobile = $model->mobile;

		$user = User::model()->findByAttributes(array('mobile'=>$mobile));
		if(!$user)
		{
			$user = User::model()->findByAttributes(array('email'=>$email));
		}
		if($user)
		{
				
		}
	}

	public function isAlreadySend()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('email = \''.$this->email.'\'');
		$criteria->addCondition('create_user_id = \'' . Yii::app()->user->id . '\'');
		$invitation = Invitation::model()->find($criteria);
		if($invitation)
			return true;
		return false;
	}

	public static function check($record)
	{
		if(isset($record->mobile))
		{
			//	$words = array("+", " ", "-");
			$record->mobile = str_replace("+", "", $record->mobile);
		}
		$criteria = new CDbCriteria;
		$criteria->addCondition('email = \''.$record->email.'\'');
		$criteria->addCondition('create_user_id = \''.Yii::app()->user->id.'\'');
		$issent = Invitation::model()->find($criteria);
		if(!$issent || $issent->email ==  null || empty($issent->email) )
		{
			$criteria1 = new CDbCriteria;
			$criteria1->addCondition('mobile = \''.$record->mobile.'\'');
			$criteria1->addCondition('create_user_id = \''.Yii::app()->user->id.'\'');
			$issent = Invitation::model()->find($criteria1);
			$arr['mobile'] = $record->mobile;
		}

		if($issent)
			return true;
		return false;
	}

	public static function sendEmailLoadShared($message)
	{
		return true;
	}

	public function sendInvitationEmail()
	{

		Yii::import('ext-prod.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$to = $this->email;
		$message->view = 'invitation';
		$message->setSubject('Invitation Email' .' ' .' '. Yii::app()->params['company']);
		//userModel is passed to the view
		$message->setBody(array('model'=>$this), 'text/html');
		$message->addTo($to);
		$message->from = Yii::app()->params['adminEmail'];
		if( self::sendEmailLoadShared($message))
		{
			$this->state_id = 1;
			$this->saveAttributes(array('state_id'));
		}
	}


	public static function sendFailureEmail()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('state_id = 0');
		$criteria->limit = 50;
		$models = self::model()->findAll($criteria);

		if($models)
		{
			foreach($models as $model)
			{
				if(isset($model->email) && !empty($model->email))
				{
					if( self::sendfEmail($model))
					{
						$model->state_id = 1;
						$model->saveAttributes(array('state_id'));
					}
				}
			}
		}
	}


	public static function sendfEmail($model)
	{
		Yii::import('ext-prod.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$message->view = 'invitation';
		$message->setSubject('Invitation' . Yii::app()->params['company']);
		// userModel is passed to the view
		$message->setBody(array('model'=>$model), 'text/html');
		$message->addTo($model->email);
		$message->from = Yii::app()->params['adminEmail'];
		return self::sendEmailLoadShared($message);
	}



	public static function sendRemainderInvitationEmail()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('state_id = 1');
		$criteria->limit = 50;
		$models = self::model()->findAll($criteria);
		if($models)
		{
			foreach($models as $model)
			{
				if(isset($model->email) && !empty($model->email))
				{
					if( self::sendRemEmail($model))
					{
						$model->state_id = 2;
						$model->saveAttributes(array('state_id'));
					}
				}
			}
		}
	}


	public static function sendMyRemEmail()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('state_id = 1');
		$criteria->addCondition('create_user_id =' .Yii::app()->user->id);
		$criteria->limit = 50;
		$models = self::model()->findAll($criteria);
		if($models)
		{
			foreach($models as $model)
			{
				if(isset($model->email) && !empty($model->email))
				{
					if( self::sendRemEmail($model))
					{
						$model->state_id = 2;
						$model->saveAttributes(array('state_id'));
					}
				}
			}
		}
	}


	public static function sendRemEmail($model)
	{
		Yii::import('ext-prod.yii-mail.YiiMailMessage');
		$message = new YiiMailMessage;
		$message->view = 'remander_invitation';
		$message->setSubject(' Remainder to Join ' . Yii::app()->params['company']);
		//userModel is passed to the view
		$message->setBody(array('model'=>$model), 'text/html');
		$message->addTo($model->email);
		$message->from = Yii::app()->params['adminEmail'];
		return self::sendEmailLoadShared($message);
	}


	public function sendInvitationMobile($record)
	{
		$message = 'TraafikApp is a Traffic-Geo application, please download it from google app';

		Yii::app()->sms->send(array('to'=>$record->mobile, 'message'=>$message));
	}
}