
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>

<script type="text/javascript">

function getDateOtions()
{

$('#renew_select').modal('show');
 $('#renew_company_to').datepicker({
				 showAnim: "clip",		
			   gotoCurrent: true,
			   dateFormat: "dd-mm-yy",
			   changeYear: true
			 });
 $('#renew_company_from').datepicker({
				 showAnim: "clip",		
			   gotoCurrent: true,
			   dateFormat: "dd-mm-yy",
			   changeYear: true
			 });

}
function deleteRecord(id,model,product){


var r = confirm("Are you sure");
if (r == true) {
		$.ajax({
				url:base_url+"index.php/home/deleteRecord",
				'type' : 'POST',
				data:{
				"record_id":id,
					"model":model
				
				},

				success:function(data){	
			//alert(data);
					window.location.href = base_url+"index.php/home";
									
					}
		});
} else {
    var txt = "You pressed Cancel!";
}

	

}



function ResellerUpdate(id,company_name,contact_name,phone_number,mail_email,country,address1,address2,web_address,town,region,post_code,admin_email,logo_text,county)
{


	$('#update_reseller_id').val(id);
	$('#reseller_company_name').val(company_name);
	$('#reseller_contact_name').val(contact_name);
	$('#reseller_phone').val(phone_number);
	$('#reseller_email').val(mail_email);
	$('#reseller_mail_country').val(country);
	
	$('#reseller_address1').val(address1);
	$('#reseller_weburl').val(web_address);
	$('#reseller_address2').val(address2);
	$('#reseller_town').val(town);
	$('#reseller_county').val(region);
	$('#reseller_post_code').val(post_code);
	$('#reseller_admin_email').val(admin_email);
	$('#reseller_logo_name').val(logo_text);
	$('#reseller_county').val(county);
	
	
		
	$('#reseller_update').modal('show');

}



function addDoc(id){

	$('#get_doc_order_id').val(id);
	$('#doc_upload').modal('show');

}

function getMessage(id)
{

	var message = $('#'+id).val();
	
	$("#full_message").empty();
	$('#full_message').html(message);	
	/*$('#full_message').innerHTML  = message;	*/
	$('#message_detail').modal('show');
	
}


function get_mail_data(com_id,create_time,type_id,file_name,file_id)
{

				
			$.ajax({
				url:base_url+"index.php/home/mailRequestOriginal",
				'type' : 'POST',
				data:{
				"com_id":com_id			
				
				},

				success:function(data){	
					window.location.href = base_url+"index.php/home";
									
					}
		});
}

function disableTextBoxes()
{
	//alert("m client");
	$(".text_disable").attr('disabled','disabled');
}

var base_url = "<?php echo base_url()?>";
$(".package_click").click(function(){
	var id = $(this).attr('id');
	var td = $("#"+id).closest("td").attr("id");
	var tr = $("#"+td).closest("tr").attr("id");

	$("#"+tr).addClass("active_row");
	var expand = $("#accordion_"+td).attr("aria-expanded");
	
	if(expand == "true"){
		$("#"+tr).removeClass("active_row");
	}
	  	

	
});
$("#search_button").click(function(){
	
	var search_query = $('#search_field').val();
	
	$.ajax({
		url:base_url+"index.php/home/search",
		'type' : 'POST',
		data:{"search_field":search_query},

		success:function(data){	
				
			$("#OrderPackages").empty();
			$('#OrderPackages').html(data);	
							
			}
		});
});


	$(".getSelect").on("change",function(){
	
	//$('#state_form_change').submit();
	
	var id = $(this).attr("id");
		var select_option = $("#"+id).val();
	
		$.ajax({
			url:base_url+"index.php/home/serviceSearch",
			'type' : 'POST',
			data:{
				"select_id":id,
				"select_option":select_option
					
				},

			success:function(data){	
				//	alert(data);
				$("#content_info").empty();
				$('#content_info').html(data);	
								
				}
			});
	});

$('.state_id').click(function(){

	$('#status').modal('show'); 
	var record_id = $(this).data('id');
	/*alert(record_id);
	var comp_id = $("#del_comp_id").data('del_id');
	alert(comp_id);*/
    $(".status_update #status_company_id").val( record_id );
    $("#delete_order_id").val( record_id );
	
   
	});	
	
		$('.uploadId').click(function(){

		$('#uploadId').modal('show');
		
		 var record_id = $(this).data('id');
		// alert(record_id);
	     $("#c_id").val( record_id );dd

		});
	
	
		$("#state_change").on("change",function(){
		
		$('#state_form_change').submit();
	
	});
	$("#reseller_change").on("change",function(){
		
		$('#reseller_form_change').submit();
	
	});
	
	function location_event(id)
   {
   $.ajax({
	'url' : base_url+"index.php/home/location",
			'type' : 'POST',
			'data' :{
				'id' : id,
			}, 
			success:function(data){
			//alert(data);
			if (data == "SE1")
			{
				document.getElementById('radio1').checked = true;				
			}
			else if (data == "WC1" || data == "WC4")
			{
				document.getElementById('radio2').checked = true;
			}
			else if (data == "EH1")
			{
				document.getElementById('radio3').checked = true;
			}
				$('#reseller_admin_password').val('');
				
					$('#location_company_id').val(id);
					$('#location').modal('show');
			
			}
   
   });
   
   
	
   }
