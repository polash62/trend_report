<style type="text/css">
    .btn-group>.btn:first-child {
        margin-left: 0;
        margin-top: 0px;
    }
    .form-control {
        border: 1px solid rgb(209, 0, 116);
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
        <section class="panel">
            <header class="panel-heading" id="panelheadfixed">
                Trend Report 
            </header>
            <div class="panel-body">
                <div class="adv-table">
                    <div class="clearfix" id="headerformfixed">
                        <form class="tasi-form" method="post" action="<?php echo site_url('dabi/dabi'); ?>">
                            <div class="form-group">
                                <div class="col-md-7" style="padding-left: 0px;  padding-right: 0px;">                                  
                                    <div class="col-md-2" style="padding-top: 5px; padding-bottom: 20px">
                                        <label for="division_id" class="control-label">Division Name :</label>
                                        <?php if ($this->session->userdata('user_level') == 3): ?>
                                            <input class="form-control" readonly type="text" name="divisionname" id="divisionname" value="<?php echo $divisionNameforRole3; ?>">
                                            <input type="hidden" name="division_id" value="<?php echo $divisionIdforRole3; ?>">
                                        <?php elseif ($this->session->userdata('user_level') == 2): ?>
                                            <input class="form-control" readonly type="text" name="divisionname" id="divisionname" value="<?php echo $divisionNameforRole2; ?>">
                                            <input type="hidden" name="division_id" value="<?php echo $divisionIdforRole2; ?>">
                                        <?php elseif ($this->session->userdata('user_level') == 1): ?>
                                            <input class="form-control" readonly type="text" name="divisionname" id="divisionname" value="<?php echo $divisionNameforRole1; ?>">
                                            <input type="hidden" name="division_id" value="<?php echo $divisionIdforRole1; ?>">
                                        <?php elseif ($this->session->userdata('user_level') == 4 || $this->session->userdata('user_level') == 15): ?>
                                            <select id="division_id" name="division_id" onchange="getRegion()" class="form-control">        
                                                <option value="">--Select Division--</option>
                                                <option value="eastern" <?php if ($division_id == 'eastern'): ?> selected <?php endif; ?>> Dabi Eastern </option>   
                                                <option value="western" <?php if ($division_id == 'western'): ?> selected <?php endif; ?>> Dabi Western </option> 
                                                <?php
                                                if (sizeof($divisionlist) > 0):
                                                    foreach ($divisionlist as $data):
                                                        if ($data->division_id == $divisionId):
                                                            ?>
                                                            <option value="<?php echo $divisionId; ?>" selected><?php echo $divisionName; ?></option>
                                                        <?php else:
                                                            ?>
                                                            <option value="<?php echo $data->division_id; ?>"><?php echo $data->division_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php else: ?>
                                            <select name="division_id" id="division_id" onchange="getRegion()" class="form-control">        
                                                <option value="" selected='selected'>--Select Division--</option>
                                                <option value="eastern" <?php if ($division_id == 'eastern'): ?> selected <?php endif; ?>> Dabi Eastern </option>   
                                                <option value="western" <?php if ($division_id == 'western'): ?> selected <?php endif; ?>> Dabi Western </option>    
                                                <?php
                                                if (sizeof($divisionlist) > 0):
                                                    foreach ($divisionlist as $data):
                                                        if ($data->division_id == $division_id):
                                                            ?>
                                                            <option value="<?php echo $data->division_id; ?>" selected="selected" ><?php echo $data->division_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->division_id; ?>"><?php echo $data->division_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>                                            
                                            </select>
                                        <?php endif; ?>
                                    </div>  

                                    <div class="col-md-2 myselect" style="padding-top: 5px; padding-bottom: 20px">                                    
                                        <label for="region_id" class="control-label">Region Name :</label>
                                        <?php if ($this->session->userdata('user_level') == 4 || $this->session->userdata('user_level') == 15): ?>
                                            <select id="region_id" name="region_id" onchange="getArea()" class="form-control">   
                                                <option value="" selected='selected'>--Select Region--</option>
                                                <?php
                                                if (sizeof($regionlist) > 0):
                                                    foreach ($regionlist as $data):
                                                        if ($data->region_id == $region_id):
                                                            ?>
                                                            <option value="<?php echo $data->region_id; ?>" selected="selected" ><?php echo $data->region_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->region_id; ?>"><?php echo $data->region_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php elseif ($this->session->userdata('user_level') == 3): ?>
                                            <select id="region_id" name="region_id" onchange="getArea()" class="form-control">       
                                                <option value="all">--All--</option>
                                                <?php if (!empty($regionId)): ?>
                                                    <option value="<?php echo $regionId; ?>" selected='selected'><?php echo $regionName; ?></option>
                                                <?php endif; ?>
                                                <?php
                                                if (sizeof($regionlist) > 0):
                                                    foreach ($regionlist as $data):
                                                        ?>
                                                        <option value="<?php echo $data->region_id; ?>"><?php echo $data->region_name; ?></option>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php elseif ($this->session->userdata('user_level') == 2): ?>
                                            <input class="form-control" readonly type="text" name="regionname" id="regionname" value="<?php echo $regionNameforRole2; ?>">
                                            <input type="hidden" name="region_id" value="<?php echo $regionIdforRole2; ?>">
                                        <?php elseif ($this->session->userdata('user_level') == 1): ?>
                                            <input class="form-control" readonly type="text" name="regionname" id="regionname" value="<?php echo $regionNameforRole1; ?>">
                                            <input type="hidden" name="region_id" value="<?php echo $regionIdforRole1; ?>">
                                        <?php else: ?>
                                            <select id="region_id" name="region_id" onchange="getArea()" class="form-control">
                                                <option value="" selected='selected'>--Select Region--</option>
                                                <?php
                                                if (sizeof($regionlist) > 0):
                                                    foreach ($regionlist as $data):
                                                        if ($data->region_id == $region_id):
                                                            ?>
                                                            <option value="<?php echo $data->region_id; ?>" selected="selected" ><?php echo $data->region_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->region_id; ?>"><?php echo $data->region_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                else:
                                                    echo "--Select Region--";
                                                endif;
                                                ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>  


                                    <div class="col-md-2 myselect" style="padding-top: 5px; padding-bottom: 20px">
                                        <label for="area_id" class="control-label">Area Name :</label>
                                        <?php if ($this->session->userdata('user_level') == 3): ?>
                                            <select id="area_id" name="area_id" onchange="getBranch()" class="form-control">
                                                <option value="" selected='selected'>--Select Area--</option>
                                                <?php
                                                if (sizeof($arealist) > 0):
                                                    foreach ($arealist as $data):
                                                        if ($data->area_id == $area_id):
                                                            ?>
                                                            <option value="<?php echo $data->area_id; ?>" selected="selected" ><?php echo $data->area_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->area_id; ?>"><?php echo $data->area_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php elseif ($this->session->userdata('user_level') == 2): ?>
                                            <select id="area_id" name="area_id" onchange="getBranch()" class="form-control">   
                                                <option value="all">--All--</option>
                                                <?php if (!empty($areaId)): ?>
                                                    <option value="<?php echo $areaId; ?>" selected='selected'><?php echo $areaName; ?></option>
                                                <?php endif; ?>
                                                <?php
                                                if (sizeof($arealist) > 0):
                                                    foreach ($arealist as $data):
                                                        ?>
                                                        <option value="<?php echo $data->area_id; ?>"><?php echo $data->area_name; ?></option>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php elseif ($this->session->userdata('user_level') == 1): ?>
                                            <input class="form-control" readonly type="text" name="areaname" id="area_id" value="<?php echo $areaNameforRole1; ?>">
                                            <input type="hidden" name="area_id" value="<?php echo $areaIdforRole1; ?>">
                                        <?php else: ?>
                                            <select name="area_id" id="area_id" onchange="getBranch()" class="form-control">  
                                                <option value="" selected='selected'>--Select Area--</option>
                                                <?php
                                                if (sizeof($arealist) > 0):
                                                    foreach ($arealist as $data):
                                                        if ($data->area_id == $area_id):
                                                            ?>
                                                            <option value="<?php echo $data->area_id; ?>" selected="selected" ><?php echo $data->area_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->area_id; ?>"><?php echo $data->area_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                else:
                                                    echo "--Select Area--";
                                                endif;
                                                ?>                                            
                                            </select>
                                        <?php endif; ?>
                                    </div>  


                                    <div class="col-md-2 myselect" style="padding-top: 5px; padding-bottom: 20px">
                                        <label for="branch_id" class="control-label">Branch Name :</label>
                                        <?php if ($this->session->userdata('user_level') == 1): ?>
                                            <select id="branch_id" name="branch_id" class="form-control">        
                                                <option value="<?php echo $branchId; ?>" selected='selected'><?php echo $branchId . '-' . $branchName; ?></option>
                                                <?php
                                                if (sizeof($branchlist) > 0):
                                                    foreach ($branchlist as $data):
                                                        ?>
                                                        <option value="<?php echo $data->branch_id; ?>"><?php echo $data->branch_id . '-' . $data->branch_name; ?></option>
                                                        <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php elseif ($this->session->userdata('user_level') == 2): ?>
                                            <select id="branch_id" name="branch_id" class="form-control">
                                                <option value="">-- Select Branch --</option>
                                                <?php
                                                if (sizeof($branchlist) > 0):
                                                    foreach ($branchlist as $data):
                                                        if ($data->branch_id == $branch_id):
                                                            ?>
                                                            <option value="<?php echo $data->branch_id; ?>" selected="selected" ><?php echo $data->branch_id . '-' . $data->branch_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->branch_id; ?>"><?php echo $data->branch_id . '-' . $data->branch_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                        <?php else: ?>
                                            <select name="branch_id" id="branch_id" class="form-control">
                                                <option value="">--Select Branch--</option>
                                                <?php
                                                if (sizeof($branchlist) > 0):
                                                    foreach ($branchlist as $data):
                                                        if ($data->branch_id == $branch_id):
                                                            ?>
                                                            <option value="<?php echo $data->branch_id; ?>" selected="selected" ><?php echo $data->branch_id . '-' . $data->branch_name; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $data->branch_id; ?>"><?php echo $data->branch_id . '-' . $data->branch_name; ?></option>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                else:
                                                    echo "--Select Branch--";
                                                endif;
                                                ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4" style="padding-top: 5px; padding-bottom: 20px">
                                        <div class="col-md-6">
                                            <label for="month" class="control-label">Month From:</label>
                                            <input type="text" id="monthfromdate" name="monthfromdate" value="<?php
                                            if (isset($monthfromdate)):
                                                echo ($monthfromdate);
                                            else:
                                                echo date('Y-m', strtotime("-13 months"));
                                            endif;
                                            ?>" class="form-control date_picker_from_class">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="month" class="control-label">Month To:</label>
                                            <input type="text" id="demo-2" name="datamonth"  value="<?php
                                            if (isset($previous1)):
                                                echo ($previous1);
                                            else:
                                                echo date('Y-m');
                                            endif;
                                            ?>" class="form-control date_picker_to_class">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3" style="padding-top: 5px; padding-bottom: 20px; padding-left: 0px">       
                                    <div class="col-md-4" style="margin-top: 10px">
                                        <label>
                                            <button class="btn btn-info" type="submit">Submit</button>
                                        </label>  
                                    </div>
                                    <div class="col-md-4" style="margin-top: 10px; padding-left: 0">
                                        <div class="dropdown" id="componentDropdown">
                                            <button  class="btn btn-info dropdown-toggle" data-toggle="dropdown">  Items <i class="fa fa-angle-down"></i></button>                  
                                            <?php if (sizeof($indicatormaster)): ?>
                                                <ul class="dropdown-menu pull-left" style="background-color:#A5A5A5">                                      
                                                    <?php foreach ($indicatormaster as $datarow): ?>
                                                        <?php if ($datarow->indicatormaster_id == 10): ?>
                                                            <li style="padding-left: 10px;">   <label class="trigger left-caret fa fa-circle-o" for="masterindicator<?php echo $datarow->indicatormaster_id; ?>"> <span class="itemfont">  <?php echo $datarow->description; ?> </span> </label>
                                                                <?php
                                                                $programId = 1;
                                                                $indicatorQr = $this->db->query("SELECT * FROM indicatordetails WHERE indicatormaster_id = '$datarow->indicatormaster_id' AND program_id = '$programId' AND default_or_not = '0' AND show_hide='1'");
                                                                $indicatordata = $indicatorQr->result();
                                                                $outputData = "";
                                                                if (sizeof($indicatordata)):
                                                                    $itemset = "";
                                                                    $outputData .= "<ul class='dropdown-menu sub-menu' style='background-color:#A5A5A5'>";
                                                                    $onchangefuncheck = "showAllDataRow('" . $datarow->indicatormaster_id . "')";
                                                                    $outputData .= "<li style='padding-left: 10px;'> <label> <input type='checkbox' onchange=" . $onchangefuncheck . " name='detailsindicatorall'  id='detailsindicatorall" . $datarow->indicatormaster_id . "' value='" . $datarow->indicatormaster_id . "'>&nbsp; <span id='" . 'selectalltext' . $datarow->indicatormaster_id . "'> Select All</span></label></li>";
                                                                    $outputData .= "<table class='table-bordered' style='margin-left:10px; font-size:11px;'><tr><td>Numbers</td><td>Values</td>";
                                                                    foreach ($indicatordata as $datarowinside):
                                                                        $itemset .= ',' . $datarowinside->item_no;
                                                                        $onchangefun = "showDataRow(" . $datarowinside->item_no . ',' . $datarow->indicatormaster_id . ")";
                                                                        if ($datarowinside->item_no % 2 != 0):
                                                                            $outputData .= "<tr><td> <input type='checkbox' class='masterindicatorclass'  onchange=" . $onchangefun . " name='detailsindicator' id='detailsindicator" . $datarowinside->item_no . "' value='" . $datarowinside->item_no . "'>&nbsp;<label class='masterindicatorclass' for='detailsindicator" . $datarowinside->item_no . "'>" . substr($datarowinside->indicator, 12) . "</label></td>";
                                                                        else:
                                                                            $outputData .= "<td><input type='checkbox' class='masterindicatorclass' onchange=" . $onchangefun . " name='detailsindicator' id='detailsindicator" . $datarowinside->item_no . "' value='" . $datarowinside->item_no . "'>&nbsp;<label class='masterindicatorclass' for='detailsindicator" . $datarowinside->item_no . "'>" . substr($datarowinside->indicator, 15) . "</label></td></tr>";
                                                                        endif;
                                                                    endforeach;
                                                                    $outputData .= "</table>";
                                                                    $outputData .= "</ul>";
                                                                    $itemset = substr($itemset, 1);
                                                                    $outputData .= "<input type='hidden' name='itemsetvalue" . $datarow->indicatormaster_id . "' id='itemsetid" . $datarow->indicatormaster_id . "' value='" . $itemset . "'>";
                                                                endif;
                                                                echo $outputData;
                                                                ?>
                                                            </li>                                               
                                                        <?php else:
                                                            ?>
                                                            <li style="padding-left: 10px;">  <label class="trigger left-caret fa fa-circle-o" for="masterindicator<?php echo $datarow->indicatormaster_id; ?>">  <span class="itemfont">  <?php echo $datarow->description; ?> </span>  </label>
                                                                <?php
                                                                $programId = 1;
                                                                $indicatorQr = $this->db->query("SELECT * FROM indicatordetails WHERE indicatormaster_id = '$datarow->indicatormaster_id' AND program_id = '$programId' AND default_or_not = '0' AND show_hide='1'");
                                                                $indicatordata = $indicatorQr->result();
                                                                $outputData = "";
                                                                if (sizeof($indicatordata)):
                                                                    $itemset = "";
                                                                    $outputData .= "<ul class='dropdown-menu sub-menu' style='background-color:#A5A5A5'>";
                                                                    $onchangefuncheck = "showAllDataRow('" . $datarow->indicatormaster_id . "')";
                                                                    $outputData .= "<li style='padding-left: 10px;'> <label> <input type='checkbox' onchange=" . $onchangefuncheck . " name='detailsindicatorall'  id='detailsindicatorall" . $datarow->indicatormaster_id . "' value='" . $datarow->indicatormaster_id . "'>&nbsp; <span id='" . 'selectalltext' . $datarow->indicatormaster_id . "'> Select All</span></label></li>";
                                                                    foreach ($indicatordata as $datarowinside):
                                                                        $itemset .= ',' . $datarowinside->item_no;
                                                                        $onchangefun = "showDataRow(" . $datarowinside->item_no . ',' . $datarow->indicatormaster_id . ")";
                                                                        $outputData .= "<li style='padding-left: 10px;'> <label> <input type='checkbox' onchange=" . $onchangefun . " name='detailsindicator' id='detailsindicator" . $datarowinside->item_no . "' value='" . $datarowinside->item_no . "'>&nbsp;" . $datarowinside->indicator . "</label></li>";
                                                                    endforeach;
                                                                    $outputData .= "</ul>";
                                                                    $itemset = substr($itemset, 1);
                                                                    $outputData .= "<input type='hidden' name='itemsetvalue" . $datarow->indicatormaster_id . "' id='itemsetid" . $datarow->indicatormaster_id . "' value='" . $itemset . "'>";
                                                                endif;
                                                                echo $outputData;
                                                                ?>
                                                            </li>
                                                        <?php
                                                        endif;
                                                    endforeach;
                                                    ?>
                                                    <li style="padding: 10px;">   <input type="checkbox" name="allnondefault" id="allnondefault" onchange="return allNonDefaultReset()" value="">  <label for="allnondefault"> <span id="nondefaultresettext"> Select All Items </span> </label>
                                                </ul>
                                            <?php endif; ?>                                       
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-offset-1" style="margin-top: 10px;padding-left: 0">   
                                        <div class="btn-group pull-right">
                                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">Export <i class="fa fa-angle-down"></i></button>
                                            <ul class="dropdown-menu pull-right">
                                                <!-- <li><a download="dabi_trendreport_<?php echo date('d-m-y'); ?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'tableforexcel', 'DABI Trend Report Data Sheet', 1);">
                                                        Save as Excel</a></li> -->
                                                <li><a href="#" onclick="generateExcel()">Save as Excel</a></li>
                                                <li><a href="#" onclick="generatePdf()">Save as PDF</a>                                                                                                                                             
                                                <li><a href="#" onclick="Clickheretoprint('#PrintTrendReport')">Print Report</a></li>
                                                <!-- <li><a href="#" data-toggle="modal" data-target="#advancedexport" > Advanced Export </a></li> -->
                                            </ul>
                                        </div>
                                    </div>                                                                                                        
                                </div>
                            </div>                            
                        </form>                        
                    </div>
                    <?php if (isset($searchbydetails) == 'details'): ?>
                        <div class="tab-content">
                            <p style="font-size: 12px; padding: 0px 0px 5px 10px; font-family: arial; font-weight: bold" id="reporttitlefixed">
                                <?php
                                if ($useRole == 4 || $useRole == 15):
                                    echo 'Global Trend Report';
                                    $first_text = 'Global Trend Report';
                                elseif ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    if ($divisionName == ('Dabi Eastern')):
                                        echo 'Zone Name:  ' . $divisionName;
                                    elseif ($divisionName == ('Dabi Western')):
                                        echo 'Zone Name:  ' . $divisionName;
                                    else:
                                        echo 'Division Name:  ' . $divisionName;
                                    endif;
                                elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo 'Region Name:  ' . $regionName;
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                    echo 'Area Name:  ' . $areaName;
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                    echo 'Branch Name:  ' . $branchName . ' - ' . $branchId;
                                elseif ($useRole == 3):
                                    echo 'Division Name:  ' . $divisionNameforRole3 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 'Region Name: ' . $regionName;
                                elseif ($useRole == 2):
                                    echo 'Region Name:  ' . $regionNameforRole2 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 'Area Name: ' . $areaName;
                                //echo 'Region Name:  ' . $regionNameforRole2;
                                elseif ($useRole == 1):
                                    echo 'Area Name:  ' . $areaNameforRole1;
                                else:
                                    echo 'Global Trend Report';
                                endif;
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php
                                if ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo '';
                                elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo 'Division Name:  ' . $divisionName;
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                    echo 'Region Name:  ' . $regionName;
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                    echo 'Area Name:  ' . $areaName;
                                #else:
                                #echo 'All Report';
                                endif;
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php
                                if ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo '';
                                elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo '';
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                    echo 'Division Name:  ' . $divisionName;
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                    echo 'Region Name:  ' . $regionName;
                                #else:
                                #echo 'All Report';
                                endif;
                                ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?php
                                if ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo '';
                                elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                    echo '';
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                    echo '';
                                elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                    echo 'Division Name:  ' . $divisionName;
                                #else:
                                #echo 'All Report';
                                endif;
                                ?>
                            </p>


                            <div id="headertabdiv" role="tabpanel" class="tab-pane active">
                                <table class="table table-bordered tab-pane active editable-sample1">
                                    <thead>                                       
                                        <tr>
                                            <th id="center">Sl.</th>
                                            <th id="center">Item Name</th>
                                            <?php if ($monthinterval == 0): ?>
                                                <th id="center"><?php echo $previousmonth13; ?></th>
                                                <th id="center"><?php echo $previousmonth12; ?></th>
                                                <th id="center"><?php echo $previousmonth11; ?></th>
                                                <th id="center"><?php echo $previousmonth10; ?></th>                                                                             
                                                <th id="center"><?php echo $previousmonth9; ?></th>
                                                <th id="center"><?php echo $previousmonth8; ?></th>
                                                <th id="center"><?php echo $previousmonth7; ?></th>
                                                <th id="center"><?php echo $previousmonth6; ?></th>
                                                <th id="center"><?php echo $previousmonth5; ?></th>
                                                <th id="center"><?php echo $previousmonth4; ?></th>
                                                <th id="center"><?php echo $previousmonth3; ?></th>
                                                <th id="center"><?php echo $previousmonth2; ?></th>
                                                <th id="center"><?php echo $previousmonth1; ?></th>
                                                <?php
                                            else:
                                                $yrmonlen = sizeof($yrmonArr);
                                                for ($m = $yrmonlen - 1; $m >= 0; $m--):
                                                    ?>
                                                    <th id="center"><?php echo $yrmonArr[$m]; ?></th>
                                                    <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </tr>
                                    </thead>
                                </table>
                            </div>


                            <div role="tabpanel" id="trenddatatab"  class="tab-pane active">
                                <style type="text/css">
                                    #center{
                                        text-align: center;
                                    }
                                </style>


                                <table class="table table-bordered tab-pane active editable-sample1">

                                    <tbody>
                                        <?php
                                        $len = sizeof($qRyresult);
                                        if ($len > 0):
                                            foreach ($qRyresult as $data):
                                                $A = $data->item_no;
                                                if (!is_numeric($A)):
                                                    ?>
                                                    <tr id="rownum<?php echo $data->item_no; ?>" style="background-color:#A5A5A5 !important; color: #FFFFFF">
                                                        <td style="text-align:right; font-weight: bold"><?php echo $data->item_no; ?> </td>  
                                                        <td style="text-align:left; padding-left: 5px;font-weight: bold"> <?php echo $data->indicator; ?> </td>                                                      
                                                        <?php if ($monthinterval == 0): ?>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <td> <?php echo '' ?> </td>
                                                            <?php
                                                        else:
                                                            for ($m = $monthinterval + 1; $m >= 1; $m--):
                                                                ?>
                                                                <td> <?php echo '' ?> </td>
                                                                <?php
                                                            endfor;
                                                        endif;
                                                        ?>
                                                    </tr>
                                                <?php else: ?> 
                                                    <?php if (intval($data->default_or_not) == 1): ?>
                                                        <tr id="rownum<?php echo $data->item_no; ?>">
                                                        <?php else: ?>
                                                        <tr id="rownum<?php echo $data->item_no; ?>" style="background-color:#C5D9F1 !important; display: none;">
                                                        <?php endif; ?>
                                                        <?php if (intval($data->default_or_not) == 1): ?>
                                                            <td style="text-align: right"> <span> </span> <span> <?php echo $data->item_no; ?> </span></td>   
                                                            <td style="text-align: left; padding-left: 10px;"> <?php echo $data->indicator; ?> </td>  
                                                        <?php else: ?>
                                                            <td> <span onclick="return deleteDataRow('<?php echo $data->item_no; ?>')"  style="color:red;cursor:pointer"><i class="fa fa-times"></i></span> <span style="text-align: right"> <?php echo $data->item_no; ?> </span></td>                                                
                                                            <td style="text-align: left; padding-left: 10px;"> <?php echo $data->indicator; ?> </td>  
                                                        <?php endif; ?>                               
                                                        <?php if ($monthinterval == 0): ?>     
                                                            <?php if (in_array($data->item_no, array(5, 46, 47, 48, 83, 84, 85, 86, 87, 88, 91, 95))): ?>
                                                                <td> <?php echo number_format($data->previousmonth13, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth12, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth11, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth10, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth9, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth8, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth7, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth6, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth5, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth4, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth3, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth2, 2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth1, 2); ?> </td>
                                                            <?php else: ?>
                                                                <td> <?php echo number_format($data->previousmonth13); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth12); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth11); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth10); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth9); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth8); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth7); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth6); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth5); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth4); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth3); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth2); ?> </td>
                                                                <td> <?php echo number_format($data->previousmonth1); ?> </td>
                                                            <?php endif; ?>
                                                            <?php
                                                        else:
                                                            for ($m = $monthinterval + 1; $m >= 1; $m--):
                                                                $monindex = 'previousmonth' . $m;
                                                                ?>
                                                                <?php if (in_array($data->item_no, array(5, 46, 47, 48, 83, 84, 85, 86, 87, 88, 91, 95))): ?>
                                                                    <td> <?php echo number_format($data->$monindex, 2); ?> </td>
                                                                <?php else: ?>
                                                                    <td> <?php echo number_format($data->$monindex); ?> </td>
                                                                <?php endif; ?>
                                                                <?php
                                                            endfor;
                                                        endif;
                                                        ?>
                                                    </tr>
                                                <?php
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>
                                    </tbody>
                                </table>                           
                            </div>                      
                        </div>
                    <?php endif; ?>
                </div>
            </div>               
        </section>
    </section>
