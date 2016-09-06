<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

  function __construct(){
    parent::__construct();
    //-- load model M_auth
    $this->load->model('m_auth','auth');
  }

	public function index()
	{
		echo "service";
	}

  /*
    Api register You use api is "ip/chaokaset/index.php/services/register "
    data to sent have name,lname,password,email,tel[],acter(1=เกษตรกร)
    data to return is status,data[name,user_id,email]
  */
  public function register(){
    //-- lode Libraries encrypt
    $this->load->library('encrypt');
    //-- input data
    $name = $this->input->post('name');
    $lname = $this->input->post('lname');
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $tel = $this->input->post('tel');
    $acter = $this->input->post('acter');
    //-- encode password
    $password_endcode = $this->encrypt->encode($password);
    //$password = $this->encrypt->decode($password_endcode);
    //-- check data
    if($name == NULL || $lname == NULL || $email == NULL || $password == NULL || $tel == NULL || $acter == NULL){
      $json_error = array('status' => FALSE);
      echo json_encode($json_error);
    }else {
      //-- set data to array
      $data = array(
                'use_name' => $name,
                'use_lname' => $lname,
                'use_email' => $email,
                'use_password' => $password_endcode,
                'use_status' => '0',
                'tuser_id' => $acter,
              );

      //-- call model insert data funtion is return id user insert now!!
      $id_user = $this->auth->register($data);

      //-- count tel
      $count_tel = count($tel);

      if ($count_tel > 1){
        //-- insert phone number > 2
        foreach ($tel as $key => $value) {
          $data2 = array(
                    'con_name' => $value,
                    'tcon_id' => '2',
                    'use_id' => $id_user,
                  );
          $this->auth->addContact($data2);
        }
      }else{
        //-- insert phone number
        $data3 = array(
                  'con_name' => $tel[0],
                  'tcon_id' => '2',
                  'use_id' => $id_user,
                );
        $this->auth->addContact($data3);
      }//else if $count_tel > 1

      //-- set value in araay
      $json = array(
                'status' => TRUE ,
                'data' => array(
                            'name' => $name." ".$lname,
                            'idUser' =>  $id_user,
                            'email' => $email,
                          ),
                );
      echo json_encode($json);
    }//else
  }//regisfuntion

  /*
    Api checkemail You use api is "ip/chaokaset/index.php/checkemail"
    data to sent is email
    data to return is TRUE or FALSE (TRUE is email not duplicate)
   */
  public function checkemail(){
    $email = $this->input->post('email');
    //-- check data
    if($email == NULL){
      echo json_encode(FALSE);
    }else {
      //-- call model
      $check = $this->auth->checkemail($email);
      if($check == NULL){
        echo json_encode(TRUE);
      }else {
        echo json_encode(FALSE);
      }
    }
  }//checkEmail

  public function login(){
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $json_error = array('status' => FALSE);
    if($email == NULL || $password == NULL){
      echo json_encode($json_error);
    }else{
      $check = $this->auth->checkemail($email);
      if($check == NULL){
        echo json_encode($json_error);
      }else{
        $pass_db = $this->encrypt->decode($check[0]['use_password']);
        if($password == $pass_db){
          $json = array(
                    'status' => TRUE ,
                    'data' => array(
                                'name' => $check[0]['use_name']." ".$check[0]['use_lname'],
                                'idUser' =>  $check[0]['use_id'],
                                'email' => $check[0]['use_email'],
                              ),
                    );
          echo json_encode($json);
        }else{
          echo json_encode($json_error);
        }
      }
    }
  }//Logging

  public function loginfacebook(){
    $name = $this->input->post('name');
    $lname = $this->input->post('lname');
    $email = $this->input->post('email');
    $token = $this->input->post('token');
    $acter = $this->input->post('acter');

    if($email == NULL || $token == NULL || $name == NULL || $lname == NULL){
      $json_error = array(
                      'status' => FALSE ,
                    );
      echo json_encode($json_error);
    }else{
      $check = $this->auth->checkemail($email);
      if($check == NULL){
        $data = array(
                  'use_name' => $name,
                  'use_lname' => $lname,
                  'use_email' => $email,
                  'use_token' => $token,
                  'use_status' => '1',
                  'tuser_id' => $acter,
                );
        $id_user = $this->auth->register($data);
        $json1 = array(
                  'status' => TRUE ,
                  'data' => array(
                              'name' => $name." ".$lname,
                              'idUser' =>  $id_user,
                              'email' => $email,
                            ),
                  );
        echo json_encode($json1);

      }else{
          $json = array(
                    'status' => TRUE ,
                    'data' => array(
                                'name' => $check[0]['use_name']." ".$check[0]['use_lname'],
                                'idUser' =>  $check[0]['use_id'],
                                'email' => $check[0]['use_email'],
                              ),
                    );
          echo json_encode($json);
      }

    }
  }//loginfacebook


}
