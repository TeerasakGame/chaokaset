<?php
	class M_auth extends CI_Model {

		function __construct(){
	        parent::__construct();
		}

    function test(){
      $sql = "SELECT * FROM type_user";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function register($data){
      $this->db->insert('users', $data);
			$id = $this->db->insert_id();
			return $id;
    }

		function addContact($data){
			$this->db->insert('contacts', $data);
		}

		function checkemail($email){
			$sql = "SELECT * FROM users WHERE use_email = ?  LIMIT 1";
			$query = $this->db->query($sql, array($email));
			return $query->result_array();
		}
	}
?>
