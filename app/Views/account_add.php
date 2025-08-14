<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
?>
<!DOCTYPE html>
<html >
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('head'); ?>
        <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
        </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header" id="alert">
				<?php $this->load->view('header'); ?>
			</header>
			<?php $this->load->view('menu_left'); ?>



<div class="content-wrapper">  
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> Open New Account 
            <?php
                if (isset($_POST['add'])) {                    
                                            
                    $f_name = $_FILES['pic']['name'];
                    $f_name = stripslashes($f_name);
                    $f_name = strtolower($f_name);
                    if(strlen($f_name) > 8) {
                        $f_name = substr($f_name, -8);  
                    }
                    $f_name = date("Y_m_d") . "_" . time() . "_" . rand(111, 999) . $f_name;
                    $file_name = "img/" . $f_name;
                    
                    if ($_FILES['pic']['name']!='') {
                        $pic = $f_name;
                        copy($_FILES['pic']['tmp_name'], $file_name);
                    } else {
                        $pic = 'pic.png';
                    }
                    
                    $data = array(
                        'ac_no'              => '',
                        'name'               => $this->input->post('name', true),
                        'father'             => $this->input->post('father', true),
                        'mother'             => $this->input->post('mother', true),
                        'mobile'             => $this->input->post('mobile', true),
                        'address'            => $this->input->post('address', true),
                        'pic'                => $pic,
                        'monthly_amount'     => $this->input->post('monthly_amount', true),
                        'employee_id'        => $this->input->post('employee_id', true),
                        'zone_id'            => $this->input->post('zone_id', true),
                        'business_address'   => $this->input->post('business_address', true),
                        'nominee_name_a'     => $this->input->post('nominee_name_a', true),
                        'nominee_co_a'       => $this->input->post('nominee_co_a', true),
                        'nominee_age_a'      => $this->input->post('nominee_age_a', true),
                        'nominee_relation_a' => $this->input->post('nominee_relation_a', true),
                        'nominee_value_a'    => $this->input->post('nominee_value_a', true),
                        'nominee_name_b'     => $this->input->post('nominee_name_b', true),
                        'nominee_co_b'       => $this->input->post('nominee_co_b', true),
                        'nominee_age_b'      => $this->input->post('nominee_age_b', true),
                        'nominee_relation_b' => $this->input->post('nominee_relation_b', true),
                        'nominee_value_b'    => $this->input->post('nominee_value_b', true),
                        'sts'                => $this->input->post('sts', true),
                        'uid'                => $_SESSION['id'],
                        'pdate'              => $this->input->post('pdate', true),
                        'sl'                 => $this->input->post('sl', true)
                    );
                    $this->db->insert('account', $data);

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/account_add'));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                        redirect(base_url('admin/account_add'));
                    }                  
                             
                }               
            ?>
			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="pull-right box-tools" style="position: absolute;right: 14px;top: 13px;">
                        <!--<a href="std_inport.php"><button class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Import Student</button></a>-->
                    </div>

                    <form id="form1" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">    
                                <h4 class="pagetitleh2">Open New Account</h4>

                                <div class="around10">
                                    <div class="row">
                                    

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input id="dob" name="pdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Account No.</label>
                                                <input name="ac_no" type="text" class="form-control">
                                            </div>
                                        </div> -->

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="name" tabindex="1" type="text" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Father</label>
                                                <input name="father" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mother</label>
                                                <input name="mother" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="mobile" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Zone Name</label>
                                                <select name="zone_id" class="form-control">
                                                    
                                                    <?php
                                                        echo "<option selected value='".get_name_by_auto_id('employee', $_SESSION['user_id'], 'zone_id')."'>".get_name_by_auto_id('zone', get_name_by_auto_id('employee', $_SESSION['user_id'], 'zone_id'), 'name')."</option>";
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Select Image</label>
                                                <div><input class="filestyle form-control" type='file' name='pic' id="file"></div>
                                                
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Monthly Saving Amount</label>
                                                <input name="monthly_amount" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employee Name</label>
                                                <select name="employee_id" class="form-control">
                                                    
                                                    <?php
                                                        if ($_SESSION['status']=='a') {
                                                            echo "<option value='' selected disabled>Select</option>";
                                                            foreach ($employee_list as $employee) {
                                                                echo "<option value='$employee->id'>$employee->name</option>";
                                                            }
                                                        } elseif ($_SESSION['status']=='u') {
                                                            echo "<option value='".$_SESSION['user_id']."'>".get_name_by_auto_id('employee', $_SESSION['user_id'], 'name')."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="sts" class="form-control" required>
                                                    <option value=""  disabled>Select</option>
                                                    <option value='1' selected>Active</option>
                                                    <option value='0'>Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>SL</label>
                                                <input name="sl" type="text" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="address" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Business Address</label>
                                                <input name="business_address" type="text" class="form-control">
                                            </div>
                                        </div>


                                        <div class="col-md-12"><hr><h4>Nominee KA</h4></div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="nominee_name_a" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Father/Mother</label>
                                                <input name="nominee_co_a" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input name="nominee_age_a" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Relation</label>
                                                <input name="nominee_relation_a" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Value (%)</label>
                                                <input name="nominee_value_a" type="text" class="form-control">
                                            </div>
                                        </div>

                                        

                                        <div class="col-md-12"><hr><h4>Nominee KHA</h4></div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="nominee_name_b" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Father/Mother</label>
                                                <input name="nominee_co_b" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input name="nominee_age_b" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Relation</label>
                                                <input name="nominee_relation_b" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Value (%)</label>
                                                <input name="nominee_value_b" type="text" class="form-control">
                                            </div>
                                        </div>

                                        

                                        <div class="col-md-12"><hr>
                                            <button type="submit" class="btn btn-info pull-left" name="add">Save</button>
                                        </div>
										
										
                                    </div>
                                </div>
                            </div>
                            
                        </div>        

                            
                    </form>
                </div>               
            </div>
        </div> 
</div>
</section>
</div>


<?php $this->load->view('f9'); ?>

</body>
</html>
<?php
} else {
        redirect('admin');
        echo "<center><div style='margin-top:50px; padding:20px; border-radius:10px; width:150px; background-color:pink;'>";
        echo "<a href='".base_url()."admin'>Please Login First</a>";
        echo "</div></center>";
    }   
?>


<script type="text/javascript">
    $(document).ready(function () {
        var date_format = 'yyyy-mm-dd';
        $('#dob,#dob2').datepicker({
            format: date_format,
            autoclose: true
        });
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
    });
</script>
