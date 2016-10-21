<?php
Class Order extends CI_Model
{

 
 function getOrders($package_name,$field_id = null)
 {
	//var_dump($package_name);die;
	$value = "";
 	if($package_name === "Business Address".$field_id)
		$value = "business_address";
	elseif($package_name === "Complete Package".$field_id)
		$value = "complete_package";
	elseif($package_name === "Website Hosting".$field_id)
		$value = "hosting";
	elseif($package_name === "Director Service Address".$field_id)
		$value = "director_service_address";
	elseif($package_name === "Registered Office Address")
		$value = "registered_office";
	elseif($package_name === "Registered Office and Director Address".$field_id)
		$value = "both";
	elseif($package_name === "Postal Deposit".$field_id)
		$value = "deposit";
	elseif($package_name === "Partner Package".$field_id)
		$value = "partner";
	elseif($package_name === "Telephone Address".$field_id)
		$value = "telephone_service";

	//var_dump($value);die;Registered_Director_Service
		
	return $value;
 }
 function orderPrice($id)
 {
	$totalPrice = 0;
		$this->db->select ( '*,tbl_order_detail.price' );
		$this->db->from ( 'tbl_order_detail' );
		$this->db->where ( "tbl_order_detail.order_summery_id", $id);
		
		$query = $this->db->get ();
		$user_orders = $query->result ();
		foreach($user_orders as $user_order)
		{
			$totalPrice += $user_order->price;
		}
		//var_dump($totalPrice);die;
	return number_format($totalPrice, 2);//$totalPrice;
 
 }
}