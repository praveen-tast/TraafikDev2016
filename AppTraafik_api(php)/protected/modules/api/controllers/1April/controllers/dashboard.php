<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			$this->load->model ( 'home_model' );
			$this->load->model ( 'search' );
			$this->load->model ( 'order' );
			$this->load->model ( 'user' );
			$this->load->library ( 'calendar' );
			$this->load->helper('download');
			$this->load->library('session');
			$this->load->library('pagination');
	}
	 public	function index() {
 
	 if ($this->session->userdata ( 'logged_in' )) {
			$session_data = $this->session->userdata( 'logged_in' );
		 	$arr['user_id'] = $session_data ['id'];
			$arr['role_id'] = $session_data ['role_id'];
			
			$config["base_url"] = base_url() . "dashboard/index";
			$config["total_rows"]  = $this->home_model->count_companies($arr);
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$show_companies= $this->home_model->show_companies($config["per_page"],$page,$arr);
			//echo $this->uri->segment(1);
			 
			//echo $this->uri->segment(2);
			//echo $this->uri->segment(3);
			//echo $this->uri->segment(4);
			// print_r($config);
			// die;
			$data ['username'] = $session_data ['first_name'];
			$data ['user_orders'] = $show_companies;
			$data ['role_id'] = $arr['role_id'];
 			$this->load->view ( 'home_view', $data );
		
	 }
	 else {
				// If no session, redirect to login page
				redirect ( 'login', 'refresh' );
			}
}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */