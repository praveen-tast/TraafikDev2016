<?php


Yii::import('zii.widgets.grid.CButtonColumn');
Yii::import('bootstrap.widgets.TbButtonColumn');

class CxButtonColumn extends TbButtonColumn
{

	/**
	 * Initializes the column.
	 * This method registers necessary client script for the button column.
	 */
	public function init()
	{
		//$this->template='{view}{update}{delete}';//{update}
		$this->viewButtonUrl='$data->getUrl()';
		$this->updateButtonUrl='$data->getUrl("update")';
		$this->deleteButtonUrl='$data->getUrl("delete")';
		
		parent::init();
	}
}