</section>

<!--#######################################################################################   for print  #################################################################-->
<section class="page" style="display: none" id="PrintTrendReport">
    <div class="col-lg-12">
        <div class="panel-body">
            <div id="printheader">
                <div class="col-lg-12">
                    <p style="margin-bottom: 25px"></p>
                    <table style="width: 100%; border: hidden; padding: 0px">
                        <tr style="border: hidden">
                            <td style="border: hidden; width: 33%">
                                <h6 style="line-height: 0px"><b>BRAC Microfinance</b></h6>
                            </td>
                            <td style="border: hidden; width: 33%">
                                <h6 style="line-height: 0px;padding: 0px;">
                                    <b>
                                        <?php
                                        $excel_title = "";
                                        if ($useRole == 4 || $useRole == 15):
                                            echo 'Global';
                                            $excel_title = 'Global';
                                        elseif ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo 'Division';
                                            $excel_title = 'Division';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo 'Region';
                                            $excel_title = 'Region';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                            echo 'Area';
                                            $excel_title = 'Area';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                            echo 'Branch';
                                            $excel_title = 'Branch';
                                        elseif ($useRole == 3):
                                            echo 'Division';
                                            $excel_title = 'Division';
                                        elseif ($useRole == 2):
                                            echo 'Region';
                                            $excel_title = 'Region';
                                        elseif ($useRole == 1):
                                            echo 'Area';
                                            $excel_title = 'Area';
                                        else:
                                            echo 'Global';
                                            $excel_title = 'Global';
                                        endif;
                                        if ($inputmonth == ""):
                                            $excel_title .= " Trend Report as on " . date('F Y', strtotime(date('Y-M') . " -1 month"));
                                        else:
                                            $excel_title .= " Trend Report as on " . date('F Y', strtotime($inputmonth));
                                        endif;
                                        ?>
                                        Trend Report as on
                                        <?php
                                        if ($inputmonth == ""):
                                            echo date('F Y', strtotime(date('Y-M') . " -1 month"));
                                        else:
                                            echo date('F Y', strtotime($inputmonth));
                                        endif;
                                        ?> (DABI)
                                    </b>
                                </h6>
                            </td>
                            <td style="border: hidden; width: 33%"></td>
                        </tr>
                    </table>
                    <?php
                    $first_text = "";
                    $second_text = "";
                    $third_text = "";
                    $fourth_text = "";
                    ?>
                    <table style="width: 100%; border: hidden; padding: 0px">
                        <tr style="border: hidden">
                            <td style="border: hidden">
                                <p style="text-align: left; line-height: 5px; line-spacing: 5px; font-size: 10px">
                                    <b id="firsttext">
                                        <?php
                                        if ($useRole == 4 || $useRole == 15):
                                            echo 'Global Trend Report';
                                            $first_text = 'Global Trend Report';
                                        elseif ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            if ($divisionName == ('Dabi Eastern')):
                                                echo 'Zone Name:  ' . $divisionName;
                                                $first_text = 'Zone Name:  ' . $divisionName;
                                            elseif ($divisionName == ('Dabi Western')):
                                                echo 'Zone Name:  ' . $divisionName;
                                                $first_text = 'Zone Name:  ' . $divisionName;
                                            else:
                                                echo 'Division Name:  ' . $divisionName;
                                                $first_text = 'Division Name:  ' . $divisionName;
                                            endif;
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo 'Region Name:  ' . $regionName;
                                            $first_text = 'Region Name:  ' . $regionName;
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                            echo 'Area Name:  ' . $areaName;
                                            $first_text = 'Area Name:  ' . $areaName;
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                            echo 'Branch Name:  ' . $branchName . ' - ' . $branchId;
                                            $first_text = 'Branch Name:  ' . $branchName . ' - ' . $branchId;
                                        elseif ($useRole == 3):
                                            echo 'Division Name:  ' . $divisionNameforRole3 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 'Region Name: ' . $regionName;
                                            $first_text = 'Division Name:  ' . $divisionNameforRole3;
                                        elseif ($useRole == 2):
                                            echo 'Region Name:  ' . $regionNameforRole2;
                                            $first_text = 'Region Name:  ' . $regionNameforRole2;
                                        elseif ($useRole == 1):
                                            echo 'Area Name:  ' . $areaNameforRole1;
                                            $first_text = 'Area Name:  ' . $areaNameforRole1;
                                        else:
                                            echo 'Global Trend Report';
                                            $first_text = 'Global Trend Report';
                                        endif;
                                        ?>
                                    </b>
                                </p>
                            </td>
                            <td style="border: hidden">
                                <p style="line-height: 5px; line-spacing: 5px; font-size: 10px">
                                    <b id="secondtext">
                                        <?php
                                        if ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo '';
                                            $second_text = '';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo 'Division Name:  ' . $divisionName;
                                            $second_text = 'Division Name:  ' . $divisionName;
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                            echo 'Region Name:  ' . $regionName;
                                            $second_text = 'Region Name:  ' . $regionName;
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                            echo 'Area Name:  ' . $areaName;
                                            $second_text = 'Area Name:  ' . $areaName;
