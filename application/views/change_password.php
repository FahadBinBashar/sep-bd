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
            <i class="fa fa-user-plus"></i> Change Password  
            <?php
                if (isset($_POST['add'])) {                    
                    
                    $current_password = $this->input->post('current_password', true);
                    $new_password     = $this->input->post('new_password', true);
                     $query = $this->db->select('pass')->from('employee')->where('id', $_SESSION['user_id'])->get();
                    foreach ($query->result() as $key => $value) {
                        echo $qpass=$value->pass;
                      }
                    if ($current_password == $qpass) {
                        $data = array(
                            'pass' => $new_password
                        );
                        $this->db->update('employee', $data, ['id' => $_SESSION['user_id']]);

                        if ( $this->db->affected_rows() ) {
                            $this->session->set_flashdata('msg', '<font color=green>Change Success!</font>');
                            redirect(base_url('admin/change_password'));
                        } else {
                            $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                        }   
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>Current Password is incorrect!</font>');
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
                                <h4 class="pagetitleh2">Change Password</h4>

                                <div class="around10">
                                    <div class="row">
                                    

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Current Password</label>
                                                <input name="current_password" type="text" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">&nbsp;</div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input name="new_password" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        


                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-info pull-left" name="add" onclick="return confirm('Change Confirm?');">Change Confirm</button>
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



