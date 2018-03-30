<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->module_id = "10,3";
    }

    function index() {
        
    }

    function login() {
        $uname = $this->input->get('username');
        $upass = $this->input->get('password');
        $userstatus = 1;
        $query = "select random_salt, password, user_id, user_pin, password, status_id from user where user_pin = ?";
        $queryResult = $this->db->query($query, array($uname));
        if ($queryResult->num_rows() > 0):
            $userdbstatus = $queryResult->row()->status_id;
            $random_salt = $queryResult->row()->random_salt;
            $db_hashpass = $queryResult->row()->password;
            $prependwithpass = $random_salt . $upass;
            $hass_password = hash('sha256', $prependwithpass);

            if ($userdbstatus == $userstatus && $hass_password == $db_hashpass):
                $userquery = $this->db->query("SELECT user.user_id, user.user_pin,user.name,user.designation,user.email,user.phone,user.birthdate,user.address,user.status_name,user_associate_role.role_id, user_associate_role.associated_id, user_associate_role.associated_name, user_associate_role.program_id, user_associate_role.program_name FROM user JOIN user_associate_role ON user.user_id=user_associate_role.user_id WHERE user.user_pin='$uname' AND user_associate_role.module_id IN ($this->module_id)");
                $userdata = $userquery->result();
                $outPutData = array(
                    'status' => 'success',
                    'message' => 'Login successfull.',
                    'result' => $userdata
                );
            else:
                $outPutData = array(
                    'status' => 'error',
                    'message' => 'Login Failed',
                );
            endif;
        else:
            $outPutData = array(
                'status' => 'error',
                'message' => 'Login Failed',
            );
        endif;
        echo json_encode($outPutData);
    }

    function mappingdata() {
        $user_id = $this->input->get('api_key');
        $assoctabQr = $this->db->query("SELECT role_id,associated_id,program_id FROM user_associate_role WHERE user_id='$user_id' AND module_id='$this->module_id'");
        if ($assoctabQr->num_rows()):
            $matching_field = "";
            if ($assoctabQr->row()->role_id == 1):
                $matching_field = " AND branch_id =" . $assoctabQr->row()->associated_id;
            elseif ($assoctabQr->row()->role_id == 2):
                $matching_field = " AND area_id =" . $assoctabQr->row()->associated_id;
            elseif ($assoctabQr->row()->role_id == 3):
                $matching_field = " AND region_id =" . $assoctabQr->row()->associated_id;
            elseif ($assoctabQr->row()->role_id == 4):
                $matching_field = " AND division_id =" . $assoctabQr->row()->associated_id;
            endif;

            $program_id = $assoctabQr->row()->program_id;
            $branchQr = $this->db->query("SELECT * FROM branch WHERE program_id='$program_id' $matching_field");
            $resultdata = $branchQr->result();
            $outPutData = array(
                'status' => 'success',
                'result' => $resultdata
            );
        else:
            $outPutData = array(
                'status' => 'error',
                'message' => 'Data Not Found',
            );
        endif;
        echo json_encode($outPutData);
    }

}
