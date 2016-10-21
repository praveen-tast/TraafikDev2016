<?php
session_start();
include("config.php");

$total = 0;
$data= urldecode($_POST['form_fields']);
$pieces = explode("&", $data);
for($a=0;$a<count($pieces);$a++)
{
$profile_key=strstr($pieces[$a],"=",true);
$profile[$profile_key] = substr(strstr($pieces[$a],"="),1);

}
	//Fields
$user_name=$profile['user_name']; 
$user_last_name=$profile['user_last_name'];
$user_email=$profile['user_email'];
$user_daytime_contact=$profile['user_daytime_contact'];
$user_contact=$profile['user_contact'];

$delivery_street=$profile['delivery_street'];
$delivery_city=$profile['delivery_city'];
$delivery_state=$profile['delivery_state'];
$delivery_zip=$profile['delivery_zip'];
$delivery_country=$profile['delivery_country'];

$billing_street = $profile['billing_street'];
$billing_city=$profile['billing_city'];
$billing_country_code=$profile['billing_country_code'];
$billing_zip=$profile['billing_zip'];
$billing_country=$profile['billing_country'];
/*
$card_name=$profile['card_name'];
$card_issue_number=$profile['card_issue_number'];
$card_issue_month=$profile['card_issue_month'];
$card_issue_year=$$profile['card_issue_year'];
$card_expiry_month=$profile['card_expiry_month'];
$card_expiry_year=$profile['card_expiry_year'];
$card_cvc=$profile['card_cvc'];*/

$company_name=$profile['company_name'];
$trading_name=$profile['trading_name'];
$director_name1=$profile['director_name1'];
$director_name2=$profile['director_name2'];
$director_name3=$profile['director_name3'];
$director_name4=$profile['director_name4'];
$find_us=$profile['find_us'];


$user_email_address = mysql_real_escape_string($profile ["user_email"]);
$user_password = mysql_real_escape_string(md5($profile ["user_pass"]));
$status = 1;//state_id

$radioGroup=$profile['radioGroup'];

$orders = $_SESSION ["cart_products"];
	$float_total = is_float($_SESSION ['grand_total'] );
	if($float_total === true)
	                       		$grand_total =  $_SESSION ['grand_total']; 
	                       		else
								$grand_total =  $_SESSION ['grand_total'].".00";


//$grand_total = $_SESSION ['grand_total'].".00";
$deposit = "0.00";

$register_service = "No";
$business_service = "No";
$director_service = "No";
$tele_service = "No";
$complete_service = "No";
$hosting = "No";

$va="";
if($radioGroup == "option1")
	$va= "SE1";
elseif($radioGroup == "option2") 
	$va= "WC1";
elseif($radioGroup == "option3") 
	$va= "EH1";
$current_time = date('Y-m-d h:i:s');

$extend_time = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($current_time)) . " + 1 year"));
/*=========================================================================================*/


