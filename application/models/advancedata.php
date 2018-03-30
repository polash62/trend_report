<?php

class Advancedata extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function defaultInd($prgramid) {
        $this->db->select('sl_no');
        $this->db->where('program_id', $prgramid);
        $this->db->where('default_or_not', 1);
        $query = $this->db->get('indicatordetails');
        $defaultindarr = array();
        if (sizeof($query)):
            $querydata = $query->result();
            foreach ($querydata as $datarow):
                $defaultindarr[] = $datarow->sl_no;
            endforeach;
        endif;
        return $defaultindarr;
    }

    function defaultIndWithoutCat($prgramid) {
        $this->db->select('sl_no');
        $this->db->where('program_id', $prgramid);
        $this->db->where('item_no >', 0);
        $query = $this->db->get('indicatordetails');
        $defaultindarr = array();
        if (sizeof($query)):
            $querydata = $query->result();
            foreach ($querydata as $datarow):
                $defaultindarr[] = $datarow->sl_no;
            endforeach;
        endif;
        return $defaultindarr;
    }

    function defaultIndDetRep($prgramid) {
        $query = $this->db->query("SELECT sl_no FROM indicatordetails WHERE (item_no >= 1) AND program_id = '$prgramid' AND default_or_not = '1'");
        $defaultindarr = array();
        if ($query->num_rows() > 0):
            $querydata = $query->result();
            foreach ($querydata as $datarow):
                $defaultindarr[] = $datarow->sl_no;
            endforeach;
        endif;
        return $defaultindarr;
    }

    function getLocationName($fieldname, $fieldvalue, $tablename) {
        $this->db->select('*');
        $this->db->where($fieldname, $fieldvalue);
        $query = $this->db->get($tablename);
        return $query->row();
    }

    function getDivisionInfo($fieldname, $fieldvalue, $tablename) {
        $this->db->select('division_id,division_name');
        $this->db->order_by('division_name', 'asc');
        $this->db->where($fieldname, $fieldvalue);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    function getRegionInfo($fieldname, $fieldvalue, $tablename) {
        $this->db->select('region_id,region_name');
        $this->db->where($fieldname, $fieldvalue);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    function getAreaInfo($fieldname, $fieldvalue, $tablename) {
        $this->db->select('area_id,area_name,region_id,region_name');
        $this->db->where($fieldname, $fieldvalue);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    function getBranchInfo($fieldname, $fieldvalue, $program_id, $tablename) {
        $this->db->select('branch_id,branch_name,area_name,region_name');
        $this->db->where($fieldname, $fieldvalue);
        $this->db->where('program_id', $program_id);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    function trendData($tablename, $idrow, $id, $programid, $monthqueryStr, $indicatorvallist) {
        $datarowQrStr = "";
        $sizeoflist = sizeof($indicatorvallist) - 1;
        for ($i = 0; $i < $sizeoflist; $i++):
            $datarowQrStr .= "SELECT date , `$indicatorvallist[$i]` value ,'$indicatorvallist[$i]' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all ";
        endfor;
        $datarowQrStr .= "SELECT date , `$indicatorvallist[$i]` value ,'$indicatorvallist[$i]' serial from $tablename where $idrow = '$id' AND program_id = '$programid'";

        $qRyString = $this->db->query("select serial,item_no,indicator, $monthqueryStr         
          from( $datarowQrStr )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = '$programid' AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        $resultData = $qRyString->result();
        return $resultData;
    }

    function trendDataYearly($tablename, $idrow, $id, $programid, $monthqueryStr, $indicatorvallist) {
        $datarowQrStr = "";
        $sizeoflist = sizeof($indicatorvallist) - 1;
        for ($i = 0; $i < $sizeoflist; $i++):
            $ind_slno = $indicatorvallist[$i];
            if ($programid < 5 && (in_array($ind_slno, array(2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 15, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 37, 39, 53, 54, 60, 61, 62, 63, 64)))):
                $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, SUBSTRING_INDEX( GROUP_CONCAT(CAST(`$ind_slno` AS CHAR) ORDER BY date DESC), ',', 1 ) as value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d')) union all ";
            elseif ($programid == 5 && (in_array($ind_slno, array(2, 3, 4, 5, 6, 7, 8, 10, 13, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 33, 35, 37, 51, 52, 58, 59, 60, 61, 62)))):
                $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, SUBSTRING_INDEX( GROUP_CONCAT(CAST(`$ind_slno` AS CHAR) ORDER BY date DESC), ',', 1 ) as value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d')) union all ";
            elseif ($programid < 5 && $ind_slno == 52):
                $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, AVG(((`32`/`23`) * 100)) value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d')) union all ";
            elseif ($programid > 4 && $ind_slno == 50):
                $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, AVG(((`30`/`21`) * 100)) value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d')) union all ";
            else:
                $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, `$ind_slno` value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all ";
            endif;
        endfor;
        $ind_slno = $indicatorvallist[$i];
        if ($programid < 5 && (in_array($ind_slno, array(2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 15, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 37, 39, 53, 54, 60, 61, 62, 63, 64)))):
            $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, SUBSTRING_INDEX( GROUP_CONCAT(CAST(`$ind_slno` AS CHAR) ORDER BY date DESC), ',', 1 ) as value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d'))";
        elseif ($programid == 5 && (in_array($ind_slno, array(2, 3, 4, 5, 6, 7, 8, 10, 13, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 33, 35, 37, 51, 52, 58, 59, 60, 61, 62)))):
            $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, SUBSTRING_INDEX( GROUP_CONCAT(CAST(`$ind_slno` AS CHAR) ORDER BY date DESC), ',', 1 ) as value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d'))";
        elseif ($programid < 5 && $ind_slno == 52):
            $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, AVG(((`32`/`23`) * 100)) value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d'))";
        elseif ($programid > 4 && $ind_slno == 50):
            $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, AVG(((`30`/`21`) * 100)) value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid' GROUP BY YEAR(STR_TO_DATE(date, '%Y-%m-%d'))";
        else:
            $datarowQrStr .= "SELECT YEAR(STR_TO_DATE(date, '%Y-%m-%d')) date, `$ind_slno` value ,'$ind_slno' serial from $tablename where $idrow = '$id' AND program_id = '$programid'";
        endif;
        $qRyString = $this->db->query("select serial,item_no,indicator, $monthqueryStr         
          from( $datarowQrStr )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = '$programid' AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        $resultData = $qRyString->result();
        return $resultData;
    }

    //select YEAR(STR_TO_DATE(date, "%Y-%m-%d")), SUBSTRING_INDEX( GROUP_CONCAT(CAST(`2` AS CHAR) ORDER BY date DESC), ',', 1 ) as value ,'2' serial from d_program where program_id =1 GROUP BY YEAR(STR_TO_DATE(date, "%Y-%m-%d"))

    function getDivisionInfoByDivisionId($fieldname, $fieldvalue, $tablename) {
        $this->db->select('division_id,division_name');
        $this->db->where_in($fieldname, $fieldvalue);
        $this->db->order_by('division_name', 'asc');
        $query = $this->db->get($tablename);
        return $query->result();
    }

}
