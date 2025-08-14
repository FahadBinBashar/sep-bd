<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a')) {
?>
<!DOCTYPE html>
<html >
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('admin/head'); ?>
        <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
        </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header" id="alert">
				<?php $this->load->view('admin/header'); ?>
			</header>
			<?php $this->load->view('admin/menu_left'); ?>



<div class="content-wrapper">  
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> Edit Doctor 

            <?php
                        
                if (isset($_POST['edit_confirm'])) {

                    $f_name = $_FILES['pic']['name'];
                    $f_name = stripslashes($f_name);
                    $f_name = strtolower($f_name);
                    if(strlen($f_name) > 8) {
                        $f_name = substr($f_name, -8);  
                    }
                    $f_name = date("Y_m_d") . "_" . time() . "_" . rand(111, 999) . $f_name;
                    $file_name = "pic/" . $f_name;
                    //copy($_FILES['pic']['tmp_name'], $file_name);
                    $pic = $f_name;

                    $name       = $_POST['name'];
                    $student_id = $_POST['student_id'];
                    $mobile     = $_POST['mobile'];
                    $email      = $_POST['email'];
                    $pass       = $_POST['pass'];
                    $password   = md5($pass);

                    if ($_FILES['pic']['name'] != "") {
                        copy($_FILES['pic']['tmp_name'], $file_name);
                        $upd_data = array(
                            'name'     => $name,
                            'student_id' => $student_id,
                            'mobile'   => $mobile,
                            'email'    => $email,
                            'pass'     => $pass,
                            'password' => $password,
                            'pic'      => $pic
                        );
                        $this->db->update( 'student', $upd_data, ['id' => $_GET['id']] );
                        echo "<font color='Green'>Edited Success!</font>";
                    } else {
                        $upd_data = array(
                            'name'     => $name,
                            'student_id' => $student_id,
                            'mobile'   => $mobile,
                            'email'    => $email,
                            'pass'     => $pass,
                            'password' => $password
                        );
                        $this->db->update( 'student', $upd_data, ['id' => $_GET['id']] );
                        echo "<font color='Green'>Edited Success!</font>";
                    }

                }

            ?>


			<?php if(isset($msg)){echo $msg;} ?>
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
                        $query = $this->db->query("select * from student where id = '$_GET[id]' order by id desc limit 1");
                        foreach($query->result() as $result) { 
                    ?>

                    <form id="form1" action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">    
                                <h4 class="pagetitleh2">Edit Doctor</h4>

                                <div class="around10">
                                    <div class="row">
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <img src="<?php echo base_url(); ?>pic/<?= $result->pic ?>" style="width: 200px; height: 200px;">
                                                <br>
                                                <label>Change Picture (if needed)</label>
                                                <input class="filestyle form-control" type='file' name='pic' id="file" size='20' />
                                            </div>
                                        </div>

                                        <div class="col-md-12"><hr></div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>BMDC No.</label>
                                                <input name="student_id" type="text" value="<?= $result->student_id ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="name" type="text" value="<?= $result->name ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="mobile" type="text" value="<?= $result->mobile ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" type="text" value="<?= $result->email ?>" class="form-control">
                                            </div>
                                        </div>
										<div class="col-md-12">
                                            <div class="form-group">
                                                <label>Login Password</label>
                                                <input name="pass" type="text" value="<?= $result->pass ?>" class="form-control" required>
                                            </div>
                                        </div>									
										
                                    </div>
                                </div>
                            </div>
                            
                        </div>        

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" name="edit_confirm">Edit Confirm</button>
                        </div>
                    </form>
                    <?php } ?>


                </div>               
            </div>
        </div> 
</div>
</section>
</div>


<?php $this->load->view('admin/f9'); ?>
                <script>
                        CKEDITOR.replace( 'editor1' );
                </script>
</body>
</html>

<?php
    } else {
        //redirect('http://ok.com');
        echo "<a href='admin'>Please Login First</a>";
    }
?>

<script type="text/javascript">

    $(document).ready(function () {
                
        $("#course_id").change(function(){
            var course_id = $(this).val();
            $(".batch").load("ajax/course_batch.php", 
                { course_id : course_id });
        });
        
        
    });
</script>



