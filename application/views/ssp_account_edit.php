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
            <i class="fa fa-user-plus"></i> Edit SSP Account 
            <?php
                if (isset($_POST['add'])) {                    
                               $emp_id= $this->input->post('employee_id', true);             
                   $data = array(
                        'name'               => $this->input->post('name', true),
                        'mobile'             => $this->input->post('mobile', true),
                        'address'            => $this->input->post('address', true),
                        'start_date'         => $this->input->post('sdate', true),
                        'end_date'           => $this->input->post('edate', true),
                        'monthly_amount'     => $this->input->post('monthly_amount', true),
                        'employee_id'        => $this->input->post('employee_id', true),
                        'sts'                => $this->input->post('sts', true),
                        'uid'                => $_SESSION['user_id'],
                        'pdate'              => date("Y-m-d")
                    );
                    $id = $this->input->post('id', true);
                    $this->db->update('account_diposit', $data, ['id' => $id]);

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Edited Success!</font>');
                        redirect(base_url('admin/ssp_account?employee_id='.$emp_id));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                        //redirect(base_url('admin/account_add'));
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
                    <?php
                        $query = $this->db->select('*')->from('account_diposit')->where('id', $_GET['id'])->get();
                        foreach ($query->result() as $key => $value) {
                    ?>

                    <form id="form1" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">    
                                <h4 class="pagetitleh2">Edit SSP Account</h4>

                                <div class="around10">
                                    <div class="row">
                                    
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="hidden" name="id" value="<?= $value->id ?>">
                                                <input name="name" value="<?= $value->name ?>" type="text" class="form-control" required>

                                            </div>
                                        </div>

                                       <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="mobile" value="<?= $value->mobile ?>" type="text" class="form-control">
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="address" value="<?= $value->address ?>" type="text" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input id="dob" name="sdate" type="text" value="<?= $value->start_date ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input id="dob" name="edate" type="text" value="<?= $value->end_date ?>" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Monthly Saving Amount</label>
                                                <input name="monthly_amount" value="<?= $value->monthly_amount ?>" type="text" class="form-control">
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
                                                                echo "<option value='$employee->id'";if($employee->id== $value->employee_id ){echo "selected";} echo">$employee->name</option>";
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
                                                    <?php
                                                        if ($value->sts==1) {
                                                            echo "<option value='1' selected>Active</option>";
                                                        } elseif ($value->sts==0) {
                                                            echo "<option value='0' selected>Inactive</option>";
                                                        }

                                                    ?>
                                                    
                                                    <option value='1'>Active</option>
                                                    <option value='0'>Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        

                                        

                                        <div class="col-md-12"><hr>
                                            <button type="submit" class="btn btn-info pull-left" name="add" onclick="return confirm('Edit Confirm?');">Edit Confirm</button>
                                        </div>
										
										
                                    </div>
                                </div>
                            </div>
                            
                        </div>        

                            
                    </form>
                    <?php } ?>
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
