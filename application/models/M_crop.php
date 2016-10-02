<?php
  class M_crop extends CI_Model {

    function showcrop($id){
      $sql = "SELECT * FROM crops JOIN seed on crops.seed_id = seed.seed_id JOIN plant on seed.plat_id = plant.plat_id WHERE use_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

    function showcropbyid($id){
      $sql = "SELECT * FROM crops JOIN seed on crops.seed_id = seed.seed_id JOIN plant on seed.plat_id = plant.plat_id JOIN plan on crops.pla_id = plan.pla_id WHERE crop_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

    function getplant(){
      $sql = "SELECT plant.plat_id,plant.plat_name,plant.plat_detail FROM plant JOIN seed on plant.plat_id = seed.plat_id GROUP BY plat_name";
      $query = $this->db->query($sql);
      return $query->result_array();
    }

    function getseed($id){
      $sql = "SELECT seed.seed_id,seed.seed_name,seed.seed_detail FROM seed WHERE plat_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

    function getplan($id){
      $sql = "SELECT * FROM plan WHERE seed_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

    function addCrop($data){
			$this->db->insert('crops', $data);
      $id = $this->db->insert_id();
			return $id;
		}

    function getplanid($id){
      $sql = "SELECT * FROM plan_template WHERE pla_id = ?";
      $query = $this->db->query($sql,array($id));
      return $query->result_array();
    }

    function addCropDetail($data){
			$this->db->insert('crop_detail', $data);
		}

    function addaccaccount($data){
      $this->db->insert('crop_account',$data);
    }

    function deleteaccount($id){
      $this->db->where('cropa_id', $id);
      $this->db->delete('crop_account');
    }

  }
?>
