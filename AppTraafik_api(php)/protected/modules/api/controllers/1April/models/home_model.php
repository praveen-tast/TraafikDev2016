<?php
class home_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
    }
   // get the count of all count_categories
   public   function count_companies($arra) {
	 // print_r($arra);
    	   $reseller ='';
			$reseller_ids = array();
			//var_dump($user_id,$role_id);die();
			if($arra['role_id'] === 2)
			{
				$resellers = $this->search->resellerUser($arra['user_id']);

					foreach($resellers as $reseller)
					{
						$reseller_ids [] = $reseller->id;
					}
			}

			$this->db->select ('*,tbl_order.id as id,tbl_order.company_id as company_id,
			tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id,
			tbl_company.company_name as company_name , tbl_reseller.company_name as reseller');
			$this->db->from ( 'tbl_order' );
			$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
			$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
			$this->db->order_by ( "tbl_company.company_name", "asc" );
			$this->db->where ( 'tbl_order.state_id !=2 AND tbl_order.state_id !=4');
			$this->db->where ( 'tbl_reseller.state_id !=1');

			if ($arra['role_id'] === 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $arra['user_id'] );
			}
			elseif ($arra['role_id'] === 2)
			{
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}


			$query = $this->db->get ();
			//echo $this->db->last_query();die;
			//$user_orders = $query->result ();
    	$num = $query->num_rows();
    	return  $num ;
    }
	
	public function show_companies($limit,$start,$arra) {
	 // print_r($arra);
    	   $reseller ='';
			$reseller_ids = array();
			//var_dump($user_id,$role_id);die();
			if($arra['role_id'] == 2)
			{
				$resellers = $this->search->resellerUser($arra['user_id']);

					foreach($resellers as $reseller)
					{
						$reseller_ids [] = $reseller->id;
					}
			}

			$this->db->select ('*,tbl_order.id as id,tbl_order.company_id as company_id,
			tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id,
			tbl_company.company_name as company_name , tbl_reseller.company_name as reseller');
			$this->db->from ( 'tbl_order' );
			$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
			$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
			$this->db->order_by ( "tbl_company.company_name", "asc" );
			$this->db->where ( 'tbl_order.state_id !=2 AND tbl_order.state_id !=4');
			$this->db->where ( 'tbl_reseller.state_id !=1');

			if ($arra['role_id'] == 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $arra['user_id'] );
			}
			elseif ($arra['role_id'] == 2)
			{
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}
			$this->db->limit($limit, $start);
			$query = $this->db->get ();
			//echo $this->db->last_query(); 
 			$result = $query->result();
			//print_r($result);
			return  $result ;
    }
  // addign a new ShowAllcategories
     function ShowAllcategories($limit, $start,$searchtext=array(),$sortt) {
    	
    	$this->db->select("*");
	   	$this->db->from("tbl_courses_categories");
		 
		$this->db->limit($limit, $start);
	   	$this->db->where(array('type'=>'1'));
	  	if($sortt['sort_element']<>'' && $sortt['sort_type']<>''){
   			$this->db->order_by($sortt['sort_element'], $sortt['sort_type']);
 	  	}else{
	    	$this->db->order_by('name', 'ASC');
		}
	   	$query=$this->db->get();
		//echo $this->db->last_query();
	   	return $query->result_array();
   }
 
function getStatusOptions($id = null)
 {
 	$list = array("Active","Suspend","Cancelled");
 	if ($id == null )	return $list;
 
 	if ( is_numeric( $id )) return $list [ $id ];
 	return $id;
 }
 
 
}