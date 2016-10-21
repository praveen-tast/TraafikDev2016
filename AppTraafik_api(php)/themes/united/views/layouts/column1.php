<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid">
<div class="container-min">
  <div class="row-fluid">
   <div class="container">
   <?php  if(isset($this->breadcrumbs)):?>
		<?php  $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
		));  ?>
		<!-- breadcrumbs -->
		<?php  endif?>
        <div class="span8">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/massenger.png','image',array());?>
       <!-- <h2>
	Lorem ipsum dolor sit amet</h2><p> consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat</p>-->
   <!-- <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/massenger.png" />--></div>
	    <div class="span4 pull-right">
		 <?php  echo $content;  ?>
	     </div>

	   <!-- content -->
    </div>
  </div>
  </div>
 </div>

<?php $this->endContent(); ?>