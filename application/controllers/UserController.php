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
		$this->load->view('home', $data);
	}

	public function loadNotifs(){
		$notifData = $this->UserModel->getNotification();
		echo json_encode($notifData, JSON_PRETTY_PRINT);
	}

	public function viewNotifs(){
		$notifData = $this->UserModel->viewNotification();
		echo json_encode($notifData, JSON_PRETTY_PRINT);
	}

	public function myTickets($userID){
		$data=array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['ticketData'] = $this->UserModel->getTicketByUserId($userID);
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
						'userID' => $result[0]->userID,
						'userName' => $result[0]->userName,
						'userEmail' => $result[0]->userEmail,
						'userLevel' => $result[0]->userLevel,
						'isLoggedId' => true
						);

					$this->session->set_userdata('isUserLoggedIn', $sessionData);
					$loggedInUser = $sessionData;
					$data['ticketData'] = $this->UserModel->getAllTickets();
					//$data['success_msg'] = 'Welcome, '.$result[0]->customerUsername.'!';
					$this->load->view('home', $data);
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
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$data['userDetails'] = $this->UserModel->getUserById($userID);

		$this->load->view('detailTicket', $data);
	}

	public function takeTicket($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$data['userDetails'] = $this->UserModel->getUserById($userID);

		$result = $this->UserModel->handleTicket($ticketID, $userID);

		if($result==true){
			$data['success_msg'] = 'Ticket added to Your Ticket List';
			$this->load->view('detailTicket', $data, refresh);
		}
	}

	public function updateTicket($ticketID){
		$data = array();
		$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
		$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
		$data['details'] = $this->UserModel->getTicketById($ticketID);
		$data['changelog'] = $this->UserModel->getChangelog($ticketID);
		$userID = $this->session->userdata['isUserLoggedIn']['userID'];
		$data['userDetails'] = $this->UserModel->getUserById($userID);

		$ticketData = array(
			'status' => $this->input->post('status')
		);
		$changelogData = array(
			'ticketID' => $ticketID,
			'userID' => $userID,
			'status' => $this->input->post('status'),
			'description' => $this->input->post('changes')
		);
		
		$result = $this->UserModel->updateTicket($ticketData, $changelogData, $ticketID);

		if($result == true){
			$data['success_msg'] = 'Ticket and changelog has been Updated';
			
			$this->load->view('ticketActions', $data);
		}
	}
}