if(! $connection )
{
	die('Could not connect: ' . mysql_error());
}
else
{

	mysql_select_db($database);
	$select = mysql_query("SELECT * FROM tbl_user WHERE (email='$user_email_address')", $connection) ;
	
	
	if(mysql_num_rows($select))
	{
		
		$value=mysql_fetch_assoc($select);
		if($value['password'] == $user_password )
		{
	
		//var_dump($value2['id'],$value2['email'],$value2['password']);die;
		$id  =$value["id"];
		$mailing_record = "INSERT INTO tbl_mailling_address".
				"(street,city,country,postcode,county,create_user_id,create_time) ".
				"VALUES "."('$delivery_street','$delivery_city','$delivery_state','$delivery_zip','$delivery_country',$id,'$current_time')";
		
	
		$billing_record = "INSERT INTO tbl_billing_address".
				"(street,city,country,postcode,county,create_user_id,create_time) ".
				"VALUES "."('$billing_street','$billing_city','$billing_country','$billing_zip','$delivery_country',$id,'$current_time')";
		
		
		//$mailing_save = mysql_query($mailing_record, $connection);
		
		if(mysql_query($mailing_record, $connection))
		{
			mysql_query($billing_record, $connection);
			//var_dump($billing_save);die;
			$mailing_search = mysql_query("SELECT * FROM tbl_mailling_address WHERE (create_user_id='$id' AND street='$delivery_street' AND city='$delivery_city' AND country='$delivery_state' AND create_time='$current_time')", $connection) ;
			//var_dump($mailing_search );die;
			if(mysql_num_rows($mailing_search))
			{
				
				$value_mailing = mysql_fetch_assoc($mailing_search);
				$billing_search = mysql_query("SELECT * FROM tbl_billing_address WHERE (create_user_id='$id' AND street='$billing_street' AND city='$billing_city' AND country='$billing_country' AND create_time='$current_time')", $connection) ;
			
				$value_billing_fetch = mysql_num_rows($billing_search);
				$value_billing = mysql_fetch_assoc($billing_search);
				$billing_id = $value_billing['id'];
				$mailing_id = $value_mailing['id'];
				if($billing_id)
				{
					
				$company_insert ="INSERT INTO tbl_company".
				"(company_name,trading,director1,director2,director3,director4,location,mailing_adress_id,billing_adress_id,create_user_id,create_time) ".
				"VALUES "."('$company_name','$trading_name','$director_name1','$director_name2','$director_name3','$director_name4','$va',$mailing_id,$billing_id,$id,'$current_time')";
				
				
			//	$company_save = mysql_query($company_insert, $connection);
				
				if(mysql_query($company_insert, $connection))
				{
					$company_search = mysql_query("SELECT * FROM tbl_company WHERE (company_name='$company_name')", $connection) ;
					$value_company = mysql_fetch_assoc($company_search);
				
					$company_id = $value_company['id'];
					foreach ( $orders as $cart_itm => $val ) {
						// set variables to use in content below
						$product_name = $val ["package_name"];
						$product_qty = $val ["product_qty"];
						$product_price = $val ["price"];
						$product_code = $val ["package_id"];
						$subtotal = ($product_price * $product_qty); // calculate Price x Qty
						
						if($product_name == "Registered Office")
							$register_service = "Yes";
							
						if($product_name == "Director Service Address")
							$director_service = "Yes";
							
						if($product_name == "Business Address")
							$business_service = "Yes";
							
						if($product_name == "Telephone Service")
							$tele_service = "Yes";
							
						if($product_name == "Business Plus")
						{
							$register_service = "Yes";
							$director_service = "Yes";
							$business_service = "Yes";
							$tele_service = "Yes";
							$hosting = "Yes";
							}
							
							
							
							if($product_name == 'Business Address' || $product_name == 'Complete Package' || $product_name == 'Business Plus' )
							$deposit = "20.00";
					
					}
					
					$order_summary_insert =  "INSERT INTO tbl_order".
							"(company_id,registered_office,director_service_address,business_address,telephone_service,complete_package,hosting,deposit,reseller_id,price,quantity,location,state_id,create_time,renewable_date,create_user_id) ".
							"VALUES "."($company_id,'$register_service','$director_service','$business_service','$tele_service','$complete_service','$hosting','$deposit','1','$grand_total','$product_qty','$va',3,'$current_time','$extend_time',$id)";
					
					if(mysql_query($order_summary_insert, $connection))
							{
								
								
								$order_summary_search = mysql_query("SELECT * FROM tbl_order WHERE (create_time='$current_time')", $connection) ;
								$value_order_summary = mysql_fetch_assoc($order_summary_search);
								$order_summary_id = $value_order_summary['id'];
							
								foreach ( $orders as $cart_itm => $val ) {
									// set variables to use in content below
									$product_name = $val ["package_name"];
									$product_qty = $val ["product_qty"];
									$product_price = $val ["price"];
									$product_code = $val ["package_id"];
									$subtotal = ($product_price * $product_qty); // calculate Price x Qty
									
								
									$order_insert =  "INSERT INTO tbl_order_detail".
											"(order_summery_id,product,price,quantity,total,create_time,create_user_id) ".
											"VALUES "."($order_summary_id,'$product_name','$product_price','$product_qty','$subtotal','$current_time',$id)";
										
									if(mysql_query($order_insert, $connection))
									{
									echo "done";
									}
									else{
									var_dump(mysql_error());
									}
									
								}
								
							
								
								
								
								
							}
							else{
									var_dump(mysql_error());
									}

			
					
				
				}
				else{
									var_dump(mysql_error());
									}
				
			}
				
				
			}
		}
		
		else 
		{
			var_dump(mysql_error());
		exit;
			
		}
	
	}
		else 
		{
			echo "1";
		exit;
			
		}
		
		//exit("This email is already being used");
		
		
		
		
		
		
	}
	else{
		$query = "INSERT INTO tbl_user".
				"(first_name,last_name,email, password,state_id,ph_no,mobile,create_time) ".
				"VALUES "."('$user_name','$user_last_name','$user_email_address','$user_password',$status,'$user_daytime_contact','$user_contact','$current_time')";



		//$result = mysql_query($query, $connection);
	
		if(mysql_query($query, $connection)){
				//mysql_select_db($database);
	$select2 = mysql_query("SELECT * FROM tbl_user WHERE (email='$user_email_address' and password='".$user_password."')", $connection) ;
	
	if(mysql_num_rows($select2))
	{
		$value2=mysql_fetch_assoc($select2);
	
		//var_dump($value2['id'],$value2['email'],$value2['password']);die;
		$id  =$value2["id"];
	$mailing_record = "INSERT INTO tbl_mailling_address".
			"(street,city,country,postcode,county,create_user_id,create_time) ".
			"VALUES "."('$delivery_street','$delivery_city','$delivery_state','$delivery_zip','$delivery_country',$id,'$current_time')";
		
	
		$billing_record = "INSERT INTO tbl_billing_address".
				"(street,city,country,postcode,county,create_user_id,create_time) ".
				"VALUES "."('$billing_street','$billing_city','$billing_country','$billing_zip','$delivery_country',$id,'$current_time')";
		
		//$mailing_save = mysql_query($mailing_record, $connection);
		
		if(mysql_query($mailing_record, $connection))
		{
			mysql_query($billing_record, $connection);
			//var_dump($billing_save);die;
			$mailing_search = mysql_query("SELECT * FROM tbl_mailling_address WHERE (create_user_id='$id' AND street='$delivery_street' AND city='$delivery_city' AND country='$delivery_state' AND create_time='$current_time')", $connection) ;
		
			if(mysql_num_rows($mailing_search))
			{
				
				$value_mailing = mysql_fetch_assoc($mailing_search);
				$billing_search = mysql_query("SELECT * FROM tbl_billing_address WHERE (create_user_id='$id' AND street='$billing_street' AND city='$billing_city' AND country='$billing_country' AND create_time='$current_time')", $connection) ;
			
				
				$value_billing_fetch = mysql_num_rows($billing_search);
				$value_billing = mysql_fetch_assoc($billing_search);
				$billing_id = $value_billing['id'];
				$mailing_id = $value_mailing['id'];
				if($billing_id)
				{
					
				$company_insert ="INSERT INTO tbl_company".
				"(company_name,trading,director1,director2,director3,director4,location,mailing_adress_id,billing_adress_id,create_user_id,create_time) ".
				"VALUES "."('$company_name','$trading_name','$director_name1','$director_name2','$director_name3','$director_name4','$va',$mailing_id,$billing_id,$id,'$current_time')";
				
				
			//	$company_save = mysql_query($company_insert, $connection);
				
				if(mysql_query($company_insert, $connection))
				{
					$company_search = mysql_query("SELECT * FROM tbl_company WHERE (company_name='$company_name')", $connection) ;
					$value_company = mysql_fetch_assoc($company_search);
				
					$company_id = $value_company['id'];
					foreach ( $orders as $cart_itm => $val ) {
						// set variables to use in content below
						$product_name = $val ["package_name"];
						$product_qty = $val ["product_qty"];
						$product_price = $val ["price"];
						$product_code = $val ["package_id"];
						$subtotal = ($product_price * $product_qty); // calculate Price x Qty
						
						if($product_name == "Registered Office")
							$register_service = "Yes";
							
						if($product_name == "Director Service Address")
							$director_service = "Yes";
							
						if($product_name == "Business Address")
							$business_service = "Yes";
							
						if($product_name == "Telephone Service")
							$tele_service = "Yes";
							
						if($product_name == "Business Plus")
							{
								$register_service = "Yes";
								$director_service = "Yes";
								$business_service = "Yes";
								$tele_service = "Yes";
								$hosting = "Yes";
								//$complete_service = "Yes";
							}
					
							if($product_name == 'Business Address' || $product_name == 'Complete Package' || $product_name == 'Business Plus' )
							$deposit = "20.00";
					}
					
					$order_summary_insert =  "INSERT INTO tbl_order".
							"(company_id,registered_office,director_service_address,business_address,telephone_service,complete_package,hosting,deposit,reseller_id,price,quantity,location,state_id,create_time,renewable_date,create_user_id) ".
							"VALUES "."($company_id,'$register_service','$director_service','$business_service','$tele_service','$complete_service','$hosting','$deposit','1','$grand_total','$product_qty','$va',3,'$current_time','$extend_time',$id)";
					
					if(mysql_query($order_summary_insert, $connection))
							{
								
								
								$order_summary_search = mysql_query("SELECT * FROM tbl_order WHERE (create_time='$current_time')", $connection) ;
								$value_order_summary = mysql_fetch_assoc($order_summary_search);
								$order_summary_id = $value_order_summary['id'];
							
								foreach ( $orders as $cart_itm => $val ) {
									// set variables to use in content below
									$product_name = $val ["package_name"];
									$product_qty = $val ["product_qty"];
									$product_price = $val ["price"];
									$product_code = $val ["package_id"];
									$subtotal = ($product_price * $product_qty); // calculate Price x Qty
									
								
									$order_insert =  "INSERT INTO tbl_order_detail".
											"(order_summery_id,product,price,quantity,total,create_time,create_user_id) ".
											"VALUES "."($order_summary_id,'$product_name','$product_price','$product_qty','$subtotal','$current_time',$id)";
										
									mysql_query($order_insert, $connection);
									
								}
								
							
								
								
								
								
							}

			
					
				
				}
				
			}
				
				
			}
		}
		
		
	
	}
			//echo "2";
			//header('Location:http://theregisteredoffice.com/admin/');
				
		}
		else
		{
			echo "3";
		}
	}
}



