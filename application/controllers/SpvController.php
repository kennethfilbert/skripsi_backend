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

		public function spvTickets($userID){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['ticketData'] = $this->SpvModel->getTicketByUserId($userID);
			//$data['userDetails'] = $this->UserModel->getUserById($userID);
			
			$this->load->view('spvTicketList', $data);
		}

		public function loadNotifs(){
			$userID = $this->session->userdata['isUserLoggedIn']['userID'];
			$notifData = $this->SpvModel->getNotification($userID);
			echo json_encode($notifData, JSON_PRETTY_PRINT);
		}

		public function viewNotifs($ticketID){
			$data = array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['details'] = $this->SpvModel->getTicketById($ticketID);
			$userID = $this->SpvModel->getTicketById($ticketID);
			$data['userDetails'] = $this->SpvModel->getUserById($userID[0]['userID']);
			
			
			$this->load->view('spvDetailTicket', $data);
		}

		public function viewFeedbackNotifs($ticketID){
			$data = array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['details'] = $this->SpvModel->getTicketById($ticketID);
			$userID = $this->SpvModel->getTicketById($ticketID);
			$data['userDetails'] = $this->SpvModel->getUserById($userID[0]['userID']);
			//$data['notifData'] = $this->UserModel->viewFeedbackNotification($ticketID);
			
			$this->load->view('spvDetailTicket', $data);
		}

		public function takeTicket($ticketID){
		
			$userID = $this->session->userdata['isUserLoggedIn']['userID'];
			$result = $this->SpvModel->handleTicket($ticketID, $userID);
			
	
			if($result==true){
				$this->session->set_flashdata('success','Ticket added to your Ticket List.');
				redirect('SpvController/spvDetailTicket/'.$ticketID);
			}
		}

		public function ticketActions($ticketID){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['details'] = $this->SpvModel->getTicketById($ticketID);
			$data['changelog'] = $this->SpvModel->getChangelog($ticketID);
			$userID = $this->session->userdata['isUserLoggedIn']['userID'];
			$data['userDetails'] = $this->SpvModel->getUserById($userID);
			
			$this->load->view('spvTicketActions', $data);
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
			
			$result = $this->SpvModel->updateTicket($ticketData, $changelogData, $emailData, $ticketID);
	
			if($result == true){
				$this->session->set_flashdata('success','Ticket and changelog has been updated, update e-mail has been sent');
				
				redirect('UserController/ticketActions/'.$ticketID);
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong');
				redirect('UserController/ticketActions/'.$ticketID);
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
			$this->excel->getActiveSheet()->SetCellValue('N1','Interval (days)');
			$this->excel->getActiveSheet()->SetCellValue('O1','Description');
			$this->excel->getActiveSheet()->SetCellValue('P1','Feedback');
			$this->excel->getActiveSheet()->SetCellValue('Q1','Approval');
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
				$interval = date_diff(date_create($element['dateAdded']), date_create($element['dateUpdated']));
				$intervalAmount = $interval->format('%R%a');
				$this->excel->getActiveSheet()->SetCellValue('N'.$rowCount, $intervalAmount);
				$this->excel->getActiveSheet()->SetCellValue('O'.$rowCount, $element['description']);
				$this->excel->getActiveSheet()->SetCellValue('P'.$rowCount, $element['feedback']);
				$this->excel->getActiveSheet()->SetCellValue('Q'.$rowCount, $element['approved']);
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