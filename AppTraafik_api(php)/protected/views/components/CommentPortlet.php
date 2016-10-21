<?php

Yii::import('zii.widgets.CPortlet');

class CommentPortlet extends CPortlet
{
	public $model = null;

	public function getRecentComments()
	{
		if ( $this->model == null ) return array();

		if (isset ($_POST['Comment']))
		{
			$comment = new Comment;
			$comment->setAttributes($_POST['Comment']);
			$comment->model_type = get_class($this->model);
			$comment->model_id = $this->model->id;
				
			$comment->save();
		
		}

		return Comment::model()->findAllByAttributes( array('model_type'=>get_class($this->model), 'model_id'=>$this->model->id));//->lastest();
	}

	protected function renderContent()
	{
		//if ( !Yii::app()->user->isGuest)
		//	$this->render('commentPortlet');
	}
}