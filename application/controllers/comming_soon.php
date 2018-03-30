<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comming_soon extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('user_name') != NULL || $this->session->userdata('user_pin') != NULL):
            $data['baseurl'] = $this->config->item('base_url');
            $data['title'] = "Comming Soon";
            $this->load->view('comming_soon', $data);
        else:
            redirect('auth');
        endif;
    }

}
