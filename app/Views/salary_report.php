<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a')) {
?>

<!DOCTYPE html>
<html >
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('head'); ?>
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
            <i class="fa fa-object-group"></i> Salary Report 
			
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
                        <h3 class="box-title titlefix">Salary Report</h3>
                    </div>

                    <div class="box-body">

                        
                        <form id="form1" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            
                            <label>From Date</label>
                            <input id="dob" name="fdate" type="text" value="<?php echo date("Y-m-d"); ?>" required>
                        
                            <label>To Date</label>
                            <input id="dob2" name="tdate" type="text" value="<?php echo date("Y-m-d"); ?>" required>

                            <input type="hidden" name="type" value="type" required>

                            <input type="submit" name="show_report" value="Show Report">
                                
                        </form>



                        
                        <hr>
                            <font size="3">
                            <?php 

                                if (isset($_POST['type'])) {
                                    $query = $this->db->query("select * from salary where sts = '1' and pdate between '$_POST[fdate]' and '$_POST[tdate]' ");
                                    echo "Report From : ".$_POST['fdate']." To : ".$_POST['tdate'];
                                    echo "<br>";
                                } else {
                                    $query = $this->db->select('*')->from('salary')->where('sts', 1)->order_by('id', 'asc')->get();
                                }

                                $total    = 0;
                                                                
                                foreach ($query->result() as $value) {
                                    $total = $total+$value->total;
                                }

                                if (isset($total)) {                                    
                                    echo "Total : ".number_format($total);
                                } else {
                                    echo 0;
                                }
                            ?>
                            </font>

                        <hr>
                        


                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Employee Name</th>
                                        <th>Duty Time</th>
                                        <th>Basic</th>
                                        <th>House</th>
                                        <th>Health</th>
                                        <th>Convence</th>
                                        <th>Total</th>
                                                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        
                                        foreach($query->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= ++$key ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->pdate ?></td>
										<td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('employee', $result->employee_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->duty_time ?></td>
										<td style="border: 1px solid #ddd;"><?= $result->basic ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->house ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->health ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->convence ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->total ?></td>
                                        										
									</tr>
									<?php } ?>
                                </tbody>
                            </table>
                            <hr>
                            

                            

                        </div>
                    </div>
                </div>
            </div>
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
