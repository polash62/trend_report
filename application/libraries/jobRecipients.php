<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobrecipients {

    public $failCount; // int
    public $image; // base64Binary
    public $job; // jobs
    public $jobDetailId; // long
    public $recipientEmail; // string
    public $sent; // boolean
    public $sentDate; // dateTime
    public $toText; // string

}
