<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->model('UserModel');
	}

	public function index()
	{
		$data=array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$this->load->view('loginUser', $data);
	}

	public function dashboard()
	{
		$data=array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['ticketData'] = $this->UserModel->getAllTickets();
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('/UserController/index', 'refresh');
		}
		//$data['userDetails'] = $this->UserModel->getUserName();
		
		$this->load->view('userHome', $data);
	}

	public function loadNotifs(){
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$notifData = $this->UserModel->getNotification($userID);
		echo json_encode($notifData, JSON_PRETTY_PRINT);
	}

	public function loadFeedbackNotifs(){
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$notifData = $this->UserModel->getFeedbackNotification($userID);
		echo json_encode($notifData, JSON_PRETTY_PRINT);
	}

	public function viewNotifs($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$userID = $this->UserModel->getTicketById($ticketID);
		$data['userDetails'] = $this->UserModel->getUserById($userID[0]['userID']);
		$data['notifData'] = $this->UserModel->viewNotification($ticketID);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('/UserController/index', 'refresh');
		}
		
		$this->load->view('detailTicket', $data);
	}

	public function viewFeedbackNotifs($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$userID = $this->UserModel->getTicketById($ticketID);
		$data['userDetails'] = $this->UserModel->getUserById($userID[0]['userID']);
		$data['notifData'] = $this->UserModel->viewFeedbackNotification($ticketID);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('/UserController/index', 'refresh');
		}
		
		$this->load->view('detailTicket', $data);
	}

	public function myTickets($userID){
		$data=array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['ticketData'] = $this->UserModel->getTicketByUserId($userID);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('UserController/index', 'refresh');
		}
		//$data['userDetails'] = $this->UserModel->getUserById($userID);
		
		$this->load->view('myTickets', $data);
	}

	public function ticketActions($ticketID){
		$data=array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$data['changelog'] = $this->UserModel->getChangelog($ticketID);
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$data['userDetails'] = $this->UserModel->getUserById($userID);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('UserController/index', 'refresh');
		}
		
		$this->load->view('ticketActions', $data);
	}

	public function userLogin()
	{
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

		$loginData = array(
			'userName' => $this->input->post('username'),
			'userPassword' => md5($this->input->post('password'))
		);
		$result = $this->UserModel->userLogin($loginData);

		if($result==true){
					$userName = $this->input->post('username');
					$result = $this->UserModel->getUserInfo($userName);
					$sessionData = array(
						'userID' => $result[0]['userID'],
						'userName' => $result[0]['userName'],
						'userEmail' => $result[0]['userEmail'],
						'userLevel' => $result[0]['userLevel'],
						'isLoggedIn' => true
						);

					$this->session->set_userdata('isUserLoggedIn', $sessionData);
					$loggedInUser = $sessionData;	
					$data['loggedInUser'] = $sessionData;
					$data['ticketData'] = $this->UserModel->getAllTickets();
					
					//$data['userDetails'] = $this->UserModel->getUserName();
					//$data['userDetails'] = $this->UserModel->getUserById($result[0]['userID']);
					//$data['success_msg'] = 'Welcome, '.$result[0]->customerUsername.'!';
					if($result[0]['userLevel'] == 2){
						$this->load->helper('cookie');
						$cookie = array(
							'name'   => 'user_session',
							'expire' => '7200',
							'domain' => '/',
							'path'   => '/',
							'prefix' => 'user',
							'secure' => TRUE
						);
						$this->input->set_cookie($cookie);
						//var_dump($cookie);
						$this->load->view('userHome', $data);
					}
					elseif($result[0]['userLevel'] == 1){
						$this->load->helper('cookie');
						$cookie = array(
							'name'   => 'spv_session',
							'expire' => '7200',
							'domain' => '/',
							'path'   => '/',
							'prefix' => 'spv',
							'secure' => TRUE
						);
						$this->input->set_cookie($cookie);
						//var_dump($cookie);
						$this->load->view('spvHome', $data);
					}
					elseif($result[0]['userLevel'] == 0){
						$this->load->helper('cookie');
						$cookie = array(
							'name'   => 'admin_session',
							'expire' => '7200',
							'domain' => '/',
							'path'   => '/',
							'prefix' => 'admin',
							'secure' => TRUE
						);
						$this->input->set_cookie($cookie);
						//var_dump($cookie);
						$this->load->view('adminDashboard', $data);
					}
					
		}
		else if($result==false){
				$data['error_msg'] = 'Invalid username/password.';
				$this->load->view('loginUser', $data);
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('isUserLoggedIn');
        $this->session->sess_destroy();
        redirect('UserController/index', 'refresh');
	}

	public function ticketDetails($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$userID = $this->UserModel->getTicketById($ticketID);
		$data['userDetails'] = $this->UserModel->getUserById($userID[0]['userID']);
		if($this->session->userdata['isUserLoggedIn']['isLoggedIn'] !=true ){
			redirect('UserController/index', 'refresh');
		}
		
		$this->load->view('detailTicket', $data);
	}

	public function takeTicket($ticketID){
		
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$ticketData = $this->UserModel->getTicketById($ticketID);
		$result = $this->UserModel->handleTicket($ticketData, $userID);
		

		if($result==true){
			$this->session->set_flashdata('success','Ticket added to your Ticket List.');
			redirect('UserController/ticketDetails/'.$ticketID);
		}
	}

	public function updateTicket($ticketID){
		
		
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];

		date_default_timezone_set('Asia/Jakarta'); 	
		$date = date('Y-m-d H:i:s');
		
		$emailDetails = $this->UserModel->getTicketById($ticketID);
		$ticketData = array(
			
			'status' => $this->input->post('status'),
			'dateUpdated' => $date
		);
		$changelogData = array(
			'ticketID' => $ticketID,
			'userID' => $userID,
			'status' => $this->input->post('status'),
			'description' => $this->input->post('changes')
		);
		$emailData = array(
			'token' => $emailDetails[0]['token'],
			'ticketTitle' => $emailDetails[0]['ticketTitle'],
			'customerName' => $emailDetails[0]['customerName'],
			'customerEmail' => $emailDetails[0]['customerEmail'],
			'customerPhone' => $emailDetails[0]['customerPhone'],
			'productName' => $emailDetails[0]['productName'],
			'inquiryType' => $emailDetails[0]['inquiryType'],
			'description' => $emailDetails[0]['description']
		);
		
		$result = $this->UserModel->updateTicket($ticketData, $changelogData, $emailData, $ticketID);

		if($result == true){
			$this->session->set_flashdata('success','Ticket and changelog has been updated, update e-mail has been sent');
			
			redirect('UserController/ticketActions/'.$ticketID);
		}
		else{
			$this->session->set_flashdata('fail','Something went wrong');
			redirect('UserController/ticketActions/'.$ticketID);
		}
	}
}
