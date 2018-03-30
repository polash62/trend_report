<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dabi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('brac');
        $this->load->model('datesearch_model');
        $this->load->model('advancedata');
        $this->load->library('excel');
        $this->load->library('FlxZipArchive');
        $this->load->helper('common_helper');
        require_once APPPATH . "/third_party/counter.php";
        $this->online = getcountonlineuser();
        $this->day = $day;
        $this->all = $all;
    }

    public function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Dabi->Report";
        if (in_array($this->session->userdata('user_level'), array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15))):
            $data['online'] = $this->online;
            $data['day'] = $this->day;
            $data['all'] = $this->all;
            ###################   take data from session   #########################
            $useRole = $this->session->userdata('user_level');
            $username = $this->session->userdata('user_name');
            $associatedId = $this->session->userdata('associated_id');
            $programId = 1; ### set programId = 1 for program dabi###
            saveactivitylog(3, $programId);  ## Activity log data save ##

            $details = "Trend Report Dabi Visit";
            savelogdata("1003", $details);

            $data['useRole'] = '';
            if ($useRole == 1):
                ########################################################  start role-1 information  #############################################################
                $queryForRole1 = $this->db->query("select * from branch where branch_id = '$associatedId' AND program_id = '$programId'");
                $data['divisionNameforRole1'] = $queryForRole1->row()->division_name;
                $data['divisionIdforRole1'] = $queryForRole1->row()->division_id;
                $data['regionNameforRole1'] = $queryForRole1->row()->region_name;
                $data['regionIdforRole1'] = $queryForRole1->row()->region_id;
                $data['areaNameforRole1'] = $queryForRole1->row()->area_name;
                $data['areaIdforRole1'] = $queryForRole1->row()->area_id;
                $data['branchName'] = $queryForRole1->row()->branch_name;
                $data['branchId'] = $queryForRole1->row()->branch_id;
                $branchIdforRole1 = $queryForRole1->row()->area_id;
                $branchId = $queryForRole1->row()->branch_id;
                $branchIdResultforRole1 = $this->db->query("select * from branch where branch_id NOT IN ('$branchId') AND area_id = '$branchIdforRole1' AND program_id = '$programId'");
                $data['branchlist'] = $branchIdResultforRole1->result();
            #######################################################  end role-1 information  #################################################################
            elseif ($useRole == 2):
                ########################################################  start role-2 information  #############################################################
                $queryForRole2 = $this->db->query("select * from area where area_id = '$associatedId' AND program_id = '$programId'");
                $data['divisionNameforRole2'] = $queryForRole2->row()->division_name;
                $data['divisionIdforRole2'] = $queryForRole2->row()->division_id;
                $data['regionNameforRole2'] = $queryForRole2->row()->region_name;
                $data['regionIdforRole2'] = $queryForRole2->row()->region_id;
                $data['areaName'] = $queryForRole2->row()->area_name;
                $data['areaId'] = $queryForRole2->row()->area_id;
                $areaIdforRole2 = $queryForRole2->row()->region_id;
                $areaId = $queryForRole2->row()->area_id;
                $areaIdResultforRole2 = $this->db->query("select * from area where area_id NOT IN ('$areaId') AND  region_id = '$areaIdforRole2' AND program_id = '$programId'");
                $data['arealist'] = $areaIdResultforRole2->result();
                $branchIdResultforRole2 = $this->db->query("select * from branch where area_id = '$areaId' AND program_id = '$programId'");
                $data['branchlist'] = $branchIdResultforRole2->result();
            #######################################################  end role-2 information  #################################################################
            elseif ($useRole == 3):
                ########################################################  start role-3 information  #############################################################
                $queryForRole3 = $this->db->query("select * from region where region_id = '$associatedId' AND program_id = '$programId'");
                $data['regionId'] = $queryForRole3->row()->region_id;
                $data['regionName'] = $queryForRole3->row()->region_name;
                $data['divisionNameforRole3'] = $queryForRole3->row()->division_name;
                $data['divisionIdforRole3'] = $queryForRole3->row()->division_id;
                $divisionIdforRole3 = $queryForRole3->row()->division_id;
                $regionId = $queryForRole3->row()->region_id;
                $regionResultForRole3 = $this->db->query("select * from region where region_id NOT IN ('$regionId') AND division_id = '$divisionIdforRole3' AND program_id = '$programId'");
                $data['regionlist'] = $regionResultForRole3->result();
                $areaIdResultforRole3 = $this->db->query("select * from area where region_id = '$regionId' AND program_id = '$programId'");
                $data['arealist'] = $areaIdResultforRole3->result();
            #######################################################  end role-3 information  #################################################################
            elseif ($useRole == 4 || $useRole == 15):
                ########################################################  start role-4 information  #############################################################
                $queryForRole4 = $this->db->query("select * from division where division_id = '$associatedId' AND program_id = '$programId'");
                // $data['divisionName'] = $queryForRole4->row()->division_name;
                // $data['divisionId'] = $queryForRole4->row()->division_id;
                $divisionId = $queryForRole4->row()->division_id;
                $divisionResultForRole4 = $this->db->query("select * from division where division_id NOT IN ('$divisionId') AND program_id = '$programId'");
                $data['divisionlist'] = $divisionResultForRole4->result();
                $regionResultForRole4 = $this->db->query("select * from region where division_id = '$divisionId' AND program_id = '$programId'");
                $data['regionlist'] = $regionResultForRole4->result();
            #######################################################  end role-4 information  #################################################################
            endif;
            $data['active_menu'] = "dabi";
            $data['active_sub_menu'] = "report";
            ########################################################  find previoun 13 month  ###################################################################   
            $inputmonth = $this->input->post('datamonth');
            $monthfromdate = $this->input->post('monthfromdate');
            $data['inputmonth'] = $this->input->post('datamonth');
            $monthinterval = 0;
            if ($inputmonth == ""):
                $inputmonth = date('Y-m', strtotime(date('Y-m') . " -1 month"));
                $monthfromdate = date('Y-m', strtotime(date('Y-m') . " -13 month"));
            else:
                $d1 = new DateTime($inputmonth);
                $d2 = new DateTime($monthfromdate);
                $dateinterval = date_diff($d1, $d2);
                $addmonth = (intval($dateinterval->d) >= 28 ? 1 : 0);  //In case 30days month interval does not count so manually I add one month.
                $monthinterval = $dateinterval->m + ($dateinterval->y * 12) + $addmonth;
                //$monthinterval = (intval($monthinterval) > 12 ? 12 : intval($monthinterval));                
                if ($d1 <= $d2 || $monthinterval > 12):
                    $monthinterval = 0;
                    $inputmonth = date('Y-m', strtotime(date('Y-m') . " -1 month"));
                    $monthfromdate = date('Y-m', strtotime(date('Y-m') . " -13 month"));
                endif;
            //$monthinterval = ($d1 <= $d2 ? 0 : $monthinterval);
            endif;
            //exit();
            $previous1 = $inputmonth;
            $data['previousmonth1'] = date('M-Y', strtotime($inputmonth));
            $data['monthfromdate'] = $monthfromdate;
            $data['monthinterval'] = $monthinterval;
            if ($monthinterval == 0):
                $checkPreviousMonthDataQr = $this->db->query("SELECT * FROM d_program WHERE date LIKE '$previous1%' AND program_id = '$programId'");
                if ($checkPreviousMonthDataQr->num_rows() <= 0):
                    $initialdate = date('Y-m', strtotime($inputmonth . " -1 month"));
                    $data['previousmonth1'] = date('M-Y', strtotime($inputmonth . " -1 month"));
                    $data['previousmonth2'] = date('M-Y', strtotime($inputmonth . " -2 month"));
                    $data['previousmonth3'] = date('M-Y', strtotime($inputmonth . " -3 month"));
                    $data['previousmonth4'] = date('M-Y', strtotime($inputmonth . " -4 month"));
                    $data['previousmonth5'] = date('M-Y', strtotime($inputmonth . " -5 month"));
                    $data['previousmonth6'] = date('M-Y', strtotime($inputmonth . " -6 month"));
                    $data['previousmonth7'] = date('M-Y', strtotime($inputmonth . " -7 month"));
                    $data['previousmonth8'] = date('M-Y', strtotime($inputmonth . " -8 month"));
                    $data['previousmonth9'] = date('M-Y', strtotime($inputmonth . " -9 month"));
                    $data['previousmonth10'] = date('M-Y', strtotime($inputmonth . " -10 month"));
                    $data['previousmonth11'] = date('M-Y', strtotime($inputmonth . " -11 month"));
                    $data['previousmonth12'] = date('M-Y', strtotime($inputmonth . " -12 month"));
                    $data['previousmonth13'] = date('M-Y', strtotime($inputmonth . " -13 month"));
                    $previousmonth13 = date('Y-m', strtotime($inputmonth . " -13 month"));
                    $data['monthfromdate'] = $previousmonth13;
                else:
                    $initialdate = $previous1;
                    $data['previousmonth2'] = date('M-Y', strtotime($inputmonth . " -1 month"));
                    $data['previousmonth3'] = date('M-Y', strtotime($inputmonth . " -2 month"));
                    $data['previousmonth4'] = date('M-Y', strtotime($inputmonth . " -3 month"));
                    $data['previousmonth5'] = date('M-Y', strtotime($inputmonth . " -4 month"));
                    $data['previousmonth6'] = date('M-Y', strtotime($inputmonth . " -5 month"));
                    $data['previousmonth7'] = date('M-Y', strtotime($inputmonth . " -6 month"));
                    $data['previousmonth8'] = date('M-Y', strtotime($inputmonth . " -7 month"));
                    $data['previousmonth9'] = date('M-Y', strtotime($inputmonth . " -8 month"));
                    $data['previousmonth10'] = date('M-Y', strtotime($inputmonth . " -9 month"));
                    $data['previousmonth11'] = date('M-Y', strtotime($inputmonth . " -10 month"));
                    $data['previousmonth12'] = date('M-Y', strtotime($inputmonth . " -11 month"));
                    $data['previousmonth13'] = date('M-Y', strtotime($inputmonth . " -12 month"));
                endif;
            else:
                $initialdate = date('Y-m', strtotime($inputmonth));
                $yrmonArr = array();
                for ($m = 0; $m <= $monthinterval; $m++):
                    $mindex = $m + 1;
                    $monindex = 'previousmonth' . $mindex;
                    $subval = '-' . $m . 'month';
                    $yrmonArr[] = date('M-Y', strtotime($inputmonth . " $subval"));
                endfor;
                $data['yrmonArr'] = $yrmonArr;
            endif;
            $data['previous1'] = $initialdate;

            ########################################################  find previoun 13 month  ###################################################################
            ####After Submit Executation This Step####
            $branchId = $this->input->post('branch_id');
            $divisionId = $this->input->post('division_id');
            $regionId = $this->input->post('region_id');
            $areaId = $this->input->post('area_id');

            //for AM and RM all option 
            if ($regionId == 'all'):
                $data['regionId'] = 0;
                $data['regionName'] = NULL;
                $regionId = 0;
            endif;
            if ($areaId == 'all'):
                $data['areaId'] = 0;
                $data['areaName'] = NULL;
                $areaId = 0;
            endif;


            $data['branch_id'] = $branchId;
            $data['division_id'] = $divisionId;
            $data['region_id'] = $regionId;
            $data['area_id'] = $areaId;

            ###When branchId###
            if ($branchId != NULL):
                $data['qRyresult'] = $this->datesearch_model->treadReportBranch('p_dabi', 'aocd', $branchId, $programId, $initialdate, $monthinterval); ##tableName, TableRowId, branchId, ProgramId, Time Interval## 
                #get region list using divisionId#
                $query = $this->db->query("select * from region where division_id = '$divisionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['regionlist'] = $query->result();
                endif;
                #get area list using regionId#
                $query = $this->db->query("select * from area where region_id = '$regionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['arealist'] = $query->result();
                endif;
                #get branch list using areaId#
                $query = $this->db->query("select * from branch where area_id = '$areaId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['branchlist'] = $query->result();
                endif;
                $query = $this->db->query("select * from branch where branch_id = '$branchId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['branchName'] = $query->row()->branch_name;
                    $data['divisionName'] = $query->row()->division_name;
                    $data['regionName'] = $query->row()->region_name;
                    $data['areaName'] = $query->row()->area_name;
                    $data['branchId'] = $query->row()->branch_id;
                    $data['divisionId'] = $query->row()->division_id;
                    $data['regionId'] = $query->row()->region_id;
                    $data['areaId'] = $query->row()->area_id;
                endif;
                $data['searchbydetails'] = 'details';
            ###When areaId###
            elseif ($areaId != NULL):
                $data['qRyresult'] = $this->datesearch_model->treadReport('d_area', 'area_id', $areaId, $programId, $initialdate, $monthinterval); ##tableName, TableRowId, areaId, ProgramId, Time Interval## 
                #get region list using divisionId#
                $query = $this->db->query("select * from region where division_id = '$divisionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['regionlist'] = $query->result();
                endif;
                #get area list using regionId#
                $query = $this->db->query("select * from area where region_id = '$regionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['arealist'] = $query->result();
                endif;
                #get branch list using areaId#
                $query = $this->db->query("select * from branch where area_id = '$areaId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['branchlist'] = $query->result();
                endif;
                $query = $this->db->query("select * from area where area_id = '$areaId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['areaName'] = $query->row()->area_name;
                    $data['divisionName'] = $query->row()->division_name;
                    $data['regionName'] = $query->row()->region_name;
                    $data['divisionId'] = $query->row()->division_id;
                    $data['regionId'] = $query->row()->region_id;
                    $data['areaId'] = $query->row()->area_id;
                endif;
                $data['searchbydetails'] = 'details';
            ###When regionId###
            elseif ($regionId != NULL):
                $data['qRyresult'] = $this->datesearch_model->treadReport('d_region', 'region_id', $regionId, $programId, $initialdate, $monthinterval); ##tableName, TableRowId, regionId, ProgramId, Time Interval## 
                #get region list using divisionId#
                $query = $this->db->query("select * from region where division_id = '$divisionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['regionlist'] = $query->result();
                endif;
                #get area list using regionId#
                $query = $this->db->query("select * from area where region_id = '$regionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['arealist'] = $query->result();
                endif;
                $query = $this->db->query("select * from region where region_id = '$regionId' AND program_id = '$programId'");
                if ($query->num_rows() > 0):
                    $data['regionName'] = $query->row()->region_name;
                    $data['divisionName'] = $query->row()->division_name;
                    $data['divisionId'] = $query->row()->division_id;
                    $data['regionId'] = $query->row()->region_id;
                endif;
                $data['searchbydetails'] = 'details';
            ###When divisionId###
            elseif ($divisionId != NULL):
                ###Trend Report by Zone eastern###
                if ($divisionId == 'eastern'):
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_zone', 'zone_id', '1', $programId, $initialdate, $monthinterval); ##tableName, TableRowId, divisionId, ProgramId, Time Interval## 
                    $data['divisionName'] = 'Dabi Eastern';
                    $data['searchbydetails'] = 'details';
                    $data['divisionId'] = "eastern";
                ###Trend Report by Zone eastern###
                elseif ($divisionId == 'western'):
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_zone', 'zone_id', '2', $programId, $initialdate, $monthinterval); ##tableName, TableRowId, divisionId, ProgramId, Time Interval## 
                    $data['divisionName'] = 'Dabi Western';
                    $data['searchbydetails'] = 'details';
                    $data['divisionId'] = "western";
                else:
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_division', 'division_id', $divisionId, $programId, $initialdate, $monthinterval); ##tableName, TableRowId, divisionId, ProgramId, Time Interval## 
                    #get region list using divisionId#
                    $query = $this->db->query("select * from region where division_id = '$divisionId' AND program_id = '$programId'");
                    if ($query->num_rows() > 0):
                        $data['regionlist'] = $query->result();
                    endif;
                    $query = $this->db->query("select * from division where division_id = '$divisionId' AND program_id = '$programId'");
                    if ($query->num_rows() > 0):
                        $data['divisionName'] = $query->row()->division_name;
                        $data['divisionId'] = $query->row()->division_id;
                    endif;
                    $data['searchbydetails'] = 'details';
                endif;
            else:
                $data['qRyresult'] = '';
            endif;
            ###This is global trend report for all level by level user###
            if (($areaId == NULL) && ($divisionId == NULL) && ($regionId == NULL) && ($branchId == NULL)):
                ###global trend for level 5 , 6 and 7 (total global trend)###
                if (in_array($this->session->userdata('user_level'), array(5, 6, 7, 13))):
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_program', '', '', $programId, $initialdate, $monthinterval); ##tableName, '', '', ProgramId, Time Interval## 
                    $data['searchbydetails'] = 'details';
                ###global trend for level 4 (total global trend)###
                elseif ($useRole == 4 || $useRole == 15):
                    $data['useRole'] = 4;
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_program', '', '', $programId, $initialdate, $monthinterval); ##tableName, '', '', ProgramId, Time Interval## 
                    $data['searchbydetails'] = 'details';
                ###global trend for level 3 (divisional global for regional user)###
                elseif ($useRole == 3):
                    $queryForRole3 = $this->db->query("select * from region where region_id = '$associatedId' AND program_id = '$programId'");
                    $data['useRole'] = 3;
                    $divisionIdforRole3 = $queryForRole3->row()->region_id;
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_region', 'region_id', $divisionIdforRole3, $programId, $initialdate, $monthinterval); ##tableName, '', '', ProgramId, Time Interval## 
                    $data['searchbydetails'] = 'details';
                ###global trend for level 2 (regional global for area user)###
                elseif ($useRole == 2):
                    $queryForRole2 = $this->db->query("select * from area where area_id = '$associatedId' AND program_id = '$programId'");
                    $data['useRole'] = 2;
                    $areaIdforRole2 = $queryForRole2->row()->area_id;
                    $data['qRyresult'] = $this->datesearch_model->treadReport('d_area', 'area_id', $areaIdforRole2, $programId, $initialdate, $monthinterval); ##tableName, '', '', ProgramId, Time Interval## 
                    $data['searchbydetails'] = 'details';
                ###global trend for level 1 (area global for branch user)###
                elseif ($useRole == 1):
                    $queryForRole1 = $this->db->query("select * from branch where branch_id = '$associatedId' AND program_id = '$programId'");
                    $data['useRole'] = 1;
                    $branchIdforRole1 = $queryForRole1->row()->branch_id;
                    $data['qRyresult'] = $this->datesearch_model->treadReport('p_dabi', 'aocd', $branchIdforRole1, $programId, $initialdate, $monthinterval); ##tableName, '', '', ProgramId, Time Interval## 
                    $data['searchbydetails'] = 'details';
                else:
                    $data['qRyresult'] = '';
                endif;
            endif;
            ### End of global trend report for all level by level user###
            $data['divisionlist'] = $this->brac->getData('division', $programId, 'program_id'); ##tableName, ProgramId, ProgramId## 
            //Get indicators details 
            $data['indicatormaster'] = $this->brac->getData('indicatormaster', '1', 'default_or_not');

            //For Enhancement 5          
            $data['user_level'] = $this->session->userdata('user_level');
            $user_level = $this->session->userdata('user_level');
            $associated_id = $this->session->userdata('associated_id');
            if (in_array($user_level, array(5, 6, 7, 13))):
                $programId = 1;
                $divisionqr = $this->db->query("SELECT * FROM division where program_id = '$programId'");
                $data['divisionarr'] = $divisionqr->result();
            elseif (in_array($user_level, array(4, 15))):
                $programId = $this->session->userdata('program_id');
                $data['divisionarr'] = $this->advancedata->getDivisionInfo('division_id', $associated_id, 'division');
            elseif (in_array($user_level, array(3))):
                $programId = $this->session->userdata('program_id');
                $data['regionarr'] = $this->advancedata->getRegionInfo('region_id', $associated_id, 'region');
            elseif (in_array($user_level, array(2))):
                $programId = $this->session->userdata('program_id');
                $data['areaarr'] = $this->advancedata->getAreaInfo('area_id', $associated_id, 'area');
            endif;
            $data['programId'] = $programId;

            $this->load->view('common/header', $data);
            $this->load->view('common/sidebar', $data);
            $this->load->view('dabi/report', $data);
            $this->load->view('common/footer', $data);
        else:
            redirect('auth');
        endif;
    }

    function getAssociateItem() {
        $componentval = $this->input->post('componentval');
        $programId = 1;
        $indicatorQr = $this->db->query("SELECT * FROM indicatordetails WHERE indicatormaster_id = '$componentval' AND program_id = '$programId' AND default_or_not = '0'");
        $indicatordata = $indicatorQr->result();
        $outputData = "";
        $outputData .= "<button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>Select Item <i class='fa fa-angle-down'></i></button>";
        if (sizeof($indicatordata)):
            $outputData .= "<ul class='dropdown-menu'>";
            foreach ($indicatordata as $datarow):
                $onchangefun = "showDataRow('" . $datarow->item_no . "')";
                $outputData .= "<li style='padding-left: 10px;'> <input type='checkbox' onchange=" . $onchangefun . " name='detailsindicator' id='detailsindicator' value='" . $datarow->item_no . "'>&nbsp;" . $datarow->indicator . "</li>";
            endforeach;
            $outputData .= "</ul>";
        endif;
        echo $outputData;
    }

    function getIndicatorNotDefault() {
        $indicatordetails = $this->brac->getIndicatordetailsData('indicatordetails', 'default_or_not', '0', 'program_id', '1');
        $indicatordetailsdefault = $this->brac->getIndicatordetailsData('indicatordetails', 'default_or_not', '1', 'program_id', '1');
        $getMaxIndItemVal = $this->brac->getMaxIndItemVal(1);
        $getAllIndItem = $this->brac->getAllIndItem(1);
        $outputData = array(
            'maxIndItemVal' => $getMaxIndItemVal,
            'notDefaultItem' => $indicatordetails,
            'defaultItem' => $indicatordetailsdefault,
            'getAllIndItem' => $getAllIndItem,
        );
        echo json_encode($outputData);
    }

    function getRegionByDivision() {
        $division_id = $this->input->post("division_id");
        if (is_int((int) $division_id)):
            $query = $this->db->query("select * from region where division_id = '$division_id' AND program_id = 1");
            if ($query->num_rows() > 0):
                $queryresult = $query->result();
                echo '<option value="">-- Select Region --</option>';
                foreach ($queryresult as $data):
                    echo '<option value="' . $data->region_id . '">' . $data->region_name . '</option>';
                endforeach;
            else:
                echo '<option value = "">no data found</option>';
            endif;
        else:
            echo '<option value = "">no data found</option>';
        endif;
    }

    function getAreaByRegion() {
        $region_id = $this->input->post("region_id");
        if (is_int((int) $region_id)):
            $query = $this->db->query("select * from area where region_id = '$region_id' AND program_id = 1");
            if ($query->num_rows() > 0):
                $queryresult = $query->result();
                echo '<option value="">-- Select Area --</option>';
                foreach ($queryresult as $data):
                    echo '<option value="' . $data->area_id . '">' . $data->area_name . '</option>';
                endforeach;
            else:
                echo '<option value = "">no data found</option>';
            endif;
        else:
            echo '<option value = "">no data found</option>';
        endif;
    }

    function getBranchByArea() {
        $area_id = $this->input->post("area_id");
        if (is_int((int) $area_id)):
            $query = $this->db->query("select * from branch where area_id = '$area_id' AND program_id = 1");
            if ($query->num_rows() > 0):
                $queryresult = $query->result();
                echo '<option value="">-- Select Branch --</option>';
                foreach ($queryresult as $data):
                    echo '<option value="' . $data->branch_id . '">' . $data->branch_id . '-' . $data->branch_name . '</option>';
                endforeach;
            else:
                echo '<option value = "">no data found</option>';
            endif;
        else:
            echo '<option value = "">no data found</option>';
        endif;
    }

    function advanceExport() {
        if (in_array($this->session->userdata('user_level'), array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15))):
            $programId = 1;
            $user_level = $this->session->userdata('user_level');
            //Delete all files and folder from advanceexport directory / not working
            //$dir = $this->config->item('base_url') . 'assets/download/advanceexport/';
            //$this->load->helper("file"); // load the helper
            //delete_files($dir, true); // delete all files/folders

            if (in_array($user_level, array(4, 5, 6, 7, 13, 15)) && ($this->input->post('divisionidval'))):
                $divisionidval = $this->input->post('divisionidval');
                $regionidval = $this->input->post('regionidval');
                $areaidval = $this->input->post('areaidval');
                $branchidval = $this->input->post('branchidval');

                $monthfrom = $this->input->post('advexpmonthfrom');
                $monthto = $this->input->post('advexpmonthto');
                $d1 = new DateTime($monthfrom);
                $d2 = new DateTime($monthto);
                $dateinterval = date_diff($d1, $d2);
                $addmonth = (intval($dateinterval->d) >= 28 ? 1 : 0);  //In case 30days month interval does not count so manually I add one month.
                $monthinterval = $dateinterval->m + ($dateinterval->y * 12) + $addmonth;
                if ($d1 >= $d2 || $monthinterval > 12):
                    $monthinterval = 12;
                    $monthfrom = date('Y-m', strtotime(date('Y-m') . " -13 month"));
                    $monthto = date('Y-m', strtotime(date('Y-m') . " -1 month"));
                endif;

                $indicatorvallist = array();
                $indicatordetailsval = $this->input->post('indicatordetailsval');
                if ($indicatordetailsval == ""):
                    $indicatordetailsval = array();
                endif;
                $defaultinddata = $this->advancedata->defaultInd($programId);
                $indicatorvallist = array_merge($indicatordetailsval, $defaultinddata);

                $yrmonArr = array();
                $monthqueryStr = "";
                $monthintervalll = $monthinterval;
                for ($m = $monthintervalll; $m >= 0; $m--):
                    $subm = $m;
                    $subval = '-' . $subm . 'month';
                    $previousmonStr = date('Y-m-t', strtotime($monthto . " $subval"));
                    $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
                    $yrmonArr[] = date('M-Y', strtotime($monthto . " $subval"));
                endfor;
                $monthqueryStr = substr($monthqueryStr, 1);

                //Division data excel prepare
                $monthtoname = date('M-Y', strtotime($monthto));
                $divisionQr = $this->advancedata->getLocationName('division_id', $divisionidval, 'division');
                $division_name = $divisionQr->division_name;
                $row1text = "BRAC Microfinance";
                $row2text = "Divisional Trend Report as on " . $monthtoname;
                $row3text = "Division Name: " . $division_name;
                $titletext = "Division-" . $division_name;
                //Write into excel file
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                $objPHPExcel->getActiveSheet()->setTitle($titletext);
                $dir_name = "assets/download/advanceexport/" . $division_name . "-" . date('d-m-Y H:i:s');
                mkdir($dir_name);
                $rowNumber = 1;
                $col = 'B';
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                $rowNumber++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                $rowNumber++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                $rowNumber++;
                //Read data from database
                $resultdata = $this->advancedata->trendData('d_division', 'division_id', $divisionidval, $programId, $monthqueryStr, $indicatorvallist);
                if (sizeof($resultdata)):
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    $col = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                    $col++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                    $col++;
                    $yrmonlen = sizeof($yrmonArr);
                    for ($mn = 0; $mn < $yrmonlen; $mn++):
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                        $col++;
                    endfor;
                    $rowNumber++;
                    $col = 'A';
                    $itemno = 0;
                    foreach ($resultdata as $datarow):
                        if (is_numeric($datarow->item_no)):
                            $itemno++;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                        else:
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                        endif;
                        $col++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                        $col++;
                        for ($m = $monthintervalll; $m >= 1; $m--):
                            if (is_numeric($datarow->item_no)):
                                $monindex = 'previousmonth' . $m;
                                $colval = $datarow->$monindex;
                            else:
                                $colval = "";
                            endif;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                            $col++;
                        endfor;
                        $col = 'A';
                        $rowNumber++;
                    endforeach;
                    $objWriter->save($dir_name . '/' . $division_name . '_' . $monthtoname . '.xls');
                endif;

                //Get all region info from region table by division id
                $regionQr = $this->advancedata->getRegionInfo('division_id', $divisionidval, 'region');
                foreach ($regionQr as $regiondata):
                    $regionid = $regiondata->region_id;
                    if (in_array($regionid, $regionidval, true)):
                        $regionname = $regiondata->region_name;
                        $row1text = "BRAC Microfinance";
                        $row2text = "Regional Trend Report as on " . $monthtoname;
                        $row3text = "Region Name: " . $regionname;
                        $titletext = "Region-" . $regionname;
                        //Write into excel file
                        $objPHPExcel = new PHPExcel();
                        $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                        $objPHPExcel->getActiveSheet()->setTitle($titletext);
                        mkdir($dir_name . '/' . $regionname);
                        $rowNumber = 1;
                        $col = 'B';
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                        $rowNumber++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                        $rowNumber++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                        $rowNumber++;
                        //Read data from database
                        $resultdata = $this->advancedata->trendData('d_region', 'region_id', $regionid, $programId, $monthqueryStr, $indicatorvallist);
                        if (sizeof($resultdata)):
                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                            $col = 'A';
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                            $col++;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                            $col++;
                            $yrmonlen = sizeof($yrmonArr);
                            for ($mn = 0; $mn < $yrmonlen; $mn++):
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                                $col++;
                            endfor;
                            $rowNumber++;
                            $col = 'A';
                            $itemno = 0;
                            foreach ($resultdata as $datarow):
                                if (is_numeric($datarow->item_no)):
                                    $itemno++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                                else:
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                                endif;
                                $col++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                                $col++;
                                for ($m = $monthintervalll; $m >= 1; $m--):
                                    if (is_numeric($datarow->item_no)):
                                        $monindex = 'previousmonth' . $m;
                                        $colval = $datarow->$monindex;
                                    else:
                                        $colval = "";
                                    endif;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                                    $col++;
                                endfor;
                                $col = 'A';
                                $rowNumber++;
                            endforeach;
                            $objWriter->save($dir_name . '/' . $regionname . '/' . $regionname . '_' . $monthtoname . '.xls');
                        endif;

                        //Get all area info from area table by region id
                        $areaQr = $this->advancedata->getAreaInfo('region_id', $regionid, 'area');
                        foreach ($areaQr as $areadata):
                            $areaid = $areadata->area_id;
                            if (in_array($areaid, $areaidval, true)):
                                $areaname = $areadata->area_name;
                                $row1text = "BRAC Microfinance";
                                $row2text = "Area Trend Report as on " . $monthtoname;
                                $row3text = "Area Name: " . $areaname;
                                $titletext = "Area-" . $areaname;
                                //Write into excel file
                                $objPHPExcel = new PHPExcel();
                                $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                                $objPHPExcel->getActiveSheet()->setTitle($titletext);
                                mkdir($dir_name . '/' . $regionname . '/' . $areaname);
                                $rowNumber = 1;
                                $col = 'B';
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                                $rowNumber++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                                $rowNumber++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                                $rowNumber++;
                                //Read data from database
                                $resultdata = $this->advancedata->trendData('d_area', 'area_id', $areaid, $programId, $monthqueryStr, $indicatorvallist);
                                if (sizeof($resultdata)):
                                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                                    $col = 'A';
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                                    $col++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                                    $col++;
                                    $yrmonlen = sizeof($yrmonArr);
                                    for ($mn = 0; $mn < $yrmonlen; $mn++):
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                                        $col++;
                                    endfor;
                                    $rowNumber++;
                                    $col = 'A';
                                    $itemno = 0;
                                    foreach ($resultdata as $datarow):
                                        if (is_numeric($datarow->item_no)):
                                            $itemno++;
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                                        else:
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                                        endif;
                                        $col++;
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                                        $col++;
                                        for ($m = $monthintervalll; $m >= 1; $m--):
                                            if (is_numeric($datarow->item_no)):
                                                $monindex = 'previousmonth' . $m;
                                                $colval = $datarow->$monindex;
                                            else:
                                                $colval = "";
                                            endif;
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                                            $col++;
                                        endfor;
                                        $col = 'A';
                                        $rowNumber++;
                                    endforeach;
                                    $objWriter->save($dir_name . '/' . $regionname . '/' . $areaname . '/' . $areaname . '_' . $monthtoname . '.xls');
                                endif;

                                //Get all branch info from branch table by area id and program id
                                $branchQr = $this->advancedata->getBranchInfo('area_id', $areaid, $programId, 'branch');
                                foreach ($branchQr as $brdata):
                                    $branchid = $brdata->branch_id;
                                    if (in_array($branchid, $branchidval, true)):
                                        $branchname = $brdata->branch_name;
                                        $row1text = "BRAC Microfinance";
                                        $row2text = "Branch Trend Report as on " . $monthtoname;
                                        $row3text = "Branch Name: " . $branchname;
                                        $titletext = "Branch-" . str_replace('/', '-', $branchname);
                                        //Write into excel file
                                        $objPHPExcel = new PHPExcel();
                                        $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                                        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                                        $objPHPExcel->getActiveSheet()->setTitle($titletext);
                                        $rowNumber = 1;
                                        $col = 'B';
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                                        $rowNumber++;
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                                        $rowNumber++;
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                                        $rowNumber++;
                                        //Read data from database
                                        $resultdata = $this->advancedata->trendData('p_dabi', 'aocd', $branchid, $programId, $monthqueryStr, $indicatorvallist);
                                        if (sizeof($resultdata)):
                                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                                            $col = 'A';
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                                            $col++;
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                                            $col++;
                                            $yrmonlen = sizeof($yrmonArr);
                                            for ($mn = 0; $mn < $yrmonlen; $mn++):
                                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                                                $col++;
                                            endfor;
                                            $rowNumber++;
                                            $col = 'A';
                                            $itemno = 0;
                                            foreach ($resultdata as $datarow):
                                                if (is_numeric($datarow->item_no)):
                                                    $itemno++;
                                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                                                else:
                                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                                                endif;
                                                $col++;
                                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                                                $col++;
                                                for ($m = $monthintervalll; $m >= 1; $m--):
                                                    if (is_numeric($datarow->item_no)):
                                                        $monindex = 'previousmonth' . $m;
                                                        $colval = $datarow->$monindex;
                                                    else:
                                                        $colval = "";
                                                    endif;
                                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                                                    $col++;
                                                endfor;
                                                $col = 'A';
                                                $rowNumber++;
                                            endforeach;
                                            $objWriter->save($dir_name . '/' . $regionname . '/' . $areaname . '/' . str_replace('/', '-', $branchname) . '_' . $monthtoname . '.xls');
                                        endif;
                                    endif;
                                endforeach; //end of branch excel file processing

                            endif;
                        endforeach;  //end of area excel file processing

                    endif;
                endforeach;  //end of region excel file processing

            elseif (in_array($user_level, array(3)) && ($this->input->post('regionidval'))):
                $regionidval = $this->input->post('regionidval');
                $areaidval = $this->input->post('areaidval');
                $branchidval = $this->input->post('branchidval');

                $monthfrom = $this->input->post('advexpmonthfrom');
                $monthto = $this->input->post('advexpmonthto');
                $d1 = new DateTime($monthfrom);
                $d2 = new DateTime($monthto);
                $dateinterval = date_diff($d1, $d2);
                $addmonth = (intval($dateinterval->d) >= 28 ? 1 : 0);  //In case 30days month interval does not count so manually I add one month.
                $monthinterval = $dateinterval->m + ($dateinterval->y * 12) + $addmonth;
                if ($d1 >= $d2 || $monthinterval > 12):
                    $monthinterval = 12;
                    $monthfrom = date('Y-m', strtotime(date('Y-m') . " -13 month"));
                    $monthto = date('Y-m', strtotime(date('Y-m') . " -1 month"));
                endif;

                $indicatorvallist = array();
                $indicatordetailsval = $this->input->post('indicatordetailsval');
                if ($indicatordetailsval == ""):
                    $indicatordetailsval = array();
                endif;
                $defaultinddata = $this->advancedata->defaultInd($programId);
                $indicatorvallist = array_merge($indicatordetailsval, $defaultinddata);

                $yrmonArr = array();
                $monthqueryStr = "";
                $monthintervalll = $monthinterval;
                for ($m = $monthintervalll; $m >= 0; $m--):
                    $subm = $m;
                    $subval = '-' . $subm . 'month';
                    $previousmonStr = date('Y-m-t', strtotime($monthto . " $subval"));
                    $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
                    $yrmonArr[] = date('M-Y', strtotime($monthto . " $subval"));
                endfor;
                $monthqueryStr = substr($monthqueryStr, 1);

                //Region data excel prepare
                $monthtoname = date('M-Y', strtotime($monthto));
                $regionQr = $this->advancedata->getLocationName('region_id', $regionidval, 'region');
                $region_name = $regionQr->region_name;
                $row1text = "BRAC Microfinance";
                $row2text = "Regional Trend Report as on " . $monthtoname;
                $row3text = "Region Name: " . $region_name;
                $titletext = "Region-" . $region_name;
                //Write into excel file
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                $objPHPExcel->getActiveSheet()->setTitle($titletext);
                $dir_name = "assets/download/advanceexport/" . $region_name . "-" . date('d-m-Y H:i:s');
                mkdir($dir_name);
                $rowNumber = 1;
                $col = 'B';
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                $rowNumber++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                $rowNumber++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                $rowNumber++;
                //Read data from database
                $resultdata = $this->advancedata->trendData('d_region', 'region_id', $regionidval, $programId, $monthqueryStr, $indicatorvallist);
                if (sizeof($resultdata)):
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    $col = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                    $col++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                    $col++;
                    $yrmonlen = sizeof($yrmonArr);
                    for ($mn = 0; $mn < $yrmonlen; $mn++):
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                        $col++;
                    endfor;
                    $rowNumber++;
                    $col = 'A';
                    $itemno = 0;
                    foreach ($resultdata as $datarow):
                        if (is_numeric($datarow->item_no)):
                            $itemno++;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                        else:
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                        endif;
                        $col++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                        $col++;
                        for ($m = $monthintervalll; $m >= 1; $m--):
                            if (is_numeric($datarow->item_no)):
                                $monindex = 'previousmonth' . $m;
                                $colval = $datarow->$monindex;
                            else:
                                $colval = "";
                            endif;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                            $col++;
                        endfor;
                        $col = 'A';
                        $rowNumber++;
                    endforeach;
                    $objWriter->save($dir_name . '/' . $region_name . '_' . $monthtoname . '.xls');
                endif;

                //Get all area info from area table by region id
                $areaQr = $this->advancedata->getAreaInfo('region_id', $regionidval, 'area');
                foreach ($areaQr as $areadata):
                    $areaid = $areadata->area_id;
                    if (in_array($areaid, $areaidval, true)):
                        $areaname = $areadata->area_name;
                        $row1text = "BRAC Microfinance";
                        $row2text = "Area Trend Report as on " . $monthtoname;
                        $row3text = "Area Name: " . $areaname;
                        $titletext = "Area-" . $areaname;
                        //Write into excel file
                        $objPHPExcel = new PHPExcel();
                        $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                        $objPHPExcel->getActiveSheet()->setTitle($titletext);
                        mkdir($dir_name . '/' . $areaname);
                        $rowNumber = 1;
                        $col = 'B';
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                        $rowNumber++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                        $rowNumber++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                        $rowNumber++;
                        //Read data from database
                        $resultdata = $this->advancedata->trendData('d_area', 'area_id', $areaid, $programId, $monthqueryStr, $indicatorvallist);
                        if (sizeof($resultdata)):
                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                            $col = 'A';
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                            $col++;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                            $col++;
                            $yrmonlen = sizeof($yrmonArr);
                            for ($mn = 0; $mn < $yrmonlen; $mn++):
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                                $col++;
                            endfor;
                            $rowNumber++;
                            $col = 'A';
                            $itemno = 0;
                            foreach ($resultdata as $datarow):
                                if (is_numeric($datarow->item_no)):
                                    $itemno++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                                else:
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                                endif;
                                $col++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                                $col++;
                                for ($m = $monthintervalll; $m >= 1; $m--):
                                    if (is_numeric($datarow->item_no)):
                                        $monindex = 'previousmonth' . $m;
                                        $colval = $datarow->$monindex;
                                    else:
                                        $colval = "";
                                    endif;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                                    $col++;
                                endfor;
                                $col = 'A';
                                $rowNumber++;
                            endforeach;
                            $objWriter->save($dir_name . '/' . $areaname . '/' . $areaname . '_' . $monthtoname . '.xls');
                        endif;

                        //Get all branch info from branch table by area id and program id
                        $branchQr = $this->advancedata->getBranchInfo('area_id', $areaid, $programId, 'branch');
                        foreach ($branchQr as $brdata):
                            $branchid = $brdata->branch_id;
                            if (in_array($branchid, $branchidval, true)):
                                $branchname = $brdata->branch_name;
                                $row1text = "BRAC Microfinance";
                                $row2text = "Branch Trend Report as on " . $monthtoname;
                                $row3text = "Branch Name: " . $branchname;
                                $titletext = "Branch-" . str_replace('/', '-', $branchname);
                                //Write into excel file
                                $objPHPExcel = new PHPExcel();
                                $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                                $objPHPExcel->getActiveSheet()->setTitle($titletext);
                                $rowNumber = 1;
                                $col = 'B';
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                                $rowNumber++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                                $rowNumber++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                                $rowNumber++;
                                //Read data from database
                                $resultdata = $this->advancedata->trendData('p_dabi', 'aocd', $branchid, $programId, $monthqueryStr, $indicatorvallist);
                                if (sizeof($resultdata)):
                                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                                    $col = 'A';
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                                    $col++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                                    $col++;
                                    $yrmonlen = sizeof($yrmonArr);
                                    for ($mn = 0; $mn < $yrmonlen; $mn++):
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                                        $col++;
                                    endfor;
                                    $rowNumber++;
                                    $col = 'A';
                                    $itemno = 0;
                                    foreach ($resultdata as $datarow):
                                        if (is_numeric($datarow->item_no)):
                                            $itemno++;
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                                        else:
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                                        endif;
                                        $col++;
                                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                                        $col++;
                                        for ($m = $monthintervalll; $m >= 1; $m--):
                                            if (is_numeric($datarow->item_no)):
                                                $monindex = 'previousmonth' . $m;
                                                $colval = $datarow->$monindex;
                                            else:
                                                $colval = "";
                                            endif;
                                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                                            $col++;
                                        endfor;
                                        $col = 'A';
                                        $rowNumber++;
                                    endforeach;
                                    $objWriter->save($dir_name . '/' . $areaname . '/' . str_replace('/', '-', $branchname) . '_' . $monthtoname . '.xls');
                                endif;
                            endif;
                        endforeach; //end of branch excel file processing
                    endif;
                endforeach;  //end of area excel file processing

            elseif (in_array($user_level, array(2)) && ($this->input->post('areaidval'))):
                $areaidval = $this->input->post('areaidval');
                $branchidval = $this->input->post('branchidval');

                $monthfrom = $this->input->post('advexpmonthfrom');
                $monthto = $this->input->post('advexpmonthto');
                $d1 = new DateTime($monthfrom);
                $d2 = new DateTime($monthto);
                $dateinterval = date_diff($d1, $d2);
                $addmonth = (intval($dateinterval->d) >= 28 ? 1 : 0);  //In case 30days month interval does not count so manually I add one month.
                $monthinterval = $dateinterval->m + ($dateinterval->y * 12) + $addmonth;
                if ($d1 >= $d2 || $monthinterval > 12):
                    $monthinterval = 12;
                    $monthfrom = date('Y-m', strtotime(date('Y-m') . " -13 month"));
                    $monthto = date('Y-m', strtotime(date('Y-m') . " -1 month"));
                endif;

                $indicatorvallist = array();
                $indicatordetailsval = $this->input->post('indicatordetailsval');
                if ($indicatordetailsval == ""):
                    $indicatordetailsval = array();
                endif;
                $defaultinddata = $this->advancedata->defaultInd($programId);
                $indicatorvallist = array_merge($indicatordetailsval, $defaultinddata);

                $yrmonArr = array();
                $monthqueryStr = "";
                $monthintervalll = $monthinterval;
                for ($m = $monthintervalll; $m >= 0; $m--):
                    $subm = $m;
                    $subval = '-' . $subm . 'month';
                    $previousmonStr = date('Y-m-t', strtotime($monthto . " $subval"));
                    $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
                    $yrmonArr[] = date('M-Y', strtotime($monthto . " $subval"));
                endfor;
                $monthqueryStr = substr($monthqueryStr, 1);

                //Region data excel prepare
                $monthtoname = date('M-Y', strtotime($monthto));
                $areaQr = $this->advancedata->getLocationName('area_id', $areaidval, 'area');
                $area_name = $areaQr->area_name;
                $row1text = "BRAC Microfinance";
                $row2text = "Area Trend Report as on " . $monthtoname;
                $row3text = "Area Name: " . $area_name;
                $titletext = "Area-" . $area_name;
                //Write into excel file
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                $objPHPExcel->getActiveSheet()->setTitle($titletext);
                $dir_name = "assets/download/advanceexport/" . $area_name . "-" . date('d-m-Y H:i:s');
                mkdir($dir_name);
                $rowNumber = 1;
                $col = 'B';
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                $rowNumber++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                $rowNumber++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                $rowNumber++;
                //Read data from database
                $resultdata = $this->advancedata->trendData('d_area', 'area_id', $areaidval, $programId, $monthqueryStr, $indicatorvallist);
                if (sizeof($resultdata)):
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    $col = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                    $col++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                    $col++;
                    $yrmonlen = sizeof($yrmonArr);
                    for ($mn = 0; $mn < $yrmonlen; $mn++):
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                        $col++;
                    endfor;
                    $rowNumber++;
                    $col = 'A';
                    $itemno = 0;
                    foreach ($resultdata as $datarow):
                        if (is_numeric($datarow->item_no)):
                            $itemno++;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                        else:
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                        endif;
                        $col++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                        $col++;
                        for ($m = $monthintervalll; $m >= 1; $m--):
                            if (is_numeric($datarow->item_no)):
                                $monindex = 'previousmonth' . $m;
                                $colval = $datarow->$monindex;
                            else:
                                $colval = "";
                            endif;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                            $col++;
                        endfor;
                        $col = 'A';
                        $rowNumber++;
                    endforeach;
                    $objWriter->save($dir_name . '/' . $area_name . '_' . $monthtoname . '.xls');
                endif;

                //Get all area info from area table by region id
                //Get all branch info from branch table by area id and program id
                $branchQr = $this->advancedata->getBranchInfo('area_id', $areaidval, $programId, 'branch');
                foreach ($branchQr as $brdata):
                    $branchid = $brdata->branch_id;
                    if (in_array($branchid, $branchidval, true)):
                        $branchname = $brdata->branch_name;
                        $row1text = "BRAC Microfinance";
                        $row2text = "Branch Trend Report as on " . $monthtoname;
                        $row3text = "Branch Name: " . $branchname;
                        $titletext = "Branch-" . str_replace('/', '-', $branchname);
                        //Write into excel file
                        $objPHPExcel = new PHPExcel();
                        $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
                        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
                        $objPHPExcel->getActiveSheet()->setTitle($titletext);
                        $rowNumber = 1;
                        $col = 'B';
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
                        $rowNumber++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
                        $rowNumber++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
                        $rowNumber++;
                        //Read data from database
                        $resultdata = $this->advancedata->trendData('p_dabi', 'aocd', $branchid, $programId, $monthqueryStr, $indicatorvallist);
                        if (sizeof($resultdata)):
                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                            $col = 'A';
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                            $col++;
                            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                            $col++;
                            $yrmonlen = sizeof($yrmonArr);
                            for ($mn = 0; $mn < $yrmonlen; $mn++):
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                                $col++;
                            endfor;
                            $rowNumber++;
                            $col = 'A';
                            $itemno = 0;
                            foreach ($resultdata as $datarow):
                                if (is_numeric($datarow->item_no)):
                                    $itemno++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                                else:
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                                endif;
                                $col++;
                                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                                $col++;
                                for ($m = $monthintervalll; $m >= 1; $m--):
                                    if (is_numeric($datarow->item_no)):
                                        $monindex = 'previousmonth' . $m;
                                        $colval = $datarow->$monindex;
                                    else:
                                        $colval = "";
                                    endif;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                                    $col++;
                                endfor;
                                $col = 'A';
                                $rowNumber++;
                            endforeach;
                            $objWriter->save($dir_name . '/' . str_replace('/', '-', $branchname) . '_' . $monthtoname . '.xls');
                        endif;
                    endif;
                endforeach; //end of branch excel file processing

            endif;


            //Create zip file and download
            $the_folder = $dir_name;
            $zip_file_name = "assets/download/advanceexport/TrendReport-" . date('d-m-Y H:i:s') . ".zip";
            $download_file = true;
            $za = new FlxZipArchive;
            $res = $za->open($zip_file_name, ZipArchive::CREATE);
            if ($res === TRUE) {
                $za->addDir($the_folder, basename($the_folder));
                $za->close();
            } else {
                echo 'Could not create a zip archive';
            }
            if ($download_file):
                ob_get_clean();
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false);
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";");
                header("Content-Transfer-Encoding: binary");
                header("Content-Length: " . filesize($zip_file_name));
                readfile($zip_file_name);
            endif;
        else:
            redirect('auth');
        endif;
    }

    function generateExcel() {
        if (in_array($this->session->userdata('user_level'), array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15))):

            $details = "Trend Report(Dabi) Excel Download";
            savelogdata("1031", $details);
            //Delete all files from trendreport_excel directory
            $dir = "assets/download/trendreport_excel/*";
            $files = glob($dir); // get all file names
            foreach ($files as $file) { // iterate files
                if (is_file($file))
                    unlink($file); // delete file
            }

            $branchId = $this->input->post('branch_id');
            $areaId = $this->input->post('area_id');
            $regionId = $this->input->post('region_id');
            $divisionId = $this->input->post('division_id');
            $useRole = $this->session->userdata('user_level');
            $programId = $this->input->post('programId');
            $initialdate = $this->input->post('initialdate');
            $monthinterval = $this->input->post('monthinterval');
            $notDefaultItem = $this->input->post('notDefaultItem');

            $associatedId = $this->session->userdata('associated_id');

            $indicatorvallist = $this->datesearch_model->indList($programId, $notDefaultItem);

            if ($monthinterval == 0):
                $monthinterval = 12;
            endif;
            $yrmonArr = array();
            $monthqueryStr = "";
            for ($m = $monthinterval; $m >= 0; $m--):
                $subval = '-' . $m . 'month';
                $previousmonStr = date('Y-m-t', strtotime($initialdate . " $subval"));
                $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
                $yrmonArr[] = date('M-Y', strtotime($initialdate . " $subval"));
            endfor;
            $monthqueryStr = substr($monthqueryStr, 1);
            $monthtoname = date('M-Y', strtotime($initialdate));

            ###When branchId###
            if ($branchId != NULL):
                $resultdata = $this->datesearch_model->treadReportBranchForExcel('p_dabi', 'aocd', $branchId, $programId, $monthqueryStr, $indicatorvallist);
                $query = $this->db->query("select * from branch where branch_id = '$branchId' AND program_id = '$programId'");
                $location_name = "not_found";
                if ($query->num_rows() > 0):
                    $location_name = $query->row()->branch_name;
                endif;
                $row1text = "BRAC Microfinance";
                $row2text = "Branch Trend Report as on " . $monthtoname;
                $row3text = "Branch Name: " . $location_name;
                $titletext = "Branch-" . str_replace('/', '-', $location_name);
            ###When areaId###
            elseif ($areaId != NULL):
                $resultdata = $this->datesearch_model->treadReportForExcel('d_area', 'area_id', $areaId, $programId, $monthqueryStr, $indicatorvallist);
                $query = $this->db->query("select * from area where area_id = '$areaId' AND program_id = '$programId'");
                $location_name = "not_found";
                if ($query->num_rows() > 0):
                    $location_name = $query->row()->area_name;
                endif;
                $row1text = "BRAC Microfinance";
                $row2text = "Area Trend Report as on " . $monthtoname;
                $row3text = "Area Name: " . $location_name;
                $titletext = "Area-" . $location_name;
            ###When regionId###
            elseif ($regionId != NULL):
                $resultdata = $this->datesearch_model->treadReportForExcel('d_region', 'region_id', $regionId, $programId, $monthqueryStr, $indicatorvallist);
                $query = $this->db->query("select * from region where region_id = '$regionId' AND program_id = '$programId'");
                $location_name = "not_found";
                if ($query->num_rows() > 0):
                    $location_name = $query->row()->region_name;
                endif;
                $row1text = "BRAC Microfinance";
                $row2text = "Regional Trend Report as on " . $monthtoname;
                $row3text = "Region Name: " . $location_name;
                $titletext = "Region-" . $location_name;
            ###When divisionId###
            elseif ($divisionId != NULL):
                ###Trend Report by Zone eastern###
                if ($divisionId == 'eastern'):
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_zone', 'zone_id', '1', $programId, $monthqueryStr, $indicatorvallist);
                    $location_name = 'Dabi Eastern';
                    $row1text = "BRAC Microfinance";
                    $row2text = "Zonal Trend Report as on " . $monthtoname;
                    $row3text = "Zone Name: " . $location_name;
                    $titletext = "Zone-" . $location_name;
                ###Trend Report by Zone eastern###
                elseif ($divisionId == 'western'):
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_zone', 'zone_id', '2', $programId, $monthqueryStr, $indicatorvallist);
                    $location_name = 'Dabi Western';
                    $row1text = "BRAC Microfinance";
                    $row2text = "Zonal Trend Report as on " . $monthtoname;
                    $row3text = "Zone Name: " . $location_name;
                    $titletext = "Zone-" . $location_name;
                else:
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_division', 'division_id', $divisionId, $programId, $monthqueryStr, $indicatorvallist);
                    #get region list using divisionId#                
                    $query = $this->db->query("select * from division where division_id = '$divisionId' AND program_id = '$programId'");
                    if ($query->num_rows() > 0):
                        $location_name = $query->row()->division_name;
                    endif;
                    $row1text = "BRAC Microfinance";
                    $row2text = "Divisional Trend Report as on " . $monthtoname;
                    $row3text = "Division Name: " . $location_name;
                    $titletext = "Division-" . $location_name;
                endif;
            else:
                $resultdata = array();
            endif;
            ###This is global trend report for all level by level user###
            if (($areaId == NULL) && ($divisionId == NULL) && ($regionId == NULL) && ($branchId == NULL)):
                ###global trend for level 5 , 6 and 7 (total global trend)###
                if (in_array($this->session->userdata('user_level'), array(5, 6, 7, 13, 14))):
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_program', 'program_id', $programId, $programId, $monthqueryStr, $indicatorvallist);
                    $row1text = "BRAC Microfinance";
                    $row2text = "Global Trend Report as on " . $monthtoname;
                    $row3text = "Global Trend Report";
                    $titletext = "Global Trend";
                    $location_name = "Global Trend";
                ###global trend for level 4 (total global trend)###
                elseif ($useRole == 4 || $useRole == 15):
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_program', 'program_id', $programId, $programId, $monthqueryStr, $indicatorvallist);
                    $row1text = "BRAC Microfinance";
                    $row2text = "Global Trend Report as on " . $monthtoname;
                    $row3text = "Global Trend Report";
                    $titletext = "Global Trend";
                    $location_name = "Global Trend";
                ###global trend for level 3 (divisional global for regional user)###
                elseif ($useRole == 3):
                    $queryForRole3 = $this->db->query("select * from region where region_id = '$associatedId' AND program_id = '$programId'");
                    $divisionIdforRole3 = $queryForRole3->row()->division_id;
                    $location_name = $queryForRole3->row()->division_name;
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_division', 'division_id', $divisionIdforRole3, $programId, $monthqueryStr, $indicatorvallist);
                    $row1text = "BRAC Microfinance";
                    $row2text = "Divisional Trend Report as on " . $monthtoname;
                    $row3text = "Division Name: " . $location_name;
                    $titletext = "Division-" . $location_name;
                ###global trend for level 2 (regional global for area user)###
                elseif ($useRole == 2):
                    $queryForRole2 = $this->db->query("select * from area where area_id = '$associatedId' AND program_id = '$programId'");
                    $areaIdforRole2 = $queryForRole2->row()->region_id;
                    $location_name = $queryForRole2->row()->region_name;
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_region', 'region_id', $areaIdforRole2, $programId, $monthqueryStr, $indicatorvallist);
                    $row1text = "BRAC Microfinance";
                    $row2text = "Regional Trend Report as on " . $monthtoname;
                    $row3text = "Region Name: " . $location_name;
                    $titletext = "Region-" . $location_name;
                ###global trend for level 1 (area global for branch user)###
                elseif ($useRole == 1):
                    $queryForRole1 = $this->db->query("select * from branch where branch_id = '$associatedId' AND program_id = '$programId'");
                    $branchIdforRole1 = $queryForRole1->row()->area_id;
                    $location_name = $queryForRole1->row()->area_name;
                    $resultdata = $this->datesearch_model->treadReportForExcel('d_area', 'area_id', $branchIdforRole1, $programId, $monthqueryStr, $indicatorvallist);
                    $row1text = "BRAC Microfinance";
                    $row2text = "Area Trend Report as on " . $monthtoname;
                    $row3text = "Area Name: " . $location_name;
                    $titletext = "Area-" . $location_name;
                else:
                    $resultdata = array();
                endif;
            endif;


            //Write into excel file
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getStyle('1:4')->getFont()->setName('Arial')->setSize(10)->setBold(true);
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
            $objPHPExcel->getActiveSheet()->setTitle($titletext);
            $rowNumber = 1;
            $col = 'B';
            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row1text);
            $rowNumber++;
            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row2text);
            $rowNumber++;
            $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row3text);
            $rowNumber++;

            //Read data from database
            $file_name = "assets/download/trendreport_excel/" . "dabi_" . str_replace('/','_',$location_name)  . "_trendreport_" . date("d-m-Y") . '.xlsx';

            if (sizeof($resultdata)):
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                ob_end_clean();
                $col = 'A';
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Sl.');
                $col++;
                $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, 'Item Name');
                $col++;
                $yrmonlen = sizeof($yrmonArr);
                for ($mn = 0; $mn < $yrmonlen; $mn++):
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $yrmonArr[$mn]);
                    $col++;
                endfor;
                $rowNumber++;
                $col = 'A';
                $itemno = 0;
                foreach ($resultdata as $datarow):
                    if (is_numeric($datarow->item_no)):
                        $itemno++;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $itemno);
                    else:
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->item_no);
                    endif;
                    $col++;
                    if ($branchId != NULL && $datarow->item_no == 52 && $programId < 5):
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, substr($datarow->indicator, 0, -1));
                    elseif ($branchId != NULL && $datarow->item_no == 50 && $programId > 4):
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, substr($datarow->indicator, 0, -1));
                    else:
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $datarow->indicator);
                    endif;
                    $col++;
                    for ($m = $monthinterval; $m >= 0; $m--):
                        if (is_numeric($datarow->item_no)):
                            $monindex = 'previousmonth' . $m;
                            $colval = $datarow->$monindex;
                        else:
                            $colval = "";
                        endif;
                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $colval);
                        $col++;
                    endfor;
                    $col = 'A';
                    $rowNumber++;
                endforeach;
                $objWriter->save($file_name);
            endif;
            echo $file_name;
        else:
            redirect('auth');
        endif;
    }

}
