<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('email');
		
		$this->load->model('CustomerModel');

		$this->load->helper('cookie');
		
	}

	public function index()
	{
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$this->load->view('loginClient', $data);
	}

    public function dashboard()
	{
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		//$customerID = $this->session->userdata['isUserLoggedIn']['customerID'];
		//$data['products'] = $this->CustomerModel->getProducts($customerID);
			if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
				redirect('/Main/index', 'refresh');
			}
		$this->load->view('dashboard', $data);
	}

	public function homepage()
	{
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$companyID = $this->session->userdata['isUserLoggedIn']['companyID'];
		$data['products'] = $this->CustomerModel->getProducts($companyID);
			if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
				redirect('/Main/index', 'refresh');
			}
		$this->load->view('home', $data);
	}

	public function forgetPassword()
	{
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$this->load->view('forgetPassword', $data);
	}

	public function profile($id){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['profileData'] = $this->CustomerModel->getCustomerById($id);
		$data['ticketData'] = $this->CustomerModel->getCustomerTickets($id);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('/Main/index', 'refresh');
		}
		$this->load->view('customerProfile', $data);
	}

	public function contactUs(){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('/Main/index', 'refresh');
		}
		$this->load->view('contactUs', $data);
	}

	public function landingPage(){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		
		$this->load->view('landingPage', $data);
	}

	public function loginCustomer()
	{
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);

		if($this->session->userdata('success_msg')){
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}
		if($this->session->userdata('error_msg')){
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}

		/*if(isset($this->session->userdata['isUserLoggedIn'])){
			$this->load->view('home', $data);
		}else{
			$this->load->view('loginClient', $data);
		}*/

		$loginData = array(
			'customerEmail' => $this->input->post('email'),
			'customerPassword' => md5($this->input->post('password'))
		);
		$result = $this->CustomerModel->customerLogin($loginData);

		if($result==true){
			$custEmail = $this->input->post('email');
					$result = $this->CustomerModel->getCustomerInfo($custEmail);
					$sessionData = array(
						'customerID' => $result[0]->customerID,
						'customerUsername' => $result[0]->customerUsername,
						'customerEmail' => $result[0]->customerEmail,
						'customerPhone' => $result[0]->customerPhone,
						'companyID' => $result[0]->companyID,
						'isLoggedIn' => true
						);

					$this->session->set_userdata('isUserLoggedIn', $sessionData);
					
					$cookie = array(
						'name'   => 'customer_session',
						'expire' => '7200',
						'domain' => '/',
						'path'   => '/',
						'prefix' => 'customer',
						'secure' => TRUE
					);
					$this->input->set_cookie($cookie);
					//var_dump($cookie);
					$data['products'] = $this->CustomerModel->getProducts($result[0]->customerID);
					//$data['success_msg'] = 'Welcome, '.$result[0]->customerUsername.'!';
					$this->load->view('dashboard', $data);
		}
		else if($result==false){
				$data['error_msg'] = 'Invalid username/password.';
				$this->load->view('loginClient', $data);
		}

		
	}

	public function logout()
	{
		
		$this->session->unset_userdata('isUserLoggedIn');
        $this->session->sess_destroy();
        redirect('Main/index', 'refresh');
	}

	public function recoverPassword()
	{	

		$custEmail = $this->input->post('email');
		$result = $this->CustomerModel->getEmail($custEmail);

		if($result==true){
			$this->CustomerModel->updatePassword($custEmail);
			$this->session->set_flashdata('success','An e-mail containing your new password has been sent to '.$custEmail.'.');
			redirect('Main/forgetPassword');
			
		}
		else{
			$this->session->set_flashdata('fail','Entered e-mail does not exist.');
			redirect('Main/forgetPassword');
		}

	}

	public function changePassword($id){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['passData'] = $this->CustomerModel->getCustomerById($id);

		$this->form_validation->set_rules('newPass', 'Password', 'required');
		$this->form_validation->set_rules('confirmPass', 'confirm password', 'required|matches[newPass]');

		if($this->form_validation->run() == FALSE){
			$data['error_msg'] = "New password does not match";
			$this->load->view('changePassword', $data);
		}
		else{
			$currentPass = $this->input->post('oldPass');
			$newPass = $this->input->post('newPass');
			
			$result = $this->CustomerModel->changePassword($currentPass, $newPass, $id);

			if($result==true){
				$data['success_msg'] = 'Your password has been changed';
				//echo $currentPass, $newPass, $id;
				$this->load->view('changePassword', $data);
			}
			else{
				$data['error_msg'] = 'Old password is incorrect';
				$this->load->view('changePassword', $data);
			}
		}
		
	}

	public function addNewTicket()
	{
		$id = $this->session->userdata['isUserLoggedIn']['customerID'];
		$email =  $this->session->userdata['isUserLoggedIn']['customerEmail'];
		//mkdir('./uploads/'.$email); <--buat di back end saat add user
		//$this->ftp->mirror('/path/to/myfolder/', '/www/uploads/');
		$target_dir =  'http://127.0.0.1/uploads/'.$email;
		$config['upload_path']          =  $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$email;
		$config['allowed_types']        = 'gif|jpg|png';
		$config['remove_spaces']		= 'TRUE';

		$this->load->library('upload', $config);

		    if (!$this->upload->do_upload('picture'))
                {
					$data['error'] = 'Error';
                    //$this->load->view('landingPage', $error); 
                }
                else
                {
					$data['success'] = 'Success';
                   // $this->load->view('landingPage', $success); 
                }
                
				$uploadData = $this->upload->data();

				/*$fileName = $uploadData['file_name'];

				$fileSource = $email.'/'.$fileName;
				if(file_exists($fileSource)){
					echo "Ayy Lmao";
				}
				$this->load->library('ftp');

				$ftp_config['hostname'] = '127.0.0.1'; 
				$ftp_config['username'] = 'root';
				$ftp_config['password'] = '';
				$ftp_config['debug']    = TRUE;

				$this->ftp->connect($ftp_config);

				$fileDestination = '/uploads/'.$email;

				$this->ftp->upload($fileSource, ".".$fileDestination);*/

    				$data = array(
    					'token' => rand(100,99999),
    					'customerID' => $id,
    					'status' => 1,
    					'customerName' => $this->input->post('name'),
    					'customerEmail' => $this->input->post('email'),
    					'customerPhone' => $this->input->post('phone'),
    					'ticketTitle' => $this->input->post('title'),
    					'productName' => $this->input->post('product'),
    					'inquiryType' => $this->input->post('inquiry'),
    					'urgency' => $this->input->post('urgency'),
    		
    					'description' => $this->input->post('descriptiontext'),
    					'picturePath' => $target_dir.'/'.$uploadData['file_name']
    				);
    		
    				$result = $this->CustomerModel->insertNewTicket($data, $email);
    				if($result==true){
    					
    					$this->session->set_flashdata('success','Your Ticket has been submitted.');
    					redirect('Main/landingPage');
    				}
                

				//$this->ftp->close();		
	}

	public function ticketDetails($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->CustomerModel->getTicketById($ticketID);
		$data['changelog'] = $this->CustomerModel->getChangelog($ticketID);
		$adminID = $this->CustomerModel->getTicketById($ticketID);
		$data['adminDetails'] = $this->CustomerModel->getAdminInfo($adminID[0]['userID']);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('/Main/homepage');
		}
		
		$this->load->view('ticketDetails', $data);
	}

	public function addFeedback($ticketID){
		$feedback = array(
			'approved' => $this->input->post("feedRadio"),
			'feedback' => $this->input->post("feedbackText"),
			'feedbackNotifSeen' => 0
		);

		$result = $this->CustomerModel->insertFeedback($feedback, $ticketID);

		$emailData = $this->CustomerModel->getTicketById($ticketID);

		if($feedback['approved']==0 && $result == true){

			date_default_timezone_set('Asia/Jakarta'); 
            $date = date('Y/m/d H:i:s');

            $subject = "Your Ticket Feedback";

			$message = "
        			<html>
        			<head>
        				<title>Your New Password</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$emailData[0]['customerName']."
        				<br><p>On ".$date." , Based on the feedback for the following support ticket: <br>
						<ul>
                            <li>
                                Ticket ID/Token     : ".$emailData[0]['token']."
                            </li>
                            <li>
                                Ticket Title/General Idea     : ".$emailData[0]['ticketTitle']."
                            </li>
                            <li>
                                Contact Name        : ".$emailData[0]['customerName']."
                            </li>
                            <li>
                                Contact E-mail      : ".$emailData[0]['customerEmail']."
                            </li>
                            <li>
                                Phone no.           : ".$emailData[0]['customerPhone']."
                            </li>
                            <li>
                                Regarding Product   : ".$emailData[0]['productName']."
                            </li>
                            <li>
                                Inquiry Type        : ".$emailData[0]['inquiryType']."
                            </li>
                           
                            <li>
                                Description         : ".$emailData[0]['description']."
                            </li>
                        </ul>
                        <br>
						<p>You indicated that the changes made were not satisfactory. Our employees will continue to work on the problem(s), and your ticket's status will be reopened.</p>
						<p>If you have a moment, please fill our customer satisfaction survey at: https://forms.gle/ECnbFYVAyeLSYmSh7 </p>
        				<p>Regards,</p>

        				<p>PT MMG Support</p>
        				
        			</div>
        		</body>
				</html>";
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'kennethfilbert343@gmail.com',
					'smtp_pass' => 'HAUNtings',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
					);
		
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
		
				$this->email->to($emailData[0]['customerEmail']);
				$this->email->from('support@mmg.com','Mitra Mentari Global');
				$this->email->subject($subject);
				$this->email->message($message);
		
						//Send email
				$this->email->send();
				$this->load->library('encrypt');

			$this->session->set_flashdata('success','Your feedback has been submitted. Please check your e-mail.');
			
		}
		elseif($feedback['approved']==1 && $result == true){

			date_default_timezone_set('Asia/Jakarta'); 
            $date = date('Y/m/d H:i:s');

            $subject = "Your Ticket Feedback";

			$message = "
        			<html>
        			<head>
        				<title>Your New Password</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$emailData[0]['customerName']."
        				<br><p>On ".$date." , Based on the feedback for the following support ticket: <br>
						<ul>
                            <li>
                                Ticket ID/Token     : ".$emailData[0]['token']."
                            </li>
                            <li>
                                Ticket Title/General Idea     : ".$emailData[0]['ticketTitle']."
                            </li>
                            <li>
                                Contact Name        : ".$emailData[0]['customerName']."
                            </li>
                            <li>
                                Contact E-mail      : ".$emailData[0]['customerEmail']."
                            </li>
                            <li>
                                Phone no.           : ".$emailData[0]['customerPhone']."
                            </li>
                            <li>
                                Regarding Product   : ".$emailData[0]['productName']."
                            </li>
                            <li>
                                Inquiry Type        : ".$emailData[0]['inquiryType']."
                            </li>
                           
                            <li>
                                Description         : ".$emailData[0]['description']."
                            </li>
                        </ul>
                        <br>
						<p>You indicated that the changes made were to your satisfaction. Your ticket's status is now closed. Thank you for using this system.</p>
						<p>If you have a moment, please fill our customer satisfaction survey at: https://forms.gle/ECnbFYVAyeLSYmSh7 </p>
        				<p>Regards,</p>

        				<p>PT MMG Support</p>
        				
        			</div>
        		</body>
				</html>";
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'kennethfilbert343@gmail.com',
					'smtp_pass' => 'HAUNtings',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
					);
		
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
		
				$this->email->to($emailData[0]['customerEmail']);
				$this->email->from('support@mmg.com','Mitra Mentari Global');
				$this->email->subject($subject);
				$this->email->message($message);
		
						//Send email
				$this->email->send();
				$this->load->library('encrypt');

			$this->session->set_flashdata('success','Thank you for your feedback. Please check your e-mail.');
			
		}
		
		redirect('Main/ticketDetails/'.$ticketID);
	}

}

?>
