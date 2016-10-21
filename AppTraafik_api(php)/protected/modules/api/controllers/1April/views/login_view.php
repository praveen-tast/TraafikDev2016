<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CONFIRMATION</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/email_css.css" />

</head>
<body>
	<div class="form-fluid">
		<div class=" col-md-4 col-sm-offset-4 login_form">
			<h3 class="title_bg">Login</h3>
			 <?php echo validation_errors(); ?>
   			 <?php echo form_open('verifylogin'); ?>
			
				<div class="form-group">
				 <input type="text" size="20" id="email" name="email" class="form-control" placeholder="Email"/>
			
				</div>
				<div class="form-group">
				  <input type="password" size="20" id="passowrd" name="password" class="form-control" placeholder="Password"/>
				
				</div>
				<div class="form-group">
				 <input type="submit" value="Login" class="btn btn-primary login_btn pull-right"/>
				</div>
			</form>
		</div>
	</div>
</body>
</html>










