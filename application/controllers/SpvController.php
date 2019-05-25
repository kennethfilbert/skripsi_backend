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
			//$userID = $this->SpvModel->getAllTickets();
			//$data['userDetails'] = $this->SpvModel->getUserById($userID[0]['userID']);
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

		public function manageProducts(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['productData'] = $this->SpvModel->getAllProducts();
			$this->load->view('manageProducts', $data);
		}

		public function addNewProduct(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['availCustomer'] = $this->SpvModel->getAllCustomers();
			$this->load->view('addProduct', $data);
		}

		public function insertNewProduct(){
			$productData = array(
				'productName' => $this->input->post('productName'),
				'customerID' => $this->input->post('customerID')
			);

			$result = $this->SpvModel->insertNewProduct($productData);

			if($result == true){
				$this->session->set_flashdata('success','Product Data has been added.');
				redirect('SpvController/addNewProduct');
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('SpvController/addNewProduct/');
			}
		}

		public function deleteProduct($id){
			$this->SpvModel->deleteProduct($id);
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
			$spvName = $this->session->userdata['isUserLoggedIn']['userName'];
			$result = $this->SpvModel->delegateTicket($ticketID, $userID, $spvName);

			if($result == true){
				$this->session->set_flashdata('success','Ticket has been delegated to the user.');
				
				redirect('SpvController/spvTicketDetails/'.$ticketID);
			}
		}

		public function exportXls(){
			
			$this->load->library('excel');
			$ticketInfo = $this->SpvModel->getAllTickets();
			
			$this->excel->setActiveSheetIndex(0);
			//header
			$this->excel->getActiveSheet()->SetCellValue('A1','Ticket ID');
			$this->excel->getActiveSheet()->SetCellValue('B1','Token');
			$this->excel->getActiveSheet()->SetCellValue('C1','Date Added');
			$this->excel->getActiveSheet()->SetCellValue('D1','Title');
			$this->excel->getActiveSheet()->SetCellValue('E1','Customer Name');
			$this->excel->getActiveSheet()->SetCellValue('F1','Customer Email');
			$this->excel->getActiveSheet()->SetCellValue('G1','Customer Phone');
			$this->excel->getActiveSheet()->SetCellValue('H1','Product Name');
			$this->excel->getActiveSheet()->SetCellValue('I1','Inquiry Type');
			$this->excel->getActiveSheet()->SetCellValue('J1','Urgency');
			$this->excel->getActiveSheet()->SetCellValue('K1','Status');
			$this->excel->getActiveSheet()->SetCellValue('L1','Handled By (ID)');
			$this->excel->getActiveSheet()->SetCellValue('M1','Last Updated');
			$this->excel->getActiveSheet()->SetCellValue('N1','Description');
			$this->excel->getActiveSheet()->SetCellValue('O1','Feedback');
			$this->excel->getActiveSheet()->SetCellValue('P1','Approval');
			//row
			$rowCount = 2;
			foreach($ticketInfo as $element){
				$this->excel->getActiveSheet()->SetCellValue('A'.$rowCount, $element['ticketID']);
				$this->excel->getActiveSheet()->SetCellValue('B'.$rowCount, $element['token']);
				$this->excel->getActiveSheet()->SetCellValue('C'.$rowCount, $element['dateAdded']);
				$this->excel->getActiveSheet()->SetCellValue('D'.$rowCount, $element['ticketTitle']);
				$this->excel->getActiveSheet()->SetCellValue('E'.$rowCount, $element['customerName']);
				$this->excel->getActiveSheet()->SetCellValue('F'.$rowCount, $element['customerEmail']);
				$this->excel->getActiveSheet()->SetCellValue('G'.$rowCount, $element['customerPhone']);
				$this->excel->getActiveSheet()->SetCellValue('H'.$rowCount, $element['productName']);
				$this->excel->getActiveSheet()->SetCellValue('I'.$rowCount, $element['inquiryType']);
				$this->excel->getActiveSheet()->SetCellValue('J'.$rowCount, $element['urgency']);
				$this->excel->getActiveSheet()->SetCellValue('K'.$rowCount, $element['status']);
				$this->excel->getActiveSheet()->SetCellValue('L'.$rowCount, $element['userID']);
				$this->excel->getActiveSheet()->SetCellValue('M'.$rowCount, $element['dateUpdated']);
				$this->excel->getActiveSheet()->SetCellValue('N'.$rowCount, $element['description']);
				$this->excel->getActiveSheet()->SetCellValue('O'.$rowCount, $element['feedback']);
				$this->excel->getActiveSheet()->SetCellValue('P'.$rowCount, $element['approved']);
				$rowCount++;
			}
			//$this->excel->getActiveSheet()->fromArray($ticketInfo);
			$filename = 'data-'.time().'.xlsx';
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header("Content-Type: application/vnd.ms-excel");
			header('Cache-Control: max-age=0');
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
			$objWriter->save('php://output');
			

		}
    
    
}