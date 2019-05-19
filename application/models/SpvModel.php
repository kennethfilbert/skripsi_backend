<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SpvModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }

    public function getAllTickets(){
        $this->db->select('*');
        $this->db->from('tickets');
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getTicketById($id){
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('ticketID', $id);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function delegateTicket($ticketID, $userID){
        $newData = array(
            'userID' => $userID
        );
        $this->db->set($newData);
		$this->db->where('ticketID', $ticketID);
        $this->db->update('tickets');

        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }

    }

    public function getAllUsers(){
        $this->db->select('*');
        $this->db->from('users');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getUserById($id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userID', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getUserByLevel(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userLevel', 2);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function updateUser($newData, $userID){
        $this->db->set($newData);
		$this->db->where('userID', $userID);
        $this->db->update('users');

        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function insertNewUser($newData, $emailData){

        $this->db->insert('users',$newData);

        date_default_timezone_set('Asia/Jakarta'); 
        $date = date('d/m/Y H:i:s');

        $subject = "Your Mitra Mentari Support User Account has been created";
        $message = "
        			<html>
        			<head>
        				<title>Your User Account is ready</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$newData['userName']."
                        <br><p>On ".$date.", A MMG Customer Support account with the following details has been created for you: </p><br>
                        <ul>
                            <li>
                                Username    : ".$newData['userName']."
                            </li>
                            <li>
                                User Email    : <b>".$newData['userEmail']."
                            </b></li>
                            <li>
                                Password       : <b>".$emailData."
                            </b></li>
                            <li>
                                User Level    : ".$newData['userLevel']."
                            </li>
                            
                        </ul>
                        <br>
                        <p>Please change your password immediately when you first log in.</p>
                        
        				<p>Regards,</p>

        				<p>PT MMG Support Administrator</p>
        				
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

        		$this->email->to($newData['userEmail']);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
                $this->load->library('encrypt');
                
                return true;
    }

    public function getAllCustomers(){
        $this->db->select('*');
        $this->db->from('customers');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getCustomerById($id){
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('customerID', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function insertNewCustomer($newData, $emailData){

        $this->db->insert('customers',$newData);

        date_default_timezone_set('Asia/Jakarta'); 
        $date = date('d/m/Y H:i:s');

        $subject = "Your Mitra Mentari Support Account has been created";
        $message = "
        			<html>
        			<head>
        				<title>Your Support Account is ready</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$newData['customerUsername']."
                        <br><p>On ".$date.", A MMG Customer Support account with the following details has been created for you: </p><br>
                        <ul>
                            <li>
                                Customer Username    : ".$newData['customerUsername']."
                            </li>
                            <li>
                                Customer Email    : <b>".$newData['customerEmail']."
                            </b></li>
                            <li>
                                Password       : <b>".$emailData."
                            </b></li>
                            <li>
                                Company Name     : ".$newData['companyName']."
                            </li>
                            
                        </ul>
                        <br>
                        <p>Please change your password immediately when you first log in.</p>
                        
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

        		$this->email->to($newData['customerEmail']);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
                $this->load->library('encrypt');
                
                echo $newData['customerEmail'];
                return true;
    }

    public function updateCustomer($newData, $custID){
        $this->db->set($newData);
		$this->db->where('customerID', $custID);
        $this->db->update('customers');

        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}