#else:
#echo 'All Report';
                                        endif;
                                        ?>
                                    </b>
                                </p>
                            </td>
                            <td style="border: hidden">
                                <p style="line-height: 5px; line-spacing: 5px; font-size: 10px">
                                    <b id="thirdtext">
                                        <?php
                                        if ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo '';
                                            $third_text = '';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo '';
                                            $third_text = '';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                            echo 'Division Name:  ' . $divisionName;
                                            $third_text = 'Division Name:  ' . $divisionName;
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                            echo 'Region Name:  ' . $regionName;
                                            $third_text = 'Region Name:  ' . $regionName;
#else:
#echo 'All Report';
                                        endif;
                                        ?>
                                    </b>
                                </p>
                            </td>
                            <td style="border: hidden">
                                <p style="line-height: 5px; line-spacing: 5px; font-size: 10px">
                                    <b id="fourthtext">
                                        <?php
                                        if ((isset($divisionName)) && (!isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo '';
                                            $fourth_text = '';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (!isset($areaName)) && (!isset($branchName))):
                                            echo '';
                                            $fourth_text = '';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (!isset($branchName))):
                                            echo '';
                                            $fourth_text = '';
                                        elseif ((isset($divisionName)) && (isset($regionName)) && (isset($areaName)) && (isset($branchName))):
                                            echo 'Division Name:  ' . $divisionName;
                                            $fourth_text = 'Division Name:  ' . $divisionName;
