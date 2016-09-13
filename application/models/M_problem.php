<?php
  /**
   *
   */
  class M_problem extends CI_Model
  {
    function showproblem($id){
      $count = "SELECT COUNT(ans_problem.cropp_id) FROM ans_problem WHERE cropp_id = crop_problem.crop_id";
      $sql = "SELECT *,(".$count .") as count_ans FROM crop_problem WHERE crop_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }
  }
?>
