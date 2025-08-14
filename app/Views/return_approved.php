<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
?>

<!DOCTYPE html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('head'); ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <i class="fa fa-object-group"></i> Saving Return Approved List   

            

			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form action="" method="post">

                            <div class="col-md-12">
                                <input name="fdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input name="tdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report">
                            </div>
                             <div class="col-md-12"><hr></div>
                        </form>
                        <?php
                                if (isset($_POST['fdate'])) {
                                    $fdate = $_POST['fdate'];
                                    $tdate = $_POST['tdate'];
                                    $emp_id=$_SESSION['user_id'];
                                    
                                 ?>   
                                 
                                 <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <?php 
                            $cnt=0; 
                            $query = $this->db->query("select * from saving_collection where pdate between '$fdate' and '$tdate' and amount_return > '0' and sts = '1' and employee_id='$emp_id'");
                            
                            //$query = $this->db->select('*')->from('saving_collection')->where('amount_return >', 0)->where('employee_id', $_SESSION['user_id'])->where('sts', 1)->order_by('id', 'desc')->get();
                            foreach($query->result() as $value) {
                                $cnt = $cnt+1;
                            }
                        ?>
                        <h3 class="box-title titlefix">Saving Return List (<?= $cnt ?>) </h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Account ID</th>
                                        <th>Name</th>
                                        <th>Return Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                                                                                                               	
                                        // $query = $this->db->select('*')->from('saving_collection')->where('amount_return >', 0)->where('employee_id', $_SESSION['user_id'])->where('sts', 1)->order_by('id', 'desc')->get();
                                        foreach ($query->result() as $key => $value) {
                                    ?>
									<tr>                                               
										<td><?= ++$key ?></td>
										<td><?= $value->id ?></td>
                                        <td><?= $value->pdate ?></td>
										<td><?= $value->ac_id ?></td>
										<td><?= get_name_by_auto_id ('account', $value->ac_id, 'name') ?></td>
                                        <td><?= $value->amount_return ?></td>
                                        <td>
                                            <?php
                                                if ($value->sts=='1') {
                                                    echo "<font color=green>Approved</font>";
                                                } elseif ($value->sts=='2') {
                                                    echo "<font color=red>Pending</font>";
                                                }
                                            ?>
                                        </td>
									</tr>
                                    <?php } ?>
									
                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->
                           
                        
            
                            <?php }else{?>
                            
                            
                            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <?php 
                            $cnt=0; 
                            $query = $this->db->select('*')->from('saving_collection')->where('amount_return >', 0)->where('employee_id', $_SESSION['user_id'])->where('sts', 1)->order_by('id', 'desc')->get();
                            foreach($query->result() as $value) {
                                $cnt = $cnt+1;
                            }
                        ?>
                        <h3 class="box-title titlefix">Saving Return List (<?= $cnt ?>) </h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Account ID</th>
                                        <th>Name</th>
                                        <th>Return Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                                                                                                               	
                                        // $query = $this->db->select('*')->from('saving_collection')->where('amount_return >', 0)->where('employee_id', $_SESSION['user_id'])->where('sts', 1)->order_by('id', 'desc')->get();
                                        foreach ($query->result() as $key => $value) {
                                    ?>
									<tr>                                               
										<td><?= ++$key ?></td>
										<td><?= $value->id ?></td>
                                        <td><?= $value->pdate ?></td>
										<td><?= $value->ac_id ?></td>
										<td><?= get_name_by_auto_id ('account', $value->ac_id, 'name') ?></td>
                                        <td><?= $value->amount_return ?></td>
                                        <td>
                                            <?php
                                                if ($value->sts=='1') {
                                                    echo "<font color=green>Approved</font>";
                                                } elseif ($value->sts=='2') {
                                                    echo "<font color=red>Pending</font>";
                                                }
                                            ?>
                                        </td>
									</tr>
                                    <?php } ?>
									
                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->
        <?php }    ?>
        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
	
<?php $this->load->view('f9'); ?>

</body>
</html>
<?php
    } else {
        redirect('admin');
    }
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

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
