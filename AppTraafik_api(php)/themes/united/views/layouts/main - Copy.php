<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="language" content="en" />


<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

<title><?php echo CHtml::encode($this->pageTitle); ?></title>


<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/modified.css" />

<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />

</head>

<body>

	<div id="page">

		<?php $this->renderNavBar();?>
		<!-- header -->
		<?php echo $content; ?>
	
		<footer>
		    <div class="container">
			    <div id="footer">


						Copyright &copy;
						<?php echo date('Y'); ?>
						by
						<?php echo CHtml::encode(Yii::app()->params['company'])?>
						. All Rights Reserved.<br />
					
			  </div>
			</div>
   
		</footer>
		<!-- footer -->

	</div>
	<!-- page -->

</body>

</html>
