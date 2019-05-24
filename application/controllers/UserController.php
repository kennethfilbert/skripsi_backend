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
	
		//$data['userDetails'] = $this->UserModel->getUserName();
		
		$this->load->view('home', $data);
	}

	public function loadNotifs(){
		$notifData = $this->UserModel->getNotification();
		echo json_encode($notifData, JSON_PRETTY_PRINT);
	}

	public function viewNotifs($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		//$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		//$data['userDetails'] = $this->UserModel->getUserById($userID);
		$data['notifData'] = $this->UserModel->viewNotification($ticketID);
		
		$this->load->view('detailTicket', $data);
	}

	public function myTickets($userID){
		$data=array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['ticketData'] = $this->UserModel->getTicketByUserId($userID);
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
						'isLoggedId' => true
						);

					$this->session->set_userdata('isUserLoggedIn', $sessionData);
					$loggedInUser = $sessionData;	
					$data['loggedInUser'] = $sessionData;
					$data['ticketData'] = $this->UserModel->getAllTickets();
					//$data['userDetails'] = $this->UserModel->getUserName();
					//$data['userDetails'] = $this->UserModel->getUserById($result[0]['userID']);
					//$data['success_msg'] = 'Welcome, '.$result[0]->customerUsername.'!';
					if($result[0]['userLevel'] == 2){
						$this->load->view('home', $data);
					}
					elseif($result[0]['userLevel'] == 1){
						$this->load->view('spvHome', $data);
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
        redirect(base_url(), 'refresh');
	}

	public function ticketDetails($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$userID = $this->UserModel->getTicketById($ticketID);
		$data['userDetails'] = $this->UserModel->getUserById($userID[0]['userID']);
		
		$this->load->view('detailTicket', $data);
	}

	public function takeTicket($ticketID){
		
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$result = $this->UserModel->handleTicket($ticketID, $userID);

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
