<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('savelogdata')) {

    function savelogdata($action, $details) {
        $CI = & get_instance();
        $userPin = $CI->session->userdata('user_name');
        $userLevel = $CI->session->userdata('user_level');
        $userid = $CI->session->userdata("userid");

        $CI->load->library('user_agent');
        $device = 'Host Name: ' . gethostname();
        $device = $device . '  | ' . 'OS: ' . $CI->agent->platform();
        if ($CI->agent->is_browser()) {
            $browser = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_robot()) {
            $browser = $CI->agent->robot();
        } elseif ($CI->agent->is_mobile()) {
            $browser = $CI->agent->mobile();
        } else {
            $browser = 'Undefined User Agent';
        }
        $ip = $_SERVER['REMOTE_ADDR'];

        $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $locationinfo = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
        $location = "";
        if (isset($locationinfo->city)):
            $location .= ' City: ' . $locationinfo->city;
        endif;
        if (isset($locationinfo->region)):
            $location .= ', Region: ' . $locationinfo->region;
        endif;
        if (isset($locationinfo->country)):
            $location .= ', Country: ' . $locationinfo->country;
        endif;

        $logdataarray = [
            'userpin' => $userPin,
            'user_id' => $userid,
            'userlevel' => $userLevel,
            'action' => $action,
            'device' => $device,
            'browser' => $browser,
            'ip' => $ip,
            'location' => $location,
            'details' => $details
        ];
        $savestatus = $CI->db->insert('logdata', $logdataarray);
    }

    function savelogdata2($action, $details, $user_level) {
        $CI = & get_instance();
        $userPin = $CI->session->userdata('user_name');
        $userid = $CI->session->userdata("userid");
        $CI->load->library('user_agent');
        $device = 'Host Name: ' . gethostname();
        $device = $device . '  | ' . 'OS: ' . $CI->agent->platform();
        if ($CI->agent->is_browser()) {
            $browser = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_robot()) {
            $browser = $CI->agent->robot();
        } elseif ($CI->agent->is_mobile()) {
            $browser = $CI->agent->mobile();
        } else {
            $browser = 'Undefined User Agent';
        }
        $ip = $_SERVER['REMOTE_ADDR'];

        $device = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $locationinfo = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
        $location = "";
        if (isset($locationinfo->city)):
            $location .= ' City: ' . $locationinfo->city;
        endif;
        if (isset($locationinfo->region)):
            $location .= ', Region: ' . $locationinfo->region;
        endif;
        if (isset($locationinfo->country)):
            $location .= ', Country: ' . $locationinfo->country;
        endif;

        $logdataarray = [
            'userpin' => $userPin,
            'user_id' => $userid,
            'userlevel' => $user_level,
            'action' => $action,
            'device' => $device,
            'browser' => $browser,
            'ip' => $ip,
            'location' => $location,
            'details' => $details
        ];
        $savestatus = $CI->db
                ->insert('logdata', $logdataarray);
    }

}


if (!function_exists('getcountonlineuser')) {

    function getcountonlineuser() {
        $CI = & get_instance();
        $datebeforeonehr = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . " -1 hour"));
        $result = $CI->db->query("select count(*) as online from loginuser where status='1' and time >= '$datebeforeonehr'");
        if ($result->num_rows() > 0) {
            $db_online = $result->row()->online;
        } else {
            $db_online = 0;
        }
        return $db_online;
    }

}


if (!function_exists('saveactivitylog')) {

    function saveactivitylog($atype_id, $program_id) {
        $CI = & get_instance();
        $userPin = $CI->session->userdata('user_name');
        $userLevel = $CI->session->userdata('user_level');
        $userid = $CI->session->userdata("userid");

        $alogarray = [
            'user_pin' => $userPin,
            'user_id' => $userid,
            'role_id' => $userLevel,
            'activitytype_id' => $atype_id,
            'program_id' => $program_id
        ];
        $savestatus = $CI->db
                ->insert('activitylog', $alogarray);
    }

}


