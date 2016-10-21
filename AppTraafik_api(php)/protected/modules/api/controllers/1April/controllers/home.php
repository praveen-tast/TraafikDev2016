<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	// session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'search' );
		$this->load->model ( 'order' );
		$this->load->model ( 'user' );
		$this->load->library ( 'calendar' );
		$this->load->helper('download');
	}

	
 	function index() {

		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];
			$reseller ='';
			$reseller_ids = array();
			//var_dump($user_id,$role_id);die();
			if($role_id === 2)
			{
				$resellers = $this->search->resellerUser($user_id);

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

			if ($role_id === 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $user_id );
			}
			elseif ($role_id === 2)
			{
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}


			$query = $this->db->get ();
			$user_orders = $query->result ();

			$data ['username'] = $session_data ['first_name'];
			$data ['user_orders'] = $user_orders;
			$data ['role_id'] = $role_id;
			$this->load->view ( 'home_view', $data );
		} else {
			// If no session, redirect to login page
			redirect ( 'login', 'refresh' );
		}
	}
 function logout() {
 
 //var_dump($this->session->userdata ( 'logged_in' ));die;
 
		$this->session->unset_userdata ( 'logged_in' );
		session_destroy ();
		redirect ( 'home', 'refresh' );
	}
 public function search() {

		if ($this->session->userdata ( 'logged_in' )) {
		$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];

			$reseller ='';
			$reseller_ids = array();

			if($role_id == 2)
				{
					$resellers = $this->search->resellerUser($user_id);

						foreach($resellers as $reseller)
						{
							$reseller_ids [] = $reseller->id;
						}
				}

			$this->db->select ( '*,tbl_order.id as id,tbl_order.company_id as company_id,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, 								             tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
			$this->db->from ( 'tbl_order' );
			$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
			$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
			$this->db->order_by ( "tbl_company.company_name", "asc" );
			//$this->db->where ( 'tbl_order.state_id !=4');
			$this->db->where ( 'tbl_reseller.state_id !=1');

			if (isset ( $_POST ["search_field"] )) {
				$query = $_POST ["search_field"];
				$this->db->like ( "tbl_company.company_name ", $query );


			if ($role_id == 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $user_id );
			}
			elseif ($role_id == 2)
			{			if($resellers)
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}



				$query = $this->db->get ();
				$user_orders = $query->result ();


				//var_dump($this->db->last_query(),$user_orders,$role_id);die;

				$data ['username'] = $session_data ['email'];
				$data ['user_orders'] = $user_orders;
				$data ['role_id'] = $role_id;
				$this->load->view ( 'home_view', $data );
				} else {

				$select_id = $_POST ["select_id"];
				$select_option = $_POST ["select_option"];
				$this->db->where ( 'tbl_order.' . $select_id, $select_option );

				if ($role_id == 0)
				$this->db->where ( 'tbl_order.create_user_id', $user_id );

			/**/if ($role_id == 2)
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
				//$this->db->where ( 'tbl_reseller.id', $reseller->id );


				$query = $this->db->get ();
				$user_orders = $query->result ();

				$data ['username'] = $session_data ['email'];
				$data ['user_id'] = $user_id;
				$data ['user_orders'] = $user_orders;
				$data ['role_id'] = $role_id;

				foreach ( $user_orders as $user_order ) {

					exit;
				}
				// $this->load->view('home_view', $data);
			}
		} else {
			// If no session, redirect to login page
			redirect ( 'login', 'refresh' );
		}
	}
	
	public function updateCompany() {

		if (isset ( $_POST ["company_id"] )) {


			$renewal = date ( "Y-m-d h:i:s", strtotime ( $_POST ['renewal'] ) );
			// var_dump($_POST);die;
			$data = array (
					'company_name' => $_POST ["user_company"],
					'trading' => $_POST ["trade_name"],
					'director1' => $_POST ["director1"],
					'director2' => $_POST ["director2"],
					'director3' => $_POST ["director3"],
					'director4' => $_POST ["director4"],
					'location' => $_POST ["location"]
			);

			$this->db->where ( 'id', $_POST ["company_id"] );
			$this->db->update ( 'tbl_company', $data );

			$company_renew = array (
					'renewable_date' => $renewal
			);

			$this->db->where ( 'company_id', $_POST ["company_id"] );
			$this->db->update ( 'tbl_order', $company_renew );
		} else if (isset ( $_POST ["user_name"] )) {
				$data_reseller = array (
					'contact_name' => $_POST ["user_name"],
					'admin_email' => $_POST ["user_email"],
					'phone_number' => $_POST ["user_contact"]
			);
				$this->db->where ( 'user_id', $_POST ["user_id"] );
				$this->db->update ( 'tbl_reseller', $data_reseller );

			$data = array (
					'first_name' => $_POST ["user_name"],
					'last_name' => $_POST ["user_last_name"],
					'email' => $_POST ["user_email"],
					'ph_no' => $_POST ["user_daytime_contact"],
					'mobile' => $_POST ["user_contact"],
					'skpe_address' => $_POST ["user_skype"],
					'counrty' => $_POST ["user_county"],
					'county' => $_POST ["user_country"]
			);
			$data_mailing = array (
					'street' => $_POST ["user_street"],
					'city' => $_POST ["user_city"],
					'county' => $_POST ["user_country"],
					'country' => $_POST ["user_county"],
					'postcode' => $_POST ["user_post_code"]
			);
			if (! empty ( $_POST ["user_password"] )) {
				$data_password = array (
						'password' => md5 ( $_POST ["user_password"] )
				);
				$this->db->where ( 'id', $_POST ["user_id"] );
				$this->db->update ( 'tbl_user', $data_password );
			}

			$this->db->where ( 'id', $_POST ["user_id"] );
			$this->db->update ( 'tbl_user', $data );

			$this->db->where ( 'id', $_POST ["mailing_id"] );
			$this->db->update ( 'tbl_mailling_address', $data_mailing );
		} else if (isset ( $_POST ["billing_id"] )) {

			$data = array (
					'billing_name' => $_POST ["billing_name"],
					'street' => $_POST ["billing_street"],
					'city' => $_POST ["billing_city"],
					'country' => $_POST ["billing_country"],
					'county' => $_POST ["billing_county"],
					'postcode' => $_POST ["billing_post_code"]
			);

			$this->db->where ( 'id', $_POST ["billing_id"] );
			$this->db->update ( 'tbl_billing_address', $data );
		} else if (isset ( $_POST ["mailing_id"] )) {

			$data = array (
					'mailing_name' => $_POST ["mailing_name"],
					'street' => $_POST ["mailing_street"],
					'city' => $_POST ["mailing_city"],
					'country' => $_POST ["mailing_country"],
					'county' => $_POST ["mailing_county"],
					'postcode' => $_POST ["mailing_postcode"]
			);

			$this->db->where ( 'id', $_POST ["mailing_id"] );
			$this->db->update ( 'tbl_mailling_address', $data );
		} else if (isset ( $_POST ["c_id"] )) {

			$data = array (
					'mailing_name' => $_POST ["mailing_name"],
					'street' => $_POST ["mailing_street"],
					'city' => $_POST ["mailing_city"],
					'country' => $_POST ["mailing_country"],
					'county' => $_POST ["mailing_county"],
					'postcode' => $_POST ["mailing_postcode"]
			);

			$this->db->where ( 'id', $_POST ["mailing_id"] );
			$this->db->update ( 'tbl_mailling_address', $data );
		} elseif (isset ( $_POST ['state_id'] )) {

			// var_dump($_POST);die();
			$company_id = $_POST ['status_company_id'];
			$data_company = array (
					'state_id' => $_POST ['state_id']
			);

			$this->db->where ( 'id', $company_id );
			$this->db->update ( 'tbl_order', $data_company );
		}

		redirect ( 'home', 'refresh' );
	}
	
		public function do_upload() {

		$session_data = $this->session->userdata ( 'logged_in' );
		$user_id = $session_data ['id'];
		$comp_id = $_POST ["comp_id"];
	//	var_dump($_POST,$_FILES); die;

		if (isset ( $_POST ["file_type_id"] )) {

			$type_id = $_POST ["file_type_id"];


		} else

			$type_id = 3;
			// var_dump($type_id);die;

		if (!empty( $_FILES ['userfile']['name'][0])) {
	//	var_dump($_FILES ['userfile']['name']);die;
		$type_name = $this->search->getTypeOptions($type_id);

		/*================================File Attachment==================================*/
		/*=======================================================*/
				$this -> db -> select('*');
				$this -> db -> from('tbl_company');
				$this -> db -> where('tbl_company.id',$comp_id);

				$query_company = $this -> db -> get();
				$detail_company=  $query_company->row();



		/*=======================================================*/
		/*=======================================================*/

				$this->db->select ( '*' );
				$this->db->from ( 'tbl_alt_email' );

				$this->db->where ( 'tbl_alt_email.company_id',$comp_id);

				$query_emails = $this->db->get();
				$alt_emails = $query_emails->result();


		/*======================User============================*/
				$this->db->select ( '*,tbl_user.id as id,tbl_user.email as email' );
				$this->db->from ( 'tbl_user' );

				$this->db->where ( 'tbl_user.id', $detail_company->create_user_id);

				$query_user = $this->db->get();
				$user = $query_user->row ();



		/*======================User============================*/
				$emails = array();
				$emails['email_1'] = $user->email;
				foreach($alt_emails as $alt_email)
					{

						$emails['email_2'] = $alt_email->email_2;
						$emails['email_3'] = $alt_email->email_3;
						$emails['email_4'] = $alt_email->email_4;
					}
						$email_to =	implode(',', $emails);



		$email_to =$email_to;//= implode(',', $emails);
		$from_email = 'The Registered Office (donotreply@theregisteredoffice.com)'; //sender email
		$subject = 'You Have Mail! >'.$detail_company->company_name; //subject of email

		$message = '<h3>You have mail!</h3>'."<br>";
		$message .= '<hr>'."<br>";
		$message .= 'Hello '.$detail_company->company_name.",<br><br>";
		$message .= "We're writing to let you know that you mail!"."<br><br>";
		$message .= 'We have scanned and attached your mail as requested.<br><br>';
		$message .= 'Should you require a hard copy please <a href="http://www.theregisteredoffice.com/login.php">log in to your control panel</a> and request the original copy.'."<br>								                    <br><br>";
		$message .= 'Kind regards,'."<br><br>";
		$message .='<b>The Registered Office</b>'."<br>";
		$message .='Tel: +44 (0) 207 112 5367'."<br>";
		$message .='Email: mail@theregisteredoffice.com'."<br>";
		$message .='Web:  theregisteredoffice.com'."<br>";
		$message .='Skype: registeredoffice'."<br>";



		$boundary = md5("sanwebe");
				//header
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "From: The Registered Office <donotreply@theregisteredoffice.com>". "\r\n";
		//$headers .= "From: Nominee Services <mail@nomineeservices.co.uk>". "\r\n";
		$headers .= "Reply-To: Aditi" . "\r\n";

		$headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";
		//plain text
		$body = "--$boundary\r\n";
		$body .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$body .= chunk_split(base64_encode($message));
		/*=======================================================================================*/
			$userfiles = $_FILES ["userfile"];

			$this->load->library ( 'upload' );

			$files = $_FILES;
			$cpt = count ( $_FILES ['userfile'] ['name'] );

			for($i = 0; $i < $cpt; $i ++) {
				$_FILES ['userfile'] ['name'] = time () . $files ['userfile'] ['name'] [$i];
				$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [$i];
				$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [$i];
				$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [$i];
				$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [$i];

				$this->upload->initialize ( $this->set_upload_options () );
				if ($this->upload->do_upload ()) {
					$data = array (
							'upload_data' => $this->upload->data ()
					);
					$data_file_info = array (
							'company_id' => $comp_id,
							'file_name' => $_FILES ['userfile'] ['name'],
							'create_user_id' => $user_id,
							'create_time' => date ( 'Y-m-d h:i:s' ),
							'type_id' => $type_id
					);

					if($this->db->insert ( 'tbl_file_info', $data_file_info ))
					{



					/*=====================================*/
					$file_tmp_name    = $_FILES ['userfile'] ['tmp_name'];
					$file_name        = $_FILES ['userfile'] ['name'];
					$file_size        = $_FILES ['userfile'] ['size'];
					$file_type        = $_FILES ['userfile'] ['type'];
					$file_error       = $_FILES ['userfile'] ['error'];



					$handle = fopen($file_tmp_name, "r");
					$content = fread($handle, $file_size);
					fclose($handle);
					$encoded_content = chunk_split(base64_encode($content));



					//attachment
					$body .= "--$boundary\r\n";
					$body .="Content-Type: $file_type; name=\"$file_name\"\r\n";
					$body .="Content-Disposition: attachment; filename=\"$file_name\"\r\n";
					$body .="Content-Transfer-Encoding: base64\r\n";
					$body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n";
					$body .= $encoded_content;


	/*===================================================================*/


					}
				} else {
					$error = array (
							'error' => $this->upload->display_errors ()
					);
					echo "Please upload mail";
				}
			}
				@mail($email_to, $subject, $body, $headers);
		} else {
			echo "Please upload mail";
		}
		redirect ( 'home', 'refresh' );
	}
			public function doc_upload() {

		$session_data = $this->session->userdata ( 'logged_in' );
		$user_id = $session_data ['id'];
		$comp_id = $_POST ["comp_id"];
		//var_dump($_POST); die;

		if (isset ( $_POST ["file_type_id"] )) {

			$type_id = $_POST ["file_type_id"];


		} else

			$type_id = 3;
			// var_dump($type_id);die;

		if (!empty( $_FILES ['userfile']['name'][0])) {
		//var_dump($_FILES ['userfile']['name']);die;
		$type_name = $this->search->getTypeOptions($type_id);

		/*================================File Attachment==================================*/
		/*=======================================================*/
				$this -> db -> select('*');
				$this -> db -> from('tbl_company');
				$this -> db -> where('tbl_company.id',$comp_id);

				$query_company = $this -> db -> get();
				$detail_company=  $query_company->row();



		/*=======================================================*/
		/*=======================================================*/

				$this->db->select ( '*' );
				$this->db->from ( 'tbl_alt_email' );

				$this->db->where ( 'tbl_alt_email.company_id',$comp_id);

				$query_emails = $this->db->get();
				$alt_emails = $query_emails->result();


		/*======================User============================*/
				$this->db->select ( '*,tbl_user.id as id,tbl_user.email as email' );
				$this->db->from ( 'tbl_user' );

				$this->db->where ( 'tbl_user.id', $detail_company->create_user_id);

				$query_user = $this->db->get();
				$user = $query_user->row ();



		/*======================User============================*/
				$emails = array();
				$emails['email_1'] = $user->email;
				foreach($alt_emails as $alt_email)
					{

						$emails['email_2'] = $alt_email->email_2;
						$emails['email_3'] = $alt_email->email_3;
						$emails['email_4'] = $alt_email->email_4;
					}
						$email_to =	implode(',', $emails);



		$email_to =$email_to;//= implode(',', $emails);
		$from_email = 'File Exchange<mail@theregisteredoffice.com>'; //sender email
		$subject = 'File Exchange Mail'; //subject of email
		$message = 'Please find the attachment below'."\r\n";
		$message .= 'Type:'.$type_name; //message body

		$boundary = md5("sanwebe");
				//header
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "From:".$from_email."\r\n";
		$headers .= "Reply-To: Aditi" . "\r\n";
		$headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";
		//plain text
		$body = "--$boundary\r\n";
		$body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
		$body .= chunk_split(base64_encode($message));
		/*=======================================================================================*/
			$userfiles = $_FILES ["userfile"];

			$this->load->library ( 'upload' );

			$files = $_FILES;
			$cpt = count ( $_FILES ['userfile'] ['name'] );

			for($i = 0; $i < $cpt; $i ++) {
				$_FILES ['userfile'] ['name'] = time () . $files ['userfile'] ['name'] [$i];
				$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [$i];
				$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [$i];
				$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [$i];
				$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [$i];

				$this->upload->initialize ( $this->set_upload_options () );
				if ($this->upload->do_upload ()) {
					$data = array (
							'upload_data' => $this->upload->data ()
					);
					$data_file_info = array (
							'company_id' => $comp_id,
							'file_name' => $_FILES ['userfile'] ['name'],
							'create_user_id' => $user_id,
							'create_time' => date ( 'Y-m-d h:i:s' ),
							'type_id' => $type_id
					);

					if($this->db->insert ( 'tbl_file_info', $data_file_info ))
					{



					/*=====================================*/
					$file_tmp_name    = $_FILES ['userfile'] ['tmp_name'];
					$file_name        = $_FILES ['userfile'] ['name'];
					$file_size        = $_FILES ['userfile'] ['size'];
					$file_type        = $_FILES ['userfile'] ['type'];
					$file_error       = $_FILES ['userfile'] ['error'];



					$handle = fopen($file_tmp_name, "r");
					$content = fread($handle, $file_size);
					fclose($handle);
					$encoded_content = chunk_split(base64_encode($content));



					//attachment
					$body .= "--$boundary\r\n";
					$body .="Content-Type: $file_type; name=\"$file_name\"\r\n";
					$body .="Content-Disposition: attachment; filename=\"$file_name\"\r\n";
					$body .="Content-Transfer-Encoding: base64\r\n";
					$body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n";
					$body .= $encoded_content;


	/*===================================================================*/


					}
				} else {
					$error = array (
							'error' => $this->upload->display_errors ()
					);
					echo "Please upload mail";
				}
			}
			//	@mail($email_to, $subject, $body, $headers);
		} else {
			echo "Please upload mail";
		}
		redirect ( 'home', 'refresh' );
	}
