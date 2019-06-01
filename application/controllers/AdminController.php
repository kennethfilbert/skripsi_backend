<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {
    public function __construct(){
			parent::__construct();
			$this->load->library('session');
			$this->load->library('form_validation');
			$this->load->library('email');
			$this->load->model('AdminModel');
		}
		
		public function dashboard()
		{
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			//$data['ticketData'] = $this->AdminModel->getAllTickets();
			//$userID = $this->AdminModel->getAllTickets();
			//$data['userDetails'] = $this->AdminModel->getUserById($userID[0]['userID']);
			$this->load->view('adminDashboard', $data);
        }

        public function logout()
	    {
            $this->session->unset_userdata('isUserLoggedIn');
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
	    }

        public function manageCustomers(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['customerData'] = $this->AdminModel->getAllCustomers();
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

			$result = $this->AdminModel->insertNewCustomer($customerData, $emailPass);

			if($result == true){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$customerData['customerEmail']);
				$this->session->set_flashdata('success','Customer Data has been added and e-mail sent.');
				redirect('AdminController/addNewCustomer');
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('AdminController/addNewCustomer/');
			}
		}
		
		public function editCustomer($custID){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['editing'] = $this->AdminModel->getCustomerById($custID);
			$this->load->view('editCustomer', $data);
		}

		public function updateCustomer($custID){
			$newData = array(
				'customerEmail' => $this->input->post('email'),
				'customerUsername' => $this->input->post('username'),
				'companyName' => $this->input->post('companyName')
			);
			$result = $this->AdminModel->updateCustomer($newData, $custID);

			if($result == true){
				$this->session->set_flashdata('success','Customer Data has been updated.');
				redirect('AdminController/editCustomer/'.$custID);
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('AdminController/editCustomer/'.$custID);
			}
		}

		public function manageProducts(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['productData'] = $this->AdminModel->getAllProducts();
			$this->load->view('manageProducts', $data);
		}

		public function addNewProduct(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['availCustomer'] = $this->AdminModel->getAllCustomers();
			$this->load->view('addProduct', $data);
		}

		public function insertNewProduct(){
			$productData = array(
				'productName' => $this->input->post('productName'),
				'customerID' => $this->input->post('customerID')
			);

			$result = $this->AdminModel->insertNewProduct($productData);

			if($result == true){
				$this->session->set_flashdata('success','Product Data has been added.');
				redirect('AdminController/addNewProduct');
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('AdminController/addNewProduct/');
			}
		}

		public function deleteProduct($id){
            $this->AdminModel->deleteProduct($id);
            $this->session->set_flashdata('success','Product data has been deleted.');
				redirect('AdminController/manageProducts');
        }
        
        public function deleteCustomer($id){
			$this->AdminModel->deleteCustomer($id);
        }
        
        public function deleteUser($id){
			$this->AdminModel->deleteUser($id);
		}

		public function manageUsers(){
			$data=array();
			$data['js'] = $this->load->view('include/script.php', NULL, TRUE);
			$data['css'] = $this->load->view('include/style.php', NULL, TRUE);
			$data['userData'] = $this->AdminModel->getAllUsers();
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
			$data['editing'] = $this->AdminModel->getUserById($userID);
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

			$result = $this->AdminModel->insertNewUser($userData, $emailPass);

			if($result == true){
				$this->session->set_flashdata('success','New User Data has been added and e-mail sent.');
				redirect('AdminController/addUser');
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('AdminController/addUser/');
			}
		}

		public function updateUser($userID){
			$newData = array(
				'userName' => $this->input->post('username'),
				'userEmail' => $this->input->post('email'),
				'userPassword' => md5($this->input->post('userPass')),
				'userLevel' => $this->input->post('level')
			);
			$result = $this->AdminModel->updateUser($newData, $userID);

			if($result == true){
				$this->session->set_flashdata('success','User Data has been updated.');
				redirect('AdminController/editUser/'.$userID);
			}
			else{
				$this->session->set_flashdata('fail','Something went wrong.');
				redirect('AdminController/editUser/'.$userID);
			}
		}

    }

?>