#else:
#echo 'All Report';
                                        endif;
                                        ?>
                                    </b>
                                </p>
                            </td>
                            <td id="printed_date"><p style="line-height: 5px; line-spacing: 5px; font-size: 10px; text-align: right">Printed Date : <?php echo date('d/m/y'); ?></p></td>
                        </tr>
                    </table>
                </div> 
            </div>
            <div class="col-lg-12">
                <div class="adv-table">
                    <style type="text/css">
                        #print{padding: 0px; width: auto; font-family: arial; font-size: 8px; text-align: right;}
                        #printheader{padding: 0px; font-weight: bold; font-size: 10px;font-family: arial;text-align: center}
                    </style>
                    <style type="text/css" media="print">
                        @page { size: landscape; margin: 0; }          
                        @media print {
                        }
                    </style>
                    <table class="display table table-bordered edit-table" id="table2excel">
                        <thead>
                            <tr>
                                <th id="printheader">Sl.</th>
                                <th id="printheader">Item Name</th>
                                <?php if ($monthinterval == 0): ?>         
                                    <th id="printheader"><?php echo $previousmonth13; ?></th>
                                    <th id="printheader"><?php echo $previousmonth12; ?></th>
                                    <th id="printheader"><?php echo $previousmonth11; ?></th>
                                    <th id="printheader"><?php echo $previousmonth10; ?></th>                                                                             
                                    <th id="printheader"><?php echo $previousmonth9; ?></th>
                                    <th id="printheader"><?php echo $previousmonth8; ?></th>
                                    <th id="printheader"><?php echo $previousmonth7; ?></th>
                                    <th id="printheader"><?php echo $previousmonth6; ?></th>
                                    <th id="printheader"><?php echo $previousmonth5; ?></th>
                                    <th id="printheader"><?php echo $previousmonth4; ?></th>
                                    <th id="printheader"><?php echo $previousmonth3; ?></th>
                                    <th id="printheader"><?php echo $previousmonth2; ?></th>
                                    <th id="printheader"><?php echo $previousmonth1; ?></th>
                                    <?php
                                else:
                                    $yrmonlen = sizeof($yrmonArr);
                                    for ($m = $yrmonlen - 1; $m >= 0; $m--):
                                        ?>
                                        <th id="printheader"><?php echo $yrmonArr[$m]; ?></th>
                                        <?php
                                    endfor;
                                endif;
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $len = sizeof($qRyresult);
                            if ($len > 0):
                                foreach ($qRyresult as $data):
                                    $A = $data->item_no;
                                    if (!is_numeric($A)):
                                        ?>
                                        <tr id="rownumprint<?php echo $data->item_no; ?>">                                              
                                            <td id="print" style="text-align: right; font-weight: bold"> <?php echo $data->item_no; ?> </td>
                                            <td id="print" style="text-align: left; font-weight: bold"> <?php echo $data->indicator; ?> </td>
                                            <?php if ($monthinterval == 0): ?>         
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <td id="print"> <?php echo '' ?> </td>
                                                <?php
                                            else:
                                                for ($m = $monthinterval + 1; $m >= 1; $m--):
                                                    ?>
                                                    <td id="print"> <?php echo '' ?> </td>
                                                    <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </tr>
                                    <?php else: ?>
                                        <tr id="rownumprint<?php echo $data->item_no; ?>">                      
                                            <td id="print" style="text-align: right"> <?php echo $data->item_no; ?> </td>
                                            <td id="print" style="text-align: left; padding-left: 8px; margin-left: 8px"> <?php echo $data->indicator; ?> </td>
                                            <?php if ($monthinterval == 0): ?>       
                                                <?php if (in_array($data->item_no, array(5, 46, 47, 48, 83, 84, 85, 86, 87, 88, 91, 95))): ?>
                                                    <td id="print"> <?php echo number_format($data->previousmonth13, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth12, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth11, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth10, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth9, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth8, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth7, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth6, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth5, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth4, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth3, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth2, 2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth1, 2); ?> </td>
                                                <?php else: ?>
                                                    <td id="print"> <?php echo number_format($data->previousmonth13); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth12); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth11); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth10); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth9); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth8); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth7); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth6); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth5); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth4); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth3); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth2); ?> </td>
                                                    <td id="print"> <?php echo number_format($data->previousmonth1); ?> </td>
                                                <?php endif; ?>
                                                <?php
                                            else:
                                                for ($m = $monthinterval + 1; $m >= 1; $m--):
                                                    $monindex = 'previousmonth' . $m;
                                                    ?>
                                                    <?php if (in_array($data->item_no, array(5, 46, 47, 48, 83, 84, 85, 86, 87, 88, 91, 95))): ?>
                                                        <td id="print"> <?php echo number_format($data->$monindex, 2); ?> </td>
                                                    <?php else: ?>
                                                        <td id="print"> <?php echo number_format($data->$monindex); ?> </td>
                                                    <?php endif; ?>
                                                    <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </tr>
                                    <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>                  
                    <div style="clear: both"></div>
                </div>                       
            </div>                    
        </div>
    </div>
