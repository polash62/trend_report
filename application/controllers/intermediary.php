<?php

/**
 * @author Saleh Ahmad  saleh@clouditbd.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class intermediary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('common_helper');
        $this->load->model('admin');
    }

    public function index() {
        /** @var Int $module_id    Module Id get from the URL */
        $module_id = $this->input->get('module_id');

        /** Take User Information from SESSION */
        $userrole = $this->session->userdata('user_level_' . $module_id);
        $userpin = $this->session->userdata('user_name');
        $userid = $this->session->userdata("userid");

        /** @var datetime $date    Current date and time */
        $date = date("Y-m-d H:i:s");

        /** Insert data on module_login_log table */
        $dataarr = [
            'user_role' => $userrole,
            'user_pin' => $userpin,
            'user_id' => $userid,
            'module_id' => $module_id,
            'date' => $date,
            'Status' => 'in'
        ];
        $module_login_log = $this->admin->inserdata('module_login_log', $dataarr);

        /** Get module information from module table */
        $moduleRow = $this->admin->getSelectedDataRow('module', 'id', $module_id);

        $theme_type = $moduleRow->theme_type;
        $initialpage = $moduleRow->initial_link;

        if ($theme_type == 2) {
            $initialpage = $this->config->item('base_url_crm') . $initialpage;
        } elseif ($theme_type == 3) {
            if (!$this->session->userdata("user_level_8")) {
                redirect('module_permission');
            }

            $initialpage .= '?user_level_8=' . urlencode(base64_encode($this->session->userdata("user_level_8")))
                    . '&associated_id_8=' . urlencode(base64_encode($this->session->userdata("associated_id_8")))
                    . '&program_id_8=' . urlencode(base64_encode($this->session->userdata("program_id_8")))
                    . '&user_id=' . urlencode(base64_encode($this->session->userdata("userid")));
        }
        redirect($initialpage);
    }

    public function intermediaryOutsideCloud() {
        /** @var Int $module_id    Module Id get from the URL */
        $module_id = $this->input->get('module_id');
        $url = $this->input->get('url');
        $user_pin = $this->input->get('user_pin');
        $roll_id = $this->input->get('roll_id');
        $name = $this->input->get('name');
        $user_id = $this->input->get('user_id');
        $as_id = $this->input->get('as_id');

        /** @var datetime $date    Current date and time */
        $date = date("Y-m-d H:i:s");

        /** Insert data on module_login_log table */
        $dataarr = [
            'user_role' => $roll_id,
            'user_pin' => $user_pin,
            'user_id' => $user_id,
            'module_id' => $module_id,
            'date' => $date,
            'Status' => 'in'
        ];
        $module_login_log = $this->admin->inserdata('module_login_log', $dataarr);

        if ($module_id == 12) {
            $initialpage = $url;
            $initialpage .= '?user_pin=' . $user_pin
                    . '&roll_id=' . $roll_id
                    . '&name=' . $name
                    . '&user_id=' . $user_id
                    . '&as_id=' . $as_id;

            redirect($initialpage);
        }
    }

}