private function set_upload_options() {

		// upload an image options
		$config = array ();
		$config ['upload_path'] = './uploads/';
		$config ['allowed_types'] = 'gif|jpg|png|pdf|jpeg';
		$config ['max_size'] = '0';
		$config ['overwrite'] = FALSE;

		return $config;
	}
	public function proof_upload() {
		$session_data = $this->session->userdata ( 'logged_in' );
		$user_id = $session_data ['id'];
		$create_time = date ( 'Y-m-d h:i:s' );


		if (! empty ( $_FILES ['userfile'] ['name'] )) {

			$userfiles = $_FILES ["userfile"];
			$company_id = $_POST ["c_id"];
			$company = $this->search->getCompany($company_id);

			$this->load->library ( 'upload' );
			$files = $_FILES;

			if (isset ( $_FILES ['userfile'] )) {

				$_FILES ['userfile'] ['name'] = time () . 'idcard' . $files ['userfile'] ['name'] [0];
				$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [0];
				$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [0];
				$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [0];
				$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [0];
				$configd ['file_name'] = $_FILES ['userfile'] ['name'];
				// var_dump($_FILES['userfile']['name']);

				$this->upload->initialize ( $this->set_upload_options () );
				if ($this->upload->do_upload ()) {

					$data = array (
							'upload_data' => $this->upload->data ()
					);
					// var_dump($data);
					$data_file = array (
							'company_id' => $company_id,
							'file_name' => $_FILES ['userfile'] ['name'] ,
							'type_id' => '4',
							'create_user_id' => $company->create_user_id,
							'update_user_id' =>$user_id,
							'create_time' => $create_time
					);

					$this->db->insert ( 'tbl_file_info', $data_file );
				} else {
					$error = array (
							'error' => $this->upload->display_errors ()
					);
					//echo "Please Upload Your  Passport or Identity Card";
				}

				$_FILES ['userfile'] ['name'] = time () . 'addproof' . $files ['userfile'] ['name'] [1];
				$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [1];
				$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [1];
				$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [1];
				$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [1];
				$configd ['file_name'] = $_FILES ['userfile'] ['name'];
				// var_dump($_FILES['userfile']['name']);

				$this->upload->initialize ( $this->set_upload_options () );
				if ($this->upload->do_upload ()) {
					$data = array (
							'upload_data' => $this->upload->data ()
					);
					$data_file = array (
							'company_id' => $company_id,
							'file_name' => $_FILES ['userfile'] ['name'] ,
							'type_id' => '5',
							'create_user_id' => $company->create_user_id,
							'update_user_id' =>$user_id,
							'create_time' => $create_time
					);

					$this->db->insert ( 'tbl_file_info', $data_file );
				} else {
					$error = array (
							'error' => $this->upload->display_errors ()
					);
					//echo "Please Upload Your Utility Bill(Proff of Address)";
					// var_dump($error);die;
				}
			}
		} else {
			echo "Please upload your identity";
		}

		redirect ( 'home', 'refresh' );
	}
	
	function message() {

		// var_dump($_POST);die;
		$session_data = $this->session->userdata ( 'logged_in' );
		$user_id = $session_data ['id'];

		$order_id = $_POST ["order_post_id"];
		$email ="";
		/*if(empty($_POST ["_email"]))
		{*/

			$this->db->select ( '*,tbl_order.id as id' );
			$this->db->from ( 'tbl_order' );
			$this->db->where ( 'tbl_order.id', $order_id);
			$query_order = $this->db->get();
			$order = $query_order->row ();
			/*======================User============================*/
			$this->db->select ( '*,tbl_user.id as id,tbl_user.email as email' );
			$this->db->from ( 'tbl_user' );
			$this->db->where ( 'tbl_user.id', $order->create_user_id);
			$query_user = $this->db->get();
			$user = $query_user->row ();
			/*======================User============================*/
			/*=====================Alt emails==============*/
			$this->db->select ( '*' );
			$this->db->from ( 'tbl_alt_email' );
			$this->db->where ( 'tbl_alt_email.company_id',$order->company_id);

			$query_emails = $this->db->get();
			$alt_emails = $query_emails->result ();
			$emails = array();
			$emails['email_1'] = $user->email;
				foreach($alt_emails as $alt_email)
					{
						$emails['email_2'] = $alt_email->email_2;
						$emails['email_3'] = $alt_email->email_3;	
						$emails['email_4'] = $alt_email->email_4;
					}

			/*=====================================*/
			$email_to = implode(',', $emails);


			$email = $email_to;
		//}
		/*else
		{
		$emails = array();
		$emails['email_1'] = $_POST ["_email"];
			$email_to = implode(',', $emails);
			$email = $email_to;
			}*/

			//var_dump($email);die;

		$data_file_info = array (
				'order_id' => $order_id,
				'message' => $_POST ["message_post"],
				'to_id' => $_POST ["to_id"],
				'from_id' => $_POST ["from_id"],
				'email_id' => $_POST ["_email"],
				'tel_no' => $_POST ["tel_no"],
				'create_time' => date ( 'Y-m-d h:i:s' ),
				'create_user_id' => $user_id
		);
		if ($this->db->insert ( 'tbl_message', $data_file_info )) {

			$to = $email;//"mail@theregisteredoffice.com";//$this->search->getMessage ( $order_id );
			$header = 'From: The Registered Office<noreply@theregisteredoffice.com>' . "\r\n";
			$header .= 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$subject = "You have a message!";
			$new_msg = "<html>
						<head>
						<title>The Registered Office</title>
						</head>
						<body>
							<h3>You have a message!</h3>
							<hr>
								Hello " . $_POST ["to_id"] . ", 	<br><br>
								We're writing to let you know that you have a message. <br><br>
								The message details of the call are:<br><br>
								<b>Call from:</b> " . $_POST ["from_id"] . "   <br><br>
								<b>Call to:</b> " . $_POST ["to_id"] . "<br><br>
								<b>Telephone number:</b> " . $_POST ["tel_no"] . "<br><br>
								<b>Message:</b> " . $_POST ["message_post"] . "<br><br>

							Best regards, <br><br>
							The Registered Office<br>
							The Admin Team	<br>

					</body>
					</html>";
			if(mail ( $to, $subject, $new_msg, $header ))
				redirect ( 'home', 'refresh' );

		}
		else
		{
				die("not done");
		}

		redirect ( 'home', 'refresh' );
	}
		function state_change() {

		$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];

			$reseller ='';
			$reseller_ids = array();
			if($role_id == 2)
				{
					$resellers = $this->search->resellerUser($user_id);

						foreach($resellers as $reseller)
						{
							$reseller_ids [] = $reseller->id;
						}
				}



		// var_dump($_POST);die;
		if($_POST ['state_change'] != 'Show All'){
		$state = $_POST ['state_change'];
		$this->db->select ( '*,tbl_order.id as id,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
		$this->db->from ( 'tbl_order' );
		$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
		$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
		$this->db->order_by ( "tbl_company.company_name", "asc" );

		//$this->db->where ( 'tbl_order.state_id !=2');
			$this->db->where ( 'tbl_reseller.state_id !=1');



		$this->db->where ( 'tbl_order.state_id', $state );
		}
		else
		{
			$this->db->select ( '*,tbl_order.id as id,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
			$this->db->from ( 'tbl_order' );
			$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
			$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
			$this->db->order_by ( "tbl_company.company_name", "asc" );
			$this->db->where ( 'tbl_order.state_id !=2');
				$this->db->where ( 'tbl_reseller.state_id !=1');
		}

			if ($role_id == 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $user_id );
			}
			elseif ($role_id == 2)
			{
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}
		$query = $this->db->get ();
		$user_orders = $query->result ();

		$data ['role_id'] = $role_id;
		$data ['user_orders'] = $user_orders;
		$data ['username'] = $session_data ['first_name'];

		$this->load->view ( 'home_view', $data );
	}

	public function updateOrder() {

		if (isset ( $_POST ['renew_company_id'] )) {
			$order_id = $_POST ["get_order_id"];
			$renewal_date = date ( 'Y-m-d h:i:s', strtotime ( $_POST ['renew_company_id'] ) );

			$data = array (
					'renewable_date' => $renewal_date
			);

			$this->db->where ( 'id', $order_id );
			$this->db->update ( 'tbl_order', $data );
		}
		if (isset ( $_POST ['location_company_id'] )) {

			$order_location_id = $_POST ["location_company_id"];
			$radioGroup = $_POST ["radioGroup"];
			$va = '';
			if ($radioGroup == "option1")
				$va = "SE1";
			elseif ($radioGroup == "option2")
				$va = "WC1";
			elseif ($radioGroup == "option3")
				$va = "EH1";

			$data_location = array (
					'location' => $va
			);


			$this->db->select ( '*' );
			$this->db->from ( 'tbl_order' );
			$this->db->where ( 'tbl_order.id',$order_location_id);
		$query = $this->db->get ();
		$orders_company = $query->row ();


			$this->db->where ( 'tbl_order.id', $order_location_id );
			if($this->db->update ( 'tbl_order', $data_location ))
				{

					$this->db->where ( 'tbl_company.id', $orders_company->company_id );
					if($this->db->update ( 'tbl_company', $data_location ))
					{
						//die("done");
					}
					else
					{
						var_dump($this->db->_error_message());die;
					}
				}
			else
				{
					var_dump($this->db->_error_message());die;
				}


		}
		if (isset ( $_POST ['reseller_id'] )) {
			$order_reseller_id = $_POST ["reseller_id"];
			$save_reseller_id = $_POST ["save_reseller_id"];
			$data = array (
					'reseller_id' => $save_reseller_id
			);

			$this->db->where ( 'id', $order_reseller_id );
			$this->db->update ( 'tbl_order', $data );
		}

		redirect ( 'home', 'refresh' );
	}
		function getStatusOptions($id = null) {

		$list = array (
				"Active",
				"Suspend",
				"Cancelled"
		);
		if ($id == null)
			return $list;

		if (is_numeric ( $id ))
			return $list [$id];
		return $id;
	}
	function addCompany() {


		$session_data = $this->session->userdata ( 'logged_in' );
		$user_id = $session_data ['id'];
		$role_id = $session_data ['role_id'];
		$time = time ();
		$create_time = date ( 'Y-m-d h:i:s' );
		$extend_time = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($create_time)) . " + 1 year"));


		if($_POST["form_fields"])
		{
	
		$package_value = $this->order->getOrders ($_POST['order_name']);

			$product = $package_value;
			$price = $_POST['price'];

			$data= urldecode($_POST['form_fields']);



			$pieces = explode("&", $data);
			for($a=0;$a<count($pieces);$a++)
			{
				$profile_key=strstr($pieces[$a],"=",true);
				$profile[$profile_key] = substr(strstr($pieces[$a],"="),1);

			}
			$company_contact_name = $profile["company_contact_name"];
			$add_company_services_popup = $profile["add_company_services_popup"];
			$add_company_location_popup = $profile["add_company_location_popup"];
			$add_company_reseller = $profile["add_company_reseller"];
			
			/*if Reseller logged in use Reseller Data to add new company*/
		$user_email = $this->search->userSearch($user_id);
		$reseller_user_id = $this->search->resellerByEmail($user_email->email);
		$rellerInfo = $this->search->userSearch($reseller_user_id->user_id);
		
		
		/*if company is added by admin user data of Reseller selected*/
		$user_reseller = $this->search->getResellerById($add_company_reseller);
		$rellerInfo = $this->search->userSearch($user_reseller->user_id);
		
		
		if($role_id ==1)
		$user_id = $rellerInfo->id;


			
			
			
			$milling = $this->search->getMaillingAdd($user_id);
			$billing = $this->search->getbillingAdd($user_id);



		$this->db->select ( '*,tbl_company.id as id,tbl_company.mailing_adress_id as mailing_adress_id,tbl_company.billing_adress_id as billing_adress_id ' );
		$this->db->from ( 'tbl_company' );

		$this->db->where ( 'tbl_company.company_name', $company_contact_name );

		$query_company = $this->db->get ();
		$company = $query_company->row ();

			$data_mailling = array (
								'mailing_name' => $milling->mailing_name,
								'street' =>$milling->street,
								'country' => $milling->country,
								'city' => $milling->city,
								'postcode' => $milling->postcode,
								'county' => $milling->county,
								'create_user_id' =>$user_id,
								'update_user_id' => $user_id,
								'create_time' => $create_time
				);

			$data_billing = array (
							   'billing_name' => $billing->mailing_name,
								'street' =>$billing->street,
								'country' => $billing->country,
								'city' => $billing->city,
								'postcode' => $billing->postcode,
								'county' => $billing->county,
								'create_user_id' => $user_id,
								'update_user_id' => $user_id,
								'create_time' => $create_time
				);

				$this->db->insert ( 'tbl_mailling_address', $data_mailling );
				$this->db->insert ( 'tbl_billing_address', $data_billing );

				$mailling_id = $this->search->getMaillingByTime($create_time);
				$billing_id = $this->search->getBillingByTime($create_time);


			$data_company = array (
								'company_name' => $company_contact_name,
								'create_user_id' => $user_id,
								'location' => $add_company_location_popup,
								'mailing_adress_id' => $mailling_id->id,
								'billing_adress_id' => $billing_id->id,
								'create_time' => $create_time
				);






				if($this->db->insert ( 'tbl_company', $data_company ))
				{
						$this->db->select ( '*,tbl_company.id as id' );
						$this->db->from ( 'tbl_company' );
						$this->db->where ( 'tbl_company.create_time', $create_time );
						$this->db->where ( 'tbl_company.create_user_id', $user_id );
						$this->db->where ( 'tbl_company.company_name', $company_contact_name);

						$query_company = $this->db->get ();
						$company = $query_company->row ();

						
						if($role_id ==1)
						{
							$reseller_id = $profile["add_company_reseller"];
						}
						elseif($role_id ==0)
						{
								$this -> db -> select('*');
								$this -> db -> from('tbl_order');
								$this->db->like ( "tbl_order.create_user_id ", $user_id );
								$query_order = $this -> db -> get();
								$this->db->order_by("id", "desc");
								$order_reseller =  $query_order->row();
								$reseller_id=$order_reseller->reseller_id;

						}
						else
							$reseller_id = $reseller_user_id->id;





						if($product == 'complete_package')
						{
							$data_order = array (
								'company_id' => $company->id,
								'renewable_date'  => $extend_time,
								'location'  => $add_company_location_popup ,
								'deposit' => '0.00',
								'registered_office'=>'Yes',
								'director_service_address'=>'Yes',
								'business_address'=>'Yes',
								'telephone_service'=>'Yes',
								'complete_package'=>'Yes',
								'hosting'=>'Yes',
								'price'  => $price,
								'quantity'  =>'1',
								'reseller_id'  => $reseller_id,
								'state_id' => '3',
								'create_user_id' => $user_id,
								'create_time' => $create_time
							);
						}
						elseif($product == 'both')
						{
							$data_order = array (
								'company_id' => $company->id,
								'renewable_date'  => $extend_time,
								'location'  => $add_company_location_popup ,
								'deposit' => '0.00',
								'registered_office'=>'Yes',
								'director_service_address'=>'Yes',
								'price'  => $price,
								'quantity'  =>'1',
								'reseller_id'  => $reseller_id,
								'state_id' => '3',
								'create_user_id' => $user_id,
								'create_time' => $create_time
							);
						}

						else{


						$data_order = array (
								'company_id' => $company->id,
								'renewable_date'  => $extend_time,
								'location'  => $add_company_location_popup ,
								'deposit' => '0.00',
								$product=>'Yes',
								'price'  => $price,
								'quantity'  =>'1',
								'reseller_id'  => $reseller_id,
								'state_id' => '3',
								'create_user_id' => $user_id,
								'create_time' => $create_time
							);
							}
							if($this->db->insert ( 'tbl_order', $data_order ))
							{
									$this->db->select ( '*,tbl_order.id as id' );
									$this->db->from ( 'tbl_order' );

									$this->db->where ( 'tbl_order.create_time', $create_time );
									$this->db->where ( 'tbl_order.create_user_id', $user_id );
									$this->db->where ( 'tbl_order.company_id',$company->id);

									$query_order = $this->db->get();
									$order = $query_order->row ();



									$data_order_detail = array (
											'order_summery_id' => $order->id,
										//	'product'  => $product,
											'product'  => $_POST['order_name'],
											'total'  => $price,
											'price'  => $price,
											'quantity'  =>'1',
											'create_user_id' => $user_id,
											'create_time' => $create_time
										);
									if($this->db->insert ( 'tbl_order_detail', $data_order_detail ))
									{
										redirect ( 'home', 'refresh' );
									}

									else
									{
										var_dump($this->db->_error_message());die;
									}

								}
								else
									{
										var_dump($this->db->_error_message());die;
										}



				}

	


		}
		elseif (! empty ( $_POST )) {
			if (isset ( $_FILES ['userfile'] )) {
				$userfiles = $_FILES ["userfile"];

				$this->load->library ( 'upload' );
				$files = $_FILES;

				$_FILES ['userfile'] ['name'] = $time . 'idcard' . $files ['userfile'] ['name'] [0];
				$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [0];
				$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [0];
				$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [0];
				$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [0];
				$configd ['file_name'] = $_FILES ['userfile'] ['name'];
				// var_dump($_FILES['userfile']['name']);

				$this->upload->initialize ( $this->set_upload_options () );
				if ($this->upload->do_upload ()) {
					$data = array (
							'upload_data' => $this->upload->data ()
					);
				} else {
					$error = array (
							'error' => $this->upload->display_errors ()
					);
					var_dump ( $error );
					die ();
				}

				$_FILES ['userfile'] ['name'] = $time . 'addproof' . $files ['userfile'] ['name'] [1];
				$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [1];
				$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [1];
				$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [1];
				$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [1];
				$configd ['file_name'] = $_FILES ['userfile'] ['name'];
				// var_dump($_FILES['userfile']['name']);

				$this->upload->initialize ( $this->set_upload_options () );
				if ($this->upload->do_upload ()) {
					$data = array (
							'upload_data' => $this->upload->data ()
					);
				} else {
					$error = array (
							'error' => $this->upload->display_errors ()
					);
					var_dump ( $error );
					die ();
				}

				$data_reseller = array (
						'company_name' => $_POST ["company_name"],
						'company_number' => $_POST ["company_phone"],
						'email_address' => $_POST ["company_email_address"],
						'town' => $_POST ["company_town"],
						'country' => $_POST ["company_country"],
						'id_proof' => $time . 'idcard' . $files ['userfile'] ['name'] [0],
						'address_proof' => $time . 'idcard' . $files ['userfile'] ['name'] [1],

						'create_user_id' => $user_id,
						'create_time' => date ( 'Y-m-d h:i:s' )
				);

				$this->db->insert ( 'tbl_company', $data_reseller );
			}
		}

		$this->load->view ( 'company' );
	}
		private function set_xsl_options() {

		// upload an image options
		$config = array ();
		$config ['upload_path'] = './uploads/xsl/';
		$config ['allowed_types'] = 'xls|xlsx';
		$config ['max_size'] = '0';
		$config ['overwrite'] = FALSE;

		return $config;
	}
		function reseller_change() {

		$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];
 
		//var_dump($_POST);die;
		if($_POST ['reseller_change'] != 'Show All'){
		$reseller_id = $_POST ['reseller_change'];
		$this->db->select ( '*,tbl_order.id as id,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
		$this->db->from ( 'tbl_order' );
		$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
		$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
		$this->db->order_by ( "tbl_company.company_name", "asc" );

		$this->db->where ( 'tbl_order.reseller_id', $reseller_id );
		}
		else
		{
		$this->db->select ( '*,tbl_order.id as id,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
		$this->db->from ( 'tbl_order' );
		$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
		$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
		$this->db->order_by ( "tbl_company.company_name", "asc" );
		}
		$query = $this->db->get ();
		$user_orders = $query->result ();

		$data ['role_id'] = $role_id;
		$data ['user_orders'] = $user_orders;
		$data ['username'] = $session_data ['first_name'];
		$this->load->view ( 'home_view', $data );
	}
	public function serviceSearch()
 {
   $key_name = "";
   $value_name = "";

	   foreach($_POST as $key=>$value)
	   {
			   $key_name = $key;
			   $value_name = $value;
	   }


 	$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];
		$reseller ='';
			$reseller_ids = array();
			//var_dump($user_id,$role_id);die();
			if($role_id == 2)
			{
				$resellers = $this->search->resellerUser($user_id);

					foreach($resellers as $reseller)
					{
						$reseller_ids [] = $reseller->id;
					}
			}

		$this->db->select ( 'tbo.*,

		tbo.id as id,
		tbo.company_id as company_id,
		tbo.create_user_id as create_user_id,
		tbo.state_id as state_id,

		tbc.company_name as company_name,
		tbr.company_name as reseller' );

		$this->db->from ( 'tbl_order as tbo' );
		$this->db->join ( 'tbl_company as tbc', 'tbc.id = tbo.company_id' );
		$this->db->join ( 'tbl_reseller as tbr', 'tbr.id = tbo.reseller_id' );
		$this->db->order_by ( "tbc.company_name", "asc" );
		$this->db->where ( 'tbo.state_id !=4');

		if($value_name != "Show All")
		$this->db->where ( "tbo.$key_name", $value_name );



		if ($role_id == 0)
			{
				$this->db->where ( 'tbo.create_user_id', $user_id );
			}
			elseif ($role_id == 2)
			{
				$this->db->where_in('tbr.id', $reseller_ids);
			}


		$query = $this->db->get ();
		$user_orders = $query->result ();
		$data ['role_id'] = $role_id;
		$data ['user_orders'] = $user_orders;
		$data ['username'] = $session_data ['first_name'];

		$this->load->view ( 'home_view', $data );


   }
   function manageReseller()
		{
			$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];




			$data ['username'] = $session_data ['first_name'];
			$data ['role_id'] = $role_id;
			$data ['resellers'] = $this->search->resellers();

			$this->load->view ( 'manageReseller', $data );

		}
		function resellerEdit()
		{
		//var_dump($_POST);die;
		$password = md5($_POST ["reseller_admin_password"]);
			$data_reseller = array (
			'company_name' =>$_POST ["reseller_company_name"],
			'admin_email' =>$_POST ["reseller_admin_email"],
			'contact_name' =>$_POST ["reseller_contact_name"],
			'mail_email' =>$_POST ["reseller_email"],
			'phone_number' =>$_POST ["reseller_phone"],
			'address1' =>$_POST ["reseller_address1"],
			'address2' =>$_POST ["reseller_address2"],
			'county' =>$_POST ["reseller_county"],
			'country' =>$_POST ["reseller_country"],
			'web_address' =>$_POST ["reseller_weburl"],
			'town' =>$_POST ["reseller_town"],
			'post_code' =>$_POST ["reseller_post_code"],
			'logo_text' =>$_POST ["reseller_logo_name"],
			);
				$this->db->where ('id', $_POST ["reseller_id"]);
				if($this->db->update ( 'tbl_reseller', $data_reseller ))
				{


					redirect ( 'home/manageReseller', 'refresh' );

				}
				else
				{

					var_dump($this->db->_error_message());die;

				}

		}
