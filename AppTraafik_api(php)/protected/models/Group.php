<?php

/**
 * Company: Yee Technologies Pvt. Ltd. < www.yeetechnologies.com >
 * Author : Praveen Shivhare < praveen.tuffgeekers@gmail.com >
 */

/**
 *
 * @property integer $id
 * @property string $name
 * @property integer $limits
 * @property integer $user_id
 * @property integer $type_id
 * @property string $create_time
 */
Yii::import ( 'application.models._base.BaseGroup' );
class Group extends BaseGroup {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function toArray() {
		$json_entry = array ();
		$json_entry ['id'] = $this->id;
		
		$json_entry ['name'] = $this->name;
		
		$json_entry ['limits'] = $this->limits;
		
		$json_entry ['user_id'] = $this->user_id;
		$json_entry ['username'] = $this->user->full_name;
		$json_entry ['user'] = $this->user->toArray ();
		
		$json_entry ['type_id'] = $this->type_id;
		
		$json_entry ['create_time'] = $this->create_time;
		return $json_entry;
	}
	public static function getGroup($from_user_id, $to_user_id) {
		$group = Group::model ()->findByPk ( $from_user_id );
		$user = User::model ()->findByPk ( $from_user_id );
		
		if (! $group) {
			$model = new Group ();
			$model->user_id = $from_user_id;
			$model->name = $user->full_name;
			if ($model->save ()) {
				
				$addUser = new UserGroup ();
				$addUser->user_id = $to_user_id;
				$addUser->group_id = $model->id;
				$addUser->state_id = 1; // Active
				$addUser->type_id = 0; // Friend List type
				if ($addUser->save ()) {
					$arr ['msg'] = "saved";
				} else {
					
					$err2 = '';
					foreach ( $addUser->getErrors () as $error )
						$err2 .= implode ( ".", $error );
					$arr ['error'] = $err2;
				}
			} else {
				$err = '';
				foreach ( $model->getErrors () as $error )
					$err .= implode ( ".", $error );
				$arr ['error'] = $err;
			}
		} else {
			$addUser = new UserGroup ();
			$addUser->user_id = $to_user_id;
			$addUser->group_id = $group->id;
			$addUser->state_id = 1; // Active
			$addUser->type_id = 0; // Friend List type
			if ($addUser->save ()) {
				$arr ['msg'] = "saved";
			} else {
				
				$err2 = '';
				foreach ( $addUser->getErrors () as $error )
					$err2 .= implode ( ".", $error );
				$arr ['error'] = $err2;
			}
		}
	}
}