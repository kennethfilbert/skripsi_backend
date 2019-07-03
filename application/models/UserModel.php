<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }
    
    //USERS

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

    public function getUserName(){
        $this->db->select('*');
		$this->db->from('users');
		$this->db->join('tickets', 'tickets.userID = users.userID');
		$query = $this->db->get();

		return $query->result_array();
    }

    public function getUserInfo($name){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userName', $name);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
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

    public function userLogin($data) {

        $condition = "userName =" . "'" . $data['userName'] . "' AND " . "userPassword =" . "'" . $data['userPassword'] . "'";
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
    
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    //TICKETS
    public function getAllTickets(){
        
        $this->db->select('*');
        $this->db->from('tickets');
        //$this->db->join('users', 'users.userID = tickets.userID');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getTicketById($id){
        $this->db->select('*');
        $this->db->from('tickets');
        //$this->db->join('users', 'users.userID = tickets.userID');
        $this->db->where('ticketID', $id);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getTicketByUserId($id){
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->join('users', 'users.userID = tickets.userID');
        $this->db->where('tickets.userID', $id);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function handleTicket($ticketData, $userID){
        $newData = array(
            'userID' => $userID,
            'status' => 2,
            'notificationSeen' => 1,
            'delegatedNotif' => 0
        );
        $this->db->set($newData);
		$this->db->where('ticketID', $ticketData[0]['ticketID']);
        $this->db->update('tickets');
        
        if($this->db->affected_rows() > 0){
            
            date_default_timezone_set('Asia/Jakarta'); 
            $date = date('d/m/Y H:i:s');

           
                $subject = "Your Support Ticket's work has been started";
                $message = "
        			<html>
        			<head>
        				<title>Your Support Ticket Has Been Updated</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$ticketData[0]['customerName']."
                        <br><p>On ".$date." You have submitted a support ticket with the following details: </p><br>
                        <ul>
                            <li>
                                Ticket ID/Token     : ".$ticketData[0]['token']."
                            </li>
                            <li>
                                Ticket Title/General Idea     : ".$ticketData[0]['ticketTitle']."
                            </li>
                            <li>
                                Contact Name        : ".$ticketData[0]['customerName']."
                            </li>
                            <li>
                                Contact E-mail      : ".$ticketData[0]['customerEmail']."
                            </li>
                            <li>
                                Phone no.           : ".$ticketData[0]['customerPhone']."
                            </li>
                            <li>
                                Regarding Product   : ".$ticketData[0]['productName']."
                            </li>
                            <li>
                                Inquiry Type        : ".$ticketData[0]['inquiryType']."
                            </li>
                           
                            <li>
                                Description         : ".$ticketData[0]['description']."
                            </li>
                        </ul>
                        <br>
                        <p>Your ticket has been handled by one of our employees, and We will notify you via further e-mails regarding the progress of your ticket.</p>

                        <p>Please visit your profile in the support website for more details.</p>
                        
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

        		$this->email->to($ticketData[0]['customerEmail']);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
        		$this->load->library('encrypt');
            
            $myTicket = array(
                'ticketID' => $ticketData[0]['ticketID'],
                'userID' => $userID,
                'status' => 2,
                'description' => 'Work Started'
            );
            $this->db->insert('changelog', $myTicket);
            
            return true;
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


    public function updateTicket($ticketData, $changelogData, $emailData, $ticketID){
        $this->db->set($ticketData);
		$this->db->where('ticketID', $ticketID);
        $this->db->update('tickets');

        if($this->db->affected_rows() > 0){
            $this->db->insert('changelog', $changelogData);
            
            if($changelogData['status']==1){
                $status = "Open";
            }
            elseif($changelogData['status']==2){
                $status = "Ongoing";
            }
            elseif($changelogData['status']==3){
                $status = "Closed";
            }

            date_default_timezone_set('Asia/Jakarta'); 
            $date = date('d/m/Y H:i:s');

            if($changelogData['status']==2 || $changelogData['status']==1){
                $subject = "Your Support Ticket's status has been updated";
                $message = "
        			<html>
        			<head>
        				<title>Your Support Ticket Has Been Updated</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$emailData['customerName']."
                        <br><p>On ".$date." You have submitted a support ticket with the following details: </p><br>
                        <ul>
                            <li>
                                Ticket ID/Token     : ".$emailData['token']."
                            </li>
                            <li>
                                Ticket Title/General Idea     : ".$emailData['ticketTitle']."
                            </li>
                            <li>
                                Contact Name        : ".$emailData['customerName']."
                            </li>
                            <li>
                                Contact E-mail      : ".$emailData['customerEmail']."
                            </li>
                            <li>
                                Phone no.           : ".$emailData['customerPhone']."
                            </li>
                            <li>
                                Regarding Product   : ".$emailData['productName']."
                            </li>
                            <li>
                                Inquiry Type        : ".$emailData['inquiryType']."
                            </li>
                           
                            <li>
                                Description         : ".$emailData['description']."
                            </li>
                        </ul>
                        <br>
                        <p>Your ticket has been updated with the following changes: </p>
                        
                        <ul>
                            <li>
                                Current Status     : ".$status."
                            </li>
                            
                            <li>
                                Changes Made        : ".$changelogData['description']."
                            </li>
                        </ul>

                        <p>Please visit your profile in the support website for more details.</p>
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

        		$this->email->to($emailData['customerEmail']);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
        		$this->load->library('encrypt');
            }
            elseif($changelogData['status']==3){
                $subject = "Your Support Ticket's status has been completed";
                $message = "
        			<html>
        			<head>
        				<title>Your Support Ticket Has Been Completed</title>
        				
        			</head>
        			<body>
        				<div style='display: block; margin-left: auto;
        				margin-right: auto; width: 70%;'>
        				
        				<p>Dear: </p>
        				".$emailData['customerName']."
                        <br><p>On ".$date." The support ticket with the following details: </p><br>
                        <ul>
                            <li>
                                Ticket ID/Token     : ".$emailData['token']."
                            </li>
                            <li>
                                Ticket Title/General Idea     : ".$emailData['ticketTitle']."
                            </li>
                            <li>
                                Contact Name        : ".$emailData['customerName']."
                            </li>
                            <li>
                                Contact E-mail      : ".$emailData['customerEmail']."
                            </li>
                            <li>
                                Phone no.           : ".$emailData['customerPhone']."
                            </li>
                            <li>
                                Regarding Product   : ".$emailData['productName']."
                            </li>
                            <li>
                                Inquiry Type        : ".$emailData['inquiryType']."
                            </li>
                           
                            <li>
                                Description         : ".$emailData['description']."
                            </li>
                        </ul>
                        <br>
                        <p>Your ticket has been finished with the following changes: </p>
                        
                        <ul>
                            <li>
                                Current Status     : ".$status."
                            </li>
                            
                            <li>
                                Changes Made        : ".$changelogData['description']."
                            </li>
                        </ul>

                        <p>Please visit your profile in the support website to review the changes made and confirm if the changes are satisfactory.</p>
                        
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

        		$this->email->to($emailData['customerEmail']);
        		$this->email->from('support@mmg.com','Mitra Mentari Global');
        		$this->email->subject($subject);
        		$this->email->message($message);

        				//Send email
        		$this->email->send();
        		$this->load->library('encrypt');
            }

            return true;
        }
        else{
            return false;
        }
    }

    //NOTIFS

    public function getNotification($userID){
        $condition  = "notificationSeen = 0 OR delegatedNotif = 1 AND delegatedTo = "."'".$userID."'";
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where($condition);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result();  
        }
        else{
            return false;
        }
    }

    public function getFeedbackNotification($userID){
        $condition  = "feedbackNotifSeen = 0 AND userID = "."'".$userID."'";
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where($condition);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result();  
        }
        else{
            return false;
        }
    }

    public function viewNotification($ticketID){
        $condition = "delegatedNotif = 1 AND ticketID = "."'".$ticketID."'";
            $ticketData = array(
                'delegatedNotif' => 0,
                'notificationSeen' => 1
            );
            $this->db->set($ticketData);
            $this->db->where($condition);
            $this->db->update('tickets');
            //$this->db->limit(1);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function viewFeedbackNotification($ticketID){
        $condition = "feedbackNotifSeen = 0 AND ticketID = "."'".$ticketID."'";
            $ticketData = array(
                'feedbackNotifSeen' => 1
            );
            $this->db->set($ticketData);
            $this->db->where($condition);
            $this->db->update('tickets');
            //$this->db->limit(1);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}