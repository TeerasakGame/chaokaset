<?php
  class M_account extends CI_Model {

    function showaccaccount($id){
      $sql = "SELECT * FROM crop_account WHERE crop_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }
    function totalaccount($id){
      $a = "SELECT sum(cropa_amount) FROM crop_account WHERE cropa_type = ? and crop_id = ?";
      $sql = "SELECT (".$a.") as plus , (".$a.") as minus FROM crop_account WHERE crop_id = ? LIMIT 1";
      $query = $this->db->query($sql,array('0',$id,'1',$id,$id));
      return $query->result_array();
    }
    function deleteaccount($id){
      $this->db-> where('cropa_id', $id);
      $this->db-> delete('crop_account');
    }
  }
?>
