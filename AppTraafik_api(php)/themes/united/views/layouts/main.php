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


<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css"/>



<link rel="stylesheet" type="text/css"	href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.min_theme.css" />
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/font-awesome/css/font-awesome.min.css">

  
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/admin.min.css">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/all-skins.min.css">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

</head>
<?php if(!Yii::app()->user->isGuest){?>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Yii::app()->homeUrl;?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/logo-min.png','traffik');?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/logo.png','traffik');?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                      
                      <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/user2-160x160.jpg','User Image',array('class'=>'img-circle'));?>
                       
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                      <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/user3-128x128.jpg','User Image',array('class'=>'img-circle'));?>
                      
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                      <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/user4-128x128.jpg','User Image',array('class'=>'img-circle'));?>
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                       <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/user3-128x128.jpg','User Image',array('class'=>'img-circle'));?>
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                       <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/user4-128x128.jpg','User Image',array('class'=>'img-circle'));?>
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	         <?php 
	        $model = User::model()->findByPk(Yii::app()->user->id);    
			 if(!empty($model->image_file))
				$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$model->image_file));
			else 
				$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));	

			echo CHtml::image($url,'User Image',array('class'=>'user-image'));?>
            <span class="hidden-xs"><?php echo ucfirst($model->full_name);?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              
                <?php 
			
                if(!empty($model->image_file))
                	$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$model->image_file));
                else
                	$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));
                
                echo CHtml::image($url,'User Image',array('class'=>'user-image'));
			//echo CHtml::image(Yii::app()->theme->baseUrl.'/images/user2-160x160.jpg','User Image',array('class'=>'user-image'));?>
                <p>
                <?php echo ucfirst($model->full_name).'-'.$model->getRoleOptions($model->role_id);?>
                  
                  <small><?php echo $model->email?></small>
                  <small><?php echo $model->mobile?></small>
                </p>
              </li>
              <!-- Menu Body -->
       
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                <?php echo CHtml::link('Profile',Yii::app()->createUrl('user/view',array('id'=>$model->id)),array('class'=>'btn btn-default btn-flat'));?>
                  
                </div>
                <div class="pull-right">
                 <?php echo CHtml::link('Sign out',Yii::app()->createUrl('user/logout'),array('class'=>'btn btn-default btn-flat'));?>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

<?php }else{?>
<body>
<?php }?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php

    echo $content; ?>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0.1
    </div>
    <strong>Copyright &copy; 2016 <a href="#">Traffik</a>.</strong> All rights reserved.
  </footer>

  


  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.min_theme.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/app.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/raphael.min.js"></script>
<?php if($this->action->id == 'dashboard'){?>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/morris/morris.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/dashboard.js"></script>
<?php }?>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/knob/jquery.knob.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/moment.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/fastclick/fastclick.js"></script>


<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/demo.js"></script>
</body>

</html>
