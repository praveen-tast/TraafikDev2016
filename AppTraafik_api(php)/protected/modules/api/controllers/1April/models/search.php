<?php
Class Search extends CI_Model
{
 function filterSearch($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_company');
 	$this -> db -> where('tbl_company.id',$id);
 	
 	$query = $this -> db -> get();
 	$user_company=  $query->row();
 	$data['user_company'] = $user_company;
 	return $user_company;
   
 }
 
 function userSearch($id)
 {

 	$this -> db -> select('*,tbl_user.id as id');
 	$this -> db -> from('tbl_user');
 	$this -> db -> where('tbl_user.id',$id);
 
 	$query = $this -> db -> get();
 	$user_details=  $query->row();
 	$data['user_details'] = $user_details;
 	return $user_details;
 	 
 }
 
 function billing($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_billing_address');
 	$this -> db -> where('tbl_billing_address.id',$id);
 
 	$query = $this -> db -> get();
 	$billing_details=  $query->row();
 	$data['billing_details'] = $billing_details;
 	return $billing_details;
 		
 }
 function mailling($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_mailling_address');
 	$this -> db -> where('tbl_mailling_address.id',$id);
 
 	$query = $this -> db -> get();
 	$mailling_details=  $query->row();
 	$data['mailling_details'] = $mailling_details;
 	return $mailling_details;
 		
 }
 
 function orders($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_order');
 	$this -> db -> where('tbl_order.company_id',$id);
 
 	$query = $this -> db -> get();
 	$order=  $query->row();
 	$data['order'] = $order;
 	return $order;
 		
 }
 function orderDetails($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_order_detail');
 	$this -> db -> where('tbl_order_detail.order_summery_id',$id);
 
 	$query = $this -> db -> get();
 	$order=  $query->result();
 	$data['order'] = $order;
 	return $order;
 		
 }

 function getUploadOptions($id = null)
 {
 
		$list = array("Upload","Received");
	if ($id == null )	
		return $list;
	else
		return $list [ $id ];
 }
 
 
 function fileInfo($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_file_info');
 	$this -> db -> where('tbl_file_info.company_id',$id);
 	$this->db->order_by("tbl_file_info.id", "desc");
 
 	$query = $this -> db -> get();
 	$files_company=  $query->result();
 	$data['files'] = $files_company;
 	return $files_company;
 	 
 }
 
 function getTypeOptions($id = null)
 {
 	$list = array("HMRC","Companies House","Business Mail","Other");
 	if ($id == null )	return $list;
 
 	if ( is_numeric( $id )) return $list [ $id ];
 	return $id;
 }
 function Message($id)
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_message');
 	$this -> db -> where('tbl_message.order_id',$id);
 	$this->db->order_by("tbl_message.id", "desc");
 
 	$query = $this -> db -> get();
 	$message_company=  $query->result();
 	$data['files'] = $message_company;
 	return $message_company;
 		
 }
