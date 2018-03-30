<?php
/**
 * @author Saleh Ahmad  saleh@clouditbd.com
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllData($tablename)
    {
        $this->db->select('*');
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function getSelectedData($tablename, $selectedrow1, $selectedValue1)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }
    
    public function getSelectedDataRow($tablename, $selectedrow1, $selectedValue1)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $queryResult = $this->db->get($tablename);
        return $queryResult->row();
    }

    public function getSelectedDataTwo($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }
    
    public function getSelectedDataThree($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                         $selectedrow3, $selectedValue3)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    //check existing division name from division table
    public function getExtraProgram($tablename, $selectedrow1, $selectedValue1)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1 . ' !=', $selectedValue1);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function getExistName($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                 $selectedrow3, $selectedValue3)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3 . ' !=', $selectedValue3);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }
    
    public function getExistNameAdd($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function getExistNameThree($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                      $selectedrow3, $selectedValue3, $selectedrow4, $selectedValue4)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $this->db->where($selectedrow4 . ' !=', $selectedValue4);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }
    
    public function getExistNameThreeAdd($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                          $selectedrow3, $selectedValue3)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function getExistNameFour($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                     $selectedrow3, $selectedValue3, $selectedrow4, $selectedValue4, $selectedrow5,
                                     $selectedValue5)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $this->db->where($selectedrow4, $selectedValue4);
        $this->db->where($selectedrow5 . ' !=', $selectedValue5);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }
    
    public function getExistNameFourAdd($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                        $selectedrow3, $selectedValue3, $selectedrow4, $selectedValue4)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $this->db->where($selectedrow4, $selectedValue4);
        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function getExistNameSix($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                    $selectedrow3, $selectedValue3, $selectedrow4, $selectedValue4, $selectedrow5,
                                    $selectedValue5, $selectedrow6, $selectedValue6)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $this->db->where($selectedrow4, $selectedValue4);
        $this->db->where($selectedrow5, $selectedValue5);
        $this->db->where($selectedrow6 . ' !=', $selectedValue6);

        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function getExistNameFive($tablename, $selectedrow1, $selectedValue1, $selectedrow2, $selectedValue2,
                                     $selectedrow3, $selectedValue3, $selectedrow4, $selectedValue4, $selectedrow5,
                                     $selectedValue5)
    {
        $this->db->select('*');
        $this->db->where($selectedrow1, $selectedValue1);
        $this->db->where($selectedrow2, $selectedValue2);
        $this->db->where($selectedrow3, $selectedValue3);
        $this->db->where($selectedrow4, $selectedValue4);
        $this->db->where($selectedrow5, $selectedValue5);

        $queryResult = $this->db->get($tablename);
        return $queryResult->result();
    }

    public function inserdata($tablename, $tabledata)
    {
        $savedata = $this->db->insert($tablename, $tabledata);
        return $savedata ? true : false;
    }

    public function updateData($tablename, $id_row, $id_update, $updateData)
    {
        $this->db->where($id_row, $id_update);
        $query = $this->db->update($tablename, $updateData);
        return $query ? true : false;
    }

    public function deletedata($tablename, $id_row, $id_delete)
    {
        $deletedata = $this->db->delete($tablename, [$id_row => $id_delete]);
        return $deletedata ? true : false;
    }

}
