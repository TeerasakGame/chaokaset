<?php
  class M_crop extends CI_Model {

    function showcrop($id){
      $sql = "SELECT * FROM crops WHERE use_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

    function showcropbyid($id){
      $sql = "SELECT * FROM crops WHERE crop_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

  }
?>
