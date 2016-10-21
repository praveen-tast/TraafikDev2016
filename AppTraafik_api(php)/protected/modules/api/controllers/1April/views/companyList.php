
<?php $this->load->view ('header');?>
<!--form end-->

<section class="form-section">
  <div class="container">
    <div class="row text-center">
     
     <table class="table table-hover">
		<thead>
			<tr>
			<th class="cmpny">
			  Company
			  
			  <form class="seach-cmpny" id="search_company" name="search_company" method="Post" action="<?php echo base_url();?>home/search">
			    <input class="form-control" placeholder="search" type="text" id="search_field" name="search_field">
			  	<input type="submit" class="btn btn-success" value="search" name="search" id="search">
				<!-- span id="search_button"><i class="fa fa-search"></i></span-->
			  </form>
			</th>
			
			<th>
			
			  <select>
			    <option>Reseller</option>
			   
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
			if($list){
				
				foreach ($list as $data)
				{
					?>
					
			<tr id="<?php echo 'row_'.$data->id;?>"  >
			<td id="<?php echo 'data_'.$data->id;?>" >
			
			<a href="<?php echo '.packageDetails'.$user_order->id;?>" id="<?php echo 'package_'.$user_order->id;?>" 
			class="accordion-toggle package_click" data-toggle="collapse" data-parent="#OrderPackages">
			
			<?php echo $user_order->company_name;?></a></td>
			<td onclick = "reseller('<?php echo $user_order->id?>')"><?php echo $user_order->reseller;?></td>
			<td class = "state_id" data-id="<?php echo $user_order->id;?>"><a href="#"><?php echo	$this->search->getStatusOptions($user_order->state_id);?></a></td>
			<td  class = "renew_id" id="<?php echo $user_order->id;?>" onclick = "displayDatepicker('<?php echo $user_order->id?>')">
						
			<?php echo date ("d-m-Y",strtotime($user_order->renewable_date));?></td>
			<td onclick =" location_event('<?php echo $user_order->id?>')"><?php echo $user_order->location;?></td>
			<td><?php echo $user_order->registered_office;?></td>
			<td><?php echo $user_order->director_service_address;?></td>
			<td><?php echo $user_order->business_address;?></td>
			<td><?php echo $user_order->telephone_service;?></td>
			
			<td>Buy</td>
			<!-- td>COMPANY</td-->
			<td>&pound;<?php echo $user_order->price;?></td>
			<td class="uploadId" data-id="<?php echo $user_order->id;?>" >
			<?php if($company->id_proof !=""){?>
			<a href="#">Received</a>
			<?php }else{?>
			<a href="#">Upload</a>
			<?php }?>
			</td>
					</tr>
					
					
				<?php }
				
				
			}?>
			
			
		
	
		</tbody>
	</table>
     
     
    
     </div>
     <div class="row">
      <div class="booking-form">

      </div>
    </div>
     </div>
  </section>

<!--form end-->
<?php $this->load->view ('footer');?>
  