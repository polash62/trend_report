<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">           
            <li class="sub-menu">
                <a href="<?php echo site_url('incentive/dashboard'); ?>" class="<?php echo (isset($active_menu) && ($active_menu == 'dashboard_incentive')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>Dashboard</span>
                </a>
            </li> 

            <li class="sub-menu">
                <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'dabi')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>Dabi</span>
                </a>
                <ul class="sub">             
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_setcriteria')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/setcriteria'); ?>">Set Criteria</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_pulldata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/pulldata'); ?>">Pull Data</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_uploadtarget')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/uploadtarget'); ?>">Upload Target</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_uploaddata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/uploaddata'); ?>">Upload LLR (Cash)</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_calculation')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/calculation'); ?>">Incentive Calculation</a></li>
                    <?php endif; ?>
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_branchdata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/branchdata'); ?>">Branch Data</a></li>
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_receivingrate')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/receivingrate'); ?>">Payment Structure</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_upload_staffposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/upload_staffposition'); ?>">Upload Staff Position</a></li>                       
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_amountcalc')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/amountcalc'); ?>">Pay Out Calculation</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_poabmbm')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/poabmbm'); ?>">Pay Out PO & BM</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_amposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/amposition'); ?>">Pay Out AM</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'dabi_rmposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/dabi/rmposition'); ?>">Pay Out RM</a></li>
                    <?php endif; ?>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'bcup')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>BCUP</span>
                </a>

                <ul class="sub">             
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_setcriteria')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/setcriteria'); ?>">Set Criteria</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_pulldata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/pulldata'); ?>">Pull Data</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_uploadtarget')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/uploadtarget'); ?>">Upload Target</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_uploaddata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/uploaddata'); ?>">Upload LLR (Cash)</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_calculation')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/calculation'); ?>">Incentive Calculation</a></li>
                    <?php endif; ?>
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_branchdata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/branchdata'); ?>">Branch Data</a></li>
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_receivingrate')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/receivingrate'); ?>">Payment Structure</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_upload_staffposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/upload_staffposition'); ?>">Upload Staff Position</a></li>                       
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_amountcalc')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/amountcalc'); ?>">Pay Out Calculation</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_poabmbm')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/poabmbm'); ?>">Pay Out PO & BM</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_amposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/amposition'); ?>">Pay Out AM</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'bcup_rmposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/rmposition'); ?>">Pay Out RM</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'mergewithdabi')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/bcup/mergewithdabi'); ?>">Merge with Dabi</a></li>
                    <?php endif; ?>
                </ul>
            </li>


            <li class="sub-menu">
                <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'progoti')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>Progoti</span>
                </a>
                <ul class="sub">
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>                       
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_setcriteria')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/setcriteria'); ?>">Set Criteria</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_pulldata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/pulldata'); ?>">Pull Data</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_uploadtarget')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/uploadtarget'); ?>">Upload Target</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_uploaddata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/uploaddata'); ?>">Upload LLR (Cash)</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_calculation')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/calculation'); ?>">Incentive Calculation</a></li>
                    <?php endif; ?>
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_branchdata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/branchdata'); ?>">Area Data</a></li>
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_receivingrate')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/receivingrate'); ?>">Payment Structure</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_upload_staffposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/upload_staffposition'); ?>">Upload Staff Position</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_amountcalc')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/amountcalc'); ?>">Pay Out Calculation</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_poabmbm')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/poabmbm'); ?>">Pay Out PO, AM</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progoti_rmposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/progoti/rmposition'); ?>">Pay Out RM</a></li>                    
                    <?php endif; ?>    
                </ul>
            </li>


            <li class="sub-menu">
                <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'scdp')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>SCDP</span>
                </a>
                <ul class="sub">             
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_setcriteria')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/setcriteria'); ?>">Set Criteria</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_pulldata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/pulldata'); ?>">Pull Data</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_uploadtarget')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/uploadtarget'); ?>">Upload Target</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_uploaddata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/uploaddata'); ?>">Upload LLR (Cash)</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_calculation')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/calculation'); ?>">Incentive Calculation</a></li>
                    <?php endif; ?>
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_branchdata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/branchdata'); ?>">Branch Data</a></li>
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_receivingrate')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/receivingrate'); ?>">Payment Structure</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_upload_staffposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/upload_staffposition'); ?>">Upload Staff Position</a></li>                       
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_amountcalc')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/amountcalc'); ?>">Pay Out Calculation</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_poabmbm')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/poabmbm'); ?>">Pay Out PO & BM</a></li>     
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'scdp_rmposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/scdp/rmposition'); ?>">Pay Out RM</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            
            
            <li class="sub-menu">
                <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'ncdp')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>NCDP</span>
                </a>
                <ul class="sub">             
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_setcriteria')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/setcriteria'); ?>">Set Criteria</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_pulldata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/pulldata'); ?>">Pull Data</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_uploadtarget')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/uploadtarget'); ?>">Upload Target</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_uploaddata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/uploaddata'); ?>">Upload LLR (Cash)</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_calculation')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/calculation'); ?>">Incentive Calculation</a></li>
                    <?php endif; ?>
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_branchdata')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/branchdata'); ?>">Branch Data</a></li>
                    <?php if (in_array($this->session->userdata('user_level_6'), array(209, 211))): ?>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_receivingrate')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/receivingrate'); ?>">Payment Structure</a></li> 
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_upload_staffposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/upload_staffposition'); ?>">Upload Staff Position</a></li>                       
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_amountcalc')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/amountcalc'); ?>">Pay Out Calculation</a></li>
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_poabmbm')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/poabmbm'); ?>">Pay Out PO & BM</a></li>     
                        <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'ncdp_rmposition')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/ncdp/rmposition'); ?>">Pay Out RM</a></li>
                    <?php endif; ?>
                </ul>
            </li>


            <li class="sub-menu">
                <a href="<?php echo site_url('incentive/target'); ?>" class="<?php echo (isset($active_menu) && ($active_menu == 'targetset')) ? 'active' : ''; ?>" >
                    <i class="fa fa-money"></i>
                    <span>Target</span>
                </a>
            </li> 

            <li class="sub-menu">
                <a href="<?php echo site_url('incentive/staffposition'); ?>" class="<?php echo (isset($active_menu) && ($active_menu == 'staffposition')) ? 'active' : ''; ?>" >
                    <i class="fa fa-money"></i>
                    <span>Staff Position</span>
                </a>
            </li> 

            <li class="sub-menu">
                <a href="javascript:;" class="<?php echo (isset($active_menu) && ($active_menu == 'admin')) ? 'active' : ''; ?>" >
                    <i class="fa fa-laptop"></i>
                    <span>Admin</span>
                </a>
                <ul class="sub">                   
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'quarter')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/admin/quarter'); ?>">Quarter</a></li>
                    <li class="<?php echo (isset($active_sub_menu) && ($active_sub_menu == 'progotiareaListdownload')) ? 'active' : ''; ?>"><a  href="<?php echo site_url('incentive/admin/progotiAreaListDownload'); ?>">Progoti Area List</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a  href="<?php echo site_url('dashboard/logout'); ?>"><i class="fa fa-laptop"></i>Log Out</a>
            </li>
        </ul>
    </div>
</aside>
<!--sidebar end-->