function reseller(id)
  {
		$('#reseller_id').val(id);
		$('#reseller').modal('show');
  }
function message_handel(id,email1)
{
		$('#get_message_order_id').val(id);
		$('#_email').val(email1);
			$('#message_post').val('');
		
		$('#message_handler').modal('show');
}
function mail_handel(id)
{
	
		$('#get_mail_order_id').val(id);
	
		$('#mail_handler').modal('show');
}

function displayDatepicker(id){
	$('#get_order_id').val(id);
	$('#renew').modal('show');
			 $('#renew_company_id').datepicker({
				 showAnim: "clip",		
			   gotoCurrent: true,
			   dateFormat: "dd-mm-yy",
			   changeYear: true
			 });
			}
			
function getOptions(id,s)
{
	var order_name = s[s.selectedIndex].id;//$(this).attr('name');
	//alert(order_name);
	 $('#service_name'+id).val(order_name);
	///console.log(this[this.selectedIndex].name);

	
	var service_quantity = $('#service_quantity'+id).val();
	
	var val = $('#payment_options'+id).val();
	var get_value = parseFloat(val.substr(val.indexOf("£") + 1) * service_quantity).toFixed(2);
	
	if(get_value != 'Other Payment')
	{	
			$('#service_amount'+id).val(get_value);
			$('#pay_amount'+id).val(get_value);
			$('#add_order_id_price'+id).val(get_value);
	}
	else
	{
			$('#service_amount'+id).val('') ;
			$('#pay_amount'+id).val(get_value);
			$('#add_order_id_price'+id).val(get_value);
	}
}

function getAmountValue(id)
{
var get_amount = $('#service_amount'+id).val();
	
	$('#pay_amount'+id).val(get_amount);

}
function  calPrice(id,mode,price){
	if(mode =="service"){
		var service_quantity = $('#service_quantity'+id).val();
		var service_amount = $('#add_order_id_price'+id).val();
		
		var calAmount = service_quantity * service_amount;
		$('#service_amount'+id).val(calAmount);
	}
	else if(mode =="product")
	{
		var product_quantity = $('#product_quantity'+id).val();
		var product_amount = $('#product_price'+id).val();
		
		var calAmount = product_quantity * price;
		$('#product_price'+id).val(calAmount);
	}
	
	
}


