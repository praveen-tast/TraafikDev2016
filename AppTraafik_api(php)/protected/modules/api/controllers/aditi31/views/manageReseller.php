
<?php $this->load->view ('header');?>
<!--form end-->

<section class="form-section">
  <div class="container-fluid">
     <div class="row">
      <div class="booking-form">
  
	   
	   
	   
	   <table class="table manage-reseller">
	     <thead>
		   <tr>
		     <th>Reseller Name</th>
			 <th>Logo</th>
			 <th>Clients</th>
		     <th>Contact Name</th>
		     <th>Phone Number</th>
		     <th>Email Alerts</th>
		     <th>Country</th>	
			<th>Email Address (Admin)</th>				 
		     <th>Edit</th>
			 <th>Delete</th>
		  </tr>
		 </thead>
		 
		 <tbody>
		     <?php foreach($resellers as $reseller)
		{
			$count = $this->search->countResellerCompanies($reseller->id);	
				
		?>
		
		   <tr>
		 
			  <td><a href="#"><?php echo $reseller->company_name;?> </a></td>
			  <td><a href="#"><?php echo $reseller->logo_text;?></a></td>
			  <td><a href="#"><?php echo $count;?></a></td>
			  <td><a href="#"><?php echo $reseller->contact_name;?></a></td>
			  <td><a href="#"><?php echo $reseller->phone_number;?></a></td>
			  <td><a href="#"><?php echo $reseller->mail_email;?></a></td>
			  <td><a href="#"><?php echo $reseller->country;?></a></td>
			  <td><a href="#"><?php echo $reseller->admin_email;?></a></td>
		
			  <td><a href="#" onClick="ResellerUpdate('<?php echo $reseller->id;?>','<?php echo $reseller->company_name;?>','<?php echo $reseller->contact_name;?>','<?php echo $reseller->phone_number;?>','<?php echo $reseller->mail_email;?>','<?php echo $reseller->country;?>','<?php echo $reseller->address1;?>','<?php echo $reseller->address2;?>','<?php echo $reseller->web_address;?>','<?php echo $reseller->town;?>','<?php echo $reseller->region;?>','<?php echo $reseller->post_code;?>','<?php echo $reseller->admin_email;?>','<?php echo $reseller->logo_text;?>','<?php echo $reseller->county;?>')">Edit </a></td>
			<td onClick="deleteRecord('<?php echo $reseller->id;?>','reseller')"><a href="#">Delete</a></td>
			</tr>
		
		   	   
<?php }?>
		 </tbody>
	</table>	 
	   </div>
	   
	   
	   
	   

        
				
      </div>
    </div>
     </div>
  </section>
	<?php $this->load->view ('footer');?>
  