if (!function_exists('sendemail')) {

    function sendemail($emailto, $emailcc, $emailsubject, $emailbody) {


        try {

            $CI = & get_instance();
            $CI->load->library('jobRecipients');
            $CI->load->library('jobs');

            /**
             * This service is available only through VPN
             */
            $soapClient = new SoapClient("http://imail.brac.net:8080/isoap.comm.imail/EmailWS?wsdl");

            $job = new jobs;
            $job->jobContentType = 'html'; // Required. Value: 'html' / 'text'
            $job->requester = 'trendx'; // Required. Value: 'trendx'
            $job->subject = $emailsubject; // Required
            $job->body = $emailbody; //Required. HTML content will be allowed only if jobContentType = 'html'. (No need to add <html><body></body></html> tag)

            $job->jobRecipients[0] = new jobRecipients;
            $job->jobRecipients[0]->recipientEmail = $emailto; // Required. Value: [recipient email address]

            $job->fromAddress = 'noreply@brac.net'; // Optional. Value: [any address]
            $job->udValue1 = 'BRAC'; // Alias of the email. Optional. Value: [application name], Default: 'BRAC'
            $job->cc = $emailcc; // Optional. Multiple address can be set by separating ';'

            $jobs = array('jobs' => $job);
            $send_email = $soapClient->__call('sendEmail', array($jobs));
        } catch (SoapFault $fault) {
            $error = 1;
            //print($fault->faultcode . "-" . $fault->faultstring);
        }

        //Manually return true for email
        return TRUE;



        /*    $config = Array(
          'smtp_timeout' => '60',
          'protocol' => 'smtp',
          'smtp_host' => 'smtp02.brac.net',
          'smtp_port' => 25,
          'mailtype' => 'html',
          'charset' => 'utf-8',
          'wordwrap' => TRUE,
          'crlf' => "\r\n",
          'newline' => "\r\n"
          );
          $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://mail.clouditbd.com',
          'smtp_port' => 465,
          'smtp_user' => 'info@clouditbd.com',
          'smtp_pass' => 'HW!%E*e[LGvf',
          'mailtype' => 'html',
          'charset' => 'iso-8859-1'
          );
          $CI = & get_instance();
          $CI->load->library('email', $config);
          $CI->email->from('automation.crm@brac.net', 'Automation CRM ');
          $CI->email->to($emailto);
          if ($emailcc != ''):
          $CI->email->cc($emailcc);
          endif;
          $CI->email->subject($emailsubject);
          $CI->email->message($emailbody);
          $emailsts = $CI->email->send();
          return $emailsts; */
    }

}


if (!function_exists('sendemailSoapClient')) {

    function sendemailSoapClient($emailto, $emailcc, $emailsubject, $emailbody) {


        try {

            $CI = & get_instance();
            $CI->load->library('jobRecipients');
            $CI->load->library('jobs');

            /**
             * This service is available only through VPN
             */
            $soapClient = new SoapClient("http://172.25.100.41:8080/isoap.comm.imail/EmailWS?wsdl");

            $job = new jobs;
            $job->jobContentType = 'html'; // Required. Value: 'html' / 'text'
            $job->requester = 'trendx'; // Required. Value: 'trendx'
            $job->subject = $emailsubject; // Required
            $job->body = $emailbody; //Required. HTML content will be allowed only if jobContentType = 'html'. (No need to add <html><body></body></html> tag)

            $job->jobRecipients[0] = new jobRecipients;
            $job->jobRecipients[0]->recipientEmail = $emailto; // Required. Value: [recipient email address]

            $job->fromAddress = 'noreply@brac.net'; // Optional. Value: [any address]
            $job->udValue1 = 'BRAC'; // Alias of the email. Optional. Value: [application name], Default: 'BRAC'
            $job->cc = $emailcc; // Optional. Multiple address can be set by separating ';'

            $jobs = array('jobs' => $job);
            $send_email = $soapClient->__call('sendEmail', array($jobs));
        } catch (SoapFault $fault) {
            $error = 1;
            //print($fault->faultcode . "-" . $fault->faultstring);
        }

        //Manually return true for email
        return TRUE;
        
    }

}



if (!function_exists('sms_log')) {

    function sms_log($module_id, $number_to, $content) {
        $CI = & get_instance();
        $smslogdata = array(
            'module_id' => $module_id,
            'number_to' => $number_to,
            'content' => $content,
            'date' => date('Y-m-d H:i:s')
        );
        $savestatus = $CI->db->insert('sms_log', $smslogdata);
    }

}
?>