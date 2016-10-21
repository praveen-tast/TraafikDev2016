<?php
Class User extends CI_Model
{
 function login($username, $password)
 {
   $this -> db -> select('*');
   $this -> db -> from('tbl_user');
   $this -> db -> where('email', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 
function getStatusOptions($id = null)
 {
 	$list = array("Active","Suspend","Cancelled");
 	if ($id == null )	return $list;
 
 	if ( is_numeric( $id )) return $list [ $id ];
 	return $id;
 }
 
 
}