/*=========================================================================================*/

// multiple recipients
//$to  = "aditi.tuffgeekers@gmail.com,.$user_email.";
$to="order@theregisteredoffice.com,nicheformations121@gmail.com,mail@theregisteredoffice.com,aditi.tuffgeekers@gmail.com";
// mail@theregisteredoffice.com,nicheformations121@gmail.com
// subject
$subject = "The Registered Office > Order >" .$company_name;


// message
$message = '
<html>
<head>
   <title>The Registered Office</title> 
</head>
<body> 
	
	 <h2>Customer Service Order Details</h2>
	 <h3>Ordered Details</h3>
	 <table class="table table-cart">
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>';
/*===================================Orders=========================================*/

// set initial total value
foreach ( $orders as $cart_itm => $val ) {	
	// set variables to use in content below
	$product_name = $val ["package_name"];
	$product_qty = $val ["product_qty"];
	$product_price = $val ["price"];
	$product_code = $val ["package_id"];
				if($product_name == 'Director Service Address')			
			{
					$product_price = $val ["price"];
					$subtotal = ($product_price * $product_qty);
			}
			else
			{ 
				$product_price = $val ["price"].'.00';
				$subtotal = ($product_price * $product_qty).'.00';
			}
	
	$subtotal = ($product_price * $product_qty); // calculate Price x Qty
	$message .= '<tr>';
	$message .= '<td>' . $product_name . '</td>';
	$message .= '<td>&pound; ' . $product_price . '.00</td>';
	$message .= '<td><input type="text" size="2" maxlength="2" name="product_qty[' . $product_code . ']" value="' . $product_qty . '"  disabled/></td>';
	$message .= '<td>&pound; ' . $subtotal . '.00</td>';
	$message .= '</tr>';
}
$message .= '</tbody></table>';

