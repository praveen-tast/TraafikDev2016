
<?php $this->load->view ('header');?>
<section id="content_info">
  <div class="table_data">	
  
   
	<table class="table table-hover">
		<thead class="home-table-header">
			<tr>
			
			<th class="cmpny th_company_class">
			  Company Name ( <?php echo count($user_orders);?>)
			  
			  <form class="seach-cmpny" id="search_company" name="search_company" method="Post" action="<?php echo base_url();?>home/search">
			    <input class="form-control" placeholder="search" type="text" id="search_field" name="search_field">
			  	<input type="submit" class="btn btn-success" value="search" name="search" id="search">
				<!-- span id="search_button"><i class="fa fa-search"></i></span-->
			  </form>
			</th>
			<?php $services =  $this->search->getServiceOptions();
			if($role_id === '1')
			{
			?>
		
			<th class="reseller-head th_reseller_class">
			<form action="<?php echo base_url();?>home/reseller_change" method="POST" name="reseller_form_change" id="reseller_form_change">
			<?php $resellers =  $this->search->resellers();?>
			  <select id="reseller_change" name="reseller_change">
			  <option>Reseller</option>
			  <option value="Show All">Show All</option>
			  <?php foreach($resellers as $reseller){?>
			    <option value="<?php echo $reseller->id;?>"><?php echo $reseller->company_name;?></option>
			   <?php }?>
			  </select>
			    </form>
			</th>
			<?php }?>
			
			<th class="th_state_class">
			<form action="<?php echo base_url();?>home/state_change" method="POST" name="state_form_change" id="state_form_change">
			<?php $states =  $this->search->getStatusOptions();?>
			 <select id="state_change" name="state_change">
			    <option>Status</option>
				<option value="Show All">Show All</option>
			      <?php foreach($states as $key =>$state){?>
			    <option value="<?php echo $key ;?>"><?php echo $state;?></option>
			   <?php }?>
			    
			  </select>
			  
			  </form>
			</th>
			
			<th onClick="getDateOtions()" class="th_renew_class">
			Renewal Date
			</th>
		
			
			<th class="th_location_class">
			
					<form action="<?php echo base_url();?>home/filterSearch" method="POST" name="location" id="location_select">
						<?php $locations =  $this->search->getLocationOptions();?>
						<select id="location_select_option" name="location_select" class="getSelect1 locClick">
								<option>Location</option>
							<?php  foreach($locations as $location){?>
								<option value="<?php echo $location;?>"><?php echo $location;?></option>
							<?php }?>
			   
						</select>
				  </form>
			</th>
			
			<th class="th_reg_class">
			<form action="<?php echo base_url();?>home/serviceSearch" method="POST" name="registered_office" id="registered_office_select">
		
			  <select id="registered_office" name="registered_office" class="getSelect1 regClick">
						<option>Registered</option>
				   <?php  foreach($services as $service){?>
						<option value="<?php echo $service;?>"><?php echo $service;?></option>
					<?php }?>
			   
			  </select>
			  </form>
			</th>
			
			<th class="th_director_class">
			<form action="<?php echo base_url();?>home/serviceSearch" method="POST" name="director_service_address" id="director_service_address_select">
			  <select id="director_service_address"  name="director_service_address" class="getSelect1 dirClick">
			    <option>Director</option>
				  <?php foreach($services as $service){?>
					<option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }?>
			    
			  </select>
			  </form>
			</th>
			
			<th class="th_business_class">
			 <form action="<?php echo base_url();?>home/serviceSearch" method="POST" name="business_address" id="business_address_select">
			  <select id="business_address" name="business_address" class="getSelect1 busClick">
			    <option>Business</option>
				  <?php foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }?>
			  
			  </select>
			  </form>
			</th>
			<th class="th_tele_class">
			  <form action="<?php echo base_url();?>home/serviceSearch" method="POST" name="telephone_service" id="telephone_service_select">
				<select id="telephone_service" name="telephone_service" class="getSelect1 telClick">
						<option>Telephone</option>
					<?php foreach($services as $service){?>
						<option value="<?php echo $service;?>"><?php echo $service;?></option>
					<?php }?>
			   
			  </select>
			  </form>
			</th>
			
			<th class="th_host_class">
			<form action="<?php echo base_url();?>home/serviceSearch" method="POST" name="hosting" id="hosting_select">
				
			  <select id="hosting" name="hosting" class="getSelect1 hostClick">
			    <option>Hosting</option>
				  <?php foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }?>
			  
			  </select>
			  </form>
			</th>
				<th class="th_diposite_class">Deposit
			  		  
			 
			</th>
			<th class="th_price_class">
			Price
			</th>
			<th class="th_upload_class">
			<form action="<?php echo base_url();?>home/filterSearch" method="POST" name="upload_form_change" id="upload_form_change">
			<?php $uploads =  $this->search->getUploadOptions();?>
			  <select id="upload_change" name="upload_change" class="getSelect1 IdClick">
			  <option>ID</option>
			  <option value="Show All">Show All</option>
			  <?php foreach($uploads as $upload){?>
			    <option value="<?php echo $upload;?>"><?php echo $upload;?></option>
			   <?php }?>
			  </select>
			    </form>
			</th>
			</tr>
		</thead>
    
    
		<tbody id="OrderPackages">
		  
 
			
			<?php 
			if($user_orders){
				//print_r($user_orders);die;
				foreach ($user_orders as $key=>$user_order)
				{
					//var_dump($user_order->company_id);die;
				  $company =  $this->search->filterSearch($user_order->company_id);
				  $user =  $this->search->userSearch($user_order->create_user_id);
				  $update_company_user = $this->search->userSearch($company->create_user_id);;
				  
				  $billing =  $this->search->billing($company->billing_adress_id);
				  $mailling =  $this->search->mailling($company->mailing_adress_id);
				  $orders =  $this->search->orders($company->id);
				  $order_details =  $this->search->orderDetails($orders->id);
				  $files_info =  $this->search->fileInfo($user_order->company_id);
				  $messages =  $this->search->Message($user_order->id);
				  $alt_emails =  $this->search->alterEmails($company->id);
				  //var_dump( $alt_emails );die;
					?>
					
			<tr id="<?php echo 'row_'.$user_order->id;?>"  >
			
			<td id="<?php echo 'data_'.$user_order->id;?>" class = "td_company_class">
			<a href="<?php echo '.packageDetails'.$user_order->id;?>" id="<?php echo 'package_'.$user_order->id;?>" 
			class="accordion-toggle package_click" data-toggle="collapse" data-parent="#OrderPackages">
			
			<?php echo $user_order->company_name;?></a></td>				
			<?php if($role_id === '1'){?><td class="reseller td_reseller_class" onclick = "reseller('<?php echo $user_order->id?>')"><a href="#"><?php echo $user_order->reseller;?></a></td>
            
            <!-- STATUS--->
            
			<td class = "state_id td_status_class" data-id="<?php echo $user_order->id;?>"><a href="#"><?php echo	$this->search->getStatusOptions($user_order->state_id);?></a></td>
            
            
            
			<td  class = "renew_id td_renew_class" id="<?php echo $user_order->id;?>" onclick = "displayDatepicker('<?php echo $user_order->id?>')">
			
				<a href="#">	
					<?php echo date ("d-m-Y",strtotime($user_order->renewable_date));?>
					</a>
					
					</td>
					
			<td onclick =" location_event('<?php echo $user_order->id?>')" class="td_location_class">
				<a href="#">
					<?php echo $user_order->location;?>
				</a>
			</td>
			<td onclick ="mail_handel('<?php echo $company->id?>')" class="td_reg_class"><a href="#"><?php echo $user_order->registered_office;?></a></td>
			<td onclick ="mail_handel('<?php echo $company->id?>')" class="td_director_class"><a href="#"><?php echo $user_order->director_service_address;?></a></td>
			<td onclick ="mail_handel('<?php echo $company->id?>')" class="td_business_class"><a href="#"><?php echo $user_order->business_address;?></a></td>
			<td onclick ="message_handel('<?php echo $user_order->id?>','<?php echo $update_company_user->email;?>','<?php echo $alt_emails->email_2?>','<?php echo $alt_emails->email_3?>','<?php echo $alt_emails->email_4?>')" class="td_tele_class"><a href="#"><?php echo $user_order->telephone_service;?></a></td>
			<?php }else{?>
			<td class = "td_status_class" data-id="<?php echo $user_order->id;?>"><?php echo	$this->search->getStatusOptions($user_order->state_id);?></td>
			<td  class = "renew_id td_renew_class" id="<?php echo $user_order->id;?>"><?php echo date ("d-m-Y",strtotime($user_order->renewable_date));?></td>
			<td class="td_location_class"><?php echo $user_order->location;?></td>
			<td class="td_reg_class"><?php echo $user_order->registered_office;?></td>
			<td class="td_director_class"><?php echo $user_order->director_service_address;?></td>
			<td class="td_business_class"><?php echo $user_order->business_address;?></td>
			<td class="td_tele_class"><?php echo $user_order->telephone_service;?></td>
			<?php }?>
			
			
			
			<td class="td_host_class"><?php echo $user_order->hosting;?></td>
			<td class="td_deposit_class">&pound;<?php 			
			$dot = strstr($user_order->deposit, '.');
			if($dot)
				echo $user_order->deposit;
			else
				echo $user_order->deposit.'.00';
			
			//echo '£'.$user_order->deposit;?></td>
			<!-- td>COMPANY</td-->
			<td class="td_price_class">&pound;<?php 
			$total_price = $this->order->orderPrice($user_order->id);
		
			$dot = strstr($total_price, '.');
			if($dot)
				echo $total_price;
			else
				echo $total_price.'.00';
			?></td>
			
			
			
			<td class="uploadId" data-id="<?php echo $company->id;?>" >
			<a href="#"><?php 
			$file_type_id = array();
			foreach($files_info as $file_info)
			{
						$file_type_id[]=$file_info->type_id;
			}
			$file_type_upload1 =  in_array("4",$file_type_id);
			$file_type_upload2 =  in_array("5",$file_type_id);
			$getYes = "";
			
			if($file_type_upload1=== true || $file_type_upload2 === true) 
			{
				echo "Recieved";
			}
				
			else
			{
				echo "Upload";
			}
		
			?></a>
			</td>
					</tr>
						<tr>	
			<td colspan="13" class="hiddenRow">
			
			 <input type="hidden" data-del_id="<?php echo 'del_comp_id'.$user_order->id;?>" name="del_comp_id" id="<?php echo 'del_comp'.$user_order->id;?>" class="form-control" value="<?php echo $user_order->company_id;?>">
									
			      <div class="panel-body accordion-body collapse <?php echo 'packageDetails'.$user_order->id;?>" id="<?php echo 'accordion_data_'.$user_order->id;?>">
			         <div class="tabs-main">	
				      <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="<?php echo "#tab_company".$user_order->id;?>" role="tab" data-toggle="tab">Company Details</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_user".$user_order->id;?>" role="tab" data-toggle="tab">Your Details</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_billing".$user_order->id;?>" role="tab" data-toggle="tab">Billing Information</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_order".$user_order->id;?>" role="tab" data-toggle="tab">Your Order</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_mail".$user_order->id;?>" role="tab" data-toggle="tab">Mail Centre</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_message".$user_order->id;?>" role="tab" data-toggle="tab">Message Centre</a></li>
						<li role="presentation"><a href="<?php echo "#tab_document".$user_order->id;?>" role="tab" data-toggle="tab">Documents</a></li>
						 <li role="presentation"><a href="<?php echo "#tab_emails".$user_order->id;?>" role="tab" data-toggle="tab">Email Alerts</a></li>
					  </ul>
					
					  <!-- Tab panes -->
					  <div class="tab-content">
					 
					    <div role="tabpanel" class="tab-pane active" id="<?php echo "tab_company".$user_order->id;?>">
					     <form  name="update_company" method="POST" action="<?php echo base_url();?>home/updateCompany" id="update_company">
					         <div class="form-group col-sm-6 col-xs-12 box">
					   		  <input type="hidden" name="company_id" id="company_id" class="form-control" value="<?php echo $company->id;?>">
									<label for="Title ">Company Name:</label> <input type="text" name="user_company" id="user_company" class="form-control" value="<?php echo $company->company_name;?>">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="First Name">Trading Name(if different):</label> <input type="text" name="trade_name" id="trade_name" class="form-control" value="<?php echo $company->trading;?>">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Director1:</label>
									 <input type="text" name="director1" id="director1" class="form-control" value="<?php echo $company->director1;?>">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Director2:</label>
									 <input type="text" name="director2" id="director2" class="form-control" value="<?php echo $company->director2;?>">
							</div>

								<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Director3:</label>
									 <input type="text" name="director3" id="director3" class="form-control" value="<?php echo $company->director3;?>">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Director4:</label>
									 <input type="text" name="director4" id="director4" class="form-control" value="<?php echo $company->director4;?>">
							</div>
							
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Renewal Date:</label>
									 <input onclick = "displayDatepicker('<?php echo $user_order->id?>')" type="text" name="renewal" id="<?php echo 'renewal_'.$user_order->id;?>" class="form-control" value="<?php echo date ("d-m-Y ",strtotime($user_order->renewable_date));?>">
							</div>
							
								<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Location:</label>
									 <input  onclick =" location_event('<?php echo $user_order->id?>')" type="text" name="location" id="<?php echo 'location'.$user_order->id;?>" class="form-control" value="<?php echo $user_order->location;?>">
							</div>
						
						
							  <div class="clearfix"></div>
					     <hr>
					    <div class="col-sm-12 text-center">
					   <input type="submit" value="Update" name="update" class="btn btn-success"/>
					    
					      <a class="btn btn-danger accordion-toggle" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">Close</a>
					    </div>
						
						<a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
						   <i class="fa fa-close"></i>
						</a>
						</form>
					    </div>
					    
					    <div role="tabpanel" class="tab-pane" id="<?php echo "tab_user".$user_order->id;?>">
					    <form  name="update_user" method ="POST" action="<?php echo base_url();?>home/updateCompany" id="update_user">
					         <div class="form-group col-sm-6 col-xs-12 box">
									<label for="Title ">First Name:</label> 
									<input type="text" name="user_name" value="<?php echo $update_company_user->first_name;?>" id="user_name" class="form-control">
							<input type="hidden" name="user_id" value="<?php echo $update_company_user->id;?>" id="user_id" class="form-control">
							<input type="hidden" name="mailing_id" value="<?php echo $mailling->id;?>" id="mailing_id" class="form-control">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="First Name">Last Name:</label> 
									<input type="text" name="user_last_name" value="<?php echo $update_company_user->last_name;?>" id="user_last_name" class="form-control">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Email:</label> 
									<input type="text" name="user_email" value="<?php echo $update_company_user->email;?>" id="user_email" class="form-control">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Last Name">Daytime Phone:</label>
									 <input type="text" value="<?php echo $update_company_user->ph_no;?>" name="user_daytime_contact" id="user_daytime_contact" class="form-control">
							</div>


							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Mobile Number:</label> 
									<input type="text" value="<?php echo $update_company_user->mobile;?>" name="user_contact" id="user_contact" class="form-control">
							</div>
							
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Skype Address:</label>
									 <input type="text" value="<?php echo $update_company_user->skpe_address;?>" name="user_skype" id="user_skype" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Street Address:</label>
									 <input type="text" value="<?php echo  $mailling->street;?>" name="user_street" id="user_street" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Town/City:</label> 
									<input type="text" value="<?php echo  $mailling->city;?>" name="user_city" id="user_city" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">County/Region:</label>
									 <input type="text" name="user_country" value="<?php echo  $mailling->county;?>" id="user_country" class="form-control">
							</div>	
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Postcode:</label>
									 <input type="text" value="<?php echo  $mailling->postcode;?>" name="user_post_code" id="user_post_code" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Country:</label> 
									<input type="text" value="<?php echo  $mailling->country;?>" name="user_county" id="user_county" class="form-control">
							</div>
							<?php if($role_id !== '2'){?>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Change Password:</label> 
									<input type="password" value="" name="user_password" id="user_password" class="form-control">
							</div>
							<?php }?>
							  <div class="clearfix"></div>
					     <hr>
					    <div class="col-sm-12 text-center">
					   <input type="submit" value="Update" name="update" class="btn btn-success"/>
					    
					      <a class="btn btn-danger accordion-toggle" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">Close</a>
					    </div>
						
						<a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
						   <i class="fa fa-close"></i>
						</a>
						</form>
					    </div>
					    
					    <div role="tabpanel" class="tab-pane" id="<?php echo "tab_billing".$user_order->id;?>">
					    <form  name="update_billing" id="update_billing" method="Post" action="<?php echo base_url();?>home/updateCompany">
					         <div class="form-group col-sm-6 col-xs-12 box">
									<label for="Title ">Billing Name:</label>
									<input type="hidden" value="<?php echo $billing->id;?>" name="billing_id" id="billing_id" class="form-control">
									 <input type="text" value="<?php echo $billing->billing_name;?>" name="billing_name" id="billing_name" class="form-control">
							</div>

								<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Street Address:</label>
									 <input type="text" value="<?php echo $billing->street;?>" name="billing_street" id="billing_street" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Town/City:</label> 
									<input type="text" value="<?php echo $billing->city;?>" name="billing_city" id="billing_city" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">County/Region:</label>
									 <input type="text" name="billing_country" value="<?php echo $billing->country;?>" id="billing_country" class="form-control">
							</div>	
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Postcode:</label>
									 <input type="text" value="<?php echo $billing->postcode;?>" name="billing_post_code" id="billing_post_code" class="form-control">
							</div>t
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Country:</label> 
									<input type="text" value="<?php echo $billing->county;?>" name="billing_county" id="billing_county" class="form-control">
							</div>
							  <div class="clearfix"></div>
					     <hr>
					    <div class="col-sm-12 text-center">
					   <input type="submit" value="Update" name="update" class="btn btn-success"/>
					    
					       <a class="btn btn-danger accordion-toggle" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">Close</a>
					    </div>
						
						<a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
						   <i class="fa fa-close"></i>
						</a>
						</form>
					    </div>
					    
					    <div role="tabpanel" class="tab-pane" id="<?php echo "tab_order".$user_order->id;?>">
			               
						    <form id="<?php echo 'service_payment'.$user_order->id;?>" name="service_payment" action="https://secure.wp3.rbsworldpay.com/wcc/purchase" class="service_payment">
		            
		                 
		                 <div class="form-group col-sm-3">
							  <label><?php if($role_id === '2')
							  {
								  echo "New Order:";
								  
								  }else
								 	 echo "Order:";
								  {
									  
									  }?></label>
		                       <select class="form-control" id="payment_options<?php echo $user_order->id;?>"  name="payment_options" onChange="getOptions('<?php echo $user_order->id;?>',this);">
		                           
		                            <option value="Registered Office Address - £29.00" id="<?php echo 'Registered Office Address'.$user_order->id?>" name="<?php echo 'Registered Office Address'.$user_order->id?>">Registered Office Address - &pound;29.00 Per Year</option>
									<option value="Director Service Address - £9.95" id="<?php echo 'Director Service Address'.$user_order->id?>" name="<?php echo 'Director Service Address'.$user_order->id?>">Director Service Address - &pound;9.95 Per Year</option>
									<option value="Registered Office and Director Address - £38.95" id="<?php echo 'Registered Office and Director Address'.$user_order->id?>" name="<?php echo 'Registered Office and Director Address'.$user_order->id?>">Registered Office + Director Address - &pound;38.95 Per Year</option>
									<option value="Business Address (1 Month) - £99.00" id="<?php echo 'Business Address'.$user_order->id?>" name="<?php echo 'Business Address'.$user_order->id?>">Business Address  - &pound;99.00 Per Year</option>
									<option value="Telephone Answer Service - £99.00" id="<?php echo 'Telephone Address'.$user_order->id?>" name="<?php echo 'Telephone Address'.$user_order->id?>">Telephone Answer Service  - &pound;99.00 Per Year</option>
									<option value="Website Hosting - £99.00" id="<?php echo 'Website Hosting'.$user_order->id?>" name="<?php echo 'Website Hosting'.$user_order->id?>">Website Hosting - &pound;99.00 Per Year</option>
									<option value="Business Plus - £199.00" id="<?php echo 'Complete Package'.$user_order->id?>" name="<?php echo 'Complete Package'.$user_order->id?>">Business Plus - &pound;199.00 Per Year</option>
									<option value="Partner Package - £50.00" id="<?php echo 'Partner Package'.$user_order->id?>" name="<?php echo 'Partner Package'.$user_order->id?>">Partner Package - £50.00</option>
									<option value="Postal Deposit (UK) - £20.00" id="<?php echo 'Postal Deposit'.$user_order->id?>" name="<?php echo 'Postal Deposit'.$user_order->id?>">Postal Deposit (UK) - &pound;20.00</option>
									<option value="Postal Deposit (Overseas) - £50.00" id="<?php echo 'Postal Deposit'.$user_order->id?>" name="<?php echo 'Postal Deposit'.$user_order->id?>">Postal Deposit (Overseas) - &pound;50.00</option>
								
		                       </select>
		                 </div>
		                 
		                 <div class="form-group col-sm-2">
		                     <label>Price</label>
							 <input type="hidden" class="form-control" id="<?php echo 'service_name'.$user_order->id;?>"  name="service_name" value="Registered Office Address">eee
							  <input type="hidden" class="form-control" id="<?php echo 'add_order_id'.$user_order->id;?>"  name="add_order_id" value="<?php echo $user_order->id;?>">
							   <input type="hidden" class="form-control" id="<?php echo 'add_order_id_price'.$user_order->id;?>"  name="add_order_id_price" value="29.00">
							
							 <input type="text" class="form-control" id="<?php echo 'service_amount'.$user_order->id;?>"  name="service_amount "value="29.00" onkeyup="getAmountValue('<?php echo $user_order->id;?>');">
						
		                 </div>
		                 
						  <div class="form-group col-sm-2">
		                     <label>Quantity</label>
							 <input type="text" class="form-control" id="<?php echo 'service_quantity'.$user_order->id;?>"  name="service_quantity"value="1" onChange="calPrice('<?php echo $user_order->id;?>','service')">
							
		                 </div>
		                      <input type="hidden" name="instId"  value="1068922"><!-- The "instId" value "211616" "1068922"should be replaced with the Merchant's own installation Id -->
					<input type="hidden" name="cartId" value="abc123"><!-- This is a unique identifier for merchants use. Example: PRODUCT123 -->
					<input type="hidden" name="currency" value="GBP"><!-- Choose appropriate currency that you would like to use -->
					<input type="hidden" name="amount" id="pay_amount<?php echo $user_order->id;?>" value="29.00">
					<input type="hidden" name="desc" value="">
					<input type="hidden" name="testMode" value="0">
					<input type="hidden" name="name" value="AUTHORISED">
					
					
					
		                 <div class="form-group col-sm-3">
                               <?php if($role_id === '2')
							  {?>
								                 
		                     <input class="btn btn-success btn-mk-payment payment_submit" onClick="payment_form('service_payment<?php echo $user_order->id;?>','<?php echo $user_order->id;?>','pay_now')" 
							 type="button" value="Pay Now" id="<?php echo 'payment_submit'.$user_order->id;?>" />
							 
							<input class="btn btn-success btn-mk-payment payment_submit" onClick="payment_form('service_payment<?php echo $user_order->id;?>',
							 '<?php echo $user_order->id;?>','invoice')"  type="button" value="Pay on Invoice" id="<?php echo 'payment_submit'.$user_order->id;?>" />  
								  
								 <?php  }else {?>
						           
		                            <input class="btn btn-primary btn-mk-payment payment_submit" onClick="payment_form('service_payment<?php echo $user_order->id;?>','<?php echo $user_order->id;?>','pay_now')" 
							 type="button" value="Make Payment Now" id="<?php echo 'payment_submit'.$user_order->id;?>" />
									  
								<?php	  }?>
                         
         
							 </div>
		                 
						 <div class="form-group col-sm-12">
							<!--label class="make-pay terms"> <input type="checkbox" name="terms" id="terms" class="required"> <span> I agree to <a href="#" data-target="#myModal_terms" data-toggle="modal">Terms and Conditions</a></span>
							</label-->
						</div>
		             </form>  
						   
						   
						   
					<?php foreach ($order_details as $order_detail){?>
						<form id="<?php echo 'order_detail'.$user_order->id;?>" name="order_detail" action="<?php echo base_url();?>home/orderDetailUpdate" class="order_detail col-sm-12" method="POST">
		            
							<div class="form-group col-sm-3 col-xs-10 box">
								<label for="Nationality">
                                  <?php if($role_id === '2')
									{
										echo " Current Order:";								  
									}
									else
								    { 	 
										echo "Order:";
									}?>
                                    
                                    
                                   </label> 
									<input type="hidden" value="<?php echo $order_detail->id;?>" name="product_id" id="product_id<?php echo $order_detail->id;?>" class="form-control text_disable" >
							
									<input type="text" value="<?php if($order_detail->product == "Complete Package")
									echo "Business Plus";else echo $order_detail->product; ?>" name="product_name" id="product_name<?php echo $order_detail->id;?>" class="form-control text_disable" >
							</div>
							<div class="form-group col-sm-2 col-xs-10 box">u
									<label for="Nationality">Price:</label> 
								<input type="text" value="<?php echo '£'.$order_detail->price;?>" name="product_price" id="product_price<?php echo $order_detail->id;?>" class="form-control text_disable">
							</div>
							<div class="form-group col-sm-2 col-xs-10 box">
									<label for="Nationality">Quantity:</label>
									 <input type="text" value="<?php echo $order_detail->quantity;?>" onChange="calPrice('<?php echo $order_detail->id;?>','product','<?php echo $order_detail->price;?>')" name="product_quantity" id="product_quantity<?php echo $order_detail->id;?>" class="form-control text_disable">
							</div>
						
							<div class="form-group col-sm-2 col-xs-10 box">
								<label for="Nationality">Date:</label>
							    <input type="text" value="<?php echo $order_detail->create_time;?>" name="product_date" id="product_date<?php echo $order_detail->id;?>" class="form-control text_disable">
							</div>
							<?php if($role_id === '1'){?>
						   <div class="form-group col-sm-3 col-xs-10 box action-btn">
							<input type="submit" value="Edit" name="update" class="btn btn-success" />
							<input type="button" value="Delete" name="update" class="btn btn-danger" onClick="deleteRecord('<?php echo $order_detail->id;?>','order_detail','<?php echo $order_detail->product?>')"/>
						   </div>
							
							<?php }?>
						</form>
							
						<?php }?>	
							
					       
  						<div class="clearfix"></div>
					     <hr>
					
						
						<a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
						   <i class="fa fa-close"></i>
						</a>
						  	<!--form action="<?php //echo base_url();?>home/addOrder" method="POST" id="service_payment" name="service_payment"-->
		               	
						
		       
		                     <div class="col-sm-12 text-center">
					    
                              <?php if($role_id !== '2'){?>
								    <a class="btn btn-danger accordion-toggle" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">Close</a>
							  <?php  }?>
					   
					    </div>
					      </div>
					      
					      <div role="tabpanel" class="tab-pane" id="<?php echo "tab_mail".$user_order->id;?>">
					        <div class="col-sm-12">
						        <table class="table table-under-panel">
						          <thead>
						            <tr>
						               <th class="date_th">Date</th>
						               <th class="time_th">Time</th>
						               <th class="type_th">Type</th>
						               <th class="file_th">File Name</th>
						               <th class="download_th">Download</th>
						               <th class="original_th">Original Copy</th>
									   <?php if($role_id === '1'){?>
									    <th class="delete_th">Delete</th>
										<?php } ?>
						            </tr>
						          </thead>
						          
								  
								  
						          <tbody class="get_mail_data" id="get_mail_data<?php echo $user_order->id?>">
						          <?php foreach ($files_info as $file_info){
								  if($file_info->type_id !=4 && $file_info->type_id !=5 && $file_info->type_id !=6 && $file_info->type_id !=7 && $file_info->type_id !=8)
								 { 
								  ?>
						            <tr>
						              <td name="mail_date" id="mail_date<?php echo $user_order->id?>"><?php echo date("Y-m-d",strtotime($file_info->create_time));?></td>
						              <td name="mail_time" id="mail_time<?php echo $user_order->id?>"><?php echo date("h:i A",strtotime($file_info->create_time));?></td>
						              <td name="mail_type" id="mail_type<?php echo $user_order->id?>"><?php echo $this->search->getTypeOptions($file_info->type_id);?></td>
						              <td name="mail_file_name" id="mail_file_name<?php echo $user_order->id?>"> <?php echo $file_info->file_name?></td>
						              <!--td>yes</td-->
									    <td name="mail_file_name" id="mail_file<?php echo $user_order->id?>"> <a href="<?php echo base_url().'home/download/'.$file_info->file_name?>">  Click Here </a></td>
									  
									  
						              <td onClick="get_mail_data('<?php echo $company->id;?>,<?php echo $file_info->create_time;?>,<?php echo $this->search->getTypeOptions($file_info->type_id);?>,<?php echo $file_info->file_name;?>,<?php echo $file_info->id;?>')">
									  <?php if($file_info->state_id != 1 ) {?>									  
									<a href="#">  Request Original </a>
									  <?} else{
									  echo "Requested -".date("d/m/Y",strtotime($file_info->req_time)); 
									   }?>
									  
									  
									  </td>
									  <?php if($role_id === '1'){?>
									  <td>
									  <a href="#" onClick="deleteRecord('<?php echo $file_info->id;?>','file_mail')"/>Delete</a>
									  </td>
									  <?php }?>
						            </tr>
						            <?php } }?>
						          </tbody>
								  
								  
								  
								  
								  
								  
						        </table>
						        
						        <?php if($role_id === '1'){?>
						                <?php echo $error;?> <!-- Error Message will show up here -->
										<?php echo form_open_multipart('home/do_upload');?>
										       <input type="hidden" name="comp_id" id="<?php echo 'comp_id'.$company->id?>" class="form-control" value="<?php echo $company->id;?>">
																			
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										
										<?php if($role_id === '1'){
											$options = $this->search->getTypeOptions();
										?>-
										    <label>Select Type:</label>
										   <select id="file_type_id" class="form-control" name="file_type_id">
										   <?php foreach($options as $key=>$value){?>
							              <option value="<?php echo $key?>"><?php echo $value; ?></option>
											<?php }?>
							              </select>
							              <?php }?>
										<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
										<?php echo "</form>";
										}?>
						        
						      </div>   
						        <a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
								   <i class="fa fa-close"></i>
								</a>
						       
					      </div>
					      
					      <div role="tabpanel" class="tab-pane" id="<?php echo "tab_message".$user_order->id;?>">
					      <div class="col-sm-12">
						        <table class="table table-under-panel">
						          <thead>
						            <tr>	
						               <th class="date_th">Date</th>
						               <th class="time_th">Time</th>
						               <th class="to_th">To</th>
						               <th class="form_th">From</th>
						               <th class="tel_th">Tel No.</th>
									   <th class="tab_message_email">Email</th>
						               <th class="tab_message_message">Message</th>
									   
									   <?php if($role_id === '1'){?>
									   <th class="delete_th">Delete</th>
									   <?php }?>
									   
						            </tr>
						          </thead>
						          
						           <tbody>
						           <?php foreach ($messages as $message){?>
						            <tr>
						              <td><?php echo date("Y-m-d",strtotime($message->create_time));?></td>
						              <td><?php echo date("h:i A",strtotime($message->create_time));?></td>
						              <td><?php echo $message->to_id;?></td>
						              <td><?php echo $message->from_id;?></td>
						              <td><?php echo $message->tel_no;?></td>
									    <td><?php echo $message->email_id;?></td>
									   
						              <td class="td_message_class">
									   <input name="message_msg" id="<?php echo 'message'.$message->id;?>" size="40" type="hidden"  class="to_id" value="<?php echo $message->message;?>"  />
									  
									  <?php $strlen =  strlen($message->message);
									  if($strlen<100 )
									  echo $result = substr($message->message, 0, 100);
									  else
									  { echo $result = substr($message->message, 0, 100);
									  
									  ?><a href="#" onClick="getMessage('message<?php echo $message->id;?>')"> Read More</a>
									  <?php } /**/ //echo $message->message;?></td>
									  
									
									  <?php if($role_id === '1'){?>
									  <td>
									  <a href="#"  onClick="deleteRecord('<?php echo $message->id;?>','message')">Delete </a>
									  </td>
									  <?php }?>
									 
						            </tr>
						            <?php }?>
						          </tbody>
						        </table>
						        <?php /*?>
						        <form id="<?php echo 'message_form'.$user_order->id;?>" role="form" action="<?php echo base_url();?>home/message" method="POST" class="message_form_class">
						        <input name="order_post_id" id="<?php echo 'order_post_id'.$user_order->id;?>" size="40" type="hidden"  class="" value="<?php echo $user_order->id?>" />
						        	 <div class="form-group">
						         <label>Call To:</label>
						          <input name="to_id" id="<?php echo 'to_id'.$user_order->id;?>" size="40" type="text"  class="to_id" value="" required />
						          </div>
						          	 <div class="form-group">
						          
						            <label>Call From:</label>
						          <input name="from_id" id="<?php echo 'from_id'.$user_order->id;?>" size="40" type="text"  class="from_id" value="" required />
						           </div>
						           	 <div class="form-group">
						            <label>Telephone Number:</label>
						                 <input name="tel_no" id="<?php echo 'tel_no'.$user_order->id;?>" size="40" type="text"  class="tel_no" value="" required />
						            </div>
						            	 <div class="form-group">
						              <label>Email Address:</label>
						           <input name="_email" id="<?php echo '_email'.$user_order->id;?>" size="40" type="text"  class="_email" value="" required />
									</div>
										 <div class="form-group">
						           <label>Message:</label>
						          <input name="message_post" id="<?php echo 'message_post'.$user_order->id;?>" size="40" type="text"  class="message_post" value=""  required/>
						       </div>
						       	 <div class="form-group">   
						        <input type="submit" value="+ Message" name="upload_message" class="btn btn-success message_form_id" id="<?php echo 'message_form_id'.$user_order->id?>"/>
						 </div>
						   </form><?php */?>
						   
						    </div>   
								<a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
								   <i class="fa fa-close"></i>
								</a>
						 
					</div>
					    
					  
					  
					  
					  
					    <div role="tabpanel" class="tab-pane" id="<?php echo "tab_document".$user_order->id;?>">
					        <div class="col-sm-12">
						        <table class="table table-under-panel">
						          <thead>
						            <tr>
						               <th class="date_th">Date</th>
						               <th class="time_th">Time</th>
						               <th class="type_th">Type</th>
						               <th class="file_th">File Name</th>
						               <th class="download_th">Download</th>
									   <?php if($role_id === '1'){?>
									   <th class="delete_th">Delete</th>
									   <?php }?>
						            </tr>
						          </thead>
						          
						          <tbody>
						          <?php 
								 /* if($company->id_proof != null ||  $company->address_proof != null){?>
								  <tr>
									<td><?php echo date("Y-m-d",strtotime($company->create_time));?></td>
									<td><?php echo date("h:i:s",strtotime($company->create_time));?></td>
									<td>Identification</td>
									<td><?php echo $company->id_proof; ?></td>
									<td><a href="<?php echo base_url().'home/download/'.$company->id_proof;?>" >Click Here</a></td>
								  </tr>
								  <tr>
									<td><?php echo date("Y-m-d",strtotime($company->create_time));?></td>
									<td><?php echo date("h:i:s",strtotime($company->create_time));?></td>
									<td>Proof of Address</td>
									<td><?php echo $company->address_proof; ?></td>
									<td><a href="<?php echo base_url().'home/download/'.$company->address_proof;?>" >Click Here</a></td>
								  </tr>
								  
								  
								<?php  }*/
								  
								  
								  foreach ($files_info as $file_info){
								  if($file_info->type_id !=0 && $file_info->type_id !=1 && $file_info->type_id !=2 && $file_info->type_id !=3)
								 { ?>
						            <tr>
						              <td><?php echo date("Y-m-d",strtotime($file_info->create_time));?></td>
						              <td><?php echo date("h:i A",strtotime($file_info->create_time));?></td>
						              <td><?php echo $this->search->docTypeOptions($file_info->type_id);?></td>
									  
						              <td><?php echo $file_info->file_name;?></td>
						              <td><a href="<?php echo base_url().'home/download/'.$file_info->file_name;?>" >Click Here</a></td>
									  <?php if($role_id === '1'){?>
									   <td>
									  <a href="#" onClick="deleteRecord('<?php echo $file_info->id;?>','file_mail')"/>Delete</a>
									  </td>
									  <?php }?>
						            </tr>
						            <?php }}?>
						          </tbody>
						        </table>
						        
						        
						                <?php /*echo $error;?> <!-- Error Document will show up here -->
										<?php echo form_open_multipart('home/do_upload');?>
										       <input type="text" name="company_doc_id" id="<?php echo 'company_doc_id'.$company->id?>" class="form-control" value="<?php echo $company->id;?>">
												 <div class="form-group">
						         <label>Invoice:</label>
						          <input name="invoice" id="<?php echo 'invoice'.$user_order->id;?>" size="40" type="text"  class="invoice" value="" />
						          </div>							
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										
										<?php if($role_id ==1){ ?>
										
										   <select id="file_type_id" class="form-control" name="file_type_id">
							              <option value="4">Identification</option>
							               <option value="5">Proof of Address</option>
							                <option value="6">Invoice</option>
											  <option value="7">Terms and Conditions</option>
											    <option value="3">Other</option>
							              </select>
							              <?php }?>
										<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
										<?php echo "</form>"*/?>
										<?php if($role_id !== '0' && $role_id !== '2'){?>
						          <input type="button" value="Add" name="add_doc"  id = "add_doc<?php echo $user_order->id;?>" class="btn btn-success" onClick="addDoc('<?php echo $company->id;?>')"/>
										<?php }?>

							 </div>   
							  
						        <a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
								   <i class="fa fa-close"></i>
								</a>
					      </div>
					  
					  
					  
					  
					  <div role="tabpanel" class="tab-pane" id="<?php echo "tab_emails".$user_order->id;?>">
					     <form  name="update_company" method="POST" action="<?php echo base_url();?>home/addAltEmail" id="altEmail"<?php echo $company->id;?>>
					         <div class="form-group col-sm-6 col-xs-12 box">
					   		  <input type="hidden" name="company_id" id="company_id<?php echo $company->id;?>" class="form-control" value="<?php echo $company->id;?>">
									<label for="Email1 ">Email Alert 1:</label> <input type="email" name="email_1" id="email_1<?php echo $company->id;?>" class="form-control" value="<?php echo $update_company_user->email;?>">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Email2">Email Alert 2:</label> <input type="email" name="email_2" id="email_2<?php echo $company->id;?>" class="form-control" value="<?php echo $alt_emails->email_2?>">
							</div>
 
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Email3">Email Alert 3:</label>
									 <input type="email" name="email_3" id="email_3<?php echo $company->id;?>" class="form-control" value="<?php echo $alt_emails->email_3?>">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="4">Email Alert 4:</label>
									 <input type="email" name="email_4" id="email_4<?php echo $company->id;?>" class="form-control" value="<?php echo $alt_emails->email_4?>">
							</div>

								
						
							  <div class="clearfix"></div>
					     <hr>
					    <div class="col-sm-12 text-center">
					   <input type="submit" value="Update" name="update" class="btn btn-success"/>
					    
					      <a class="btn btn-danger accordion-toggle" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">Close</a>
					    </div>
						
						<a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
						   <i class="fa fa-close"></i>
						</a>
						</form>
					    </div>
					  
					  
					  
					    
						
					  </div>  
					</div>
			     </div>
			</tr>
					
				<?php }
				
				
			}?>
			
			
		
	
		</tbody>
	</table>
	 <div class="row" style="margin-left:200px;">
       <?php echo $this->pagination->create_links(); ?>
  </div>
	</div>
	
				
</section>

	<?php $this->load->view ('footer');?>

   <?php $this->load->view ('modal');?>

