<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SpvController extends CI_Controller {
    public function __construct(){
			parent::__construct();
			$this->load->library('session');
			$this->load->library('form_validation');
			$this->load->library('email');
			$this->load->model('SpvModel');
		}
		
		public function dashboard()
		{
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['ticketData'] = $this->SpvModel->getAllTickets();
			$userID = $this->SpvModel->getAllTickets();
			$data['userDetails'] = $this->SpvModel->getUserById($userID[0]['userID']);
			$this->load->view('spvHome', $data);
		}

		public function manageCustomers(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['customerData'] = $this->SpvModel->getAllCustomers();
			$this->load->view('manageCustomers', $data);
		}

		public function addNewCustomer(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$this->load->view('addCustomer', $data);
		}

		public function insertNewCustomer(){
			$customerData = array(
				'customerEmail' => $this->input->post('email'),
				'customerUsername' => $this->input->post('username'),
				'customerPassword' => md5($this->input->post('password')),
				'companyName' => $this->input->post('companyName')
			);

			$emailPass = $this->input->post('password');

			$result = $this->SpvModel->insertNewCustomer($customerData, $emailPass);

			if($result == true){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$customerData['customerEmail']);
				$this->session->set_flashdata('success','Customer Data has been added and e-mail sent.');
				redirect('SpvController/addNewCustomer');
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('SpvController/addNewCustomer/');
			}
		}
		
		public function editCustomer($custID){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['editing'] = $this->SpvModel->getCustomerById($custID);
			$this->load->view('editCustomer', $data);
		}

		public function updateCustomer($custID){
			$newData = array(
				'customerEmail' => $this->input->post('email'),
				'customerUsername' => $this->input->post('username'),
				'companyName' => $this->input->post('companyName')
			);
			$result = $this->SpvModel->updateCustomer($newData, $custID);

			if($result == true){
				$this->session->set_flashdata('success','Customer Data has been updated.');
				redirect('SpvController/editCustomer/'.$custID);
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('SpvController/editCustomer/'.$custID);
			}
		}

		public function manageUsers(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['userData'] = $this->SpvModel->getAllUsers();
			$this->load->view('manageUsers', $data);
		}

		public function addUser(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$this->load->view('addUser', $data);
		}

		public function editUser($userID){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['editing'] = $this->SpvModel->getUserById($userID);
			$this->load->view('editUser', $data);
		}

		public function insertNewUser(){
			$userData = array(
				'userName' => $this->input->post('username'),
				'userEmail' => $this->input->post('email'),
				'userPassword' => md5($this->input->post('userPass')),
				'userLevel' => $this->input->post('level')
			);

			$emailPass = $this->input->post('userPass');

			$result = $this->SpvModel->insertNewUser($userData, $emailPass);

			if($result == true){
				$this->session->set_flashdata('success','New User Data has been added and e-mail sent.');
				redirect('SpvController/addUser');
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('SpvController/addUser/');
			}
		}

		public function updateUser($userID){
			$newData = array(
				'userName' => $this->input->post('username'),
				'userEmail' => $this->input->post('email'),
				'userPassword' => md5($this->input->post('userPass')),
				'userLevel' => $this->input->post('level')
			);
			$result = $this->SpvModel->updateUser($newData, $userID);

			if($result == true){
				$this->session->set_flashdata('success','Customer Data has been updated.');
				redirect('SpvController/editUser/'.$userID);
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('SpvController/editUser/'.$userID);
			}
		}

	
		public function logout()
		{
				$this->session->unset_userdata('isUserLoggedIn');
				$this->session->sess_destroy();
				redirect(base_url(), 'refresh');
		}

		public function spvTicketDetails($ticketID){
			$data = array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['details'] = $this->SpvModel->getTicketById($ticketID);
			$userID = $this->SpvModel->getTicketById($ticketID);
			$data['userDetails'] = $this->SpvModel->getUserById($userID[0]['userID']);
			$data['availUsers'] = $this->SpvModel->getUserByLevel();
			
			$this->load->view('spvDetailTicket', $data);
		}

		public function delegateTicket($ticketID){
			$userID = $this->input->post('userID');
			$result = $this->SpvModel->delegateTicket($ticketID, $userID);

			if($result == true){
				$this->session->set_flashdata('success','Ticket has been delegated to the user.');
				
				redirect('SpvController/spvTicketDetails/'.$ticketID);
			}
		}
    
    
}