/*======================================Orders======================================*/

	 $message .='<h3>Your Details</h3>
  <table>
		<tr>
			<td>Name:</td>
			<td>'.$user_name.'</td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td>'.$user_last_name.'</td>
		</tr>';
	
		$message .= '<tr>
			<td>Email:</td>
			<td>'.$user_email.'</td>
		</tr>';
		
		
		$message .='
		<tr>
			<td>Daytime Phone Number:</td>
			<td>'.$user_daytime_contact.'</td>
		</tr>
		<tr>
			<td>Mobile Number:</td>
			<td>'.$user_contact.'</td>
		</tr>
		
		
	</table>
		<h3>Mailing Address</h3>
	<table>
		<tr>
			<td>Street Address:</td>
			<td>'.$delivery_street.'</td>
		</tr>
		<tr>
			<td>Town/City:</td>
			<td>'.$delivery_city.'</td>
		</tr>
		<tr>
			<td>County/State :</td>
			<td>'.$delivery_state.'</td>
		</tr>
		<tr>
			<td>Postcode:</td>
			<td>'.$delivery_zip.'</td>
		</tr>
		<tr>
			<td>Country:</td>
			<td>'.$delivery_country.'</td>
		</tr>';		
		
	$message .='</table>
		<h3>Billing Address</h3>
	<table>
		<tr>
			<td>Street Address:</td>
			<td>'.$billing_street.'</td>
		</tr>
		<tr>
			<td>Town/City:</td>
			<td>'.$billing_city.'</td>
		</tr>
		<tr>
			<td>County/State :</td>
			<td>'.$billing_country_code.'</td>
		</tr>
		<tr>
			<td>Postcode:</td>
			<td>'.$billing_zip.'</td>
		</tr>
		<tr>
			<td>Country:</td>
			<td>'.$billing_country.'</td>
		</tr>
	</table>';
	

		
		
	
	
	//Power of Attorney
	
	$message .= '<h3>Company Information</h3>
	
  <table>
		<tr>
			<td>Company Name:</td>
			<td>'.$company_name.'</td>
		</tr>';
	if($trading_name!='')
	{	
		$message .= '<tr>
			<td>Trading Name:</td>
			<td>'.$trading_name.'</td>
		</tr>';
}
	if($director_name1!='')
	{
	$message .= '<tr>
			<td>Director Name 1:</td>
			<td>'.$director_name1.'</td>
		</tr>';
}
		if($director_name2!='')
		{
		$message .= '<tr>
			<td>Director Name 2:</td>
			<td>'.$director_name2.'</td>
		</tr>';
		}
		if($director_name3!='')
		{
			$message .= '<tr>
			<td>Director Name 3:</td>
			<td>'.$director_name3.'</td>
		</tr>';
		}
		if($director_name3!='')
		{
			$message .= '<tr>
			<td>Director Name 4:</td>
			<td>'.$director_name4.'</td>
		</tr>';
		}
		
		$message .="
				<tr>
				<td>
