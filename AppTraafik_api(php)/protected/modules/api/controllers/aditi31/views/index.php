  <div class="table_data">	
     
	<table class="table table-hover">
		<thead>
			<tr>
			<th class="cmpny">
			  Company Name
			  
			  <form class="seach-cmpny" id="search_company" name="search_company" method="Post" action="<?php echo base_url();?>home/search">
			    <input class="form-control" placeholder="search" type="text" id="search_field" name="search_field">
			  	<input type="submit" class="btn btn-success" value="search" name="search" id="search">
				<!-- span id="search_button"><i class="fa fa-search"></i></span-->
			  </form>
			</th>
			
			<th>
			<form action="<?php echo base_url();?>home/reseller_change" method="POST" name="reseller_form_change" id="reseller_form_change">
			<?php $resellers =  $this->search->resellers();?>
			  <select id="reseller_change" name="reseller_change">
			  <option value="0">Reseller</option>
			  <option value="00">Show All</option>
			  <?php foreach($resellers as $reseller){?>
			    <option value="<?php echo $reseller->id;?>"><?php echo $reseller->company_name;?></option>
			   <?php }?>
			  </select>
			    </form>
			</th>
			
			<th>
			<form action="<?php echo base_url();?>home/state_change" method="POST" name="state_form_change" id="state_form_change">
			<?php $states =  $this->search->getStatusOptions();?>
			 <select id="state_change" name="state_change">
			    <option>Status</option>
				<option value="00">Show All</option>
			      <?php foreach($states as $key =>$state){?>
			    <option value="<?php echo $key ;?>"><?php echo $state;?></option>
			   <?php }?>
			    
			  </select>
			  
			  </form>
			</th>
			
			<th>
			
			
			  <select>
			  
			    <option>Renewal Date</option>
			   
			  </select>
			</th>
			
			<th>
			  <select>
			    <option>Location</option>
			    
			  </select>
			</th>
			
			<th>
			<!--form action="<?php //echo base_url();?>home/serviceSearch" method="POST" name="registered_office" id="registered_office"-->
			<?php $services =  $this->search->getServiceOptions();?>
			  <select id="registered_office" name="registered_office" class="getSelect">
			    <option>Registered</option>
				   <?php  foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }?>
			   
			  </select>
			  <!--/form-->
			</th>
			
			<th>
			  <select id="director_service_address" class="getSelect">
			    <option>Director</option>
				  <?php /*foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }*/?>
			    
			  </select>
			</th>
			
			<th>
			  <select id="business_address" class="getSelect">
			    <option>Business</option>
				  <?php /*foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }*/?>
			  
			  </select>
			</th>
			<th>
			  <select id="telephone_service" class="getSelect">
			    <option>Telephone</option>
				  <?php /*foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }*/?>
			   
			  </select>
			</th>
			<th>
			  <select id="hosting" class="getSelect">
			    <option>Hosting</option>
				  <?php /*foreach($services as $service){?>
			    <option value="<?php echo $service;?>"><?php echo $service;?></option>
			   <?php }*/?>
			  
			  </select>
			</th>
			<!--th>
			  <select>
			    <option>Package</option>
			    <option>Option1</option>
			    <option>Option2</option>
			    <option>Option3</option>
			    <option>Option4</option>
			    <option>Option5</option>
			  </select>
			</th-->
			<th>
			  <select>
			    <option>Price</option>			    
			   
			  </select>
			</th>
			<th>
			  <select>
			    <option>Upload</option>
			    
			  </select>
			</th>
			</tr>
		</thead>
    
    
		<tbody id="OrderPackages">
		  
 
			
			<?php 
			if($user_orders){
				
				foreach ($user_orders as $user_order)
				{
					//var_dump($user_order->company_id);die;
				  $company =  $this->search->filterSearch($user_order->company_id);
				  $user =  $this->search->userSearch($user_order->create_user_id);
				  $billing =  $this->search->billing($company->billing_adress_id);
				  $mailling =  $this->search->mailling($company->mailing_adress_id);
				  $orders =  $this->search->orders($company->id);
				  $order_details =  $this->search->orderDetails($orders->id);
				  $files_info =  $this->search->fileInfo($user_order->company_id);
				  $messages =  $this->search->Message($user_order->id);
					?>
					
			<tr id="<?php echo 'row_'.$user_order->id;?>"  >
			<td id="<?php echo 'data_'.$user_order->id;?>" >
			
			<a href="<?php echo '.packageDetails'.$user_order->id;?>" id="<?php echo 'package_'.$user_order->id;?>" 
			class="accordion-toggle package_click" data-toggle="collapse" data-parent="#OrderPackages">
			
			<?php echo $user_order->company_name;?></a></td>
			<td onclick = "reseller('<?php echo $user_order->id?>')"><a href="#"><?php echo $user_order->reseller;?></a></td>
			<td class = "state_id" data-id="<?php echo $user_order->id;?>"><a href="#"><?php echo	$this->search->getStatusOptions($user_order->state_id);?></a></td>
			<td  class = "renew_id" id="<?php echo $user_order->id;?>" onclick = "displayDatepicker('<?php echo $user_order->id?>')">
				<a href="#">	
					<?php echo date ("d-m-Y",strtotime($user_order->renewable_date));?></td>
				</a>	
			<td onclick =" location_event('<?php echo $user_order->id?>')">
				<a href="#">
					<?php echo $user_order->location;?>
				</a>
			</td>
			<td onclick ="mail_handel('<?php echo $user_order->id?>')"><a href="#"><?php echo $user_order->registered_office;?></a></td>
			<td onclick ="mail_handel('<?php echo $user_order->id?>')"><a href="#"><?php echo $user_order->director_service_address;?></a></td>
			<td onclick ="mail_handel('<?php echo $user_order->id?>')"><a href="#"><?php echo $user_order->business_address;?></a></td>
			<td onclick ="message_handel('<?php echo $user_order->id?>')">
				<a href="#">
					<?php echo $user_order->telephone_service;?>
				</a>
			</td>
			
			<td>Buy</td>
			<!-- td>COMPANY</td-->
			<td>&pound;<?php echo $user_order->price;?></td>
			<td class="uploadId" data-id="<?php echo $user_order->id;?>" >
			<?php if($company->id_proof !=""){?>
			<a href="#">Received</a>
			<?php }else{?>
			<a href="#">ID</a>
			<?php }?>
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
					    <li role="presentation"><a href="<?php echo "#tab_order".$user_order->id;?>" role="tab" data-toggle="tab">Order Details</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_mail".$user_order->id;?>" role="tab" data-toggle="tab">Mail Centre</a></li>
					    <li role="presentation"><a href="<?php echo "#tab_message".$user_order->id;?>" role="tab" data-toggle="tab">Message Centre</a></li>
						<li role="presentation"><a href="<?php echo "#tab_document".$user_order->id;?>" role="tab" data-toggle="tab">Documents</a></li>
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
									 <input onclick = "displayDatepicker('<?php echo $user_order->id?>')" type="text" name="renewal" id="<?php echo 'renewal_'.$user_order->id;?>" class="form-control" value="<?php echo date ("d-m-Y h:i:s",strtotime($user_order->renewable_date));?>">
							</div>
							
								<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Location:</label>
									 <input  onclick =" location_event('<?php echo $user_order->id?>')" type="text" name="location" id="<?php echo 'location'.$user_order->id;?>" class="form-control" value="<?php echo $user_order->location;?>">
							</div>
							
							<div class="form-group col-sm-6 col-xs-12 box cmpny-img">
							<?php if($company->id_proof !=""){?>
							    <img src = "<?php echo base_url().'/uploads/'.$company->id_proof;?>"  >	
							    <?php }?>
							   <?php if($company->address_proof !=""){?> 
							    <img src = "<?php echo base_url().'/uploads/'.$company->address_proof;?>"  >
							     <?php }?>
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
									<input type="text" name="user_name" value="<?php echo $user->first_name;?>" id="user_name" class="form-control">
							<input type="hidden" name="user_id" value="<?php echo $user->id;?>" id="user_id" class="form-control">
							<input type="hidden" name="mailing_id" value="<?php echo $mailling->id;?>" id="mailing_id" class="form-control">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="First Name">Last Name:</label> 
									<input type="text" name="user_last_name" value="<?php echo $user->last_name;?>" id="user_last_name" class="form-control">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Middle Name">Email:</label> 
									<input type="text" name="user_email" value="<?php echo $user->email;?>" id="user_email" class="form-control">
							</div>

							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Last Name">Daytime Phone:</label>
									 <input type="text" value="<?php echo $user->ph_no;?>" name="user_daytime_contact" id="user_daytime_contact" class="form-control">
							</div>


							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Mobile Number:</label> 
									<input type="text" value="<?php echo $user->mobile;?>" name="user_contact" id="user_contact" class="form-control">
							</div>
							
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Skype Address:</label>
									 <input type="text" value="<?php echo $user->skpe_address;?>" name="user_skype" id="user_skype" class="form-control">
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
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Change Password:</label> 
									<input type="text" value="" name="user_password" id="user_password" class="form-control">
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
									 <input type="text" name="billing_country" value="<?php echo $billing->county;?>" id="billing_country" class="form-control">
							</div>	
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Postcode:</label>
									 <input type="text" value="<?php echo $billing->postcode;?>" name="billing_post_code" id="billing_post_code" class="form-control">
							</div>
							<div class="form-group col-sm-6 col-xs-12 box">
									<label for="Nationality">Country:</label> 
									<input type="text" value="<?php echo $billing->country;?>" name="billing_county" id="billing_county" class="form-control">
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
					    <form  name="update_order" name="update_order" method="Post" action="<?php echo base_url();?>home/updateCompany">
						
							
							<?php foreach ($order_details as $order_detail){?>
							
							
							<div class="form-group col-sm-3 col-xs-12 box">
									<label for="Nationality">Order:</label> 
									<input type="text" value="<?php echo $order_detail->product;?>" name="product_name" id="product_name" class="form-control">
							</div>
							<div class="form-group col-sm-3 col-xs-12 box">
									<label for="Nationality">Price:</label> 
									<input type="text" value="<?php echo $order_detail->price;?>" name="product_price" id="product_price" class="form-control">
							</div>
							<div class="form-group col-sm-3 col-xs-12 box">
									<label for="Nationality">Quantity:</label>
									 <input type="text" value="<?php echo $order_detail->quantity;?>" name="product_quantity" id="product_quantity" class="form-control">
							</div>
						
								<div class="form-group col-sm-3 col-xs-12 box">
									<label for="Nationality">Date:</label>
									 <input type="text" value="<?php echo $order_detail->create_time;?>" name="product_quantity" id="product_quantity" class="form-control">
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
					      
					      <div role="tabpanel" class="tab-pane" id="<?php echo "tab_mail".$user_order->id;?>">
					        <div class="col-sm-12">
						        <table class="table table-under-panel">
						          <thead>
						            <tr>
						               <th>Date</th>
						               <th>Time</th>
						               <th>Type</th>
						               <th>File Name</th>
						               <th>Download</th>
						               <th>Request Original</th>
						            </tr>
						          </thead>
						          
						          <tbody>
						          <?php foreach ($files_info as $file_info){?>
						            <tr>
						              <td><?php echo date("Y-m-d",strtotime($file_info->create_time));?></td>
						              <td><?php echo date("h:i A",strtotime($file_info->create_time));?></td>
						              <td><?php echo $this->search->getTypeOptions($file_info->type_id);?></td>
						              <td><?php echo $file_info->file_name;?></td>
						              <td>yes</td>
						              <td>Not yet</td>
						            </tr>
						            <?php }?>
						          </tbody>
						        </table>
						        
						        
						                <?php /*echo $error;?> <!-- Error Message will show up here -->
										<?php echo form_open_multipart('home/do_upload');?>
										       <input type="hidden" name="comp_id" id="<?php echo 'comp_id'.$company->id?>" class="form-control" value="<?php echo $company->id;?>">
																			
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										
										<?php if($role_id ==1){ ?>
										
										   <select id="file_type_id" class="form-control" name="file_type_id">
							              <option value="0">HMRC</option>
							               <option value="1">Companies House</option>
							                <option value="2">Business Mail</option>
							              </select>
							              <?php }?>
										<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
										<?php echo "</form>"*/?>
						        
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
						               <th>Date</th>
						               <th>Time</th>
						               <th>To</th>
						               <th>From</th>
						               <th>Tel No.</th>
						               <th>Message</th>
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
						              <td><?php echo $message->message;?></td>
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
						               <th>Date</th>
						               <th>Time</th>
						               <th>Type</th>
						               <th>File Name</th>
						               <th>Download</th>
						            </tr>
						          </thead>
						          
						          <tbody>
						          <?php foreach ($files_info as $file_info){?>
						            <tr>
						              <td><?php echo date("Y-m-d",strtotime($file_info->create_time));?></td>
						              <td><?php echo date("h:i A",strtotime($file_info->create_time));?></td>
						              <td><?php echo $this->search->getTypeOptions($file_info->type_id);?></td>
						              <td><?php echo $file_info->file_name;?></td>
						              <td>yes</td>
						              <td>Not yet</td>
						            </tr>
						            <?php }?>
						          </tbody>
						        </table>
						        
						        
						                <?php echo $error;?> <!-- Error Document will show up here -->
										<?php echo form_open_multipart('home/do_upload');?>
										       <input type="text" name="company_doc_id" id="<?php echo 'company_doc_id'.$company->id?>" class="form-control" value="<?php echo $company->id;?>">
												 <div class="form-group">
						         <label>Invoice:</label>
						          <input name="invoice" id="<?php echo 'invoice'.$user_order->id;?>" size="40" type="text"  class="invoice" value="" />
						          </div>							
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										
										<?php if($role_id ==1){ ?>
										
										   <select id="file_type_id" class="form-control" name="file_type_id">
							              <option value="0">HMRC</option>
							               <option value="1">Companies House</option>
							                <option value="2">Business Mail</option>
							              </select>
							              <?php }?>
										<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
										<?php echo "</form>"?>
						        
						      </div>   
						        <a class="btn-close" id="<?php echo 'packageDetails'.$user_order->id;?>" data-toggle="collapse" data-parent="#OrderPackages" data-target="<?php echo '.packageDetails'.$user_order->id;?>">
								   <i class="fa fa-close"></i>
								</a>
					      </div>
					  
					  
					    
						
					  </div>  
					</div>
			     </div>
			</tr>
					
				<?php }
				
				
			}?>
			
			
		
	
		</tbody>
	</table>
	</div>
