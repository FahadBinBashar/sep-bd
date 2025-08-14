<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a')) {
?>
<!DOCTYPE html>
<html >
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('admin/head'); ?>
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header" id="alert">
				<?php $this->load->view('fishing/header'); ?>
			</header>
            <?php $this->load->view('fishing/menu_left'); ?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-object-group"></i> Salary Details of <?= get_name_by_auto_id('f_employee', $employee_id, 'name') ?> 
            
			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        
                        <h3 class="box-title titlefix">Salary Details of <?= get_name_by_auto_id('f_employee', $employee_id, 'name') ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Employee Name</th>
                                        <th>Date</th>
                                        <th>Duty Time</th>                                        
                                        <th>Basic</th>
                                        <th>House</th>
                                        <th>Health</th>
                                        <th>Convence</th>
                                        <th>Total</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($employee_salary as $key => $salary) { ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= ++$key ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id('f_employee', $employee_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $salary->pdate ?></td>
                                        
                                        <td style="border: 1px solid #ddd;"><?= $salary->duty_time ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $salary->basic ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $salary->house ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $salary->health ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $salary->convence ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $salary->total ?></td>
                                        
									</tr>
									<?php } ?>
                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


	
	
<?php $this->load->view('admin/f9'); ?>

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