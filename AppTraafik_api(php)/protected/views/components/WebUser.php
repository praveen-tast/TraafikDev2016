<?php
class WebUser extends CWebUser
{
	private $_model = null;

	public function getModel() {

		if($this->isGuest) return null;

		if($this->_model instanceof User)
			return $this->_model;

		$this->_model = User::model()->findByPk($this->id);
		return $this->_model;
	}

	public function checkAccess($operation, $params=array(), $allowCaching=true)
	{
		return parent::checkAccess($operation, $params, $allowCaching);
	}

	public function loggedInAs() {
		if($this->isGuest)
			return Yii::t('Guest');
		else
			return $this->getModel()->full_name;
	}
	/**
	 * Return admin status.
	 * @return boolean
	 */
	

	public function getIsAdmin() {
		if($this->isGuest)
			return false;
		else
			return $this->getModel()->getIsAdmin();
	}
	public function getIsManager() {
		if($this->isGuest)
			return false;
		else
			return $this->getModel()->getIsManager();
	}
	public function getIsUser() {
		if($this->isGuest)
			return false;
		else
			return $this->getModel()->getIsUser();
	}
	public function afterLogin($fromCookie)
	{
		if(Yii::app()->user->model)Yii::app()->user->model->updateLastVisit();
	}
}
?>
