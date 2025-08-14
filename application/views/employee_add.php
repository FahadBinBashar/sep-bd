<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a')) {
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
            <i class="fa fa-user-plus"></i> Add New Employee 
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
                        'name'         => $this->input->post('name', true),
                        'father'       => $this->input->post('father', true),
                        'mother'       => $this->input->post('mother', true),
                        'mobile'       => $this->input->post('mobile', true),
                        'email'        => $this->input->post('email', true),
                        'address'      => $this->input->post('address', true),
                        'pic'          => $pic,
                        'nid'          => $this->input->post('nid', true),
                        'pass'         => $this->input->post('pass', true),
                        'zone_id'      => $this->input->post('zone_id', true),
                        'ref_name'     => $this->input->post('ref_name', true),
                        'ref_nid'      => $this->input->post('ref_nid', true),
                        'ref_relation' => $this->input->post('ref_relation', true),
                        'ref_address'  => $this->input->post('ref_address', true),
                        'sts'          => 1,
                        'uid'          => $_SESSION['user_id'],
                        'pdate'        => date("Y-m-d H:i:s"),
                        'status'       => 'u'
                    );
                    $this->db->insert('employee', $data);

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/employee_list'));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                        redirect(base_url('admin/employee_add'));
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
                                <h4 class="pagetitleh2">Add New Employee</h4>

                                <div class="around10">
                                    <div class="row">
                                    

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="name" type="text" class="form-control" required>
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
                                                <input name="mobile" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" type="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="address" type="text" class="form-control">
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
                                                <label>NID No.</label>
                                                <input name="nid" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Zone Name</label>
                                                <select name="zone_id" class="form-control" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <?php
                                                        foreach ($zone_list as $zone) {
                                                            echo "<option value='$zone->id'>$zone->name</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Login Password</label>
                                                <input name="pass" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">&nbsp;</div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ref. Name</label>
                                                <input name="ref_name" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ref. NID No.</label>
                                                <input name="ref_nid" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ref. Relation</label>
                                                <input name="ref_relation" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ref. Address</label>
                                                <input name="ref_address" type="text" class="form-control" required>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
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