function payment_form(id,order_id,mode){

	 var values = $('#'+id).serialize();
		//alert(values);
	 $.ajax({

			'url' : base_url+"index.php/home/addOrder",
			'type' : 'POST',
			'data' :{
				'user_services' : values,
				'order_id' :order_id
			}, 
			'success' : function(data) { 
			//alert(data)
				if(mode == 'invoice')
				{
					window.location.href = base_url+"index.php/home";
				}
				else 
				{
				
					$('#'+id).submit();		
				}
				
			
			},
			'error' : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
}
$('.regClick').change(function(){
//alert("regClick");
		$('#registered_office_select').submit();	

});
$('.hostClick').change(function(){
//alert("hostClick");
		$('#hosting_select').submit();	

});
$('.telClick').change(function(){
//alert("telClick");
		$('#telephone_service_select').submit();	

});
$('.busClick').change(function(){
//alert("busClick");
		$('#business_address_select').submit();	

});
$('.dirClick').change(function(){
//alert("dirClick");
		$('#director_service_address_select').submit();	

});
$('.locClick').change(function(){
//alert("dirClick");
		$('#location_select').submit();	

});
$('.IdClick').change(function(){
//alert("dirClick");
		$('#upload_form_change').submit();	

});
$('#getRenewalDate').click(function(){
//alert("dirClick");
var renewfrom = $('#renew_company_from').val();
var renewto = $('#renew_company_to').val();
	if(!renewfrom)
	{
		alert('Please select from renewal date');
	}
	else if(!renewto)
	{
		alert('Please select to renewal date');
	}
	else{
		/* $.ajax({

			'url' : base_url+"index.php/home/addOrder",
			'type' : 'POST',
			'data' :{
				'user_services' : values,
				'order_id' :order_id
			}, 
			'success' : function(data) { 
			//alert(data)
				
				$('#'+id).submit();		
				
			
			},
			'error' : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});*/
		$('#renewal_form').submit();	
		}

});



function getformSubmit(id)
{	

 var values = $('#add_company_form_popup').serialize();
 var price = $('#add_company_services_popup').val();
 var order_name = $('#add_company_services_popup').find('option:selected').attr('id');


 var company=$('#company_contact_name').val();
			if(!company)
			{
				alert("Please fill Your Company Name");
				return false;
			}

	
	else {
				
		//alert(values);
	 $.ajax({

			'url' : base_url+"index.php/home/addCompany",
			'type' : 'POST',
			'data' :{
				'form_fields' : values,
				'order_name' : order_name,
				'price' : price,
			}, 
			'success' : function(data) { 
		//alert(data)
			
			if(id == "pay_now")
					$('#add_company_form_popup').submit();		
				else
					window.location.href = base_url+"index.php/home";	/**/
			
			},
			'error' : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
			}
		});
		
	}
	

}
/*====================================================================*/



</script>
<!-- Modal -->
  <div class="modal fade" id="status" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Order Status</h4>
        </div>
        <div class="modal-body status_update">
          <form role="form" action="<?php echo base_url();?>home/updateCompany" method="POST" >
            <div class="form-group">
            
              <label for="usrname">Status</label>
                <input name="status_company_id" id="status_company_id" size="40" type="hidden"  class="" value="" />
				<?php $states =  $this->search->getStatusOptions();?>
              <select id="state_id" class="form-control" name="state_id">
              	   <?php foreach($states as $key =>$state){?>
			    <option value="<?php echo $key ;?>"><?php echo $state;?></option>
			   <?php }?>
              </select>
            </div>
			  <div class="text-right form-actn-top">  
                <button type="submit" class="btn btn-success">Change Status</button>
			</div>	
          </form>
          <form  action="<?php echo base_url();?>home/delete_row" method="POST" >
			  <div class="text-right form-actn-bottm">            
				 <input name="delete_order_id" id="delete_order_id" size="40" type="hidden"  class="" value="" />
				 <button type="submit" class="btn btn-danger">Delete</button>
				 <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
			  </div>	
          </form>
        </div>
      </div>
    </div>
  </div>
  
  
<div class="modal fade" id="uploadId" role="dialog">
   <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="alert">We need to be able to confirm your identity.Send us a copy of your passport or ID card and a less than 30 days utility bill</h4>
        </div>	<?php echo $error;?> <!-- Error Message will show up here -->
				<?php echo form_open_multipart('home/proof_upload');?>
          <div class="modal-body upload_file_form">
        	 <div class="form-group">
				 <input name="c_id" id="c_id" size="40" type="hidden"  class="" value="" />.
				 <label>Passport or Identity Card</label>
				<?php echo "<input type='file' name='userfile[0]' size='20' />"; ?>
				</div>
				 <div class="form-group">
				 <label>Utility Bill(Proff of Address)</label>
				<?php echo "<input type='file' name='userfile[1]' size='20' />"; ?>
				
				</div>
				 <div class="form-group text-right">
				 
				<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success nmr' /> ";?>
				</div>
    
       </div>
        <?php echo "</form>"?>
      </div>
    </div>
</div>



  <div class="modal fade" id="renew" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Order Renew</h4>
        </div>
        <div class="modal-body ">
     
     
        <form role="form" action="<?php echo base_url();?>home/updateOrder" method="POST" >
            <div class="form-group">
            
              <!--label for="usrname">Renewal Date</label-->
                <input name="get_order_id" id="get_order_id" size="40" type="hidden"  class="form-control" value="" />
     		  <input name="renew_company_id" id="renew_company_id" size="40" type="text"  class="form-control" value="" placeholder="Renewal Date" />
     
            </div>
			 <div class="text-right"> 
                 <button type="submit" class="btn  btn-success">Change Renewal Date</button>
			     <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
             </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  
  
    <div class="modal fade" id="location" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Order Location</h4>
        </div>
        <div class="modal-body ">
     		       <form role="form" action="<?php echo base_url();?>home/updateOrder" method="POST" >
            <div class="form-group">
            
              <label for="usrname">Locations</label>
                <input name="location_company_id" id="location_company_id" size="40" type="hidden"  class="form-control" value="" />
														<div class="form-group form-control"><input type="radio" value="option1" id="radio1" name="radioGroup" > 
														
														<b>Tower Bridge Office</b>
														,St Saviours Wharf,
														Mill Street,
													London,
														SE1 2BE
														
													</div>
													<div class="form-group form-control"><input type="radio" value="option2" id="radio2" name="radioGroup" >
													
														<b>West End Office</b>
														,Bloomsbury Way,
														London,
														WC1 2SE
													</div>
														<div class="form-group form-control"><input type="radio" value="option3" id="radio3" name="radioGroup" >
													
																											
														<b>Tweeddale Court</b>
														,High Street,
														Old Town Edinburgh,
														EH1 1TE
													</div>
            </div>
			 <div class="text-right"> 
                <button type="submit" class="btn  btn-success">Change Location</button>
			    <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
             </div> 
          </form>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="reseller" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Order Reseller</h4>
        </div>
        <div class="modal-body ">
     
     		       <form role="form" action="<?php echo base_url();?>home/updateOrder" method="POST" >
            <div class="form-group">
            
              <label for="usrname">Resellers</label>
                <input name="reseller_id" id="reseller_id" size="40" type="hidden"  class="form-control" value="" />
       			<?php   $resellers =  $this->search->resellers();?>
				 <select id="save_reseller_id" class="form-control" name="save_reseller_id">
				<?php foreach ($resellers as $reseller){?>f
              <option value="<?php echo $reseller->id?>"><?php echo $reseller->company_name?></option>
                <?php }?>
              </select>
            </div>
             
             <div class="text-right"> 
			   <button type="submit" class="btn btn-success">Change Reseller</button>
			   <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
             </div>
			 
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="message_handler" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Send Message</h4>
        </div>
        <div class="modal-body ">
        
        
        
        
     		        <form id="<?php echo 'message_form'.$user_order->id;?>" role="form" action="<?php echo base_url();?>home/message" method="POST" class="message_form_class">
						     
						        <input name="order_post_id"  id="get_message_order_id" size="40" type="hidden"  class="form-control" value="" />
						        	 <div class="form-group">
						         <!--label>Call To:</label-->
						          <input name="to_id"  size="40" type="text"  class="form-control" value=""  placeholder="Call To"/>
						          </div>
						          	 <div class="form-group">
						          
						            <!--label>Call From:</label-->
						          <input name="from_id" size="40" type="text" placeholder="Call From" class="form-control" value="" required />
						           </div>
						           	 <div class="form-group">
						            <!--label>Telephone Number:</label-->
						                 <input name="tel_no"  size="40" type="text" placeholder="Telephone Number" class="form-control" value=""  />
						            </div>
						            	 <div class="form-group">
						              <!--label>Email Address:</label-->
						           <input name="_email"  size="40" type="text"  class="form-control" value=""  placeholder="Email Address"/>
									</div>
										 <div class="form-group">
						           <!--label>Message:</label-->
								   <textarea name="message_post" class="form-control" placeholder="Message" value="" id="message_post">
								  </textarea>
									</div>
						       	 <div class="form-group">   
								   <div class="text-right">
		 				             <input type="submit" value="+ Message" name="upload_message" class="btn btn-success message_form_id" />
								     <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
								   </div>
								</div>
						   </form>
						   
						   
						   
        </div>
      </div>
    </div>
  </div>
 
  
  
  
  <div class="modal fade" id="mail_handler" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Mail Center</h4>
        </div>
        <div class="modal-body ">
        
             <?php echo $error;?> <!-- Error Message will show up here -->
										<?php echo form_open_multipart('home/do_upload');?>
                                        <div class="form-group">
										   <input type="hidden" name="comp_id" id="get_mail_order_id" class="form-control" value="">
																			
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										</div>
										<?php if($role_id ==1){
											$options = $this->search->getTypeOptions();
										?>
                                        <div class="form-group">
										    <label>Select Type:</label>
										   <select id="file_type_id_mail" class="form-control" name="file_type_id">
										   <?php foreach($options as $key=>$value){?>
							              <option value="<?php echo $key?>"><?php echo $value; ?></option>
											<?php }?>
							              </select>
							              <?php }?>
										<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
                                          <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
                                        </div>
										<?php echo "</form>";?>
        
        
     		    <?php /*echo $error;?> <!-- Error Message will show up here -->
										<?php echo form_open_multipart('home/do_upload');?>
										<div class="form-group">
										       <input type="hidden" name="comp_id" id="get_mail_order_id" class="form-control" value="">
																			
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										</div>
										<?php if($role_id ==1){ 
											$options = $this->search->getTypeOptions();
										?>
										<div class="form-group">
						           <label>Select Type:</label>
						       
										   <select id="file_type_id" class="form-control" name="file_type_id">
							              <?php foreach($options as $key=>$value){?>
							              <option value="<?php echo $key?>"><?php echo $value; ?></option>
											<?php }?>
							              </select>
										  	</div>
							              <?php }?>
										 <div class="text-right">   
										  <?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
										   <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
										</div>   
										<?php echo "</form>";*/ ?>
						   
						   
        </div>
      </div>
    </div>
  </div>

  
<!--Company pop-up-->  
<div class="modal fade" id="company" role="dialog">
    <div class="modal-dialog company-modal">

      <!-- Modal content-->
      <div class="modal-content company-modal-pd">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Add Company</h4>
        </div>
        <div class="modal-body ">

                 <div class="row">
                  <div class="booking-form">
				  
           <form id="add_company_form_popup" name="add_company_form_popup" action="https://secure.wp3.rbsworldpay.com/wcc/purchase" class="add_company_form_popup">
		                                    
             <div class="form-group col-sm-6"><input type="text" class="form-control" placeholder="Company Name"  name="company_contact_name" id="company_contact_name" value="" required /></div>
 			 <div class="form-group col-sm-6">
					<select class="form-control" name="add_company_services_popup" id="add_company_services_popup">
						<option id="Registered Office Address" value="29.00">Registered Office Address @ £29.00/per year</option>
						<option id="Business Address" value="99.00">Business Address @ £99.00/per year</option>
						<option id="Telephone Address" value="99.00">Telephone Service @ £99.00/per year</option>
						<option id="Complete Package" value="199.00">Business Plus @ £199.00/per year</option>
						<option id="Registered Office and Director Address" value="38.99">Registered Office + Director Service Address @ £38.99/per year</option>
					</select>
			 </div>
			  <div class="form-group col-sm-6">
              
								<select class="form-control" name="add_company_location_popup" id="add_company_location_popup">	
									   <option value="SE1"> 
											<b>Tower Bridge Office</b>
											,St Saviours Wharf,
											Mill Street,
											London,
											SE1 2BE
									    </option>					
									
									
									    <option value="WC1"> 
												<b>West End Office</b>
														,Bloomsbury Way,
														London,
														WC1 2SE
										</option>			 
   
										
										<option value="EH1"> 
												<b>Tweeddale Court</b>
												,High Street,
												Old Town Edinburgh,
												EH1 1TE
										</option>		
									</select>	
											
                      </div>
                      <?php if($role_id == 1){?>
                      
                      
                       <div class="form-group col-sm-6">
                       	<?php $resellers =  $this->search->resellers();?>
					<select class="form-control" name="add_company_reseller" id="add_company_reseller">
                    
			             
			                 <?php foreach($resellers as $reseller){?>
			                     <option value="<?php echo $reseller->id;?>"><?php echo $reseller->company_name;?></option>
			                 <?php }?>
			       </select>
			       </div>
						
                        <?php }?>
                        
                        
						</div>
                       
                      
                    <div class="submit-btn">
                       <div class="text-right"> 
					     <button type="button" class="btn submited-btn pay-now" id="pay_now" onClick="getformSubmit('pay_now')">Pay Now</button>
                         <button type="button" class="btn submited-btn pay-Invoice" id="pay_Invoice" onClick="getformSubmit('pay_Invoice')">Pay on Invoice</button>
					    <button type="submit" class="btn btn-default submited-btn nmr" data-dismiss="modal">Cancel</button>
                       </div>
                    </div>
                    </form> 
                    
                    
                            
                  </div>
                </div>
						   
						   
						   
        </div>
      </div>
    </div>
  </div>  
  
<!--Company pop-up end-->  
<!--Message pop-up-->  
<div class="modal fade" id="message_detail" role="dialog">
    <div class="modal-dialog company-modal">

      <!-- Modal content-->
      <div class="modal-content company-modal-pd">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Message</h4>
        </div>
        <div class="modal-body ">
        
        
        
        
                 <div class="row">
                  <div class="booking-form">
			<p id="full_message"></p>
                  </div>
                </div>		   
        </div>
      </div>
    </div>
  </div>  
  
<!--Message pop-up end-->  
<!-- Document Upload -->
  <div class="modal fade" id="doc_upload" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Document Upload</h4>
        </div>
        <div class="modal-body ">
        
        
        
        
     		    <?php	$docTypeOptions = $this->search->docTypeOptions();

				echo $error;?> <!-- Error Message will show up here -->
										<?php

										echo form_open_multipart('home/doc_upload');?>
										<div class="form-group">
										       <input type="hidden" name="comp_id" id="get_doc_order_id" class="form-control" value="">
																			
										<?php echo "<input type='file' name='userfile[]' size='20' multiple/>"; ?>
										</div>'s
										<?php if($role_id ==1){ ?>
										<div class="form-group">
						           <label>Select Type:</label>
						       
										   <select id="file_type_id" class="form-control" name="file_type_id">
										   <?php foreach($docTypeOptions as $key=>$value)
										   {?>
							              <option value="<?php echo $key;?>"><?php echo $value;?></option>
											  <?php }?>
							              </select>
										  	</div>
							              <?php }?>
										<?php echo "<input type='submit' name='submit' value='+Add' class='btn btn-success' /> ";?>
										 <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
										<?php echo "</form>"?>
						   
						   
        </div>
      </div>
    </div>
  </div>
  
  <!--Document -->
  <!-- Reseller Upload -->
  <div class="modal fade" id="reseller_update" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Reseller Update</h4>
        </div>
        <div class="modal-body ">
		
         <form class="seach-cmpny" id="reseller_manage" name="reseller_manage" method="Post" action="<?php echo base_url();?>home/resellerEdit">
              
            <input class="form-control" type="hidden"  name ="reseller_id"  id="update_reseller_id" value="">
          <div class="form-group"> 	
                <label>Reseller Name</label>	
             <input type="text" class="form-control" placeholder="Reseller Name" name="reseller_company_name" id="reseller_company_name" value=""  /></div>	
			 <div class="form-group"> 	
                <label>Contact Name</label>	
            <input type="text" class="form-control" placeholder="Contact Name"  name="reseller_contact_name" id="reseller_contact_name" value=""  /></div> 			
			<div class="form-group"> 	
                <label>Logo</label>	
             <input type="text" class="form-control" placeholder="Logo" name="reseller_logo_name" id="reseller_logo_name" value=""  /></div>			
            <div class="form-group"> 	
                <label>Phone Number</label>	<input type="text" class="form-control" placeholder="Phone Number"  name="reseller_phone" id="reseller_phone" value="" /></div>
             <div class="form-group"> 	
                <label>Email Alerts</label>	<input type="email" class="form-control" placeholder="Email Address" name="reseller_email" id="reseller_email" value="" /></div>
            <div class="form-group"> 	
                <label>Address 1</label>	<input type="text" class="form-control" placeholder="Address 1" name="reseller_address1" id="reseller_address1" value="" /></div>
             <div class="form-group"> 	
                <label>Website Address</label>	<input type="text" class="form-control" placeholder="Website Address" name="reseller_weburl" id="reseller_weburl" value="" /></div>
             <div class="form-group"> 	
                <label>Address 2</label>	<input type="text" class="form-control" placeholder="Address 2"  name="reseller_address2" id="reseller_address2" value="" /></div>
            <div class="form-group"> 	
                <label>Town / City</label>	<input type="text" class="form-control" placeholder="Town / City"  name="reseller_town" id="reseller_town" value=""/></div>
             <div class="form-group"> 	
                <label>County</label>	<input type="text" class="form-control" placeholder="County" name="reseller_county" id="reseller_county" value="" /></div>
            <div class="form-group"> 	
                <label>Post Code</label>	<input type="text" class="form-control" placeholder="Post Code"  name="reseller_post_code" id="reseller_post_code" value="" /></div>
            <div class="form-group"> 	
                <label>Email Address (Admin)</label>	<input type="text" class="form-control" placeholder="Email Address (Admin)"  name="reseller_admin_email" id="reseller_admin_email" value="" /></div>
          
		   <div class="form-group"> 	
                <label>Country</label>	
									<select class="form-control" name="reseller_country">
									<option value="Afganistan">Afghanistan</option>
									<option value="Albania">Albania</option>
									<option value="Algeria">Algeria</option>
									<option value="American Samoa">American Samoa</option>
									<option value="Andorra">Andorra</option>
									<option value="Angola">Angola</option>
									<option value="Anguilla">Anguilla</option>
									<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
									<option value="Argentina">Argentina</option>
									<option value="Armenia">Armenia</option>
									<option value="Aruba">Aruba</option>
									<option value="Australia">Australia</option>
									<option value="Austria">Austria</option>
									<option value="Azerbaijan">Azerbaijan</option>
									<option value="Bahamas">Bahamas</option>
									<option value="Bahrain">Bahrain</option>
									<option value="Bangladesh">Bangladesh</option>
									<option value="Barbados">Barbados</option>
									<option value="Belarus">Belarus</option>
									<option value="Belgium">Belgium</option>
									<option value="Belize">Belize</option>
									<option value="Benin">Benin</option>
									<option value="Bermuda">Bermuda</option>
									<option value="Bhutan">Bhutan</option>
									<option value="Bolivia">Bolivia</option>
									<option value="Bonaire">Bonaire</option>
									<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
									<option value="Botswana">Botswana</option>
									<option value="Brazil">Brazil</option>
									<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
									<option value="Brunei">Brunei</option>
									<option value="Bulgaria">Bulgaria</option>
									<option value="Burkina Faso">Burkina Faso</option>
									<option value="Burundi">Burundi</option>
									<option value="Cambodia">Cambodia</option>
									<option value="Cameroon">Cameroon</option>
									<option value="Canada">Canada</option>
									<option value="Canary Islands">Canary Islands</option>
									<option value="Cape Verde">Cape Verde</option>
									<option value="Cayman Islands">Cayman Islands</option>
									<option value="Central African Republic">Central African Republic</option>
									<option value="Chad">Chad</option>
									<option value="Channel Islands">Channel Islands</option>
									<option value="Chile">Chile</option>
									<option value="China">China</option>
									<option value="Christmas Island">Christmas Island</option>
									<option value="Cocos Island">Cocos Island</option>
									<option value="Colombia">Colombia</option>
									<option value="Comoros">Comoros</option>
									<option value="Congo">Congo</option>
									<option value="Cook Islands">Cook Islands</option>
									<option value="Costa Rica">Costa Rica</option>
									<option value="Cote DIvoire">Cote D'Ivoire</option>
									<option value="Croatia">Croatia</option>
									<option value="Cuba">Cuba</option>
									<option value="Curaco">Curacao</option>
									<option value="Cyprus">Cyprus</option>
									<option value="Czech Republic">Czech Republic</option>
									<option value="Denmark">Denmark</option>
									<option value="Djibouti">Djibouti</option>
									<option value="Dominica">Dominica</option>
									<option value="Dominican Republic">Dominican Republic</option>
									<option value="East Timor">East Timor</option>
									<option value="Ecuador">Ecuador</option>
									<option value="Egypt">Egypt</option>
									<option value="El Salvador">El Salvador</option>
									<option value="Equatorial Guinea">Equatorial Guinea</option>
									<option value="Eritrea">Eritrea</option>
									<option value="Estonia">Estonia</option>
									<option value="Ethiopia">Ethiopia</option>
									<option value="Falkland Islands">Falkland Islands</option>
									<option value="Faroe Islands">Faroe Islands</option>
									<option value="Fiji">Fiji</option>
									<option value="Finland">Finland</option>
									<option value="France">France</option>
									<option value="French Guiana">French Guiana</option>
									<option value="French Polynesia">French Polynesia</option>
									<option value="French Southern Ter">French Southern Ter</option>
									<option value="Gabon">Gabon</option>
									<option value="Gambia">Gambia</option>
									<option value="Georgia">Georgia</option>
									<option value="Germany">Germany</option>
									<option value="Ghana">Ghana</option>
									<option value="Gibraltar">Gibraltar</option>
									<option value="Great Britain">Great Britain</option>
									<option value="Greece">Greece</option>
									<option value="Greenland">Greenland</option>
									<option value="Grenada">Grenada</option>
									<option value="Guadeloupe">Guadeloupe</option>
									<option value="Guam">Guam</option>
									<option value="Guatemala">Guatemala</option>
									<option value="Guinea">Guinea</option>
									<option value="Guyana">Guyana</option>
									<option value="Haiti">Haiti</option>
									<option value="Hawaii">Hawaii</option>
									<option value="Honduras">Honduras</option>
									<option value="Hong Kong">Hong Kong</option>
									<option value="Hungary">Hungary</option>
									<option value="Iceland">Iceland</option>
									<option value="India">India</option>
									<option value="Indonesia">Indonesia</option>
									<option value="Iran">Iran</option>
									<option value="Iraq">Iraq</option>
									<option value="Ireland">Ireland</option>
									<option value="Isle of Man">Isle of Man</option>
									<option value="Israel">Israel</option>
									<option value="Italy">Italy</option>
									<option value="Jamaica">Jamaica</option>
									<option value="Japan">Japan</option>
									<option value="Jordan">Jordan</option>
									<option value="Kazakhstan">Kazakhstan</option>
									<option value="Kenya">Kenya</option>
									<option value="Kiribati">Kiribati</option>
									<option value="Korea North">Korea North</option>
									<option value="Korea Sout">Korea South</option>
									<option value="Kuwait">Kuwait</option>
									<option value="Kyrgyzstan">Kyrgyzstan</option>
									<option value="Laos">Laos</option>
									<option value="Latvia">Latvia</option>
									<option value="Lebanon">Lebanon</option>
									<option value="Lesotho">Lesotho</option>
									<option value="Liberia">Liberia</option>
									<option value="Libya">Libya</option>
									<option value="Liechtenstein">Liechtenstein</option>
									<option value="Lithuania">Lithuania</option>
									<option value="Luxembourg">Luxembourg</option>
									<option value="Macau">Macau</option>
									<option value="Macedonia">Macedonia</option>
									<option value="Madagascar">Madagascar</option>
									<option value="Malaysia">Malaysia</option>
									<option value="Malawi">Malawi</option>
									<option value="Maldives">Maldives</option>
									<option value="Mali">Mali</option>
									<option value="Malta">Malta</option>
									<option value="Marshall Islands">Marshall Islands</option>
									<option value="Martinique">Martinique</option>
									<option value="Mauritania">Mauritania</option>
									<option value="Mauritius">Mauritius</option>
									<option value="Mayotte">Mayotte</option>
									<option value="Mexico">Mexico</option>
									<option value="Midway Islands">Midway Islands</option>
									<option value="Moldova">Moldova</option>
									<option value="Monaco">Monaco</option>
									<option value="Mongolia">Mongolia</option>
									<option value="Montserrat">Montserrat</option>
									<option value="Morocco">Morocco</option>
									<option value="Mozambique">Mozambique</option>
									<option value="Myanmar">Myanmar</option>
									<option value="Nambia">Nambia</option>
									<option value="Nauru">Nauru</option>
									<option value="Nepal">Nepal</option>
									<option value="Netherland Antilles">Netherland Antilles</option>
									<option value="Netherlands">Netherlands (Holland, Europe)</option>
									<option value="Nevis">Nevis</option>
									<option value="New Caledonia">New Caledonia</option>
									<option value="New Zealand">New Zealand</option>
									<option value="Nicaragua">Nicaragua</option>
									<option value="Niger">Niger</option>
									<option value="Nigeria">Nigeria</option>
									<option value="Niue">Niue</option>
									<option value="Norfolk Island">Norfolk Island</option>
									<option value="Norway">Norway</option>
									<option value="Oman">Oman</option>
									<option value="Pakistan">Pakistan</option>
									<option value="Palau Island">Palau Island</option>
									<option value="Palestine">Palestine</option>
									<option value="Panama">Panama</option>
									<option value="Papua New Guinea">Papua New Guinea</option>
									<option value="Paraguay">Paraguay</option>
									<option value="Peru">Peru</option>
									<option value="Phillipines">Philippines</option>
									<option value="Pitcairn Island">Pitcairn Island</option>
									<option value="Poland">Poland</option>
									<option value="Portugal">Portugal</option>
									<option value="Puerto Rico">Puerto Rico</option>
									<option value="Qatar">Qatar</option>
									<option value="Republic of Montenegro">Republic of Montenegro</option>
									<option value="Republic of Serbia">Republic of Serbia</option>
									<option value="Reunion">Reunion</option>
									<option value="Romania">Romania</option>
									<option value="Russia">Russia</option>
									<option value="Rwanda">Rwanda</option>
									<option value="St Barthelemy">St Barthelemy</option>
									<option value="St Eustatius">St Eustatius</option>
									<option value="St Helena">St Helena</option>
									<option value="St Kitts-Nevis">St Kitts-Nevis</option>
									<option value="St Lucia">St Lucia</option>
									<option value="St Maarten">St Maarten</option>
									<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
									<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
									<option value="Saipan">Saipan</option>
									<option value="Samoa">Samoa</option>
									<option value="Samoa American">Samoa American</option>
									<option value="San Marino">San Marino</option>
									<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
									<option value="Saudi Arabia">Saudi Arabia</option>
									<option value="Senegal">Senegal</option>
									<option value="Serbia">Serbia</option>
									<option value="Seychelles">Seychelles</option>
									<option value="Sierra Leone">Sierra Leone</option>
									<option value="Singapore">Singapore</option>
									<option value="Slovakia">Slovakia</option>
									<option value="Slovenia">Slovenia</option>
									<option value="Solomon Islands">Solomon Islands</option>
									<option value="Somalia">Somalia</option>
									<option value="South Africa">South Africa</option>
									<option value="Spain">Spain</option>
									<option value="Sri Lanka">Sri Lanka</option>
									<option value="Sudan">Sudan</option>
									<option value="Suriname">Suriname</option>
									<option value="Swaziland">Swaziland</option>
									<option value="Sweden">Sweden</option>
									<option value="Switzerland">Switzerland</option>
									<option value="Syria">Syria</option>
									<option value="Tahiti">Tahiti</option>
									<option value="Taiwan">Taiwan</option>
									<option value="Tajikistan">Tajikistan</option>
									<option value="Tanzania">Tanzania</option>
									<option value="Thailand">Thailand</option>
									<option value="Togo">Togo</option>
									<option value="Tokelau">Tokelau</option>
									<option value="Tonga">Tonga</option>
									<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
									<option value="Tunisia">Tunisia</option>
									<option value="Turkey">Turkey</option>
									<option value="Turkmenistan">Turkmenistan</option>
									<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
									<option value="Tuvalu">Tuvalu</option>
									<option value="Uganda">Uganda</option>
									<option value="Ukraine">Ukraine</option>
									<option value="United Arab Erimates">United Arab Emirates</option>
									<option value="United Kingdom">United Kingdom</option>
									<option value="United States of America">United States of America</option>
									<option value="Uraguay">Uruguay</option>
									<option value="Uzbekistan">Uzbekistan</option>
									<option value="Vanuatu">Vanuatu</option>
									<option value="Vatican City State">Vatican City State</option>
									<option value="Venezuela">Venezuela</option>
									<option value="Vietnam">Vietnam</option>
									<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
									<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
									<option value="Wake Island">Wake Island</option>
									<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
									<option value="Yemen">Yemen</option>
									<option value="Zaire">Zaire</option>
									<option value="Zambia">Zambia</option>
									<option value="Zimbabwe">Zimbabwe</option>
									</select>

              </div>
			   <!--div class="form-group"> 	
			    <label>Password</label>	
			   <input type="password" class="form-control" placeholder="Password"  name="reseller_admin_password" id="reseller_admin_password" value="" />
			   </div-->
              <div class="form-group btn-edit"> 
                    <div class="text-right"> 			  
			        <input type="submit" value="Edit" name="update" class="btn btn-success"/>
			        <button type="submit" class="btn btn-default nmr" data-dismiss="modal">Cancel</button>
			 </div>	
			 </div>	
        </form> 		   
        </div>
      </div>
    </div>
  </div>
  
  <!--Reseller -->
  
 <!----------------------------------->
   <div class="modal fade" id="renew_select" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 style="color:red;">Renewal Date</h4>
        </div>
        <div class="modal-body ">
     
     
        <form role="form" action="<?php echo base_url();?>home/renewalRecords" method="POST" id="renewal_form">
            <div class="form-group">
            
              <!--label for="usrname">Renewal Date</label-->
			       <input name="renew_company_from" id="renew_company_from" size="40" type="text"  class="form-control" value="" placeholder="Renewal Date From" />
     		  <input name="renew_company_to" id="renew_company_to" size="40" type="text"  class="form-control" value="" placeholder="Renewal Date To" />

            </div>
			 <div class="text-right"> 
                 <button type="button" class="btn  btn-success" id="getRenewalDate">Find</button>
             </div>
          </form>
        </div>
      </div>
    </div>
  </div>