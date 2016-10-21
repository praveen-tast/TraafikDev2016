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
Yii::import ( 'application.models._base.BaseLocationGroup' );
class LocationGroup extends BaseLocationGroup {
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function saveLocationGroup($from_user, $to_user, $time_limit,$type) {
		$json_entry = array();
		
		$group = LocationGroup::model ()->findByAttributes ( array (
				'user_id' => $from_user 
		) );
		$user = User::model ()->findByPk ( $from_user );
		$json_entry['from_user'] = $user->toArray();
		if (! $group) {
			$new_group = new LocationGroup ();
			$new_group->user_id = $from_user;
			$new_group->type_id = LocationGroup::TYPE_FRIEND_LIST_TYPE;
			$new_group->name = $user->full_name;
			if ($new_group->save ()) {
				$user_location_group = UserLocationGroup::model ()->findByAttributes ( array (
						'user_id' => $to_user,
						'group_id' => $new_group->id 
				) );
				if (! $user_location_group) {
				$this->saveUserLocationGroup($to_user,$new_group->id ,$time_limit,$type);
				$to_user = User::model ()->findByPk ( $to_user );
				$json_entry['to_user'] = $to_user->toArray();
				
				}
			} else {
				foreach ( $new_group->getErrors () as $error )
					$err = implode ( ',', $error );
				return $err;
			}
		} else {
			$user_location_group = UserLocationGroup::model ()->findByAttributes ( array (
					'user_id' => $to_user,
					'group_id' => $group->id 
			) );
			if (! $user_location_group) {
				
				$this->saveUserLocationGroup($to_user,$group->id ,$time_limit,$type);
				$to_user = User::model ()->findByPk ( $to_user );
				$json_entry['to_user'] = $to_user->toArray();
				
			}
			else 
			{
				$to_user = User::model ()->findByPk ( $to_user );
				$json_entry['to_user'] = $to_user->toArray();
				
			}
		}
		return $json_entry;
	}

	public static  function saveUserLocationGroup($to_user , $group_id,$time_limit,$type)
	{
				
		$new_user_location_group = new UserLocationGroup ();
		$new_user_location_group->user_id = $to_user;
		$new_user_location_group->group_id = $group_id;
		$new_user_location_group->duration = $time_limit;
		$new_user_location_group->duration_type = $type;
		$new_user_location_group->type_id = UserLocationGroup::TYPE_FRIEND_LIST_TYPE;
		$new_user_location_group->state_id = UserLocationGroup::STATE_ACTIVE;
		if ($new_user_location_group->save ()) {
			return true;
		} else {
			foreach ( $new_user_location_group->getErrors () as $error )
				$err = implode ( ',', $error );
			return $err;
		}
	}
	
	

}