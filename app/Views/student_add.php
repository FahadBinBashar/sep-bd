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
            <i class="fa fa-user-plus"></i> Add New Doctor 
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

                    <form id="form1" action="student-submit" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">    
                                <h4 class="pagetitleh2">Add New Doctor</h4>

                                <div class="around10">
                                    <div class="row">
                                        
                                        

                                        <div class="col-md-12"></div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>BMDC No.</label>
                                                <input name="sid" type="text" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="name" type="text" class="form-control" required>
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
                                                <input name="email" type="text" class="form-control">
                                            </div>
                                        </div>
										<div class="col-md-12">
                                            <div class="form-group">
                                                <label>Login Password</label>
                                                <input name="password" type="text" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Date Of Birth</label>
                                                <input id="dob" name="dob" placeholder="" type="text" class="form-control">
                                                <span class="text-danger"></span>
                                            </div>									
                                        </div>
										
                                    </div>
                                </div>
                            </div>
                            
                            </div>        

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right" name="product_add">Save</button>
                            </div>
                    </form>
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

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = 'yyyy-mm-dd';
        $('#dob').datepicker({
            format: date_format,
            autoclose: true
        });
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
    });
</script>