</section>


<div class="modal fade" id="advancedexportprocessing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Advanced Export Processing</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="form-group ">
                        <div class="col-md-12">
                            <img src="<?php echo $baseurl; ?>assets/img/animation_processing.gif">                               
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>






<script type="text/javascript">

    function removeExtraItem() {
        var radioselectedlen = $('input[name="divisionidval"]:checked').length;
        if (radioselectedlen == 0) {
            $("#itemselecterrordiv").show();
            return false;
        } else {
            var radioselected = document.querySelector('input[name="divisionidval"]:checked').value;
            var cid = "dataitemlist" + radioselected;
            var nid = "dataitemnotremovelist" + radioselected;
            document.getElementById(cid).setAttribute("id", nid);
            $("li[id*='dataitemlist']").remove();
            //$("#advancedexport").modal('hide');
            //$("#advancedexportprocessing").modal('show');
            return true;
        }
    }

    function regionClick(checksts, regionid) {
        var areaid = 'areaidval' + regionid;
        var branchid = 'branchidval' + regionid;
        if (checksts.checked) {
            $('input:checkbox[id^="' + areaid + '"]').prop('checked', true);
            $('input:checkbox[id^="' + branchid + '"]').prop('checked', true);
        } else {
            $('input:checkbox[id^="' + areaid + '"]').prop('checked', false);
            $('input:checkbox[id^="' + branchid + '"]').prop('checked', false);
        }
    }

    function areaClick(checksts, regionid, areaid) {
        var branchid = 'branchidval' + regionid + areaid;
        if (checksts.checked) {
            $('input:checkbox[id^="' + branchid + '"]').prop('checked', true);
        } else {
            $('input:checkbox[id^="' + branchid + '"]').prop('checked', false);
        }
    }

    function indMasterClick(checksts, masterid) {
        var inddetailid = 'indicatordtid' + masterid;
        if (checksts.checked) {
            $('input:checkbox[id^="' + inddetailid + '"]').prop('checked', true);
        } else {
            $('input:checkbox[id^="' + inddetailid + '"]').prop('checked', false);
        }
    }

    $('html').on({
        "shown.bs.dropdown": function () {
            this.closable = true;
        },
        "click": function (e) {
            var target = $(e.target);
            if (target.hasClass("masterindicatorclass")) {
                this.closable = false;
            } else {
                this.closable = true;
            }
        },
        "hide.bs.dropdown": function () {
            return this.closable;
        }
    });


    $(function () {
        $(".dropdown-menu > li > label").on("click", function (e) {
            var current = $(this).next();
            var grandparent = $(this).parent().parent();
            if ($(this).hasClass('left-caret') || $(this).hasClass('right-caret'))
                $(this).toggleClass('left-caret right-caret');
            grandparent.find('.left-caret').not(this).toggleClass('right-caret left-caret');
            grandparent.find(".sub-menu:visible").not(current).hide();
            current.toggle();
            e.stopPropagation();
            if ($(this).hasClass('fa-circle-o') || $(this).hasClass('fa-dot-circle-o')) {
                $(this).toggleClass('fa-circle-o fa-dot-circle-o');
                grandparent.find('.fa-dot-circle-o').not(this).toggleClass('fa-dot-circle-o fa-circle-o');
            }

        });
    });



    var notDefaultItem = [];
    var defaultItem = [];
    var notDefaultItemStatic = [];
    var maxIndItemVal;
    var allIndItem = [];
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('dabi/dabi/getIndicatorNotDefault'); ?>",
            data: '',
            success: function (responseData) {
                var parseData = JSON.parse(responseData);
                var notDefaultItemData = parseData.notDefaultItem;
                var defaultItemData = parseData.defaultItem;
                maxIndItemVal = parseData.maxIndItemVal;
                allIndItem = parseData.getAllIndItem;
                for (var i = 0; i < notDefaultItemData.length; i++) {
                    var itemno = notDefaultItemData[i].item_no;
                    $("#rownum" + itemno).hide();
                    $("#rownumprint" + itemno).hide();
                    //$("#rownumexe" + itemno).hide();
                    notDefaultItem.push(itemno);
                    notDefaultItemStatic.push(itemno);
                }
                var sl = 0;
                for (var j = 0; j < defaultItemData.length; j++) {
                    var itemsl = defaultItemData[j].item_no;
                    defaultItem.push(itemsl);
                    if (itemsl % 1 === 0 && ($("#rownum" + itemsl).is(":visible"))) {
                        sl++;
                        $("#rownum" + itemsl).find('td span:eq(1)').text(sl);
                        $("#rownumprint" + itemsl).find('td:first').text(sl);
                    }
                }
            }
        });
    });

    $("#rownumJ").fadeOut(700);
    $("#rownumprintJ").hide();
    //$("#rownumexeJ").hide();
    notDefaultItem.push("J");
    //To change category text for branch trend report
    var branch_id = $("#branch_id").val();
    if (branch_id != "") {
        $("#rownum53").find('td:eq(1)').text("Category");
        $("#rownumprint53").find('td:eq(1)').text("Category");
        $("#rownum74").find('td:eq(1)').text("Branch Type");
        $("#rownumprint74").find('td:eq(1)').text("Branch Type");
    }


    function deleteDataRow(rowval) {
        $("#rownum" + rowval).fadeOut(700);
        $("#rownumprint" + rowval).hide();
        //$("#rownumexe" + rowval).hide();
        var valIndex = $.inArray(rowval, notDefaultItem);
        if (valIndex == -1) {
            notDefaultItem.push(rowval);
        }
        $("#detailsindicator" + rowval).prop("checked", false);

        setTimeout(function () {
            var sl = 0;
            for (var j = 0; j < allIndItem.length; j++) {
                var itemsl = allIndItem[j].item_no;
                if (itemsl % 1 === 0 && ($("#rownum" + itemsl).is(":visible"))) {
                    sl++;
                    $("#rownum" + itemsl).find('td span:eq(1)').text(sl);
                    $("#rownumprint" + itemsl).find('td:first').text(sl);
                }
            }
        }, 800);

        //Only for loan slab 
        if (rowval > 58) {
            $("#rownum" + rowval).hide();
            $("#rownumJ").fadeOut(700);
            $("#rownumprintJ").hide();
            //$("#rownumexeJ").hide();
            notDefaultItem.push("J");
            for (var loansl = 59; loansl < maxIndItemVal; loansl++) {
                if ($("#rownum" + loansl).is(":visible")) {
                    var valIndex = $.inArray("J", notDefaultItem);
                    if (valIndex > -1) {
                        notDefaultItem.splice(valIndex, 1);
                        $("#rownumJ").fadeIn(700);
                        $("#rownumprintJ").show();
                        //$("#rownumexeJ").show();
                    }
                }
            }
        }
    }

    function showDataRow(rowval, masterId) {
        rowval = rowval.toString();
        if ($("#rownum" + rowval).is(":visible")) {
            $("#rownum" + rowval).fadeOut(700);
            $("#rownumprint" + rowval).hide();
            //$("#rownumexe" + rowval).hide();
            $("#selectalltext" + masterId).text("Select All");
            $("#detailsindicatorall" + masterId).prop("checked", false);
            var valIndex = $.inArray(rowval, notDefaultItem);
            if (valIndex == -1) {
                notDefaultItem.push(rowval);
            }
        } else {
            $("#rownum" + rowval).fadeIn(700);
            $("#rownumprint" + rowval).show();
            //$("#rownumexe" + rowval).show();
            var valIndex = $.inArray(rowval, notDefaultItem);
            if (valIndex > -1) {
                notDefaultItem.splice(valIndex, 1);
            }
        }

        setTimeout(function () {
            var sl = 0;
            for (var j = 0; j < allIndItem.length; j++) {
                var itemsl = allIndItem[j].item_no;
                if (itemsl % 1 === 0 && ($("#rownum" + itemsl).is(":visible"))) {
                    sl++;
                    $("#rownum" + itemsl).find('td span:eq(1)').text(sl);
                    $("#rownumprint" + itemsl).find('td:first').text(sl);
                }
            }
        }, 800);

        //Only for loan slab 
        if (rowval > 58) {
            for (var loansl = 59; loansl < maxIndItemVal; loansl++) {
                if ($("#rownum" + loansl).is(":visible")) {
                    var valIndex = $.inArray("J", notDefaultItem);
                    if (valIndex > -1) {
                        notDefaultItem.splice(valIndex, 1);
                        $("#rownumJ").fadeIn(700);
                        $("#rownumprintJ").show();
                        //$("#rownumexeJ").show();
                    }
                }
            }
        }
    }

    function showAllDataRow(masterId) {
        var itemsetid = $("#itemsetid" + masterId).val();
        var itemArr = itemsetid.split(",");
        if ($("#detailsindicatorall" + masterId).prop('checked')) {
            if (masterId == 10) {
                $("#rownumJ").fadeIn(700);
                $("#rownumprintJ").show();
                //$("#rownumexeJ").show();
                var valIndex = $.inArray("J", notDefaultItem);
                if (valIndex > -1) {
                    notDefaultItem.splice(valIndex, 1);
                }
            }
            $("#selectalltext" + masterId).text("Select None");
            for (i = 0; i < itemArr.length; i++) {
                var idvalue = itemArr[i];
                $("#detailsindicator" + idvalue).prop("checked", true);
                $("#rownum" + idvalue).fadeIn(700);
                $("#rownumprint" + idvalue).show();
                //$("#rownumexe" + idvalue).show();
                var valIndex = $.inArray(idvalue, notDefaultItem);
                if (valIndex > -1) {
                    notDefaultItem.splice(valIndex, 1);
                }
            }
        } else {
            $("#selectalltext" + masterId).text("Select All");
            for (i = 0; i < itemArr.length; i++) {
                var idvalue = itemArr[i];
                $("#detailsindicator" + idvalue).prop("checked", false);
                $("#rownum" + idvalue).fadeOut(700);
                $("#rownumprint" + idvalue).hide();
                //$("#rownumexe" + idvalue).hide();
                var valIndex = $.inArray(idvalue, notDefaultItem);
                if (valIndex == -1) {
                    notDefaultItem.push(idvalue);
                }
            }
            $("#rownumJ").fadeOut(700);
            $("#rownumprintJ").hide();
            //$("#rownumexeJ").hide();
            notDefaultItem.push("J");
        }

        setTimeout(function () {
            var sl = 0;
            for (var j = 0; j < allIndItem.length; j++) {
                var itemsl = allIndItem[j].item_no;
                if (itemsl % 1 === 0 && ($("#rownum" + itemsl).is(":visible"))) {
                    sl++;
                    $("#rownum" + itemsl).find('td span:eq(1)').text(sl);
                    $("#rownumprint" + itemsl).find('td:first').text(sl);
                }
            }
        }, 800);
    }

    function allNonDefaultReset() {
        var tempNotDefault = [];
        for (var arrin = 0; arrin < notDefaultItemStatic.length; arrin++) {
            tempNotDefault[arrin] = notDefaultItemStatic[arrin];
        }
        if ($("#allnondefault").prop('checked')) {
            $("#nondefaultresettext").text("Reset All Selection");
            for (i = 0; i < tempNotDefault.length; i++) {
                var idvalue = tempNotDefault[i];
                var valIndex = $.inArray(idvalue, notDefaultItem);
                if (valIndex > -1) {
                    $("#detailsindicator" + idvalue).prop("checked", true);
                    $("#rownum" + idvalue).fadeIn(700);
                    $("#rownumprint" + idvalue).show();
                    //$("#rownumexe" + idvalue).show();
                    notDefaultItem.splice(valIndex, 1);
                }
            }
            $("#rownumJ").fadeIn(700);
            $("#rownumprintJ").show();
            $("#rownumexeJ").show();
            var valIndex = $.inArray("J", notDefaultItem);
            if (valIndex > -1) {
                notDefaultItem.splice(valIndex, 1);
            }
        } else {
            $("#nondefaultresettext").text("Select All Items");
            for (i = 0; i < notDefaultItemStatic.length; i++) {
                var idvalue = tempNotDefault[i];
                var valIndex = $.inArray(idvalue, notDefaultItem);
                if (valIndex < 1) {
                    $("#detailsindicator" + idvalue).prop("checked", false);
                    $("#rownum" + idvalue).fadeOut(700);
                    $("#rownumprint" + idvalue).hide();
                    //$("#rownumexe" + idvalue).hide();
                    notDefaultItem.push(idvalue);
                }
            }
            $("#rownumJ").fadeOut(700);
            $("#rownumprintJ").hide();
            //$("#rownumexeJ").hide();
            var valIndex = $.inArray("J", notDefaultItem);
            if (valIndex < 1) {
                notDefaultItem.push("J");
            }
        }

        setTimeout(function () {
            var sl = 0;
            for (var j = 0; j < allIndItem.length; j++) {
                var itemsl = allIndItem[j].item_no;
                if (itemsl % 1 === 0 && ($("#rownum" + itemsl).is(":visible"))) {
                    sl++;
                    $("#rownum" + itemsl).find('td span:eq(1)').text(sl);
                    $("#rownumprint" + itemsl).find('td:first').text(sl);
                }
            }
        }, 800);
    }

    function getRegion() {
        var division_id = $("#division_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('dabi/dabi/getRegionByDivision'); ?>",
            data: 'division_id=' + division_id,
            success: function (data) {
                document.getElementById("region_id").innerHTML = data;
                document.getElementById("area_id").innerHTML = "<option value=''>-- Select Area --</option>";
                document.getElementById("branch_id").innerHTML = "<option value=''>-- Select Branch --</option>";
            }
        });
    }

    function getArea() {
        var region_id = $("#region_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('dabi/dabi/getAreaByRegion'); ?>",
            data: 'region_id=' + region_id,
            success: function (data) {
                document.getElementById("area_id").innerHTML = data;
                document.getElementById("branch_id").innerHTML = "<option value=''>-- Select Branch --</option>";
            }
        });
    }

    function getBranch() {
        var area_id = $("#area_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('dabi/dabi/getBranchByArea'); ?>",
            data: 'area_id=' + area_id,
            success: function (data) {
                document.getElementById("branch_id").innerHTML = data;
            }
        });
    }

    //For print
    function Clickheretoprint(elem) {
        Popup(jQuery(elem).html());
    }

    function Popup(data) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/saveactivitylogfun'); ?>",
            data: 'activity_id=6' + '&program_id=1',
            success: function (data) {
            }
        });
        var numOfVisibleRows = $('#table2excel tbody tr').filter(function () {
            return $(this).css('display') !== 'none';
        }).length;

        var mywindow = window.open('', '');
        mywindow.document.write('<html><title></title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo $baseurl ?>assets/css/bootstrap.min.css" type="text/css" />');
        mywindow.document.write('<head></head><body><style type="text/css">');
        mywindow.document.write('table{margin-left:0px;margin-right:10px;margin-top:1px;margin-bottom:0px}');
        mywindow.document.write('table thead, tr, th, table tbody, tr, td { border: 1px solid #000; width:auto}');
        mywindow.document.write('<style type="text/css">body{ margin-left:100px;margin-right:0px;margin-top:1px;margin-bottom:0px } </style><body>');

        var divtag1 = '<div class="col-lg-12">' +
                '<div class="adv-table">';
        var divtag11 = '</div></div>';
        var htmlStyle = '<style type="text/css">' +
                '#print{padding: 0px; width: auto; font-family: arial; font-size: 8px; text-align: right;}' +
                '#printheader{padding: 0px; font-weight: bold; font-size: 10px;font-family: arial;text-align: center}' +
                '</style>' +
                '<style type="text/css" media="print">' +
                '@page { size: landscape; margin: 0; }' +
                '@media print { .pagebreakclass {page-break-after: always; } }' +
                '</style>';
        var divtag2 = '<table class="display table table-bordered edit-table">';
        var divtag22 = '</table>';


        if (numOfVisibleRows > 51) {
            var printheader = document.getElementById("printheader").innerHTML;
            mywindow.document.write('<div class="col-lg-12">');
            mywindow.document.write(printheader);
            mywindow.document.write(divtag1);
            mywindow.document.write(htmlStyle);
            mywindow.document.write(divtag2);
            var line = 0;

            $.each($('#table2excel thead tr'), function (i, row) {
                line++;
                mywindow.document.write('<thead><tr>');
                $.each($(row).find("td, th"), function (j, cell) {
                    var txt = $(cell).text().trim() || " ";
                    mywindow.document.write('<th id="printheader">' + txt + '</th>');
                });
                mywindow.document.write('</thead></tr>');
            });

            mywindow.document.write('<tbody>');
            $.each($('#table2excel tbody tr'), function (k, row) {
                if ($(this).css("display") != 'none') {
                    line++;
                    mywindow.document.write('<tr>');
                    $.each($(row).find("td, th"), function (l, cell) {
                        var txt = $(cell).text().trim() || " ";
                        if (l == 0) {
                            mywindow.document.write('<td id="print" style="text-align: right">' + txt + '</td>');
                        } else if (l == 1) {
                            mywindow.document.write('<td id="print" style="text-align: left;padding-left:8px">' + txt + '</td>');
                        } else {
                            mywindow.document.write('<td id="print">' + txt + '</td>');
                        }
                    });
                    mywindow.document.write('</tr>');
                }
                return line < 51;
            });
            mywindow.document.write('</tbody>');
            mywindow.document.write(divtag22);
            mywindow.document.write(divtag11);

            mywindow.document.write('<div class="pagebreakclass"> </div>');
            mywindow.document.write('<div class="col-lg-12">  </div>');
            mywindow.document.write(printheader);
            mywindow.document.write(divtag1);
            mywindow.document.write(divtag2);

            $.each($('#table2excel thead tr'), function (m, row) {
                line++;
                mywindow.document.write('<thead><tr>');
                $.each($(row).find("td, th"), function (n, cell) {
                    var txt = $(cell).text().trim() || " ";
                    mywindow.document.write('<th id="printheader">' + txt + '</th>');
                });
                mywindow.document.write('</thead></tr>');
            });

            var newpageline = 0;
            mywindow.document.write('<tbody>');
            $.each($('#table2excel tbody tr'), function (q, row) {
                if ($(this).css("display") != 'none') {
                    line++;
                    newpageline++;
                    if (newpageline > 50) {
                        mywindow.document.write('<tr>');
                        $.each($(row).find("td, th"), function (r, cell) {
                            var txt = $(cell).text().trim() || " ";
                            if (r == 0) {
                                mywindow.document.write('<td id="print" style="text-align: right">' + txt + '</td>');
                            } else if (r == 1) {
                                mywindow.document.write('<td id="print" style="text-align: left;padding-left:8px">' + txt + '</td>');
                            } else {
                                mywindow.document.write('<td id="print">' + txt + '</td>');
                            }
                        });
                        mywindow.document.write('</tr>');
                    }
                }
            });
            mywindow.document.write('</tbody>');
            mywindow.document.write(divtag22);
            mywindow.document.write(divtag11);

            mywindow.document.write(divtag22);
            mywindow.document.write(divtag11);
            mywindow.document.write('</div>');

        } else {
            mywindow.document.write(data);
        }

        mywindow.document.write('</body></html>');
        mywindow.document.close();

        setTimeout(function () {
            mywindow.print();
        }, 500);
    }

    //Generate PDF
    function generatePdf() {
        var activity_code = "1032";
        var details = "Trend Report(Dabi) PDF Download";

        var formData = {
            'activity_code': activity_code,
            'details': details,
        };

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/savelogdata'); ?>",
            data: formData,
            success: function (data) {
                console.log(data);
            }
        });

        var firsttext = $("#firsttext").text();
        firsttext = firsttext.replace(/[\s\n\r]+/g, ' ');
        var secondtext = $("#secondtext").text();
        secondtext = secondtext.replace(/[\s\n\r]+/g, ' ');
        var thirdtext = $("#thirdtext").text();
        thirdtext = thirdtext.replace(/[\s\n\r]+/g, ' ');
        var fourthtext = $("#fourthtext").text();
        fourthtext = fourthtext.replace(/[\s\n\r]+/g, ' ');
        var printed_date = $("#printed_date").text();
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var currentdate = d.getFullYear() + '-' +
                (('' + month).length < 2 ? '0' : '') + month + '-' +
                (('' + day).length < 2 ? '0' : '') + day;
        var reportMonth = "<?php echo $previousmonth1; ?>";
        var pdf = new jsPDF('l', 'pt', 'letter', true);
        pdf.setFontSize(8);
        pdf.setFontType("bold");
        pdf.setFont("times");
        pdf.text(300, 15, "Global Trend Report as on " + reportMonth + " (DABI)");
        pdf.text(30, 25, "BRAC Microfinance");
        pdf.text(28, 35, firsttext);
        pdf.text(160, 35, secondtext);
        pdf.text(290, 35, thirdtext);
        pdf.text(420, 35, fourthtext);
        pdf.text(670, 35, printed_date);
        pdf.setFontType("normal");
        pdf.cellInitialize();
        pdf.setFontSize(6.4);
        var line = 0;
        $.each($('#table2excel tr'), function (i, row) {
            if ($(this).css("display") != 'none') {
                line++;
                if (i == 0) {
                    pdf.setFontType("bold");
                } else if (line == 52) {  //Line/Row number to enter into second page
                    pdf.addPage();
                    pdf.setFontSize(8);
                    pdf.setFontType("bold");
                    pdf.text(300, 15, "Global Trend Report as on " + reportMonth + " (DABI)");
                    pdf.text(30, 25, "BRAC Microfinance");
                    pdf.text(28, 35, firsttext);
                    pdf.text(160, 35, secondtext);
                    pdf.text(290, 35, thirdtext);
                    pdf.text(420, 35, fourthtext);
                    pdf.text(670, 35, printed_date);
                    pdf.setFontSize(6.4)
                    pdf.cellInitialize();
                    $.each($('#table2excel thead tr'), function (k, row) {
                        $.each($(row).find("td, th"), function (l, cell) {
                            var txt = $(cell).text().trim() || " ";
                            var width = 0;
                            var text_align = "right";
                            if (l == 0) {
                                width = 12;
                                text_align = "right";
                            } else if (l == 1) {
                                text_align = "left";
                                width = 150;
                            } else {
                                width = 47;
                            }
                            pdf.cell(10, 45, width, 10, txt, k, text_align);
                        });
                    });
                    pdf.setFontType("normal");
                } else {
                    pdf.setFontType("normal");
                }
                $.each($(row).find("td, th"), function (j, cell) {
                    var txt = $(cell).text().trim() || " ";
                    var width = 0;
                    var text_align = "right";
                    if (j == 0) {
                        width = 12;
                        text_align = "right";
                        if (isNaN(txt)) {
                            pdf.setFontType("bold");
                        } else {
                            pdf.setFontType("normal");
                        }
                    } else if (j == 1) {
                        text_align = "left";
                        width = 150;
                    } else {
                        width = 47;
                    }
                    pdf.cell(10, 45, width, 10, txt, i, text_align);
                });
            }
        });
        pdf.save("DABI_Trend_Report_" + currentdate + ".pdf");
        //pdf.output('dataurlnewwindow');
    }


    //Generate excel file 
    function generateExcel() {
        var branch_id = "<?php echo $branch_id; ?>";
        var area_id = "<?php echo $area_id; ?>";
        var region_id = "<?php echo $region_id; ?>";
        var division_id = "<?php echo $division_id; ?>";
        var programId = "<?php echo $programId; ?>";
        var monthinterval = "<?php echo $monthinterval; ?>";
        var initialdate = "<?php echo $previous1; ?>";
        var dataString = "branch_id=" + branch_id + "&area_id=" + area_id + "&region_id=" + region_id + "&division_id=" + division_id + "&programId=" + programId + "&monthinterval=" + monthinterval + "&initialdate=" + initialdate + "&notDefaultItem=" + notDefaultItem;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('home/saveactivitylogfun'); ?>",
            data: 'activity_id=4' + '&program_id=' + programId,
            success: function (data) {
            }
        });

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('dabi/dabi/generateExcel'); ?>",
            data: dataString,
            success: function (data) {
                window.location = "../" + data;
            }
        });
    }


    $(document).ready(function () {

        $(".monthPicker").datepicker({
            dateFormat: 'mm-yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        });

        $(".monthPicker").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

    });
</script>


<!-- For excel export this js included -->
<script src="<?php echo $baseurl; ?>assets/excel/excellentexport.js"></script> 
<!-- For pdf export this js included -->
<script src="<?php echo $baseurl; ?>assets/pdfcreate/jspdf.debug.js"></script> 

