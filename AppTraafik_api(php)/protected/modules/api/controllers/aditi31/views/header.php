<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>File Exchange</title>
		<meta name="description" content="Responsive Animated Border Menus with CSS Transitions" />
		<meta name="keywords" content="navigation, menu, responsive, border, overlay, css transition" />
		<meta name="author" content="Codrops" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/icons.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style2.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/form-style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/main.css" />
			<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/classie.js"></script>
	<script src="<?php echo base_url();?>assets/js/borderMenu.js"></script>
	
 <head>
   <script type="text/javascript">

/***********************************************
* Drop Down Date select script- by JavaScriptKit.com
* This notice MUST stay intact for use
* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and more
***********************************************/

var monthtext=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'];

function populatedropdown(dayfield, monthfield, yearfield){
var today=new Date()
var dayfield=document.getElementById(dayfield)
var monthfield=document.getElementById(monthfield)
var yearfield=document.getElementById(yearfield)
for (var i=0; i<31; i++)
dayfield.options[i]=new Option(i, i+1)
dayfield.options[today.getDate()]=new Option(today.getDate(), today.getDate(), true, true) //select today's day
for (var m=0; m<12; m++)
monthfield.options[m]=new Option(monthtext[m], monthtext[m])
monthfield.options[today.getMonth()]=new Option(monthtext[today.getMonth()], monthtext[today.getMonth()], true, true) //select today's month
var thisyear=today.getFullYear()
for (var y=0; y<20; y++){
yearfield.options[y]=new Option(thisyear, thisyear)
thisyear+=1
}
yearfield.options[0]=new Option(today.getFullYear(), today.getFullYear(), true, true) //select today's year
}

</script>
 </head>
 <?php if($role_id == 0 || $role_id == 2){?>
 <body onload="disableTextBoxes();">
   <?php }else{?>
    <body>
   <?php }?>
   <?php $this->load->view ('modal'); 
 //  $this->session->set_userdata('orders', $user_orders);?>
   <nav id="myNavbar" class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
			<nav id="bt-menu" class="bt-menu">
							
				<?php  if($role_id == 2){?>
					<a class="navbar-brand logo" href="<?php echo base_url();?>home"><?php 
				$reseller = $this->search->resellerByUserId();
				if($reseller->logo_text == "")
				{
				 echo "The Registered Office";
				}
			
				else
				{		
				echo $reseller->logo_text;
				
				}?></a>
				
				<?php }
				
				elseif($role_id == 0)
				{
					$resellerCompany = $this->search->companyReseller();?>
					<a class="navbar-brand logo" href="<?php echo base_url();?>home"><?php echo $resellerCompany->logo_text;?></a>
					<?php 
				}
				else {?>
			<a class="navbar-brand logo" href="<?php echo base_url();?>home">File Exchanage</a>
				<?php }?>
				
				
				
				<ul>
					<li><a href="<?php echo base_url();?>home" class="bt-icon icon-zoom">Home</a></li>
					<li><a href="#" class="bt-icon icon-refresh">Refresh</a></li>
					<li><a href="#" class="bt-icon icon-lock">Lock</a></li>
					<li><a href="#" class="bt-icon icon-speaker">Sound</a></li>
					<li><a href="#" class="bt-icon icon-star">Favorite</a></li>
				</ul>
			</nav>	
			 <ul class="nav navbar-nav navbar-right">
		
			    <li class="<?php if($this->uri->segment(2)==""){echo "active";}?>"><a href="<?php echo base_url();?>home"> Company List</a></li>
                <li><a href="#" data-toggle="modal" data-target="#company"> + Company</a></li>
	
				
				<?php
			if($role_id == 1){?>
				
				<li class="<?php if($this->uri->segment(2)=="manageReseller"){echo "active";}?>"><a href="<?php echo base_url();?>home/manageReseller"> Reseller List</a></li>
				<li class="<?php if($this->uri->segment(2)=="reseller"){echo "active";}?>"><a href="<?php echo base_url();?>home/reseller"> + Reseller</a></li>
				
				<?php }?>
				<?php /**/?>
                <li class="live-btn"><a href="#" onclick="phplive_launch_chat_0(0)" id="phplive_btn_1421304743"></a></li>
                <!-- ------------------------------- live chat -------------------------------- --> 
                        <script type="text/javascript">
                                (function() {
                                    var phplive_e_1421304743 = document.createElement("script");
                                    phplive_e_1421304743.type = "text/javascript";
                                    phplive_e_1421304743.async = true;
                                    phplive_e_1421304743.src = "//t2.phplivesupport.com/equinitee/js/phplive_v2.js.php?v=0|1421304743|0|";
                                    document.getElementById("phplive_btn_1421304743").appendChild(
                                            phplive_e_1421304743);
                                })();
                            </script> 
                        <!-- ------------------------------- live chat ENDS -------------------------------- --> 
						
				
						
                		<?php
			if($role_id == 1){?>
			
			<li class="export">
				<form action="<?php echo base_url();?>home/filterExportExcel/" method="POST" name="export" id="export" >
				<input type="hidden" id="str_var" name="str_var" value="<?php print urlencode(base64_encode(serialize($user_orders))) ?>">
				 <input type="submit" value="Export" name="export"  id = "export" class="btn export-btn"/>
									
				</form>
				</li>
			
                 <li class="<?php if($this->uri->segment(2)=="xsl_upload"){echo "active";}?>"><a href="<?php echo base_url();?>home/xsl_upload"> + Data</a></li>
				 <!--li class="<?php //if($this->uri->segment(2)=="delete_comp_list"){echo "active";}?>"><a href="<?php //echo base_url();?>home/delete_comp_list">Deleted Companies</a></li-->
				
				 	<?php }?>
					
				<li><a href="<?php echo base_url();?>home/logout">Logout</a> </li>
		
				
            </ul>
		</nav>	