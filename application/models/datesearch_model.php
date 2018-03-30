<?php

class Datesearch_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function indList($prgramid, $notDefaultItem) {
        if ($notDefaultItem != ""):
            $notDefaultItem = explode(',', $notDefaultItem);
        endif;
        $this->db->select('sl_no');
        $this->db->where('program_id', $prgramid);
        if (sizeof($notDefaultItem)):
            $this->db->where_not_in('item_no', $notDefaultItem);
        endif;
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

    function treadReport($tablename, $idrow, $id, $programid, $initialdate, $monthinterval) {
        ########################################################  find previoun 13 month  ###################################################################
        if ($monthinterval == 0):
            $previous1 = date('Y-m-t', strtotime($initialdate));
            $previousmonth1 = date('MY', strtotime($initialdate));
            $data['previousmonth1'] = date('M-Y', strtotime($initialdate));
            $previous2 = date('Y-m-t', strtotime($initialdate . " -1 month"));
            $previousmonth2 = date('MY', strtotime($initialdate . " -1 month"));
            $data['previousmonth2'] = date('M-Y', strtotime($initialdate . " -1 month"));
            $previous3 = date('Y-m-t', strtotime($initialdate . " -2 month"));
            $previousmonth3 = date('MY', strtotime($initialdate . " -2 month"));
            $data['previousmonth3'] = date('M-Y', strtotime($initialdate . " -2 month"));
            $previous4 = date('Y-m-t', strtotime($initialdate . " -3 month"));
            $previousmonth4 = date('MY', strtotime($initialdate . " -3 month"));
            $data['previousmonth4'] = date('M-Y', strtotime($initialdate . " -3 month"));
            $previous5 = date('Y-m-t', strtotime($initialdate . " -4 month"));
            $previousmonth5 = date('MY', strtotime($initialdate . " -4 month"));
            $data['previousmonth5'] = date('M-Y', strtotime($initialdate . " -4 month"));
            $previous6 = date('Y-m-t', strtotime($initialdate . " -5 month"));
            $previousmonth6 = date('MY', strtotime($initialdate . " -5 month"));
            $data['previousmonth6'] = date('M-Y', strtotime($initialdate . " -5 month"));
            $previous7 = date('Y-m-t', strtotime($initialdate . " -6 month"));
            $previousmonth7 = date('MY', strtotime($initialdate . " -6 month"));
            $data['previousmonth7'] = date('M-Y', strtotime($initialdate . " -6 month"));
            $previous8 = date('Y-m-t', strtotime($initialdate . " -7 month"));
            $previousmonth8 = date('MY', strtotime($initialdate . " -7 month"));
            $data['previousmonth8'] = date('M-Y', strtotime($initialdate . " -7 month"));
            $previous9 = date('Y-m-t', strtotime($initialdate . " -8 month"));
            $previousmonth9 = date('MY', strtotime($initialdate . " -8 month"));
            $data['previousmonth9'] = date('M-Y', strtotime($initialdate . " -8 month"));
            $previous10 = date('Y-m-t', strtotime($initialdate . " -9 month"));
            $previousmonth10 = date('MY', strtotime($initialdate . " -9 month"));
            $data['previousmonth10'] = date('M-Y', strtotime($initialdate . " -9 month"));
            $previous11 = date('Y-m-t', strtotime($initialdate . " -10 month"));
            $previousmonth11 = date('MY', strtotime($initialdate . " -10 month"));
            $data['previousmonth11'] = date('M-Y', strtotime($initialdate . " -10 month"));
            $previous12 = date('Y-m-t', strtotime($initialdate . " -11 month"));
            $previousmonth12 = date('MY', strtotime($initialdate . " -11 month"));
            $data['previousmonth12'] = date('M-Y', strtotime($initialdate . " -11 month"));
            $previous13 = date('Y-m-t', strtotime($initialdate . " -12 month"));
            $previousmonth13 = date('MY', strtotime($initialdate . " -12 month"));
            $data['previousmonth13'] = date('M-Y', strtotime($initialdate . " -12 month"));
            $monthqueryStr = "sum(case when date = '$previous13' then value else 0 end) 'previousmonth13',
          sum(case when date = '$previous12' then value else 0 end) 'previousmonth12',
          sum(case when date = '$previous11' then value else 0 end) 'previousmonth11',
          sum(case when date = '$previous10' then value else 0 end) 'previousmonth10',
          sum(case when date = '$previous9' then value else 0 end) 'previousmonth9',
          sum(case when date = '$previous8' then value else 0 end) 'previousmonth8',
          sum(case when date = '$previous7' then value else 0 end) 'previousmonth7',
          sum(case when date = '$previous6' then value else 0 end) 'previousmonth6',
          sum(case when date = '$previous5' then value else 0 end) 'previousmonth5',
          sum(case when date = '$previous4' then value else 0 end) 'previousmonth4',
          sum(case when date = '$previous3' then value else 0 end) 'previousmonth3',
          sum(case when date = '$previous2' then value else 0 end) 'previousmonth2',
          sum(case when date = '$previous1' then value else 0 end) 'previousmonth1'";
        else:
            $monthqueryStr = "";
            $monthintervalll = $monthinterval + 1;
            for ($m = $monthintervalll; $m >= 1; $m--):
                $subm = $m - 1;
                $subval = '-' . $subm . 'month';
                $previousmonStr = date('Y-m-t', strtotime($initialdate . " $subval"));
                $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
            endfor;
            $monthqueryStr = substr($monthqueryStr, 1);
        endif;
        ########################################################  /find previoun 13 month  ###################################################################
        if ($tablename == 'd_program'):
            $qRyString = $this->db->query("select serial,item_no,indicator,default_or_not, $monthqueryStr
          from(
          select date , `1` value ,'1' serial from $tablename where program_id = $programid union all
          select date , `2` value ,'2' serial from $tablename where program_id = $programid union all
          select date , `3` value ,'3' serial from $tablename where program_id = $programid union all
          select date , `4` value ,'4' serial from $tablename where program_id = $programid union all
          select date , `5` value ,'5' serial from $tablename where program_id = $programid union all
          select date , `6` value ,'6' serial from $tablename where program_id = $programid union all
          select date , `7` value ,'7' serial from $tablename where program_id = $programid union all
          select date , `8` value ,'8' serial from $tablename where program_id = $programid union all
          select date , `9` value ,'9' serial from $tablename where program_id = $programid union all
          select date , `10` value ,'10' serial from $tablename where program_id = $programid union all
          select date , `11` value ,'11' serial from $tablename where program_id = $programid union all
          select date , `12` value ,'12' serial from $tablename where program_id = $programid union all
          select date , `13` value ,'13' serial from $tablename where program_id = $programid union all
          select date , `14` value ,'14' serial from $tablename where program_id = $programid union all
          select date , `15` value ,'15' serial from $tablename where program_id = $programid union all
          select date , `16` value ,'16' serial from $tablename where program_id = $programid union all
          select date , `17` value ,'17' serial from $tablename where program_id = $programid union all
          select date , `18` value ,'18' serial from $tablename where program_id = $programid union all
          select date , `19` value ,'19' serial from $tablename where program_id = $programid union all
          select date , `20` value ,'20' serial from $tablename where program_id = $programid union all
          select date , `21` value ,'21' serial from $tablename where program_id = $programid union all
          select date , `22` value ,'22' serial from $tablename where program_id = $programid union all
          select date , `23` value ,'23' serial from $tablename where program_id = $programid union all
          select date , `24` value ,'24' serial from $tablename where program_id = $programid union all
          select date , `25` value ,'25' serial from $tablename where program_id = $programid union all
          select date , `26` value ,'26' serial from $tablename where program_id = $programid union all
          select date , `27` value ,'27' serial from $tablename where program_id = $programid union all
          select date , `28` value ,'28' serial from $tablename where program_id = $programid union all
          select date , `29` value ,'29' serial from $tablename where program_id = $programid union all
          select date , `30` value ,'30' serial from $tablename where program_id = $programid union all
          select date , `31` value ,'31' serial from $tablename where program_id = $programid union all
          select date , `32` value ,'32' serial from $tablename where program_id = $programid union all
          select date , `33` value ,'33' serial from $tablename where program_id = $programid union all
          select date , `34` value ,'34' serial from $tablename where program_id = $programid union all
          select date , `35` value ,'35' serial from $tablename where program_id = $programid union all
          select date , `36` value ,'36' serial from $tablename where program_id = $programid union all
          select date , `37` value ,'37' serial from $tablename where program_id = $programid union all
          select date , `38` value ,'38' serial from $tablename where program_id = $programid union all
          select date , `39` value ,'39' serial from $tablename where program_id = $programid union all
          select date , `40` value ,'40' serial from $tablename where program_id = $programid union all
          select date , `41` value ,'41' serial from $tablename where program_id = $programid union all
          select date , `42` value ,'42' serial from $tablename where program_id = $programid union all
          select date , `43` value ,'43' serial from $tablename where program_id = $programid union all
          select date , `44` value ,'44' serial from $tablename where program_id = $programid union all
          select date , `45` value ,'45' serial from $tablename where program_id = $programid union all
          select date , `46` value ,'46' serial from $tablename where program_id = $programid union all
          select date , `47` value ,'47' serial from $tablename where program_id = $programid union all
          select date , `48` value ,'48' serial from $tablename where program_id = $programid union all
          select date , `49` value ,'49' serial from $tablename where program_id = $programid union all
          select date , `50` value ,'50' serial from $tablename where program_id = $programid union all
          select date , `51` value ,'51' serial from $tablename where program_id = $programid union all
          select date , `52` value ,'52' serial from $tablename where program_id = $programid union all
          select date , `53` value ,'53' serial from $tablename where program_id = $programid union all
          select date , `54` value ,'54' serial from $tablename where program_id = $programid union all
          select date , `55` value ,'55' serial from $tablename where program_id = $programid union all
          select date , `56` value ,'56' serial from $tablename where program_id = $programid union all
          select date , `57` value ,'57' serial from $tablename where program_id = $programid union all
          select date , `58` value ,'58' serial from $tablename where program_id = $programid union all
          select date , `59` value ,'59' serial from $tablename where program_id = $programid union all
          select date , `60` value ,'60' serial from $tablename where program_id = $programid union all
          select date , `61` value ,'61' serial from $tablename where program_id = $programid union all
          select date , `62` value ,'62' serial from $tablename where program_id = $programid union all
          select date , `63` value ,'63' serial from $tablename where program_id = $programid union all
          select date , `64` value ,'64' serial from $tablename where program_id = $programid union all
          select date , `65` value ,'65' serial from $tablename where program_id = $programid union all
          select date , `66` value ,'66' serial from $tablename where program_id = $programid union all
          select date , `67` value ,'67' serial from $tablename where program_id = $programid union all
          select date , `68` value ,'68' serial from $tablename where program_id = $programid union all
          select date , `69` value ,'69' serial from $tablename where program_id = $programid union all
          select date , `70` value ,'70' serial from $tablename where program_id = $programid union all
          select date , `71` value ,'71' serial from $tablename where program_id = $programid union all
          select date , `72` value ,'72' serial from $tablename where program_id = $programid union all
          select date , `73` value ,'73' serial from $tablename where program_id = $programid union all
          select date , `74` value ,'74' serial from $tablename where program_id = $programid union all
          select date , `75` value ,'75' serial from $tablename where program_id = $programid union all
          select date , `76` value ,'76' serial from $tablename where program_id = $programid union all
          select date , `77` value ,'77' serial from $tablename where program_id = $programid union all
          select date , `78` value ,'78' serial from $tablename where program_id = $programid union all
          select date , `79` value ,'79' serial from $tablename where program_id = $programid union all
          select date , `80` value ,'80' serial from $tablename where program_id = $programid union all
          select date , `81` value ,'81' serial from $tablename where program_id = $programid union all
          select date , `82` value ,'82' serial from $tablename where program_id = $programid union all
          select date , `83` value ,'83' serial from $tablename where program_id = $programid union all
          select date , `84` value ,'84' serial from $tablename where program_id = $programid union all
          select date , `85` value ,'85' serial from $tablename where program_id = $programid union all
          select date , `86` value ,'86' serial from $tablename where program_id = $programid union all
          select date , `87` value ,'87' serial from $tablename where program_id = $programid union all
          select date , `88` value ,'88' serial from $tablename where program_id = $programid union all
          select date , `89` value ,'89' serial from $tablename where program_id = $programid union all
          select date , `90` value ,'90' serial from $tablename where program_id = $programid union all
          select date , `91` value ,'91' serial from $tablename where program_id = $programid union all
          select date , `92` value ,'92' serial from $tablename where program_id = $programid union all
          select date , `93` value ,'93' serial from $tablename where program_id = $programid union all
          select date , `94` value ,'94' serial from $tablename where program_id = $programid union all
          select date , `95` value ,'95' serial from $tablename where program_id = $programid union all          
          select date , `102` value ,'102' serial from $tablename where program_id = $programid union all
          select date , `103` value ,'103' serial from $tablename where program_id = $programid union all
          select date , `105` value ,'105' serial from $tablename where program_id = $programid union all
          select date , `106` value ,'106' serial from $tablename where program_id = $programid union all
          select date , `107` value ,'107' serial from $tablename where program_id = $programid union all
          select date , `108` value ,'108' serial from $tablename where program_id = $programid union all         
          select date , `109` value ,'109' serial from $tablename where program_id = $programid union all
          select date , `801` value ,'801' serial from $tablename where program_id = $programid union all
          select date , `802` value ,'802' serial from $tablename where program_id = $programid union all
          select date , `803` value ,'803' serial from $tablename where program_id = $programid union all                   
          select date , `804` value ,'804' serial from $tablename where program_id = $programid union all
          select date , `805` value ,'805' serial from $tablename where program_id = $programid union all
          select date , `806` value ,'806' serial from $tablename where program_id = $programid union all
          select date , `807` value ,'807' serial from $tablename where program_id = $programid union all
          select date , `808` value ,'808' serial from $tablename where program_id = $programid union all
          select date , `809` value ,'809' serial from $tablename where program_id = $programid union all
          select date , `810` value ,'810' serial from $tablename where program_id = $programid union all
          select date , `811` value ,'811' serial from $tablename where program_id = $programid union all
          select date , `812` value ,'812' serial from $tablename where program_id = $programid union all
          select date , `110` value ,'110' serial from $tablename where program_id = $programid union all
          select date , `111` value ,'111' serial from $tablename where program_id = $programid union all
          select date , `112` value ,'112' serial from $tablename where program_id = $programid union all
          select date , `113` value ,'113' serial from $tablename where program_id = $programid union all
          select date , `114` value ,'114' serial from $tablename where program_id = $programid union all    
          select date , `115` value ,'115' serial from $tablename where program_id = $programid   )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = $programid AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        else:
            $qRyString = $this->db->query("select serial,item_no,indicator,default_or_not, $monthqueryStr         
          from(
          select date , `1` value ,'1' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `2` value ,'2' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `3` value ,'3' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `4` value ,'4' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `5` value ,'5' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `6` value ,'6' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `7` value ,'7' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `8` value ,'8' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `9` value ,'9' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `10` value ,'10' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `11` value ,'11' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `12` value ,'12' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `13` value ,'13' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `14` value ,'14' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `15` value ,'15' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `16` value ,'16' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `17` value ,'17' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `18` value ,'18' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `19` value ,'19' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `20` value ,'20' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `21` value ,'21' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `22` value ,'22' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `23` value ,'23' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `24` value ,'24' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `25` value ,'25' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `26` value ,'26' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `27` value ,'27' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `28` value ,'28' serial from $tablename where $idrow = '$id' AND program_id = '$programid'union all
          select date , `29` value ,'29' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `30` value ,'30' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `31` value ,'31' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `32` value ,'32' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `33` value ,'33' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `34` value ,'34' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `35` value ,'35' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `36` value ,'36' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `37` value ,'37' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `38` value ,'38' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `39` value ,'39' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `40` value ,'40' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `41` value ,'41' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `42` value ,'42' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `43` value ,'43' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `44` value ,'44' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `45` value ,'45' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `46` value ,'46' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `47` value ,'47' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `48` value ,'48' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `49` value ,'49' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `50` value ,'50' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `51` value ,'51' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all    
          select date , `52` value ,'52' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `53` value ,'53' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `54` value ,'54' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `55` value ,'55' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `56` value ,'56' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `57` value ,'57' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `58` value ,'58' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `59` value ,'59' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `60` value ,'60' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `61` value ,'61' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `62` value ,'62' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `63` value ,'63' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `64` value ,'64' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `65` value ,'65' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `66` value ,'66' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `67` value ,'67' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `68` value ,'68' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `69` value ,'69' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `70` value ,'70' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `71` value ,'71' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `72` value ,'72' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `73` value ,'73' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `74` value ,'74' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `75` value ,'75' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `76` value ,'76' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `77` value ,'77' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `78` value ,'78' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `79` value ,'79' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `80` value ,'80' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `81` value ,'81' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `82` value ,'82' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `83` value ,'83' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `84` value ,'84' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `85` value ,'85' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `86` value ,'86' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `87` value ,'87' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `88` value ,'88' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `89` value ,'89' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `90` value ,'90' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `91` value ,'91' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `92` value ,'92' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `93` value ,'93' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `94` value ,'94' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `95` value ,'95' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `102` value ,'102' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `103` value ,'103' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `105` value ,'105' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `106` value ,'106' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `107` value ,'107' serial from $tablename where $idrow = '$id' AND program_id = $programid union all            
          select date , `108` value ,'108' serial from $tablename where $idrow = '$id' AND program_id = $programid union all            
          select date , `109` value ,'109' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `801` value ,'801' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `802` value ,'802' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `803` value ,'803' serial from $tablename where $idrow = '$id' AND program_id = $programid union all                     
          select date , `804` value ,'804' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `805` value ,'805' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `806` value ,'806' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `807` value ,'807' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `808` value ,'808' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `809` value ,'809' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `810` value ,'810' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `811` value ,'811' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `812` value ,'812' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `110` value ,'110' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `111` value ,'111' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `112` value ,'112' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `113` value ,'113' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `114` value ,'114' serial from $tablename where $idrow = '$id' AND program_id = $programid union all    
          select date , `115` value ,'115' serial from $tablename where $idrow = '$id' AND program_id = $programid   )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = '$programid' AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        endif;
        $resultData = $qRyString->result();
        return $resultData;
    }

    function treadReportBranch($tablename, $idrow, $id, $programid, $initialdate, $monthinterval) {

        if ($monthinterval == 0):
            $previous1 = date('Y-m-t', strtotime($initialdate));
            $previousmonth1 = date('MY', strtotime($initialdate));
            $data['previousmonth1'] = date('M-Y', strtotime($initialdate));
            $previous2 = date('Y-m-t', strtotime($initialdate . " -1 month"));
            $previousmonth2 = date('MY', strtotime($initialdate . " -1 month"));
            $data['previousmonth2'] = date('M-Y', strtotime($initialdate . " -1 month"));
            $previous3 = date('Y-m-t', strtotime($initialdate . " -2 month"));
            $previousmonth3 = date('MY', strtotime($initialdate . " -2 month"));
            $data['previousmonth3'] = date('M-Y', strtotime($initialdate . " -2 month"));
            $previous4 = date('Y-m-t', strtotime($initialdate . " -3 month"));
            $previousmonth4 = date('MY', strtotime($initialdate . " -3 month"));
            $data['previousmonth4'] = date('M-Y', strtotime($initialdate . " -3 month"));
            $previous5 = date('Y-m-t', strtotime($initialdate . " -4 month"));
            $previousmonth5 = date('MY', strtotime($initialdate . " -4 month"));
            $data['previousmonth5'] = date('M-Y', strtotime($initialdate . " -4 month"));
            $previous6 = date('Y-m-t', strtotime($initialdate . " -5 month"));
            $previousmonth6 = date('MY', strtotime($initialdate . " -5 month"));
            $data['previousmonth6'] = date('M-Y', strtotime($initialdate . " -5 month"));
            $previous7 = date('Y-m-t', strtotime($initialdate . " -6 month"));
            $previousmonth7 = date('MY', strtotime($initialdate . " -6 month"));
            $data['previousmonth7'] = date('M-Y', strtotime($initialdate . " -6 month"));
            $previous8 = date('Y-m-t', strtotime($initialdate . " -7 month"));
            $previousmonth8 = date('MY', strtotime($initialdate . " -7 month"));
            $data['previousmonth8'] = date('M-Y', strtotime($initialdate . " -7 month"));
            $previous9 = date('Y-m-t', strtotime($initialdate . " -8 month"));
            $previousmonth9 = date('MY', strtotime($initialdate . " -8 month"));
            $data['previousmonth9'] = date('M-Y', strtotime($initialdate . " -8 month"));
            $previous10 = date('Y-m-t', strtotime($initialdate . " -9 month"));
            $previousmonth10 = date('MY', strtotime($initialdate . " -9 month"));
            $data['previousmonth10'] = date('M-Y', strtotime($initialdate . " -9 month"));
            $previous11 = date('Y-m-t', strtotime($initialdate . " -10 month"));
            $previousmonth11 = date('MY', strtotime($initialdate . " -10 month"));
            $data['previousmonth11'] = date('M-Y', strtotime($initialdate . " -10 month"));
            $previous12 = date('Y-m-t', strtotime($initialdate . " -11 month"));
            $previousmonth12 = date('MY', strtotime($initialdate . " -11 month"));
            $data['previousmonth12'] = date('M-Y', strtotime($initialdate . " -11 month"));
            $previous13 = date('Y-m-t', strtotime($initialdate . " -12 month"));
            $previousmonth13 = date('MY', strtotime($initialdate . " -12 month"));
            $data['previousmonth13'] = date('M-Y', strtotime($initialdate . " -12 month"));
            $monthqueryStr = "sum(case when date = '$previous13' then value else 0 end) 'previousmonth13',
          sum(case when date = '$previous12' then value else 0 end) 'previousmonth12',
          sum(case when date = '$previous11' then value else 0 end) 'previousmonth11',
          sum(case when date = '$previous10' then value else 0 end) 'previousmonth10',
          sum(case when date = '$previous9' then value else 0 end) 'previousmonth9',
          sum(case when date = '$previous8' then value else 0 end) 'previousmonth8',
          sum(case when date = '$previous7' then value else 0 end) 'previousmonth7',
          sum(case when date = '$previous6' then value else 0 end) 'previousmonth6',
          sum(case when date = '$previous5' then value else 0 end) 'previousmonth5',
          sum(case when date = '$previous4' then value else 0 end) 'previousmonth4',
          sum(case when date = '$previous3' then value else 0 end) 'previousmonth3',
          sum(case when date = '$previous2' then value else 0 end) 'previousmonth2',
          sum(case when date = '$previous1' then value else 0 end) 'previousmonth1'";
        else:
            $monthqueryStr = "";
            $monthintervalll = $monthinterval + 1;
            for ($m = $monthintervalll; $m >= 1; $m--):
                $subm = $m - 1;
                $subval = '-' . $subm . 'month';
                $previousmonStr = date('Y-m-t', strtotime($initialdate . " $subval"));
                $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
            endfor;
            $monthqueryStr = substr($monthqueryStr, 1);
        endif;
        ########################################################  /find previoun 13 month  ###################################################################

        $qRyString = $this->db->query("select serial,item_no,indicator,default_or_not,$monthqueryStr
          from(
          select date , `1` value ,'1' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `2` value ,'2' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `3` value ,'3' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `4` value ,'4' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `5` value ,'5' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `6` value ,'6' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `7` value ,'7' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `8` value ,'8' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `9` value ,'9' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `10` value ,'10' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `11` value ,'11' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `12` value ,'12' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `13` value ,'13' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `14` value ,'14' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `15` value ,'15' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `16` value ,'16' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `17` value ,'17' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `18` value ,'18' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `19` value ,'19' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `20` value ,'20' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `21` value ,'21' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `22` value ,'22' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `23` value ,'23' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `24` value ,'24' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `25` value ,'25' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `26` value ,'26' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `27` value ,'27' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `28` value ,'28' serial from $tablename where $idrow = '$id' AND program_id = '$programid'union all
          select date , `29` value ,'29' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `30` value ,'30' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `31` value ,'31' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `32` value ,'32' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `33` value ,'33' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `34` value ,'34' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `35` value ,'35' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `36` value ,'36' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `37` value ,'37' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `38` value ,'38' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `39` value ,'39' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `40` value ,'40' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `41` value ,'41' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `42` value ,'42' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `43` value ,'43' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `44` value ,'44' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `45` value ,'45' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `46` value ,'46' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `47` value ,'47' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `48` value ,'48' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `49` value ,'49' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `50` value ,'50' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `51` value ,'51' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all    
          select date , `52` value ,'52' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `53` value ,'53' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `54` value ,'54' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `55` value ,'55' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `56` value ,'56' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `57` value ,'57' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `58` value ,'58' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `59` value ,'59' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , (CASE WHEN `60` > 0 THEN `60` WHEN `61` > 0 THEN `61` WHEN `62` > 0 THEN `62` WHEN `63` > 0 THEN `63` WHEN `64` > 0 THEN `64` ELSE 0 END) value,'60' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all          
          select date , `65` value ,'65' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `66` value ,'66' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `67` value ,'67' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `68` value ,'68' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `69` value ,'69' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `70` value ,'70' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `71` value ,'71' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `72` value ,'72' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `73` value ,'73' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `74` value ,'74' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `75` value ,'75' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `76` value ,'76' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `77` value ,'77' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `78` value ,'78' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `79` value ,'79' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `80` value ,'80' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `81` value ,'81' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `82` value ,'82' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `83` value ,'83' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `84` value ,'84' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `85` value ,'85' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `86` value ,'86' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `87` value ,'87' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `88` value ,'88' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `89` value ,'89' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `90` value ,'90' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `91` value ,'91' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `92` value ,'92' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `93` value ,'93' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `94` value ,'94' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `95` value ,'95' serial from $tablename where $idrow = '$id' AND program_id = $programid union all         
          select date , `102` value ,'102' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `103` value ,'103' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `105` value ,'105' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `106` value ,'106' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `107` value ,'107' serial from $tablename where $idrow = '$id' AND program_id = $programid union all            
          select date , `108` value ,'108' serial from $tablename where $idrow = '$id' AND program_id = $programid union all            
          select date , `109` value ,'109' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `801` value ,'801' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , (CASE WHEN `802` > 0 THEN `802` WHEN `803` > 0 THEN `803` ELSE 0 END) value,'802' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all             
          select date , `804` value ,'804' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `805` value ,'805' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `806` value ,'806' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `807` value ,'807' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `808` value ,'808' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `809` value ,'809' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `810` value ,'810' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `811` value ,'811' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `812` value ,'812' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `110` value ,'110' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `111` value ,'111' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `112` value ,'112' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `113` value ,'113' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `114` value ,'114' serial from $tablename where $idrow = '$id' AND program_id = $programid union all    
          select date , `115` value ,'115' serial from $tablename where $idrow = '$id' AND program_id = $programid   )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = '$programid' AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        $resultData = $qRyString->result();
        return $resultData;
    }

    function treadReportBranchProgoti($tablename, $idrow, $id, $programid, $initialdate, $monthinterval) {

        if ($monthinterval == 0):
            $previous1 = date('Y-m-t', strtotime($initialdate));
            $previousmonth1 = date('MY', strtotime($initialdate));
            $data['previousmonth1'] = date('M-Y', strtotime($initialdate));
            $previous2 = date('Y-m-t', strtotime($initialdate . " -1 month"));
            $previousmonth2 = date('MY', strtotime($initialdate . " -1 month"));
            $data['previousmonth2'] = date('M-Y', strtotime($initialdate . " -1 month"));
            $previous3 = date('Y-m-t', strtotime($initialdate . " -2 month"));
            $previousmonth3 = date('MY', strtotime($initialdate . " -2 month"));
            $data['previousmonth3'] = date('M-Y', strtotime($initialdate . " -2 month"));
            $previous4 = date('Y-m-t', strtotime($initialdate . " -3 month"));
            $previousmonth4 = date('MY', strtotime($initialdate . " -3 month"));
            $data['previousmonth4'] = date('M-Y', strtotime($initialdate . " -3 month"));
            $previous5 = date('Y-m-t', strtotime($initialdate . " -4 month"));
            $previousmonth5 = date('MY', strtotime($initialdate . " -4 month"));
            $data['previousmonth5'] = date('M-Y', strtotime($initialdate . " -4 month"));
            $previous6 = date('Y-m-t', strtotime($initialdate . " -5 month"));
            $previousmonth6 = date('MY', strtotime($initialdate . " -5 month"));
            $data['previousmonth6'] = date('M-Y', strtotime($initialdate . " -5 month"));
            $previous7 = date('Y-m-t', strtotime($initialdate . " -6 month"));
            $previousmonth7 = date('MY', strtotime($initialdate . " -6 month"));
            $data['previousmonth7'] = date('M-Y', strtotime($initialdate . " -6 month"));
            $previous8 = date('Y-m-t', strtotime($initialdate . " -7 month"));
            $previousmonth8 = date('MY', strtotime($initialdate . " -7 month"));
            $data['previousmonth8'] = date('M-Y', strtotime($initialdate . " -7 month"));
            $previous9 = date('Y-m-t', strtotime($initialdate . " -8 month"));
            $previousmonth9 = date('MY', strtotime($initialdate . " -8 month"));
            $data['previousmonth9'] = date('M-Y', strtotime($initialdate . " -8 month"));
            $previous10 = date('Y-m-t', strtotime($initialdate . " -9 month"));
            $previousmonth10 = date('MY', strtotime($initialdate . " -9 month"));
            $data['previousmonth10'] = date('M-Y', strtotime($initialdate . " -9 month"));
            $previous11 = date('Y-m-t', strtotime($initialdate . " -10 month"));
            $previousmonth11 = date('MY', strtotime($initialdate . " -10 month"));
            $data['previousmonth11'] = date('M-Y', strtotime($initialdate . " -10 month"));
            $previous12 = date('Y-m-t', strtotime($initialdate . " -11 month"));
            $previousmonth12 = date('MY', strtotime($initialdate . " -11 month"));
            $data['previousmonth12'] = date('M-Y', strtotime($initialdate . " -11 month"));
            $previous13 = date('Y-m-t', strtotime($initialdate . " -12 month"));
            $previousmonth13 = date('MY', strtotime($initialdate . " -12 month"));
            $data['previousmonth13'] = date('M-Y', strtotime($initialdate . " -12 month"));
            $monthqueryStr = "sum(case when date = '$previous13' then value else 0 end) 'previousmonth13',
          sum(case when date = '$previous12' then value else 0 end) 'previousmonth12',
          sum(case when date = '$previous11' then value else 0 end) 'previousmonth11',
          sum(case when date = '$previous10' then value else 0 end) 'previousmonth10',
          sum(case when date = '$previous9' then value else 0 end) 'previousmonth9',
          sum(case when date = '$previous8' then value else 0 end) 'previousmonth8',
          sum(case when date = '$previous7' then value else 0 end) 'previousmonth7',
          sum(case when date = '$previous6' then value else 0 end) 'previousmonth6',
          sum(case when date = '$previous5' then value else 0 end) 'previousmonth5',
          sum(case when date = '$previous4' then value else 0 end) 'previousmonth4',
          sum(case when date = '$previous3' then value else 0 end) 'previousmonth3',
          sum(case when date = '$previous2' then value else 0 end) 'previousmonth2',
          sum(case when date = '$previous1' then value else 0 end) 'previousmonth1'";
        else:
            $monthqueryStr = "";
            $monthintervalll = $monthinterval + 1;
            for ($m = $monthintervalll; $m >= 1; $m--):
                $subm = $m - 1;
                $subval = '-' . $subm . 'month';
                $previousmonStr = date('Y-m-t', strtotime($initialdate . " $subval"));
                $monthqueryStr .= "," . "sum(case when date ='" . $previousmonStr . "' then value else 0 end) previousmonth" . $m;
            endfor;
            $monthqueryStr = substr($monthqueryStr, 1);
        endif;
        ########################################################  /find previoun 13 month  ###################################################################

        $qRyString = $this->db->query("select serial,item_no,indicator,default_or_not,$monthqueryStr
          from(
          select date , `1` value ,'1' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `2` value ,'2' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `3` value ,'3' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `4` value ,'4' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `5` value ,'5' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `6` value ,'6' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `7` value ,'7' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `8` value ,'8' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `9` value ,'9' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `10` value ,'10' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `11` value ,'11' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `12` value ,'12' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `13` value ,'13' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `14` value ,'14' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `15` value ,'15' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `16` value ,'16' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `17` value ,'17' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `18` value ,'18' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `19` value ,'19' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `20` value ,'20' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `21` value ,'21' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `22` value ,'22' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `23` value ,'23' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `24` value ,'24' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `25` value ,'25' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `26` value ,'26' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `27` value ,'27' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `28` value ,'28' serial from $tablename where $idrow = '$id' AND program_id = '$programid'union all
          select date , `29` value ,'29' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `30` value ,'30' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `31` value ,'31' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `32` value ,'32' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `33` value ,'33' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `34` value ,'34' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `35` value ,'35' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `36` value ,'36' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `37` value ,'37' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `38` value ,'38' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `39` value ,'39' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `40` value ,'40' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `41` value ,'41' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `42` value ,'42' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `43` value ,'43' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `44` value ,'44' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `45` value ,'45' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `46` value ,'46' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `47` value ,'47' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `48` value ,'48' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `49` value ,'49' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `50` value ,'50' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `51` value ,'51' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all    
          select date , `52` value ,'52' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `53` value ,'53' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `54` value ,'54' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `55` value ,'55' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `56` value ,'56' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `57` value ,'57' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all         
          select date , (CASE WHEN `58` > 0 THEN `58` WHEN `59` > 0 THEN `59` WHEN `60` > 0 THEN `60` WHEN `61` > 0 THEN `61` WHEN `62` > 0 THEN `62` ELSE 0 END) value,'58' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all          
          select date , `63` value ,'63' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `64` value ,'64' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all    
          select date , `65` value ,'65' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `66` value ,'66' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `67` value ,'67' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `68` value ,'68' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `69` value ,'69' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `70` value ,'70' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `71` value ,'71' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `72` value ,'72' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `73` value ,'73' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `74` value ,'74' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `75` value ,'75' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `76` value ,'76' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `77` value ,'77' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `78` value ,'78' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `79` value ,'79' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `80` value ,'80' serial from $tablename where $idrow = '$id' AND program_id = $programid union all 
          select date , `81` value ,'81' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `82` value ,'82' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `83` value ,'83' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `84` value ,'84' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `85` value ,'85' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `86` value ,'86' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `87` value ,'87' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `88` value ,'88' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `89` value ,'89' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `90` value ,'90' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `91` value ,'91' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `92` value ,'92' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `93` value ,'93' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `94` value ,'94' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `95` value ,'95' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `102` value ,'102' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `103` value ,'103' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `105` value ,'105' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `106` value ,'106' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `107` value ,'107' serial from $tablename where $idrow = '$id' AND program_id = $programid union all            
          select date , `108` value ,'108' serial from $tablename where $idrow = '$id' AND program_id = $programid union all            
          select date , `109` value ,'109' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `801` value ,'801' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , (CASE WHEN `802` > 0 THEN `802` WHEN `803` > 0 THEN `803` ELSE 0 END) value,'802' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all
          select date , `804` value ,'804' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `805` value ,'805' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `806` value ,'806' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `807` value ,'807' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `808` value ,'808' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `809` value ,'809' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `810` value ,'810' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `811` value ,'811' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `812` value ,'812' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `110` value ,'110' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `111` value ,'111' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `112` value ,'112' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `113` value ,'113' serial from $tablename where $idrow = '$id' AND program_id = $programid union all
          select date , `114` value ,'114' serial from $tablename where $idrow = '$id' AND program_id = $programid union all    
          select date , `115` value ,'115' serial from $tablename where $idrow = '$id' AND program_id = $programid   )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = '$programid' AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        $resultData = $qRyString->result();
        return $resultData;
    }

    function treadReportBranchForExcel($tablename, $idrow, $id, $programid, $monthqueryStr, $indicatorvallist) {
        $datarowQrStr = "";
        $sizeoflist = sizeof($indicatorvallist) - 1;
        for ($i = 0; $i < $sizeoflist; $i++):
            if ($indicatorvallist[$i] == 60 && $programid < 5):
                $datarowQrStr .= "select date , (CASE WHEN `60` > 0 THEN `60` WHEN `61` > 0 THEN `61` WHEN `62` > 0 THEN `62` WHEN `63` > 0 THEN `63` WHEN `64` > 0 THEN `64` ELSE 0 END) value,'60' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all ";
                $i = $i + 4;
            elseif ($indicatorvallist[$i] == 802):
                $datarowQrStr .= "select date , (CASE WHEN `802` > 0 THEN `802` WHEN `803` > 0 THEN `803` ELSE 0 END) value,'802' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all ";
                $i = $i + 1;
            elseif ($indicatorvallist[$i] == 58 && $programid > 4):
                $datarowQrStr .= "select date , (CASE WHEN `58` > 0 THEN `58` WHEN `59` > 0 THEN `59` WHEN `60` > 0 THEN `60` WHEN `61` > 0 THEN `61` WHEN `62` > 0 THEN `62` ELSE 0 END) value,'58' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all ";
                $i = $i + 4;
            else:
                $datarowQrStr .= "SELECT date , `$indicatorvallist[$i]` value ,'$indicatorvallist[$i]' serial from $tablename where $idrow = '$id' AND program_id = '$programid' union all ";
            endif;
        endfor;
        $datarowQrStr .= "SELECT date , `$indicatorvallist[$i]` value ,'$indicatorvallist[$i]' serial from $tablename where $idrow = '$id' AND program_id = '$programid'";

        $qRyString = $this->db->query("select serial,item_no,indicator, $monthqueryStr         
          from( $datarowQrStr )
          src inner join indicatordetails on src.serial=indicatordetails.sl_no where indicatordetails.program_id = '$programid' AND indicatordetails.show_hide = '1' group by serial ORDER BY indicatordetails.order_by ASC");
        $resultData = $qRyString->result();
        return $resultData;
    }

    function treadReportForExcel($tablename, $idrow, $id, $programid, $monthqueryStr, $indicatorvallist) {
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

}