function filterSearch()
{

			$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];
			$reseller ='';

			$reseller_ids = array();
			$comp_ids = array();

			$this -> db -> select('*');
			$this -> db -> from('tbl_file_info');
			$this -> db -> where('tbl_file_info.type_id !=0');
			$this -> db -> where('tbl_file_info.type_id !=1');
			$this -> db -> where('tbl_file_info.type_id !=2');
			$this -> db -> where('tbl_file_info.type_id !=3');
			$this -> db -> where('tbl_file_info.type_id !=6');
			$this -> db -> where('tbl_file_info.type_id !=7');
			$this -> db -> where('tbl_file_info.type_id !=8');
			//$this->db->group_by("tbl_file_info.company_id");
			$query_file_info = $this -> db -> get();
			$file_info_results =  $query_file_info->result();

			foreach($file_info_results as $file_info_result)
				{
					$comp_ids[] = $file_info_result->company_id;

				}


			//var_dump($user_id,$role_id);die();
			if($role_id == 2)
			{
				$resellers = $this->search->resellerUser($user_id);

					foreach($resellers as $reseller)
					{
						$reseller_ids [] = $reseller->id;
					}
			}
				//var_dump($reseller_ids);die;
				$this->db->select ( '*,tbl_order.id as id,tbl_order.company_id as company_id,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
				$this->db->from ( 'tbl_order' );
				$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );

				$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
				$this->db->order_by ( "tbl_company.company_name", "asc" );
				$this->db->where ( 'tbl_order.state_id !=4');
				$this->db->where ( 'tbl_reseller.state_id !=1');

			if ($role_id == 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $user_id );
			}
			elseif ($role_id == 2)
			{
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}




		if(isset($_POST['location_select']))
		{

			$location = $_POST['location_select'];
				if($location != 'Show All')
					$this->db->where ( 'tbl_order.location', $location );
		///die($_POST['location_select']);

		}
		elseif(isset($_POST["upload_change"]))
		{

				$Id_upload = $_POST["upload_change"];
				if($Id_upload != 'Show All')
					{

						if($Id_upload === "Upload")
						{
								if($comp_ids)
									$this->db->where_not_in('tbl_company.id', $comp_ids);

						}
						else
						{
							if($comp_ids)
								$this->db->where_in('tbl_company.id', $comp_ids);




						}
					}

		}

				$query = $this->db->get ();
				$user_orders = $query->result ();
				$data ['username'] = $session_data ['first_name'];
				$data ['user_orders'] = $user_orders;
				$data ['role_id'] = $role_id;
				$this->load->view ( 'home_view', $data );

	}
	
	
	function addAltEmail()
	{
				$session_data = $this->session->userdata ( 'logged_in' );
				$user_id = $session_data ['id'];
				$role_id = $session_data ['role_id'];
				$company_id = $_POST['company_id'];

		$emails = $this->search->alterEmails($company_id);
		if($emails)
		{
				$email_2 = $_POST['email_2'];
				$email_3 = $_POST['email_3'];
				$email_4 = $_POST['email_4'];

			$data_alt_emails = array (
			'company_id' => $company_id,
			'email_2' => $email_2,
			'email_3' => $email_3,
			'email_4' =>$email_4,
			'create_user_id' => $user_id,
			'create_time' => date ( 'Y-m-d h:i:s' )
			);
					$this->db->update ( 'tbl_alt_email', $data_alt_emails );


		}

		else{
		//var_dump($_POST);die;



				$email_2 = $_POST['email_2'];
				$email_3 = $_POST['email_3'];
				$email_4 = $_POST['email_4'];

			$data_alt_emails = array (
							'company_id' => $company_id,
							'email_2' => $email_2,
							'email_3' => $email_3,
							'email_4' =>$email_4,
							'create_user_id' => $user_id,
							'create_time' => date ( 'Y-m-d h:i:s' )
					);
					$this->db->insert ( 'tbl_alt_email', $data_alt_emails );

			}
	redirect ( 'home', 'refresh' );
	}
	public function download($file_name)
	{
		$this->load->helper('download'); //load helper
		$url = "./uploads/".$file_name;
		//$url = "./uploads/";
		$data = file_get_contents($url); // Read the file's contents

		$name = $file_name;

		force_download($name, $data);
	}
		public function mailRequestOriginal()
	{
			$data = $_POST['com_id'];
			$pieces = explode(",", $data);
			$company_id = '';
			$create_time = '';
			$type_id = '';
			$file_name = '';
			$file_id = '';
			for($a=0;$a<count($pieces);$a++)
			{
				$company_id = $pieces[0];
				$create_time = $pieces[1];
				$type_id = $pieces[2];
				$file_name = $pieces[3];
				$file_id = $pieces[4];


			}
			  $company_name =  $this->search->filterSearch($company_id)->company_name;

			$to = 'request@theregesteredoffice.com,aditi.tuffgeekers@gmail.com,madhurima.tuffgeekers@gmail.com,nicheformations121@gmail.com';
		//	$to = 'aditi.tuffgeekers@gmail.com,madhurima.tuffgeekers@gmail.com';
			$header = 'From: File Exchange<mail@theregisteredoffice.com>' . "\r\n";
			$header .= 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$subject = "File Exchange > Request Original";
			$new_msg = "<html>
				<head>
				   <title>The Registered Office</title>
				</head>
				<body>
					 <h3>You have a Request Original!</h3>
								<hr>
								Hello , 	<br><br>
										We're writing to let you know that you have a request original. <br><br>

				The message details of the request are:<br><br>

				Company Name : " . $company_name . "   <br><br>

				File Name : " . $file_name . "<br><br>

				Date of Request : " .  date("Y-m-d",strtotime($create_time)) . "<br><br>

				Time of Request :  " . date("h:i A",strtotime($create_time)) . "<br><br>

				Type :  " . $type_id . "<br><br>

				Best regards, <br><br>

				The Registered Office<br>
				The Admin Team	<br>

 				</body>
 				</html>";
		if(mail ( $to, $subject, $new_msg, $header ))
			{
			$req_time = date ( 'Y-m-d h:i:s' );
				$data= array (
				'state_id' => 1,
				'req_time' => $req_time
						);

						$this->db->where ( 'id', $file_id);
					if($this->db->update ( 'tbl_file_info', $data ))

						redirect ( 'home', 'refresh' );
					else
					var_dump( $this->db->_error_message ());die;

	}
		else
		{
				die("not done");
		}

	}
	 function message_according_id($id)
 {
	$id = $_POST['message_id'];
 	$this -> db -> select('*');
 	$this -> db -> from('tbl_message');
 	$this -> db -> where('tbl_message.id',$id);

 	$query = $this -> db -> get();
 	$message_company=  $query->row();
 	return $message_company->message;

 }
 function deleteRecord()
{
	$id = $_POST['record_id'];


	if($_POST['model'] == 'order_detail'){

		 	$this -> db -> select('*');
			$this -> db -> from('tbl_order_detail');
			$this -> db -> where('tbl_order_detail.id',$id);
			$query_order_detail = $this -> db -> get();
			$order_detail =  $query_order_detail->row();
			$order_summery_price = $order_detail->price;
			$order_summery_id = $order_detail->order_summery_id;

			$order_product = $order_detail->product;

			$package_value = $this->order->getOrders ($order_product);
			//	var_dump($order_product,$package_value);die;

			$this -> db -> select('*');
			$this -> db -> from('tbl_order');
			$this -> db -> where('tbl_order.id',$order_summery_id);

			$query_order = $this -> db -> get();
			$main_order =  $query_order->row();
			$order_price = $main_order->price;

			$price = $order_price - $order_summery_price;



		$this->db->where ( 'id', $id );
		if($this->db->delete ( 'tbl_order_detail' ))
		{
			if($package_value == 'complete_package')
			{
						$data = array(
										'price'=>$price,
										'registered_office' => 'No',
										'director_service_address' => 'No',
										'business_address' => 'No',
										'telephone_service' => 'No',
										'complete_package' => 'No',
										'hosting' => 'No'
							);
			}
			else
			{
						$data = array(
							'price'=>$price,
							$package_value => 'No'
							);
			}

			$this->db->where ( 'id', $order_summery_id );
			$this->db->update ( 'tbl_order', $data );

		}
	}
	elseif($_POST['model'] == 'reseller')
	{
		 	$this -> db -> select('*');
			$this -> db -> from('tbl_reseller');
			$this -> db -> where('tbl_reseller.id',$id);

			$query = $this -> db -> get();
			$message_company=  $query->row();

			$data = array(
			'state_id'=>1
			);


			$this->db->where ( 'id', $id );
				$this->db->update ( 'tbl_reseller', $data );

	}
			elseif($_POST['model'] == 'message')
		{
			$this->db->where ( 'id', $id );
			$this->db->delete ( 'tbl_message' );

		}
			elseif($_POST['model'] == 'file_mail')
		{

			$this -> db -> select('*');
			$this -> db -> from('tbl_file_info');
			$this -> db -> where('tbl_file_info.id',$id);

			$query = $this -> db -> get();
			$file_mail =  $query->row();
		//	var_dump($file_mail->file_name);die;
			if(unlink("./uploads/".$file_mail->file_name))
			{
				$this->db->where ( 'id', $id );
				$this->db->delete ( 'tbl_file_info' );
			}
			else
			{
				var_dump( $this->db->_error_message ());die;
			}



		}


	}
	function orderDetailUpdate()
{
			$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			if(isset($_POST["product_id"])){
			//die("ddff");
					$product_name	= $_POST["product_name"];
					$product_price	= $_POST ["product_price"];
					$product_quantity	= $_POST ["product_quantity"];
					$product_date	= date ( 'Y-m-d h:i:s',strtotime( $_POST ["product_date"]));
					$product_id	= $_POST ["product_id"];

				$data = array(
					'product' => $product_name,
					'price' => $product_price,
					'quantity' => $product_quantity,
					'create_time' => $product_date,
					'update_user_id' => $user_id

				);
						$this->db->where ( 'id', $product_id);
							if($this->db->update ( 'tbl_order_detail', $data ))

								redirect ( 'home', 'refresh' );
							else
							var_dump( $this->db->_error_message ());die;
							}
				redirect ( 'home', 'refresh' );

}
function xsl_upload() {
	$session_data = $this->session->userdata ( 'logged_in' );
	$user_id = $session_data ['id'];
	$role_id = $session_data ['role_id'];

	$time = time ();

		if (isset ( $_FILES ['userfile'] )) {
			//var_dump ( $_FILES );die;
			$userfiles = $_FILES ["userfile"];

			$this->load->library ( 'upload' );
			$files = $_FILES;
			$_FILES ['userfile'] ['name'] = $time . 'xsl' . $files ['userfile'] ['name'] [0];
			$_FILES ['userfile'] ['type'] = $files ['userfile'] ['type'] [0];
			$_FILES ['userfile'] ['tmp_name'] = $files ['userfile'] ['tmp_name'] [0];
			$_FILES ['userfile'] ['error'] = $files ['userfile'] ['error'] [0];
			$_FILES ['userfile'] ['size'] = $files ['userfile'] ['size'] [0];
			$configd ['file_name'] = $_FILES ['userfile'] ['name'];


			//	var_dump ($_FILES ['userfile'] ['name']);die;

			$this->upload->initialize ( $this->set_xsl_options () );
			if ($this->upload->do_upload ()) {
				$data = array (
						'upload_data' => $this->upload->data ()
				);
				$this->load->library ( 'excel' );
				$file = './uploads/xsl/' . $_FILES ['userfile'] ['name'];
				$objPHPExcel = PHPExcel_IOFactory::load ( $file );
				$allDataInSheet = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, true );

				$arrayCount = count ( $allDataInSheet );

			for($i = 2; $i <= $arrayCount; $i ++)
			{
				$getdata1 = $allDataInSheet [$i];
				$create_time = date("Y-m-d h:i:s");
				$d = str_replace("/","-",$getdata1['C']);
				$renewal =	date("Y-m-d h:i:s",strtotime($d)) ;


				$reseller = $this->search->getResellerId($getdata1['B']);

				//var_dump($reseller);die;


					$user = $this->search->userEmail($getdata1['AA']);
				

		$first_name = $getdata1['T'];
		$last_name =  $getdata1['U'];
		$email=$getdata1['AA'];
		$password = md5($getdata1['AE']);
		$ph_no = $getdata1['AB'];
		$mobile = $getdata1['AC'];
		$skpe_address = $getdata1['AD'];
		$street = $getdata1['V'];
		$city = $getdata1['W'];
		$counrty = $getdata1['Z'];
		$postcode = $getdata1['Y'];
		$county = $getdata1['X'];


					if(!$user)
					{
					
						$user_data = array(
								'first_name' => $first_name,
								'last_name' => $last_name,
								'email'=>$email,
								'password' => $password,
								'ph_no' => $ph_no,
								'mobile' => $mobile,
								'skpe_address' => $skpe_address,
								'street' => $street,
								'city' => $city,
								'counrty' => $counrty ,
								'postcode' => $postcode,
								'county' => $county,
								'role_id' => 0,
								'create_time' => $create_time
						);

						/*==============================User ===========================================================*/
						if($this->db->insert ( 'tbl_user', $user_data ))
						{

							//var_dump('tbl_user');
							$user_detail = $this->search->getUserCreateTime($create_time);

							/*======================================Mailing===============================================*/
							$mailling_data = array(
									'mailing_name' => $getdata1['N'],
									'street' =>  $getdata1['O'],
									'country'=>$getdata1['S'],
									'city' => $getdata1['P'],
									'postcode' => $getdata1['R'],
									'county' => $getdata1['Q'],
									'create_user_id' =>$user_detail->id,
									'create_time' => date("Y-m-d h:i:s")
							);
							if($this->db->insert ( 'tbl_mailling_address', $mailling_data ))
							{

								//var_dump('tbl_mailling_address');
								$mailling_detail = $this->search->getMaillingByTime($create_time);

								/*=========================================Billing================================================*/
								$billing_data = array(
									'billing_name' => $getdata1['N'],
									'street' =>  $getdata1['O'],
									'country'=>$getdata1['Q'],
									'city' => $getdata1['P'],
									'postcode' => $getdata1['R'],
									'county' => $getdata1['S'],
									'create_user_id' =>$user_detail->id,
									'create_time' => date("Y-m-d h:i:s")
								);
								if($this->db->insert ( 'tbl_billing_address', $billing_data ))
								{

									//var_dump('tbl_billing_address');
									$billing_detail = $this->search->getBillingByTime($create_time);

									/*=========================================Company================================================*/

									$company_data = array(
										'company_name' => $getdata1['A'],
										'location' => $getdata1['E'],
										'mailing_adress_id' => $mailling_detail->id,
										'billing_adress_id' => $billing_detail->id,
										'create_user_id' => $user_detail->id,
										'create_time' => date("Y-m-d h:i:s")
									);

									if($this->db->insert ( 'tbl_company', $company_data ))
									{
										//var_dump('tbl_company');
										$company_detail = $this->search->getCompanyByTime($create_time);


										/*==========================order===============================================================*/
										$order_data = array(
												'company_id' => $company_detail->id,
												'renewable_date'  => $renewal,
												'location'  => $getdata1['E'],
												'registered_office'=> $getdata1['F'],
												'director_service_address'=> $getdata1['G'],
												'business_address'=> $getdata1['H'],
												'telephone_service'=>$getdata1['I'],
												//'complete_package'=>$getdata1['J'],
												'hosting'=>$getdata1['J'],
												'deposit'=>$getdata1['K'],
												'price' => str_replace('£', '', $getdata1['L']),
												'quantity'  =>'1',
												'reseller_id'  => $reseller,
												'state_id' => '0',
												'create_user_id' => $user_detail->id,
												'create_time' => date("Y-m-d h:i:s")
										);

										if($this->db->insert ( 'tbl_order', $order_data ))
										{

											//var_dump('tbl_order');
											/*===========================order detail=====================================================*/

											$order_detail = $this->search->getOrderByTime($create_time);

											$order_detail_data = array(
													'order_summery_id' => $order_detail->id,
													'product' => 'Registered Office Address',
													'price' => str_replace('£', '', $getdata1['L']),
													'quantity' => '1',
													'total' => str_replace('£', '', $getdata1['L']),
													'create_user_id' => $user_detail->id,
													'create_time' => date("Y-m-d h:i:s")

											);
											if($this->db->insert ( 'tbl_order_detail', $order_detail_data ))
											{
												//var_dump('tbl_order_detail');
											}

											else
											  var_dump($this->db->_error_message());
										}
										else
											var_dump($this->db->_error_message());

									}
									else
										var_dump($this->db->_error_message());




								}
								else
								var_dump($this->db->_error_message());


							}
							else
								var_dump($this->db->_error_message());


						}
						else
							var_dump($this->db->_error_message());

					}

					else

					{
							/*======================================Mailing===============================================*/
							$mailling_data = array(
									'mailing_name' => $getdata1['N'],
									'street' =>  $getdata1['O'],
									'country'=>$getdata1['S'],
									'city' => $getdata1['P'],
									'postcode' => $getdata1['R'],
									'county' => $getdata1['Q'],
									'create_user_id' =>$user->id,
									'create_time' => date("Y-m-d h:i:s")
							);
							if($this->db->insert ( 'tbl_mailling_address', $mailling_data ))
							{

								//var_dump('tbl_mailling_address else',$mailling_data );die;
								$mailling_detail = $this->search->getMaillingByTime($create_time);

								/*=========================================Billing================================================*/
								$billing_data = array(
										'billing_name' => $getdata1['N'],
										'street' =>  $getdata1['O'],
										'country'=>$getdata1['Q'],
										'city' => $getdata1['P'],
										'postcode' => $getdata1['R'],
										'county' => $getdata1['S'],
										'create_user_id' =>$user->id,
										'create_time' => date("Y-m-d h:i:s")
								);
								if($this->db->insert ( 'tbl_billing_address', $billing_data ))
								{

									//var_dump('tbl_billing_address else');
									$billing_detail = $this->search->getBillingByTime($create_time);

									/*=========================================Company================================================*/

									$company_data = array(
											'company_name' => $getdata1['A'],
											'location' => $getdata1['E'],
											'mailing_adress_id' => $mailling_detail->id,
											'billing_adress_id' => $billing_detail->id,
											'create_user_id' =>$user->id,
											'create_time' => date("Y-m-d h:i:s")
									);

									if($this->db->insert ( 'tbl_company', $company_data ))
									{
									//	var_dump('tbl_company else');
										$company_detail = $this->search->getCompanyByTime($create_time);


										/*==========================order===============================================================*/
										$order_data = array(
												'company_id' => $company_detail->id,
												'renewable_date'  => $renewal,
												'location'  => $getdata1['E'],
												'registered_office'=> $getdata1['F'],
												'director_service_address'=> $getdata1['G'],
												'business_address'=> $getdata1['H'],
												'telephone_service'=>$getdata1['I'],
												//'complete_package'=>$getdata1['J'],
												'hosting'=>$getdata1['J'],
												'deposit'=>$getdata1['K'],
												'price'  => str_replace('£', '', $getdata1['L']),
												'quantity'  =>'1',
												'reseller_id'  => $reseller,
												'state_id' => '0',
												'create_user_id' =>$user->id,
												'create_time' => date("Y-m-d h:i:s")
										);

										if($this->db->insert ( 'tbl_order', $order_data ))
										{

											//var_dump('tbl_order else');
											/*===========================order detail=====================================================*/

											$order_detail = $this->search->getOrderByTime($create_time);

											$order_detail_data = array(
													'order_summery_id' => $order_detail->id,
													'product' => 'Registered Office Address',
													'price' => str_replace('£', '', $getdata1['L']),
													'quantity' => '1',
													'total' => str_replace('£', '', $getdata1['L']),
													'create_user_id' =>$user->id,
													'create_time' => date("Y-m-d h:i:s")

											);
											//var_dump($order_detail,$order_detail_data);die;
											if($this->db->insert ( 'tbl_order_detail', $order_detail_data ))
											{
												//var_dump('tbl_order_detail else');

											}
											else
											{
												var_dump($this->db->_error_message());die;
											}
										}
										else
										{
											var_dump($this->db->_error_message());die;
										}

									}
									else
									{
										var_dump($this->db->_error_message());die;
									}



								}
								else
								{
									var_dump($this->db->_error_message());die;
								}


							}
							else
							{
								var_dump($this->db->_error_message());die;
							}

					}
					

				}
				redirect ( 'home', 'refresh' );
			}else {
				$error = array (
						'error' => $this->upload->display_errors ()
				);
				echo "Please upload file";
				die ();
			}redirect ( 'home', 'refresh' );
		}
			$data ['role_id'] = $role_id;
			$this->load->view ( 'xsl', $data );
		//$this->load->view('xsl');
	}
	public function location()
{
	$id = $_POST["id"];

	$this -> db -> select('*');
	$this -> db -> from('tbl_order');
	$this -> db -> where('tbl_order.id',$id);

	$query = $this -> db -> get();
	$order =  $query->row();
	echo $order->location;

}
public function ExportExcel($order)
{

			$this->db->select ('*,tbl_order.id as id,tbl_order.company_id as company_id,
				tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id,
				tbl_company.company_name as company_name , tbl_reseller.company_name as reseller');
			$this->db->from ( 'tbl_order' );
			$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
			$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
			$this->db->order_by ( "tbl_company.company_name", "asc" );
			$query = $this->db->get ();
			$user_orders = $query->result ();
			if($order)
			$user_orders = $order;
			else
			
			
			$data ['user_orders'] = $user_orders;
			$this->load->view('spreadsheet_view',$data);

}
public function filterExportExcel()
{

	$str_var = $_POST["str_var"];
	$array_var = unserialize(base64_decode($str_var));
	//print_r($array_var);
	 if(empty($array_var)){
	

		if ($this->session->userdata ( 'logged_in' )) {

			$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];
			$reseller ='';
			$reseller_ids = array();
			//var_dump($user_id,$role_id);die();
			if($role_id == 2)
			{
				$resellers = $this->search->resellerUser($user_id);

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

			if ($role_id == 0)
			{
				$this->db->where ( 'tbl_order.create_user_id', $user_id );
			}
			elseif ($role_id == 2)
			{
				$this->db->where_in('tbl_reseller.id', $reseller_ids);
			}


			$query = $this->db->get ();
			$user_orders = $query->result ();

			$data ['username'] = $session_data ['first_name'];
			$data ['user_orders'] = $user_orders;
			$data ['role_id'] = $role_id;
			//print_r($data);
			$this->load->view ( 'spreadsheet_view', $data );
		} else {
			// If no session, redirect to login page
			redirect ( 'login', 'refresh' );
		}
	
	 }else{
		$data['user_orders'] = $array_var;		
		$this->load->view('spreadsheet_view',$data);
	 }
}


public function renewalRecords()
{
	$session_data = $this->session->userdata ( 'logged_in' );
	$user_id = $session_data ['id'];
	$role_id = $session_data ['role_id'];

	/*$this->db->select ( '*,tbl_order.id as id,tbl_order.create_time as create_time,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
		$this->db->from ( 'tbl_order' );
		$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
		$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
		$this->db->order_by ( "tbl_company.company_name", "asc" );*/


	$reseller ='';
	$reseller_ids = array();
	$resellers = $this->search->resellerUser($user_id);
	//var_dump($resellers);die;
		if($role_id == 2)
		{
			if($resellers){

				foreach($resellers as $reseller)
				{
					$reseller_ids [] = $reseller->id;
				}
			}
		}

		$this->db->select ( '*,tbl_order.id as id,tbl_order.create_time as create_time,tbl_order.create_user_id as create_user_id ,tbl_order.state_id as state_id, tbl_company.company_name as company_name , tbl_reseller.company_name as reseller' );
		$this->db->from ( 'tbl_order' );
		$this->db->join ( 'tbl_company', 'tbl_company.id=tbl_order.company_id' );
		$this->db->join ( 'tbl_reseller', 'tbl_reseller.id=tbl_order.reseller_id' );
		$this->db->where ( 'tbl_order.state_id !=4');
		$this->db->order_by ( "tbl_company.company_name", "asc" );
		$from = date('Y-m-d',strtotime($_POST["renew_company_from"]));
		$to = date('Y-m-d h:i:s',strtotime( $_POST["renew_company_to"]." 00:00:00"));
        //$from = date('Y-m-d',strtotime($_POST["renew_company_from"]));
    	//$to = date('Y-m-d',strtotime( $_POST["renew_company_to"]));

		// var_dump($_POST);die;



		$this->db->where('tbl_order.renewable_date >=', $from);
		$this->db->where('tbl_order.renewable_date <=', $to);
		//$this->db->where("tbl_order.renewable_date BETWEEN $from AND $to");

		//var_dump($this->db->last_query());die;

		if ($role_id == 0)
		{
			$this->db->where ( 'tbl_order.create_user_id', $user_id );
		}
		elseif ($role_id == 2)
		{	
			if($resellers)
			$this->db->where_in('tbl_reseller.id', $reseller_ids);
		}



		$query = $this->db->get ();
		$user_orders = $query->result();

		$data ['role_id'] = $role_id;
		$data ['user_orders'] = $user_orders;
		$data ['username'] = $session_data ['first_name'];
		$this->load->view ( 'home_view', $data );


}
public function delete_row()
 {
 $order_id = $_POST ['delete_order_id'];
 
    
  $data = array(
    'state_id' => 4
  );
  $this->db->where ( 'id', $order_id);
  $this->db->update ( 'tbl_order', $data );
 
   redirect ( 'home', 'refresh' );
 
  

 }
 public function addOrder()
	{
				$session_data = $this->session->userdata ( 'logged_in' );
				$user_id = $session_data ['id'];
		   if(isset($_POST)){


			   $data_order =array();

			   $data= urldecode($_POST['user_services']);
			   $field_id = $_POST['order_id'];
				$pieces = explode("&", $data);
				for($a=0;$a<count($pieces);$a++)
				{
					$profile_key=strstr($pieces[$a],"=",true);
					$profile[$profile_key] = substr(strstr($pieces[$a],"="),1);

				}


				$old_order_id = $profile['add_order_id'];
				$package_name = $profile ['service_name'];
				$amount = $profile ['amount'];
				$package_value = $this->order->getOrders ($package_name,$field_id);
				$quantity = $profile ['service_quantity'];


				$this->db->select ( '*');
				$this->db->from ( 'tbl_order' );
					$this->db->where ( 'tbl_order.id', $old_order_id  );
					$query = $this->db->get ();
					$user_order = $query->row();
					$old_price = $user_order->price;
					$new_price = $old_price + $amount;



				if($package_value != "both" && $package_value != "complete_package" && $package_value != "deposit" &&  $package_value != "partner")
				{

					$data_order = array (
							$package_value => 'Yes' ,
							'price'=>$new_price,
							'create_user_id' => $user_order->create_user_id,
							'update_user_id' => $user_id
					);
				}
				elseif($package_value == "both")
				{
					$data_order = array (
							'registered_office' => 'Yes' ,
							'director_service_address' => 'Yes',
							'price'=>$new_price,
								'create_user_id' => $user_order->create_user_id,
								'update_user_id' => $user_id
					);

				}
				elseif($package_value == "partner")
				{
					$data_order = array (
							'registered_office' => 'Yes' ,
							'director_service_address' => 'Yes',
							'business_address' => 'Yes',
							'price'=>$new_price,
								'create_user_id' => $user_order->create_user_id,
								'update_user_id' => $user_id
					);

				}
				elseif($package_value == "complete_package")
				{
					$data_order = array (
								'registered_office' => 'Yes' ,
								'director_service_address' => 'Yes',
								'business_address' => 'Yes',
								'telephone_service' => 'Yes',
								'complete_package' => 'Yes',
								'hosting' => 'Yes',
								'price'=>$new_price,
								'create_user_id' => $user_order->create_user_id,
								'update_user_id' => $user_id

						);
				}
				elseif($package_value == "deposit")
				{
					$data_order = array (
								'deposit' => $amount,
								'price'=>$new_price,
									'create_user_id' => $user_order->create_user_id,
									'update_user_id' => $user_id
						);
				}
				$this->db->where ( 'id', $old_order_id );
				if($this->db->update ( 'tbl_order', $data_order ))
				{


				$product = trim($package_name, $field_id);

					$data_order_details = array (
							'order_summery_id' => $old_order_id,
							'product' => $product,
							'price' => $amount,
							'quantity' => $quantity,
							'total' => $new_price,
							'create_user_id' => $user_order->create_user_id,
							'update_user_id' => $user_id,
							'create_time' => date ( 'Y-m-d h:i:s' )
					);
					if($this->db->insert ( 'tbl_order_detail', $data_order_details ))
						{ echo "1";}
					else
						{ //echo "not done";
						}
					}

		}
				redirect ( 'home', 'refresh' );

	}
	function reseller() {

			$session_data = $this->session->userdata ( 'logged_in' );
			$user_id = $session_data ['id'];
			$role_id = $session_data ['role_id'];
			$email = $_POST ["reseller_email"];


		if (! empty ( $_POST )) {


			$company_name = $_POST ["reseller_company_name"];
			$contact_name = $_POST ["reseller_contact_name"];
			$mail_email = $email;
			$phone_number = $_POST ["reseller_phone"];
			$address1 = $_POST ["reseller_address1"];
			$address2 = $_POST ["reseller_address2"];
			$county = $_POST ["reseller_county"];
			$post_code = $_POST ["reseller_post_code"];
			$web_address = $_POST ["reseller_weburl"];
			$admin_email = $_POST ["reseller_admin_email"];
			$town = $_POST ["reseller_town"];
			$country = $_POST ["reseller_country"];
			$logo_text = $_POST ["reseller_logo_name"];
			$user_id = $user_data->id;
			$create_user_id = $user_id;
			$create_time = date ( 'Y-m-d h:i:s' ) ;
			$password = md5($_POST["reseller_admin_password"]);

			if($admin_email ="")
			{
				$admin_email = $mail_email;
			}
			else
			{
			$admin_email = $_POST ["reseller_admin_email"];
			}

			$user_data = $this->search->resellerEmail($email);
			if($user_data)
			{
				$data = array (
					'role_id' => "2",
					'password' => $password
			);

			$this->db->where ( 'id', $user_data->id );
			if($this->db->update ( 'tbl_user', $data ))
			{


				$data_reseller = array (
						'company_name' => $company_name,
						'contact_name' => $contact_name,
						'mail_email' => $mail_email,
						'phone_number' => $phone_number,
						'address1' => $address1,
						'address2' => $address2,
						'county' => $county,
						'post_code' => $post_code,
						'web_address' => $web_address,
						'admin_email' => $admin_email,
						'town' => $town,
						'country' => $country,
						'logo_text' => $logo_text,
						'user_id' => $user_data->id,
						'create_user_id' => $create_user_id,
						'create_time' => $create_time
				);
				$this->db->insert ( 'tbl_reseller', $data_reseller );

			  }
			  else
			  {
					var_dump($this->db->_error_message());die;

			  }


			}
			else
			{
				$data_user = array(
					'first_name' => $contact_name,
					'email' => $mail_email,
					'password' => $password,
					'ph_no' => $phone_number,
					'street' => $address1,
					'city' => $town,
					'counrty' => $country,
					'postcode'=> $post_code,
					'county' => $county,
					'role_id' => '2',
					'state_id' => '1',
					'create_user_id' => $user_id,
					'create_time' => $create_time	/*	*/
					);

					if($this->db->insert ( 'tbl_user', $data_user ))
					{

						$user_data = $this->search->resellerEmail($mail_email);
							$data_reseller = array (
									'company_name' => $company_name,
									'contact_name' => $contact_name,
									'mail_email' => $mail_email,
									'phone_number' => $phone_number,
									'address1' => $address1,
									'address2' => $address2,
									'county' => $county,
									'post_code' => $post_code,
									'web_address' => $web_address,
									'admin_email' => $admin_email,
									'town' => $town,
									'country' => $country,
									'logo_text' => $logo_text,
									'user_id' => $user_data->id,
									'create_user_id' => $create_user_id,
									'create_time' => $create_time
							);
				if($this->db->insert ( 'tbl_reseller', $data_reseller ))
					{
							redirect ( 'home', 'refresh' );


					}
				else
					{
						var_dump($this->db->_error_message());die;
					}

					}

					else
					{
						var_dump($this->db->_error_message());die;
					}

			}



		}

		$data ['username'] = $session_data ['first_name'];
			$data ['user_orders'] = $user_orders;
			$data ['role_id'] = $role_id;
			//var_dump($data ['role_id']);die;
			$this->load->view ( 'reseller', $data );

		//$this->load->view ( 'reseller' );
	}
}

?>