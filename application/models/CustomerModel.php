<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CustomerModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }

    public function insertNewTicket($data){
        $this->db->insert('tickets', $data);

        //$result = $this->CustomerModel->getCustomerInfo($email);
            //$custName = $result[0]->customerUsername;
            date_default_timezone_set('Asia/Jakarta'); 
            $date = date('d/m/Y H:i:s');

            if($data['status']==1){
                $status = "Open";
            }
            elseif($data['status']==2){
                $status = "Ongoing";
            }
            elseif($data['status']==3){
                $status = "Closed";
            }

            $subject = "Your Support Ticket has been submitted";

        			/*$message = "
        			<html>
        			<head>
        				<title>Your Ticket has been submitted/title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$data['customerName']."
        				<br><p>On ".$date." You have submitted a support ticket.</p><br>
        				
                        </b>
                        <p></p>
        				<p>Regards,</p>

        				<p>PT MMG Support</p>
        				
        			</div>
        		    </body>
                    </html>";*/
                    
                    $message = "
        			<html>
        			<head>
        				<title>Your Support Ticket Has Been Submitted</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$data['customerName']."
                        <br><p>On ".$date." You have submitted a support ticket with the following details: </p><br>
                        <ul>
                            <li>
                                Ticket ID/Token     : ".$data['token']."
                            </li>
                            <li>
                                Contact Name        : ".$data['customerName']."
                            </li>
                            <li>
                                Contact E-mail      : ".$data['customerEmail']."
                            </li>
                            <li>
                                Phone no.           : ".$data['customerPhone']."
                            </li>
                            <li>
                                Regarding Product   : ".$data['productName']."
                            </li>
                            <li>
                                Inquiry Type        : ".$data['inquiryType']."
                            </li>
                            <li>
                                Urgency level       : ".$data['urgency']."
                            </li>
                            <li>
                                Description         : ".$data['description']."
                            </li>
                            <li>
                                Status              :<b> ".$status."</b>
                            </li>

                        <p>We will notify you via further e-mails regarding the progress of your ticket.</p>
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

        		$this->email->to($data['customerEmail']);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
        		$this->load->library('encrypt');

            
			    return true;
    }

    public function customerLogin($data) {

        $condition = "customerEmail =" . "'" . $data['customerEmail'] . "' AND " . "customerPassword =" . "'" . $data['customerPassword'] . "'";
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
    
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomerInfo($email){
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('customerEmail', $email);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result();
        }
        else{
            return false;
        }
    }
    
    public function getCustomerById($id){
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->join('companies', 'companies.companyID = customers.companyID');
        $this->db->where('customerID', $id);

        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result();
        }
        else{
            return false;
        }
    }


    public function getEmail($email){
        $this->db->select('customerEmail');
        $this->db->from('customers');
        $this->db->where('customerEmail', $email);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getProducts($id){
        $this->db->select('productName');
        $this->db->from('products');
        //$this->db->join('companies', 'companies.productID = products.customerID');
        $this->db->where('companyID', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function changePassword($oldPass, $newPass, $id){
        $this->db->select('customerPassword');
        $this->db->from('customers');
        $this->db->where('customerPassword', md5($oldPass));
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $hashedPass = array(
                'customerPassword' => md5($newPass)
            );
            $this->db->set($hashedPass);
            $this->db->where('customerID',$id);
            $this->db->update('customers');
            if($this->db->affected_rows() > 0){
                return true;
            }
        } 
        else {
            return false;
        }
    } 

    

    public function updatePassword($email){
        
        $newStr = rand();
        $newPass = array(
            'customerPassword'=>md5($newStr)
        );
        $this->db->set($newPass);
        $this->db->where('customerEmail',$email);
        $this->db->update('customers');
        if ($this->db->affected_rows() > 0) {
            $result = $this->CustomerModel->getCustomerInfo($email);
            $custName = $result[0]->customerUsername;
            date_default_timezone_set('Asia/Jakarta'); 
            $date = date('Y/m/d H:i:s');

            $subject = "Password Reset Confirmation";

        			$message = "
        			<html>
        			<head>
        				<title>Your New Password</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$custName."
        				<br><p>On ".$date." You requested a password reset because you forgot your password.</p><br>
        				<p>Your new password is: <b>".$newStr."
                        </b>
                        <p>Please change your password immediately after this.</p>
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

        		$this->email->to($email);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
        		$this->load->library('encrypt');

            
			    return true;
		} 
		else {
			return false;
		}
    }

    public function getCustomerTickets($id){
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('customerID', $id);
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

    public function getAdminInfo($id){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userID', $id);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getChangelog($ticketID){
        $this->db->select('*');
        $this->db->from('changelog');
        $this->db->where('ticketID', $ticketID);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    } 

    public function insertFeedback($feedback, $ticketID){
        $this->db->set($feedback);
        $this->db->where('ticketID', $ticketID);
        $this->db->update('tickets');
        
        
        if ($this->db->affected_rows() > 0) {

            return true;
        }
        else{
            return false;
        }
    }

    
}
