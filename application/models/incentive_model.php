<?php

class Incentive_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getTableAllData($tablename) {
        $this->db->select('*');
        $query = $this->db->get($tablename);
        return $query->result();
    }

    function getTableAllDataRow($tablename) {
        $this->db->select('*');
        $query = $this->db->get($tablename);
        return $query->row();
    }

    function getTableDataResultOneWhere($tablename, $field_name, $field_val) {
        $this->db->select('*');
        $this->db->where($field_name, $field_val);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    function getTableDataResultOneWhereRow($tablename, $field_name, $field_val) {
        $this->db->select('*');
        $this->db->where($field_name, $field_val);
        $query = $this->db->get($tablename);
        return $query->row();
    }

    function getQuarterInfo($current_month) {
        $quarterQr = $this->db->query("SELECT * FROM inc_quarter WHERE ('$current_month' BETWEEN `date_from` AND `date_to`)");
        return $quarterQr->row();
    }

    function getQuarterInfoById($quarter_id) {
        $this->db->select('*');
        $this->db->where('id', $quarter_id);
        $query = $this->db->get('inc_quarter');
        return $query->row();
    }

    function conQuarterRow($qid, $program_id) {
        $this->db->select('month,is_greater_value,is_less_value,cat5_actual,cat4_3_actual,cat2_1_actual');
        $this->db->join('inc_conditionset', 'inc_conditionset.id=condition_id');
        $this->db->where('program_id', $program_id);
        $this->db->where('quarter_id', $qid);
        $this->db->order_by('condition_id');
        $query = $this->db->get('inc_condition_quarter');
        return $query->result();
    }

    function gettableTwoWhereRow($tablename, $field_name1, $field_val1, $field_name2, $field_val2) {
        $this->db->select('*');
        $this->db->where($field_name1, $field_val1);
        $this->db->where($field_name2, $field_val2);
        $query = $this->db->get($tablename);
        return $query->row();
    }

    function getAlldata() {
        $this->db->select('*');
        $this->db->order_by("id", "DESC");
        $this->db->from('inc_quarter');
        $query = $this->db->get();
        return $query->result();
    }

    function editquarter($id) {
        $this->db->select('*');
        $this->db->from('inc_quarter');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getReceivingrateData($program_id, $quarter_id) {
        $query = $this->db->query("SELECT * FROM inc_receivingrate WHERE program_id = '$program_id' AND quarter_id = '$quarter_id'");
        return $query->result();
    }

    function getMaxMonthDataExist($table_name, $month_from, $month_to) {
        $query = $this->db->query("SELECT max(date) as maxdate FROM $table_name WHERE (date BETWEEN '$month_from' AND '$month_to')");
        return $query->row()->maxdate;
    }

    function getDataTableName($program_id) {
        $table_name = '';
        if ($program_id == 1):
            $table_name = 'inc_calcdabi';
        elseif ($program_id == 2):
            $table_name = 'inc_calcbcup';
        elseif ($program_id == 3):
            $table_name = 'inc_calcncdp';
        elseif ($program_id == 4):
            $table_name = 'inc_calcscdp';
        elseif ($program_id == 5):
            $table_name = 'inc_calcprogoti';
        elseif ($program_id == 6):
            $table_name = 'inc_calcbmo';
        endif;
        return $table_name;
    }

    function getMaxQuarterFromDataTab($table_name) {
        $this->db->select_max('quarter_id');
        $result = $this->db->get($table_name);
        return $result->row()->quarter_id;
    }

    function checkDataHasorNot($table_name, $quarter_id) {
        $this->db->select('id');
        $this->db->from($table_name);
        $this->db->where('quarter_id', $quarter_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function queryStrResult($str) {
        $query = $this->db->query($str);
        return $query;
    }

}

?>