Location Required
				:</td>
				<td>";
		if($radioGroup == "option1")
		{
			
			$message .= 'West End Office,
						Bloomsbury Way,
						London,
						WC1 2SE';
			
		}
		else 
		{
			$message .= 'Tower Bridge Office,
			St Saviours Wharf,
			Mill Street,
			London,
			SE1 2BE';
		}
		$message .="<td>
				</tr>
				</table>
				</body>
</html>";


	   
	   $header = 'From: The Registered Office <mail@theregisteredoffice.com>' . "\r\n";      
       $header .= 'MIME-Version: 1.0' . "\r\n";
     //  $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 	$header   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
       mail($to, $subject, $message,$header);
       //header('Location:signup.php');
       // TODO: Store the order code somewhere..
   
       
   /*=====================================================================================*/
             
       $new_msg = '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-family:Roboto; width:100%;background:#f1f0ec;">
    <tbody><tr>
        <td>
            <table cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody><tr>
                    <td width="20" bgcolor="#f2f2f2"></td>
                    <td width="560" valign="top" bgcolor="#f2f2f2" align="center">
                        <p>
                            <font size="2">
                                                            </font>
                        </p>
                    </td>
                    <td width="20" bgcolor="#f2f2f2"></td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="13" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" valign="top" bgcolor="#ffffff">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tbody><tr>
                                <td width="100%" valign="top" align="center"><a target="_blank" style="display:block;width:220px;min-height:57px;border:none" href="http://theregisteredoffice.com/"><font size="6">
								<img width="220" height="57" title="theRegister" alt="theRegister" src="http://theregisteredoffice.com/beta_new/img/logo.png" style="display:block" class="CToWUd"></font></a></td>
                                <td width="120"></td>                           
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="20" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#5BBC2F"></td>
                    <td width="560" height="3" bgcolor="#5BBC2F"></td>
                    <td width="20" bgcolor="#5BBC2F"></td>
                </tr>
				     <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="20" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#5BBC2F"></td>
                    <td width="560" height="3" bgcolor="#5BBC2F"></td>
                    <td width="20" bgcolor="#5BBC2F"></td>
                </tr>
            </tbody></table>
            <table cellspacing="0" cellpadding="0" border="0" align="center">
                <tbody><tr>
                    <td width="20" bgcolor="#5BBC2F"></td>
                    <td width="560" height="3" bgcolor="#5BBC2F"></td>
                    <td width="20" bgcolor="#5BBC2F"></td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="20" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
                <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" valign="top" bgcolor="#ffffff">
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tbody><tr>
                                <td width="20"></td>
                                <td width="520" valign="top">
                                    <table cellspacing="0" cellpadding="0" border="0">
                                        <tbody><tr>
                                            <td width="260" valign="top" align="left">
                                                <p>
                                                    <font size="4">
                                                       
                                                            <span>Hi</span> '.$user_name.' ('.$company_name.'),
                                                       
                                                    </font>
                                                            		
                                                </p>
                                            </td>
                                          
                                        </tr>
                                    </tbody></table>
     <p>  Thank you for your order.</p>

 <p>Please use the address details below as selected when placing your order.</p>

 <p>To Login to your client admin click here.</p>

 <p>Should you need any further information please do not hesitate to call or email us.</p>

 <p>Regards,</p>

 <p>The Registered Office Team </p>'; 
	$new_msg .='</table>
	
	
		    <table cellspacing="0" cellpadding="0" border="0" align="center"  width="560">
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			<tr>
			<td bgcolor="#5BBC2F" width="100%" valign="" height="30" >
  <b>&nbsp;&nbsp;&nbsp;<font color="#ffffff">Tower Bridge Office</font></b>
			</td>
			</tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			
			</table>
	<table>
		<tr>
			<td>Address 1:</td>
			<td>Unit 1 St Saviours Wharf</td>
		</tr>
		<tr>
			<td>Address 2:</td>
			<td>23 Mill Street</td>
		</tr>
		<tr>
			<td>Town/City:</td>
			<td>London</td>
		</tr>
		<tr>
			<td>County:</td>
			<td>London</td>
		</tr>
		<tr>
			<td>Postcode:</td>
			<td>SE1 2BE</td>
		</tr>
		<tr>
			<td>Country:</td>
			<td>United Kingdom</td>
		</tr>
	</table>
	
	
	
	
		    <table cellspacing="0" cellpadding="0" border="0" align="center"  width="560">
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			<tr>
			<td bgcolor="#5BBC2F" width="100%" valign="" height="30" >
  <b>&nbsp;&nbsp;&nbsp;<font color="#ffffff">West End Office</font></b>
			</td>
			</tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			
			</table>
	<table>
		<tr>
			<td>Address 1:</td>
			<td>40 Bloomsbury Way</td>
		</tr>
		<tr>
			<td>Address 2:</td>
			<td>Lower Ground Floor</td>
		</tr>
		<tr>
			<td>Town/City:</td>
			<td>London</td>
		</tr>
		<tr>
			<td>County:</td>
			<td>London</td>
		</tr>
		<tr>
			<td>Postcode:</td>
			<td>WC1A 2SE</td>
		</tr>
		<tr>
			<td>Country:</td>
			<td>United Kingdom</td>
		</tr>
	</table>
	
	
	
	
	
	
		    <table cellspacing="0" cellpadding="0" border="0" align="center"  width="560">
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			<tr>
			<td bgcolor="#5BBC2F" width="100%" valign="" height="30" >
  <b>&nbsp;&nbsp;&nbsp;<font color="#ffffff">Edinburgh Office</font></b>
			</td>
			</tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			
			</table>
	<table>
		<tr>
			<td>Address 1:</td>
			<td>3 Tweeddale Court</td>
		</tr>
		<tr>
			<td>Town/City:</td>
			<td>Old Town Edinburgh</td>
		</tr>
		<tr>
			<td>County:</td>
			<td>Edinburgh</td>
		</tr>
	
		<tr>
			<td>Postcode:</td>
			<td>EH1 1TE</td>
		</tr>
		<tr>
			<td>Country:</td>
			<td>United Kingdom</td>
		</tr>
	</table>';
     $new_msg .= '
     	  <table cellspacing="0" cellpadding="0" border="0" align="center"  width="560">
     		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
     		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			<tr>
     		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
		<td bgcolor="#5BBC2F" width="100%" valign="" height="30" >
  <b>&nbsp;&nbsp;&nbsp;<font color="#ffffff">Order Details</font></b>
			</td>
			</tr>
     		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
     		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
     		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
			</table>
     		  <table cellspacing="0" cellpadding="0" border="0" align="left" class="table table-cart" width="100%">

									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>';
       
                                                            		
       foreach ( $orders as $cart_itm => $val ) {
       	// set variables to use in content below
       	$product_name = $val ["package_name"];
       	$product_qty = $val ["product_qty"];
       	$product_price = $val ["price"];
       	$product_code = $val ["package_id"];
		
				if($product_name == 'Director Service Address')			
			{
					$product_price = $val ["price"];
					$subtotal = ($product_price * $product_qty);
			}
			else
			{ 
				$product_price = $val ["price"].'.00';
				$subtotal = ($product_price * $product_qty).'.00';
			}
		
		
     //  	$subtotal = ($product_price * $product_qty); // calculate Price x Qty
       	$new_msg .= '<tr>';
       	$new_msg .= '<td align="left">' . $product_name . '</td>';
       	$new_msg .= '<td align="left">&pound; ' . $product_price . '</td>';
       	$new_msg .= '<td align="left"><input type="text" size="2" maxlength="2" name="product_qty[' . $product_code . ']" value="' . $product_qty . '" disabled/></td>';
       	$new_msg .= '<td align="left">&pound; ' . $subtotal . '</td>';
       	$new_msg .= '</tr>';
       }                     		
                                                            		
                                                            		
                                                            		
                                                            		
       
    $new_msg .=' </tbody></table><table cellspacing="0" cellpadding="0" border="0">
	 <tbody>
	 <tr>
       
	      <td>
                                              
                                            </td>
       
	 </tr>
	 </tbody>
         </table>
                                </td>
                            </tr>
    		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
    		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
    		 <tr>
                    <td width="20" bgcolor="#ffffff"></td>
                    <td width="560" height="10" bgcolor="#ffffff"></td>
                    <td width="20" bgcolor="#ffffff"></td>
                </tr>
                        </tbody></table>
       
       
         <table cellspacing="0" cellpadding="0" border="0" align="center"  width="560">
			<tr>
			<td width="560"  bgcolor="#5BBC2F" height="20">
		<center><font color="#ffffff">© 2015 The Registered Office(a trading name of Registered Office (UK) Limited).</font></center>
			</td>
			</tr>
			</table>
       
       
       
                    </td>
       
                </tr>
            </tbody></table>
       
        </td>
    </tr>
</tbody></table>';
        
       $header = 'From: The Registered Office <mail@theregisteredoffice.com>' . "\r\n";
       $header .= 'MIME-Version: 1.0' . "\r\n";
     //  $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 	$header   .= "Content-type:text/html;charset=UTF-8" . "\r\n";
       mail($user_email, $subject, $new_msg,$header);
	    mail('aditi.tuffgeekers@gmail.com', $subject, $new_msg,$header);
     //  header('Location:signup.php');
       /*====================================================================*/
           
       
       
       
       
       


?>