<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	*/
	public $breadcrumbs=array();

	public $actions = array();
	public $menu_top = array();
	public $menu_left = array();


	public function sendJSONResponse( $arr)
	{
		header('Content-type: application/json');
		echo json_encode($arr);
		Yii::app()->end();
	}

	/**
	 * @return string the page heading (or caption). Defaults to the controller name and the action name,
	 * without the application name.
	 */

	/**
	 * @param string $value the page heading (or caption)
	 */


	/**
	 * @return string the page description (or subtitle). Defaults to the page title + 'page' suffix.
	 */

	/**
	 * @param string $value the page description (or subtitle)
	 */

	/**
	 * @param string $value the page description (or subtitle)
	 */
	public function setPageKeywords($value) {
		if ( !empty($value) ) $this->_pageKeywords = $value . ', ' . $this->_pageKeywords;
	}
	public function getPageKeywords() {
		if($this->_pageKeywords!==null)
		{
			$list = explode ( ',', $this->_pageKeywords);
			array_map('trim', $list);
			array_unique( $list);
			$this->_pageKeywords = implode ( ',', $list );
			return $this->_pageKeywords;
		}
		else
		{
			return Yii::app()->name . ', ' . $this->getPageCaption();
		}
	}

	protected function processSEO($model)
	{

	}


	public function init()
	{
		parent::init();

	}

	public function renderNavBar()
	{
		$this->menu_top = array(
				array(
						'class'=>'bootstrap.widgets.TbMenu',
						'items'=>array(
								array('label'=>'Create Account', 'url'=>array('/user/admin'),'visible'=>!Yii::app()->user->isGuest,),								
								array('label'=>'Disable', 'url'=>array('#'),'visible'=>!Yii::app()->user->isGuest,),
								array('label'=>'Reset', 'url'=>array('#'),'visible'=>!Yii::app()->user->isGuest,),
								array('label'=>'Reports', 'url'=>array('/post/admin'),'visible'=>!Yii::app()->user->isGuest,),
								//array('label'=>'Messages', 'url'=>array('/message/admin'),'visible'=>!Yii::app()->user->isGuest,),									
						),
				),

				/*array(
						'class'=>'bootstrap.widgets.TbMenu',
						'htmlOptions'=>array('class'=>'pull-right'),
						'items'=>array(
								array('label'=>'Log in', 'url'=>array('user/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest,
										array(
												array('label'=>'User', 'url'=>array('/user/admin'),'icon'=>'icon-user icon-white','visible'=>!Yii::app()->user->isGuest,),
										)),
									),
							),*/				
					);

		$this->widget('bootstrap.widgets.TbNavbar', array(
				//'type'=>'inverse', // null or 'inverse'
				'brand'=>false,
				//'brandUrl'=>Yii::app()->homeUrl,
				'collapse'=>false, // requires bootstrap-responsive.css
				'items'=>$this->menu_top,
				'fixed'=> false,
		));
	}
	public function renderSettingNavBar()
	{
		$this->menu_top = array(
				array(
						'class'=>'bootstrap.widgets.TbMenu',
						'items'=>array(
								array('label'=>'Change Password', 'url'=>array('#'),'visible'=>!Yii::app()->user->isGuest,),
								array('label'=>'Profile', 'url'=>array('#'),'visible'=>!Yii::app()->user->isGuest,),
						),
				),
	
				/*array(
				 'class'=>'bootstrap.widgets.TbMenu',
						'htmlOptions'=>array('class'=>'pull-right'),
						'items'=>array(
								array('label'=>'Log in', 'url'=>array('user/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest,
										array(
												array('label'=>'User', 'url'=>array('/user/admin'),'icon'=>'icon-user icon-white','visible'=>!Yii::app()->user->isGuest,),
										)),
						),
				),*/
		);
	
		$this->widget('bootstrap.widgets.TbNavbar', array(
				//'type'=>'inverse', // null or 'inverse'
				'brand'=>false,
				//'brandUrl'=>Yii::app()->homeUrl,
				'collapse'=>false, // requires bootstrap-responsive.css
				'items'=>$this->menu_top,
				'fixed'=> false,
		));
	}

	public function AddAnalytics()
	{


	}
	public function beforeAction($event)
	{
		AuthSession::authenticateSession();

		User::setUserOnline();
		//QuizSession::UpdateExpiredSessions();
		return parent::beforeAction($event);
	}

	public function addLog($msg )
	{

	}
}