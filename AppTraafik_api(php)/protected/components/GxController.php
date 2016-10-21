<?php


define('CACHE_DURATION', 50);


abstract class GxController extends Controller
{

	public $tabs_data = null;
	public $tabs_name = null;

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

		);
	}
	/**
	 * Returns the data model based on the primary key or another attribute.
	 * This method is designed to work with the values passed via GET.
	 * If the data model is not found or there's a malformed key, an
	 * HTTP exception will be raised.
	 * #MethodTracker
	 * This method is based on the gii generated method controller::loadModel, from version 1.1.7 (r3135). Changes:
	 * <ul>
	 * <li>Support to composite PK.</li>
	 * <li>Support to use any attribute (column) name besides the PK.</li>
	 * <li>Support to multiple attributes.</li>
	 * <li>Automatically detects the PK column names.</li>
	 * </ul>
	 * @param mixed $key The key or keys of the model to be loaded.
	 * If the key is a string or an integer, the method will use the tables' PK if
	 * the PK has a single column. If the table has a composite PK and the key
	 * has a separator (see below), the method will detect it and use it.
	 * <pre>
	 * $key = '12-27'; // PK values with separator for tables with composite PK.
	 * </pre>
	 * If $key is an array, it can be indexed by integers or by attribute (column)
	 * names, as for {@link CActiveRecord::findByAttributes}.
	 * If the array doesn't have attribute names, as below, the method will use
	 * the table composite PK.
	 * <pre>
	 * $key = array(
	 *   12,
	 *   27,
	 *   ...,
	 * );
	 * </pre>
	 * If the array is indexed by attribute names, as below, the method will use
	 * the attribute names to search for and load the model.
	 * <pre>
	 * $key = array(
	 *   'model_id' => 44,
	 * 	 ...,
	 * );
	 * </pre>
	 * Warning: each attribute used should have an index on the database and the set of
	 * attributes used should identify only one item on the database (the attributes being
	 * ideally part of or multiple unique keys).
	 * @param string $modelClass The model class name.
	 * @return GxActiveRecord The loaded model.
	 * @see GxActiveRecord::pkSeparator
	 * @throws CHttpException if there's an invalid request (with code 400) or if the model is not found (with code 404).
	 */
	public function loadModel($key, $modelClass) {

		// Get the static model.
		$staticModel = GxActiveRecord::model($modelClass);

		if (is_array($key)) {
			// The key is an array.
			// Check if there are column names indexing the values in the array.
			reset($key);
			if (key($key) === 0) {
				// There are no attribute names.
				// Check if there are multiple PK values. If there's only one, start again using only the value.
				if (count($key) === 1)
					return $this->loadModel($key[0], $modelClass);

				// Now we will use the composite PK.
				// Check if the table has composite PK.
				$tablePk = $staticModel->getTableSchema()->primaryKey;
				if (!is_array($tablePk))
					throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

				// Check if there are the correct number of keys.
				if (count($key) !== count($tablePk))
					throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

				// Get an array of PK values indexed by the column names.
				$pk = $staticModel->fillPkColumnNames($key);

				// Then load the model.
				$model = $staticModel->findByPk($pk);
			} else {
				// There are attribute names.
				// Then we load the model now.
				$model = $staticModel->findByAttributes($key);
			}
		} else {
			// The key is not an array.
			// Check if the table has composite PK.
			$tablePk = $staticModel->getTableSchema()->primaryKey;
			if (is_array($tablePk)) {
				// The table has a composite PK.
				// The key must be a string to have a PK separator.
				if (!is_string($key))
					throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

				// There must be a PK separator in the key.
				if (stripos($key, GxActiveRecord::$pkSeparator) === false)
					throw new CHttpException(400, Yii::t('giix', 'Your request is invalid.'));

				// Generate an array, splitting by the separator.
				$keyValues = explode(GxActiveRecord::$pkSeparator, $key);

				// Start again using the array.
				return $this->loadModel($keyValues, $modelClass);
			} else {
				// The table has a single PK.
				// Then we load the model now.
				$model = $staticModel->findByPk($key);
			}
		}

		// Check if we have a model.
		if ($model === null)
			throw new CHttpException(404, Yii::t('giix', 'The requested page does not exist.'));

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * #MethodTracker
	 * This method is based on the gii generated method controller::performAjaxValidation, from version 1.1.7 (r3135). Changes:
	 * <ul>
	 * <li>Supports multiple models.</li>
	 * </ul>
	 * @param CModel|array $model The model or array of models to be validated.
	 * @param string $form The name of the form. Optional.
	 */
	protected function performAjaxValidation($model, $form = null) {
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($form === null) || ($_POST['ajax'] == $form))) {
			echo GxActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Finds the related primary keys specified in the form POST.
	 * Only for HAS_MANY and MANY_MANY relations.
	 * @param array $form The post data.
	 * @param array $relations A list of model relations in the format returned by {@link CActiveRecord::relations}.
	 * @param string $uncheckValue Since Yii 1.1.7, htmlOptions (in {@link CHtml::activeCheckBoxList})
	 * has an option named 'uncheckValue'. If you set it to different values than the default value (''), you will
	 * need to set the appropriate value to this argument. This method can't be used when 'uncheckValue' is null.
	 * @return array An array where the keys are the relation names (string) and the values are arrays with the related model primary keys (int|string) or composite primary keys (array with pk name (string) => pk value (int|string)).
	 * Example of returned data:
	 * <pre>
	 * array(
	 *   'categories' => array(1, 4),
	 *   'tags' => array(array('id1' => 3, 'id2' => 7), array('id1' => 2, 'id2' => 0)) // composite pks
	 * )
	 * </pre>
	 * An empty array is returned in case there is no related pk data from the post.
	 * This data comes directly from the form POST data.
	 * @see GxHtml::activeCheckBoxList
	 * @throws InvalidArgumentException If uncheckValue is null.
	 */
	protected function getRelatedData($form, $relations, $uncheckValue = '') {
		if ($uncheckValue === null)
			throw new InvalidArgumentException(Yii::t('giix', 'giix cannot handle automatically the POST data if "uncheckValue" is null.'));

		$relatedPk = array();
		foreach ($relations as $relationName => $relationData) {
			if (isset($form[$relationName]) && (($relationData[0] == GxActiveRecord::HAS_MANY) || ($relationData[0] == GxActiveRecord::MANY_MANY)))
				$relatedPk[$relationName] = $form[$relationName] === $uncheckValue ? null : $form[$relationName];
		}
		return $relatedPk;
	}

	public function StartPanel($name = 'tabpanel1')
	{
		$this->tabs_name = $name;
		$this->tabs_data = array();

	}
	public function AddPanel($title, $objects, $relations, $view, $model = null, $addMenu = true)
	{
		if ( $addMenu ) $this->menu[] = array('label'=>Yii::t('app', 'Add ') . $title , 'url'=>array($view .'/create', 'id'=> $model ? $model->id :null, 'icon'=>'icon-plus icon-white'));

		if ( $objects )
		{

			if ( $objects instanceof CActiveDataProvider)
				$dataProvider = $objects;
			else $dataProvider = new CArrayDataProvider($objects);

			if ( $dataProvider->getItemCount())
			{
				$content = $this->renderPartial('/'.$view.'/_list',array('dataProvider'=>$dataProvider),true);
				$this->tabs_data[] = array('label'=>$title, 'content'=>$content, 'active'=> count ( $this->tabs_data) == 0 ? true: false);
			}
		}
	}
	public function EndPanel()
	{
		$this->widget('bootstrap.widgets.TbTabs', array(
				'type'=>'tabs', // 'tabs' or 'pills'
				'tabs'=>$this->tabs_data,
				//	'htmlOptions'=>array('class'=>'tabbable tabs-left well')
		));

	}
	public function EndPanelLeft()
	{
		$this->widget('bootstrap.widgets.TbTabs', array(
				'type'=>'tabs', // 'tabs' or 'pills'
				'tabs'=>$this->tabs_data,
				'htmlOptions'=>array('class'=>'tabbable tabs-left well')
		));

	}
	public function EndPanelRight()
	{
		$this->widget('bootstrap.widgets.TbTabs', array(
				'type'=>'tabs', // 'tabs' or 'pills'
				'tabs'=>$this->tabs_data,
				'htmlOptions'=>array('class'=>'tabbable tabs-right well')
		));

	}


	public function getAutoCompleteListFromUrl($model, $attribute, $url = 'user/active')
	{
		$this->widget('ext.widgets.MultiComplete', array(
				'model'=>$model,
				'attribute'=>$attribute,
				'splitter'=>',',
				'sourceUrl'=>$this->createUrl($url),
				// additional javascript options for the autocomplete plugin
				'options'=>array(
						'minLength'=>'1',
				),
				'htmlOptions'=>array(
						'size'=>'60'
				),
		));
	}
	public function getAutoCompleteFromArary($model, $attribute,$array_list)
	{
		$this->widget('ext.widgets.MultiComplete', array(
				//$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model'=>$model,
				'attribute'=>$attribute,
				'splitter'=>',',
				'source'=>$array_list,
				// additional javascript options for the autocomplete plugin
				'options'=>array(
						'minLength'=>'1',
				),
				'htmlOptions'=>array(
						'size'=>'60'
				),
		));
	}
	protected function richTextEditor()
	{
		return 0; //0 // mean no rich text editor
	}
	public function actionUpload($name = 'filedata')
	{
		$uploaded_file = CUploadedFile::getInstanceByName( $name);
		if(isset( $uploaded_file))
		{
			$filename = Yii::app()->basePath .'/..' . UPLOAD_PATH . basename($uploaded_file);
			if ( file_exists($filename))$filename = Yii::app()->basePath .'/..' . UPLOAD_PATH . time().'_' . basename($uploaded_file);
			$uploaded_file->saveAs(  $filename);
			$data = array(
					'err' => '',
					'msg' => $this->CreateUrl( 'download',array('file' => basename($filename))),
			);
			echo CJSON::encode($data);
		}
		Yii::app()->end();
	}

	public function downloadAs($title, $tpl, $name, $content, $type='pdf')
	{
		$types = array(
				'text' => 'text/plain',
				'pdf' => 'application/pdf',
				'word' => 'application/msword'
		);

		$exts = array(
				'text' => 'txt',
				'pdf' => 'pdf',
				'word' => 'doc'
		);

		// Load anything?
		$out_file = $tpl . '.' . $exts[ $type ];
		if( $type == 'pdf' )
		{
			$pdf = Yii::createComponent('ex-prod.tcpdf.ETcPdf', 'P', 'cm', 'A4', true, 'UTF-8');
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor(Yii::app()->name);
			$pdf->SetTitle($title);
			$pdf->SetSubject($title);
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->writeHTML($content, true, 0, true, 0);
			// new style
			$style = array(
					'border' => false,
					'padding' => 0,
					'fgcolor' => array(128,0,0),
					'bgcolor' => false
			);

			// QRCODE,H : QR-CODE Best error correction
			$pdf->SetXY(100, 180);
			$pdf->write2DBarcode('www.yeetechnologies.com', 'QRCODE,H', '', '', 50, 50, $style, 'N');
			$pdf->Text(100, 175, 'QRCODE H - NO PADDING');

			$pdf->Output($out_file, "I");
		}

		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Pragma: no-cache');
		header("Content-Type: ".$types[ $type ]."");
		header("Content-Disposition: attachment; filename=\"".$out_file."\";");
		header("Content-Length: ".filesize($out_file));
		readfile ( $out_file );
		exit;
	}
	public function actionDownload($file = null, $thumbnail = false)
	{
		//	$file = 'user.jpg';
		if ( isset($file))
		{
			$imgFile = Yii::app()->basePath .'/..' .UPLOAD_PATH  . basename($file);
			if ( file_exists($imgFile))
			{
				if ( $thumbnail )
				{
					$imgFile = self::scaleImageFile($imgFile);
				}

				$request = Yii::app()->getRequest();
				$request->sendFile(basename($imgFile),file_get_contents($imgFile));
			}
		}
		throw new CHttpException(404, Yii::t('app', 'File not found'));
	}

	public function actionThumbnail($file)
	{
		$this->actionDownload($file, true);
	}

	public static function scaleImageFile($src_file, $send = false) {

		$dst_file =  dirname( $src_file) . DIRECTORY_SEPARATOR . 'thumbnail_' . basename($src_file);

		if ( !file_exists($dst_file))
		{
			$max_width = 200;
			$max_height = 200;

			list($width, $height, $image_type) = getimagesize($src_file);

			switch ($image_type)
			{
				case 1: $src = imagecreatefromgif($src_file); break;
				case 2: $src = imagecreatefromjpeg($src_file);  break;
				case 3: $src = imagecreatefrompng($src_file); break;
				default: return '';  break;
			}

			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;

			if( ($width <= $max_width) && ($height <= $max_height) ){
				$tn_width = $width;
				$tn_height = $height;
			}elseif (($x_ratio * $height) < $max_height){
				$tn_height = ceil($x_ratio * $height);
				$tn_width = $max_width;
			}else{
				$tn_width = ceil($y_ratio * $width);
				$tn_height = $max_height;
			}

			$tmp = imagecreatetruecolor($tn_width,$tn_height);

			/* Check if this image is PNG or GIF to preserve its transparency */
			if(($image_type == 1) OR ($image_type==3))
			{
				imagealphablending($tmp, false);
				imagesavealpha($tmp,true);
				$transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
				imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
			}
			imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);

			/*
			 * imageXXX() has only two options, save as a file, or send to the browser.
			* It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
			* So I start the output buffering, use imageXXX() to output the data stream to the browser,
			* get the contents of the stream, and use clean to silently discard the buffered contents.
			*/
			imagejpeg($tmp, $dst_file, 85);
		}
		if ( $send && file_exists($dst_file))
		{
			header('Content-type: image/jpeg');
			header("Content-Disposition: inline; filename=".basename($dst_file));
			header("Content-Length: ".filesize($dst_file));
			readfile($dst_file);
		}
		return $dst_file;
	}


	protected function processActions($model = null)
	{

		$follow = UserFollow::isFollowing($model);
		$like = UserLike::isLike($model);

		$this->actions [] = array('label'=>Yii::t('app', 'Follow'),'icon'=>'icon-hand-up icon-white','url'=>array('user/follow','id'=>$model->id, 'model'=>get_class($model)),'visible'=> !$follow && !User::isSelf ($model) && !Yii::app()->user->isGuest );
		$this->actions [] = array('label'=>Yii::t('app', 'Following'), 'icon'=>'icon-hand-down icon-white','url'=>array('user/follow','id'=>$model->id,'model'=>get_class($model)),'htmlOptions' => array('class'=>'btn btn-primary'),'visible'=> $follow && !User::isSelf ($model) && !Yii::app()->user->isGuest);
		$this->actions [] = array('label'=>Yii::t('app', 'Like'),'icon'=>'icon-thumbs-up icon-white','url'=>array('user/like','id'=>$model->id, 'model'=>get_class($model)),'visible'=> !$like && !User::isSelf ($model) && !Yii::app()->user->isGuest );
		$this->actions [] = array('label'=>Yii::t('app', 'Liked'), 'icon'=>'icon-thumbs-down icon-white','url'=>array('user/like','id'=>$model->id,'model'=>get_class($model)),'htmlOptions' => array('class'=>'btn btn-primary'),'visible'=> $like && !User::isSelf ($model) );

	}

	public function sendFeedEmail($model){

		$to =  Yii::app()->user->model->email;
		$subject = 'Welcome To Be Employable';
		$body = $this->render('feed', array('model'=>$model),true);
		$this->sendMail(array('to'=>$to,'subject'=>$subject,'body'=>$body));
	}

	public function isCreateAllowed()
	{
		if ( !Yii::app()->user->isUser ) return true;

		return false;
	}

	
	
	

}