function resellers()
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this->db->where ( 'tbl_reseller.state_id !=1');
 	$this->db->order_by ( "tbl_reseller.company_name", "asc" );
	
 	$query = $this -> db -> get();
 	$resellers=  $query->result();
 	$data['resellers'] = $resellers;
 	return $resellers;
 	 
 }
  function getServiceOptions()
 {
 	$list = array("Show All","Yes","No"); 
		return $list;
 }
 function getLocationOptions()
 {
 
 	$list = array("Show All","SE1","WC1","EH1");
 	return $list;
 }
  function alterEmails($id)
 {

    	$this -> db -> select('*');
		$this -> db -> from('tbl_alt_email');
		$this -> db -> where('tbl_alt_email.company_id',$id);
		$query = $this -> db -> get();
		$emails=  $query->row();
		$data['emails'] = $emails;
 	return $emails;
 }
 function docTypeOptions($id = null)
 {
 	$list = array("4"=>"Identification","5"=>"Proof of Address","6"=>"Invoice","7"=>"Terms and Conditions","8"=>"Other");
 	if ($id == null )	return $list;
 
 	if ( is_numeric( $id )) return $list [ $id ];
 	return $id;
 }
 function resellerUser( $id)
 {
 //var_dump($id);
	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this -> db -> where('tbl_reseller.user_id',$id);
 
 	$query = $this -> db -> get();
 	$resellers =  $query->result();
	//var_dump($resellers);die;
 	$data['resellers'] = $resellers;
 	return $resellers;
 }
  function getCompany( $id)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_company');
	$this -> db -> where('tbl_company.id',$id);
 
 	$query = $this -> db -> get();
 	$company=  $query->row();
 	$data['company'] = $company;
 	return $company;
 }
   function resellerEmail( $email)
 {
 //var_dump($email);die;
	$this -> db -> select('*');
 	$this -> db -> from('tbl_user');
	$this -> db -> where('tbl_user.email',$email);
	
 
 	$query = $this -> db -> get();
 	$user =  $query->row();
 	$data['user'] = $user;
 	return $user;
 } 
    function userEmail( $email)
 {
 //var_dump($email);die;
	$this -> db -> select('*');
 	$this -> db -> from('tbl_user');
	$this -> db -> where('tbl_user.email',$email);	
 	$query = $this -> db -> get();
 	$user =  $query->row();
 	$data['user'] = $user;
 	return $user;
 } 
	function resellerByEmail( $email)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this -> db -> where('tbl_reseller.mail_email',$email);
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$reseller_email =  $query->row();
 	$data['reseller_email'] = $reseller_email;
 	return $reseller_email;
 }
	function getMaillingAdd( $create_user_id)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_mailling_address');
	$this -> db -> where('tbl_mailling_address.create_user_id',$create_user_id);
	$this->db->order_by("id", "desc");
	$this->db->limit(1);
 
 	$query = $this -> db -> get();
 	$mailling =  $query->row();
 	$data['mailling'] = $mailling;
 	return $mailling;
 }
   function getbillingAdd( $create_user_id)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_billing_address');
	$this -> db -> where('tbl_billing_address.create_user_id',$create_user_id);
	$this->db->order_by("id", "desc");
	$this->db->limit(1);
 
 	$query = $this -> db -> get();
 	$billing =  $query->row();
 	$data['billing'] = $billing;
 	return $billing;
 }
 
  function getBillingByTime( $create_time)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_billing_address');
	$this -> db -> where('tbl_billing_address.create_time',$create_time);
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$billing_id =  $query->row();
 	$data['billing_id'] = $billing_id;
 	return $billing_id;
 }
   function getMaillingByTime( $create_time)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_mailling_address');
	$this -> db -> where('tbl_mailling_address.create_time',$create_time);	
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$milling_id =  $query->row();
 	$data['milling_id'] = $milling_id;
 	return $milling_id;
 }
    function countResellerCompanies($id)
 {
 	$this->db->select ( '*' );
	$this->db->from ( 'tbl_order' );
			
	$this->db->where ( 'tbl_order.reseller_id',$id );
	$query = $this->db->get();
	$user_orders = $query->num_rows();
			
	return $user_orders;
			
 }
	function getUserCreateTime($create_time)
 {
 	$this->db->select ( '*' );
 	$this->db->from ( 'tbl_user' );
 		
 	$this->db->where ( 'tbl_user.create_time',$create_time );
	 $this->db->order_by("id", "desc");
 	$query = $this->db->get();
 	$user = $query->row();
 		
 	return $user;
 		
 }

	function getCompanyByTime( $create_time )
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_company');
 	$this -> db -> where('tbl_company.create_time',$create_time);
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$company=  $query->row();
 	$data['company'] = $company;
 	return $company;
 }
 
	function getOrderByTime( $create_time )
 {
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_order');
 	$this -> db -> where('tbl_order.create_time',$create_time);
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$order=  $query->row();
 	$data['order'] = $order;
 	return $order;
 }
	function resellerByUserId()
 {
 
	$session_data = $this->session->userdata ( 'logged_in' );
	$user_id = $session_data ['id'];
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this -> db -> where('tbl_reseller.user_id',$user_id);
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$reseller_user =  $query->row();
 	$data['reseller_user'] = $reseller_user;
 	return $reseller_user;
 }
	function getResellerId( $reseller_name)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this->db->like ( "tbl_reseller.company_name ", $reseller_name );
	$query = $this -> db -> get();
 	$reseller_user =  $query->row();
	return $reseller_user->id;
 
 }
 	function companyReseller()
 {
 
	$session_data = $this->session->userdata ( 'logged_in' );
	$user_id = $session_data ['id'];
	
	
	$this -> db -> select('*');
 	$this -> db -> from('tbl_order');
	$this->db->like ( "tbl_order.create_user_id ", $user_id );
	$query_order = $this -> db -> get();
 	$order_reseller =  $query_order->row();
	
	
	
	
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this -> db -> where('tbl_reseller.id',$order_reseller->reseller_id);
	$this->db->order_by("id", "desc");
 
 	$query = $this -> db -> get();
 	$reseller_user =  $query->row();
 	$data['reseller_user'] = $reseller_user;
 	return $reseller_user;
 }
 	function getResellerById($id)
 {
	$this -> db -> select('*');
 	$this -> db -> from('tbl_reseller');
	$this->db->like ( "tbl_reseller.id ", $id );
	$query = $this -> db -> get();
 	$reseller_user =  $query->row();
	return $reseller_user;
 
 }
  function getStatusOptions($id =null)
 {
 	$list = array("Active","Suspend","Cancelled","Pending","Deleted"); 
 	if ($id == null )	return $list;
 else
 		return $list [ $id ];
 }
}