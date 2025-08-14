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
            <i class="fa fa-user-plus"></i> Edit Employee 
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
                        $data = array(
                            'name'    => $this->input->post('name', true),
                            'mobile'  => $this->input->post('mobile', true),
                            'address' => $this->input->post('address', true),
                            'pic'     => $pic,
                            'pass'    => $this->input->post('pass', true),
                            'sts'     => 1
                        );
                    } else {
                        $data = array(
                            'name'    => $this->input->post('name', true),
                            'mobile'  => $this->input->post('mobile', true),
                            'address' => $this->input->post('address', true),
                            'pass'    => $this->input->post('pass', true),
                            'sts'     => 1
                        );
                    }
                    
                    $this->db->update( 'employee', $data, ['id' => $_GET['id']] );

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Edited Success!</font>');
                        //redirect(base_url('trading/party_client_list'));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
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
                        $query = $this->db->query("select * from employee where id = '$_GET[id]' ");
                        foreach($query->result() as $result) {
                    ?>
                    <form id="form1" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">    
                                <h4 class="pagetitleh2">Edit Employee</h4>

                                <div class="around10">
                                    <div class="row">
                                    

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="name" type="text" value="<?= $result->name ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="mobile" type="text" value="<?= $result->mobile ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Image [if needed]</label>
                                                <div><input class="filestyle form-control" type='file' name='pic' id="file" size='20' /></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="address" type="text" value="<?= $result->address ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input name="pass" type="text" value="<?= $result->pass ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-info pull-left" name="add">Edit Confirm</button>
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



