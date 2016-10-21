<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
<?php  if(isset($this->breadcrumbs)):?>
		<?php  $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
		));  ?>
		<!-- breadcrumbs -->
		<?php  endif?>
  	  <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     <div class="user-panel">
        <div class="pull-left image">
          <?php 
	        $model = User::model()->findByPk(Yii::app()->user->id);    
			 if(!empty($model->image_file))
				$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>$model->image_file));
			else 
				$url = Yii::app()->createAbsoluteUrl('user/download',array('file'=>'user.png'));
			echo CHtml::image($url,'User Image',array('class'=>'user-image'));?>
            
        </div>
        <div class="pull-left info">
          <p><?php echo ucfirst($model->full_name);?></p>
          <!-- a href="#"><i class="fa fa-circle text-success"></i> Online</a-->
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
   
               <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
            <!-- ul class="treeview-menu">
          <?php //$this->renderNavBar();?>
          </ul-->
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Options</span>
            <span class="label label-primary pull-right">4</span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i>Option 1</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Option 2</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Option 3</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Option 4</a></li>
          </ul>
          <!-- ul class="treeview-menu">
           <?php //$this->renderSettingNavBar();?>
          </ul-->
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
     <div class="span9">
		<div id="content">
			<?php echo $content; ?>
		</div>
		<!-- content -->
	</div>
    

	<div class="span2 pull-right">

		<div id="sidebar">
		<?php
		/*$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Allowed Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();*/
		?>
		</div>
	</div>
</div>

<?php $this->endContent(); ?>