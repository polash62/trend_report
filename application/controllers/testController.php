<?php

/**
 * @author Shahadat 
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TestController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('common_helper');
    }

    function index() {
        echo "test controller called";
    }

    function emailTest($emailto = "amit.roy@brac.net") {
        $emailcc = "shahadat@clouditbd.com";
        $emailsub = "Test Email at Trendx";
        $emailbody = "A test email function within test controller.";
        if (sendemail($emailto, $emailcc, $emailsub, $emailbody)):
            echo 'Email sent';
        else:
            echo 'Failed to send email';
        endif;
    }

}
