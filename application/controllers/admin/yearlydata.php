<?php

class YearlyData extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('common_helper');
        $this->load->library('curl');
        $this->load->model('advancedata');
        require_once APPPATH . "/third_party/counter.php";
        $this->online = getcountonlineuser();
        $this->day = $day;
        $this->all = $all;
    }

    function index() {
        $data['baseurl'] = $this->config->item('base_url');
        $data['title'] = "Yearly Data";
        $data['active_menu'] = "admin";
        $data['active_sub_menu'] = "yearlydata";

        if (in_array($this->session->userdata('user_level'), array(5, 6, 7))):
            $data['online'] = $this->online;
            $data['day'] = $this->day;
            $data['all'] = $this->all;
            $programQr = $this->db->query("SELECT * FROM program WHERE status = '1' AND program_id <= 5");
            $data['programlist'] = $programQr->result();

            $yearQr = $this->db->query("SELECT DISTINCT(DATE_FORMAT(date, '%Y')) AS year from p_dabi");
            $data['yearList'] = $yearQr->result();

            $this->load->view('common/header', $data);
            $this->load->view('common/sidebar_admin', $data);
            $this->load->view('admin/yearlydata', $data);
            $this->load->view('common/footer', $data);
        else:
            redirect('auth');
        endif;
    }

    function getDivision() {
        $id = $this->input->get('program');
        $queryStr = $this->db->query("SELECT DISTINCT division_id,division_name from division  WHERE program_id='$id' order by division_name")->result();
        echo json_encode($queryStr);
    }

    function getYear() {
        $date = $this->input->get('date');
        $queryStr = $this->db->query("SELECT  DISTINCT(DATE_FORMAT(date, '%Y')) AS year from p_dabi  WHERE DATE_FORMAT(date, '%Y') BETWEEN '$date' AND date_format(date,'%Y')")->result();
        echo json_encode($queryStr);
    }

    function getAction() {
        $programId = $this->input->post('programId');
        $division = $this->input->post('divisionList');
        $yearFrom = $this->input->post('year_from');
        $yearTo = $this->input->post('year_to');
        $divisionList = implode(",", $division);

        $url_2 = site_url('admin/yearlydata/yearlyCreateDetailReportExcel');
        $this->curl->simple_get($url_2, array('programId' => $programId, 'divisionList' => $divisionList, 'yearFrom' => $yearFrom, 'yearTo' => $yearTo));

        $this->session->set_userdata('successfull', 'Data Reprocess Started Successfully...');
        redirect('admin/yearlydata');
    }

    function yearlyCreateDetailReportExcel() {
        $programId = $this->input->get('programId');
        $divisionList = $this->input->get('divisionList');
        $yearFrom = $this->input->get('yearFrom');
        $yearTo = $this->input->get('yearTo');

        if ($programId == 1):
            $branch_datatable = "p_dabi";
        elseif ($programId == 2):
            $branch_datatable = "p_bcup";
        elseif ($programId == 3):
            $branch_datatable = "p_ncdp";
        elseif ($programId == 4):
            $branch_datatable = "p_scdp";
        elseif ($programId == 5):
            $branch_datatable = "p_progoti";
        endif;

        for ($i = $yearFrom; $i <= $yearTo; $i++):
            $yearQr = $this->db->query("SELECT MIN(date) AS yearfrom, MAX(date) AS yearto FROM $branch_datatable WHERE (DATE_FORMAT(date, '%Y') = '$i')");
            if ($yearQr->row()->yearfrom != '' || $yearQr->row()->yearto != ''):
                $this->createDetailsFile($programId, $divisionList, $yearQr->row()->yearfrom, $yearQr->row()->yearto);
            endif;
        endfor;
    }

    function createDetailsFile($programId, $divisionList, $mindate, $maxdate) {
        $program_name = "";
        if ($programId == 1):
            $branch_datatable = "p_dabi";
            $program_name = "dabi";
        elseif ($programId == 2):
            $branch_datatable = "p_bcup";
            $program_name = "bcup";
        elseif ($programId == 3):
            $branch_datatable = "p_ncdp";
            $program_name = "ncdp";
        elseif ($programId == 4):
            $branch_datatable = "p_scdp";
            $program_name = "scdp";
        elseif ($programId == 5):
            $branch_datatable = "p_progoti";
            $program_name = "progoti";
        endif;


        $d1 = new DateTime($mindate);
        $d2 = new DateTime($maxdate);

        $dateinterval = date_diff($d1, $d2);
        $addmonth = (intval($dateinterval->d) > 28 ? 1 : 0);
        $monthinterval = $dateinterval->m + ($dateinterval->y * 12) + $addmonth;

        $indicatorvallist = $this->advancedata->defaultIndWithoutCat($programId);
        $initialdate = date('Y-m', strtotime($maxdate));
        $yrmonArr = array();
        $monthqueryStr = "";

        for ($m = $monthinterval; $m >= 0; $m--):
            $subval = '-' . $m . 'month';
            $previousmonStr = date('Y-m-t', strtotime($initialdate . " $subval"));
            //echo $subval . '//' . $maxdate . '//' . $previousmonStr . "===";
            $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
            $yrmonArr[] = date('M-Y', strtotime($initialdate . " $subval"));
        endfor;

        $monthqueryStr = substr($monthqueryStr, 1);

        $my_file = fopen("assets/download/detailreport_defaultexcel_yearly/logfile.txt", "w");
        $divisionQr = $this->db->query("SELECT division_id,division_name from division where division_id  IN ($divisionList) order by division_id asc")->result();
        if (sizeof($divisionQr)):
            foreach ($divisionQr as $divisiondata):
                $division_id = $divisiondata->division_id;
                $division_name = $divisiondata->division_name;
                $branchData_arr = array();
                $branchName_arr = array();
                $branchID_arr = array();
                $branch_regionName_arr = array();
                $branch_areaName_arr = array();
                $tabledata = "";

                $arr_index = 0;
                $qRyresult = $this->advancedata->trendData('d_division', 'division_id', $division_id, $programId, $monthqueryStr, $indicatorvallist);
                //Get all region info from region table by division id
                $regionQr = $this->advancedata->getRegionInfo('division_id', $division_id, 'region');
                foreach ($regionQr as $regiondata):
                    $regionid = $regiondata->region_id;
                    $areaQr = $this->advancedata->getAreaInfo('region_id', $regionid, 'area');
                    foreach ($areaQr as $areadata):
                        $areaid = $areadata->area_id;
                        $branchQr = $this->advancedata->getBranchInfo('area_id', $areaid, $programId, 'branch');
                        foreach ($branchQr as $brdata):
                            $branchid = $brdata->branch_id;
                            $resultdata = $this->advancedata->trendData($branch_datatable, 'aocd', $branchid, $programId, $monthqueryStr, $indicatorvallist);
                            $branchData_arr[$arr_index] = $resultdata;
                            $branchName_arr[$arr_index] = $brdata->branch_name;
                            $branchID_arr[$arr_index] = $brdata->branch_id;
                            $branch_regionName_arr[$arr_index] = $regiondata->region_name;
                            $branch_areaName_arr[$arr_index] = $areadata->area_name;
                            fwrite($my_file, " branchid= " . $branchid);
                            $arr_index++;
                        endforeach;
                    endforeach;
                endforeach;

                $file_name = "assets/download/detailreport_defaultexcel_yearly/" . date('Y', strtotime($maxdate)) . '_' . $program_name . "_" . $division_name . ".xls";
                fwrite($my_file, "arr_index= " . $arr_index);

                //Write into excel file
                if ($arr_index > 0):
                    $yrmnlen = sizeof($yrmonArr);
                    $row1text = "BRAC Microfinance";
                    $row2text = "Detail Report from " . date('M-Y', strtotime($yrmonArr[0])) . " to " . date('M-Y', strtotime($yrmonArr[$yrmnlen - 1]));

                    $tabledata .= '<table border="1">';
                    $tabledata .= '<tbody>';
                    $tabledata .= '<tr>';
                    $tabledata .= '<td align="center" colspan="5"><b>' . $row1text . '</b></td>';
                    $tabledata .= '</tr>';
                    $tabledata .= '<tr>';
                    $tabledata .= '<td align="center" colspan="5"><b>' . $row2text . '</b></td>';
                    $tabledata .= '</tr>';

                    $tabledata .= '<tr>';
                    $tabledata .= '<td align="center" rowspan="2"> <b> Division </b></td>';
                    $tabledata .= '<td align="center" rowspan="2"><b>Region</b></td>';
                    $tabledata .= '<td align="center" rowspan="2"><b>Area</b></td>';
                    $tabledata .= '<td align="center" rowspan="2"><b>Branch</b></td>';
                    $tabledata .= '<td align="center" rowspan="2"><b>Branch Code</b></td>';
                    foreach ($qRyresult as $datarow):
                        $tabledata .= '<td align="center" colspan="' . $yrmnlen . '"><b>' . $datarow->indicator . '</b></td>';
                    endforeach;
                    $tabledata .= '</tr>';
                    $tabledata .= '<tr>';
                    foreach ($qRyresult as $datarow):
                        for ($m = 0; $m < $yrmnlen; $m++):
                            $tabledata .= '<td align="center"><b>' . $yrmonArr[$m] . '</b></td>';
                        endfor;
                    endforeach;
                    $tabledata .= '</tr>';

                    for ($ri = 0; $ri < sizeof($branchName_arr); $ri++):
                        fwrite($my_file, "loop= " . $ri);
                        $tabledata .= '<tr>';
                        $tabledata .= '<td align="center">' . $division_name . '</td>';
                        $tabledata .= '<td align="center">' . $branch_regionName_arr[$ri] . '</td>';
                        $tabledata .= '<td align="center">' . $branch_areaName_arr[$ri] . '</td>';
                        $tabledata .= '<td align="center">' . $branchName_arr[$ri] . '</td>';
                        $tabledata .= '<td align="center">' . $branchID_arr[$ri] . '</td>';
                        foreach ($branchData_arr[$ri] as $datarow):
                            for ($m = $yrmnlen - 1; $m >= 0; $m--):
                                $monindex = 'previousmonth' . $m;
                                $tabledata .= '<td align="center">' . number_format($datarow->$monindex) . '</td>';
                            endfor;
                        endforeach;
                        $tabledata .= '</tr>';
                    endfor;
                    $tabledata .= '</tbody>';
                    $tabledata .= '</table>';
                endif;
                file_put_contents($file_name, $tabledata);
            endforeach;
        endif;
        //exit();
    }

}
