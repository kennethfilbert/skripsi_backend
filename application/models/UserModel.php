<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model{
	public function __construct(){
		parent::__construct();
    }
    
    //USERS
    public function getUserInfo($name){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('userName', $name);
        $this->db->limit(1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result();
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
            return $query->result();
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

    public function getTicketByUserId($id){
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('userID', $id);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function handleTicket($ticketID, $userID){
        $newData = array(
            'userID' => $userID,
            'status' => 'Ongoing'
        );
        $this->db->set($newData);
		$this->db->where('ticketID', $ticketID);
        $this->db->update('tickets');
        
        if($this->db->affected_rows() > 0){
            $myTicket = array(
                'ticketID' => $ticketID,
                'userID' => $userID,
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

    public function updateTicket($ticketData, $changelogData, $ticketID){
        $this->db->set($ticketData);
		$this->db->where('ticketID', $ticketID);
        $this->db->update('tickets');

        if($this->db->affected_rows() > 0){
            $this->db->insert('changelog', $changelogData);
            return true;
        }
        else{
            return false;
        }
    }

    public function getNotification(){
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('notificationSeen', 0);
        $query = $this->db->get();

        if($query->num_rows() != 0){
            $condition = "notificationSeen = 0";
            $ticketData = array(
                'notificationSeen' => 1
            );
            $this->db->set($ticketData);
            $this->db->where($condition);
            $this->db->update('tickets');
            return $query->result();  
        }
        else{
            return false;
        }
    }

    public function viewNotification(){
        
        if($this->db->affected_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}