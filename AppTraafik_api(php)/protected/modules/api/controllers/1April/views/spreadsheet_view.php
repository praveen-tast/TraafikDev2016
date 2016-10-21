<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=exceldata.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border='1'>
  <tr>
    <td>Company Name</td>
    <td>Reseller</td>   
    <td>Status</td>
	 <td>Renewal Date</td>
	<td>Location</td>
	<td>Registered</td>
	<td>Director</td>
	<td>Business</td>
	<td>Telephone</td>
	<td>Hosting</td>
	<td>Deposit</td>
	<td>Amount</td>
	<td>ID</td>
	<td>Billing Name</td>
	<td>Street Address</td>
	<td>Town/City</td>
	<td>County/Region</td>
	<td>Postcode</td>
	<td>Country</td>
	<td>First Name</td>
	<td>Last Name</td>
	<td>Street Address</td>
	<td>Town/City</td>
	<td>County/Region</td>
	<td>Postcode</td>
	<td>Country</td>
	<td>Email</td>
	<td>Daytime Phone</td>
	<td>Mobile Number</td>
	<td>Skype Address</td>
	<td>Password</td>
  </tr>
  <?php 
			if($user_orders){
				
				foreach ($user_orders as $user_order)
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
		<tr>
			
			<td><?php echo $user_order->company_name;?></td>
			<td><?php echo $user_order->reseller;?></td>	
			<td><?php echo	$this->search->getStatusOptions($user_order->state_id);?>	</td>
			<td><?php echo date ("d/m/Y",strtotime($user_order->renewable_date));?>	</td>
			<td><?php echo $user_order->location;?></td>
			<td><?php echo $user_order->registered_office;?></td>
			<td><?php echo $user_order->director_service_address;?></td>
			<td><?php echo $user_order->business_address;?></td>
			<td><?php echo $user_order->telephone_service;?></td>
			<td><?php echo $user_order->hosting;?></td>
			<td>&pound;<?php 			
			$dot = strstr($user_order->deposit, '.');
			if($dot)
				echo $user_order->deposit;
			else
				echo $user_order->deposit.'.00';?>
				</td>
			
			<td>&pound;<?php 
			$total_price = $this->order->orderPrice($user_order->id);
			//var_dump($total_price);die;
			$dot = strstr($total_price, '.');
			if($dot)
				echo $total_price;
			else
				echo $total_price.'.00';
			?></td>
			<td>
			<?php 
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
				echo "yes";
			}
				
			else
			{
				echo "no";
			}
		
			?>
			</td>
			
			
			<td><?php echo $billing->billing_name;?></td>
			<td><?php echo $billing->street;?></td>
			<td><?php echo $billing->city;?></td>
			<td><?php echo $billing->county;?></td>
			<td><?php echo $billing->postcode;?></td>
			<td><?php echo $billing->country;?></td>
			
			
			<td><?php echo $update_company_user->first_name;?></td>
			<td><?php echo $update_company_user->last_name;?></td>
			<td><?php echo $mailling->street;?></td>
			<td><?php echo $mailling->city;?></td>
			<td><?php echo $mailling->county;?></td>
			<td><?php echo $mailling->postcode;?></td>
			
			
			<td><?php echo $mailling->country;?></td>
			<td><?php echo $update_company_user->email;?></td>
			<td><?php echo $update_company_user->ph_no;?></td>
			<td><?php echo $update_company_user->mobile;?></td>
			<td><?php echo $update_company_user->skpe_address;?></td>
			<td></td>
					
			
			</tr>
  
  
  
  			
				<?php }
				
				
			}?>
</table>
