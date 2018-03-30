<?php

/**
 * @author Saleh Ahmad  saleh@clouditbd.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('brac');
        $this->load->model('admin');
        $this->load->library('excel');
        $this->load->helper('common_helper');
    }

    public function index() {
        if (($this->session->userdata('user_level') != NULL || $this->session->userdata('userrole') != NULL) && ($this->session->userdata('user_name') != NULL || $this->session->userdata('user_pin') != NULL)):
            redirect('home');
        else:
            $data['page_title'] = 'Login Home';
            $data['baseurl'] = $this->config->item('base_url');
            $this->load->view('auth/login', $data);
        endif;
    }

    public function login() {
        $data['title'] = 'Login Home';
        $data['baseurl'] = $this->config->item('base_url');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $uname = $this->input->post('username');

        if (!$this->form_validation->run()) {
            $this->session->set_userdata('login_error', 'Please set username/password correctly');
            $this->load->view('auth/login', $data);
            $logdetails = "Userpin:" . $uname . " Try to login but validation failed";
            savelogdata("1001", $logdetails);
        } else {
            $upass = $this->input->post('password');
            $userstatus = 1;
            $query = "select random_salt, password, user_id, user_pin, password, status_id from user where user_pin = ?";
            $queryResult = $this->db->query($query, [$uname]);
            if ($queryResult->num_rows() > 0) {
                $userdbstatus = $queryResult->row()->status_id;
                $random_salt = $queryResult->row()->random_salt;
                $db_hashpass = $queryResult->row()->password;
                $prependwithpass = $random_salt . $upass;
                $hass_password = hash('sha256', $prependwithpass);

                if ($hass_password == $db_hashpass) {

                    if ($userdbstatus == $userstatus) {

                        /* $ulevel = $queryResult->row()->role_id; //role id for trendx
                          $associatedId = $queryResult->row()->associated_id;
                          $programId = $queryResult->row()->program_id;

                          $data['user_name'] = $uname;
                         */

                        /**
                         * Session user name for trend report
                         */
                        $this->session->set_userdata('user_name', $uname);

                        /**
                         * Session user name for CRM
                         */
                        $this->session->set_userdata("userid", $queryResult->row()->user_id);
                        $this->session->set_userdata("user_pin", $queryResult->row()->user_pin);

                        /**
                         * Set session for all modules
                         */
                        $user_id = $queryResult->row()->user_id;
                        $moduleQr = $this->db->query("SELECT id FROM module WHERE cloud_or_not ='1'");
                        $moduledata = $moduleQr->result();
                        foreach ($moduledata as $datarow) {
                            $module_id = $datarow->id;
                            $assoc_tabQr = $this->db->query("SELECT role_id, associated_id, program_id 
FROM user_associate_role 
WHERE user_id='$user_id' AND module_id='$module_id'");
                            if ($assoc_tabQr->num_rows()) {
                                $this->session->set_userdata('user_level_' . $module_id, $assoc_tabQr->row()->role_id);
                                $this->session->set_userdata('associated_id_' . $module_id, $assoc_tabQr->row()->associated_id);
                                $this->session->set_userdata('program_id_' . $module_id, $assoc_tabQr->row()->program_id);
                            }
                        }

                        /**
                         * For Trend Report
                         */
                        $this->session->set_userdata('user_level', $this->session->userdata('user_level_10'));
                        $this->session->set_userdata('associated_id', $this->session->userdata('associated_id_10'));
                        $this->session->set_userdata('program_id', $this->session->userdata('program_id_10'));

                        if ($this->session->userdata('program_id_10') == 1 || $this->session->userdata('program_id_10') == 4) {
                            $this->session->set_userdata('extra_facility', 'yes');
                        } else {
                            $this->session->set_userdata('extra_facility', 'no');
                        }

                        /**
                         * Fetch Program Id from User Associate Role
                         */
                        $this->db->select('user_associate_role.program_id AS pid');
                        $this->db->from('user_associate_role');
                        $this->db->join('user', 'user.user_id = user_associate_role.user_id');
                        $this->db->where('user_associate_role.user_id', $this->session->userdata('userid'));
                        $query = $this->db->get();
                        $programId = $query->row()->pid;

                        /**
                         * For CRM
                         */
                        $this->session->set_userdata('userrole', $this->session->userdata('user_level_3'));
                        $this->loginUser($uname);
                        $details = " Login  Successfully";
                        savelogdata("1001",$details);

                        /*   //Temporary : to redirect dashboard to mylocation page for 3 days
                          $base_url_crm = $this->config->item('base_url_crm');
                          if (in_array($this->session->userdata('user_level'), array(1, 2, 3, 4)) && ($this->session->userdata('program_id') == 1)):
                          redirect($base_url_crm . 'location/findlocation/MyLocatoin');
                          endif; */
                        redirect('auth');
                    } else {
                        $this->session->set_userdata('login_error', 'Your account has been deactivated. Please, contact with admin.');
                        $logdetails = "Userpin:" . $uname . " Try to login but account deactivated.";
                        savelogdata("1001", $logdetails);
                        redirect('auth');
                    }
                } else {
                    $this->session->set_userdata('login_error', 'Please Check Password or User Pin');
                    $logdetails = "Userpin:" . $uname . " Try to login but login authentication failed";
                    savelogdata("1001", $logdetails);
                    redirect('auth');
                }
            } else {
                $this->session->set_userdata('login_error', 'Please check username/password correctly');
                $logdetails = "Userpin:" . $uname . " Try to login but login authentication failed";
                savelogdata("1001", $logdetails);
                redirect('auth');
            }
        }
    }

    public function loginUser($user_pin) {
        //  $user_pin = $this->session->userdata('user_name');
        $result = $this->admin->getSelectedData('loginuser', 'user_pin', $user_pin);
        if (sizeof($result) > 0):
            $updateData = [
                'status' => '1',
                'time' => date('Y-m-d H:i:s')
            ];

            $updateDataQuery = $this->admin->updateData('loginuser', 'user_pin', $user_pin, $updateData);

        /* if ($updateDataQuery) {
          echo "Success Update";
          } else {
          echo "Failed Update";
          } */

        else:
            $result2 = $this->admin->getSelectedDataRow('user', 'user_pin', $user_pin);
            if (sizeof($result2) > 0):
                $insertData = [
                    'user_id' => $result2->user_id,
                    'user_pin' => $result2->user_pin,
                    'status' => '1',
                    'time' => date('Y-m-d H:i:s')
                ];

                $inserdataQuery = $this->admin->inserdata('loginuser', $insertData);

            /* if ($inserdataQuery) {
              echo "Success Insert";
              } else {
              echo "Failed Insert";
              } */
            endif;
        endif;
    }

}
