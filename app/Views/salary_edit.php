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
            <i class="fa fa-object-group"></i> Employee Salary Edit  

			<?php
                if (isset($_POST['add'])) { 
                   
                    $total    = $this->input->post('total', true);
                    $basic    = $total/100*50;
                    $house    = $total/100*30;
                    $health   = $total/100*10;
                    $convence = $total/100*10;

                    $data = array(
                        'employee_id' => $this->input->post('employee_id', true),
                        'duty_time'   => $this->input->post('duty_time', true),
                        'basic'       => $basic, 
                        'house'       => $house,
                        'health'      => $health,
                        'convence'    => $convence,
                        'total'       => $total,
                        'pfand'       => 0,
                        'net_total'   => $total,                    
                        'sts'         => 1,
                        'uid'         => $_SESSION['id'],
                        'pdate'       => $this->input->post('pdate', true)
                    );
                    $this->db->update( 'f_salary', $data, ['id' => $salary_id] );

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Edit Success!</font>');
                        redirect(base_url('fishing/salary'));
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
            <div class="col-md-3">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Salary</h3>
                    </div><!-- /.box-header -->
                    <?php foreach ($single_salary as $key => $salary) { ?>
                    <form id="form1" action="#" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">

                            <div class="form-group">
                                <label>Date</label>
                                <input id="dob" name="pdate" type="text" value="<?= $salary->pdate ?>" class="form-control">
                                <span class="text-danger"></span>
                            </div>


                            <div class="form-group">
                                <label>Employee Name</label>
                                <select name="employee_id" class="form-control" required>
                                    <option value="<?= $salary->employee_id ?>" selected>
                                        <?= get_name_by_auto_id('f_employee', $salary->employee_id, 'name') ?>
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Total Amount</label>
                                <input name="total" value="<?= $salary->total ?>" type="text" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            
                            <div class="form-group">
                                <label>Duty Time</label>
                                <input name="duty_time" type="text" value="<?= $salary->duty_time ?>" class="form-control">
                                <span class="text-danger"></span>
                            </div>

                            

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" name="add">Edit Confirm</button>
                        </div>
                    </form>
                    <?php } ?>
                </div>

            </div>
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Salary Summery </h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
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
                                        <th>Edit</th>
                                        <th class="text-right"> X </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = $this->db->select('*')->from('f_salary')->where('sts', 1)->where('uid', $_SESSION['id'])->order_by('id', 'desc')->get();
                                        foreach($query->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td><?= ++$key ?></td>
                                        <td><?= $result->pdate ?></td>
										<td><?= get_name_by_auto_id ('f_employee', $result->employee_id, 'name') ?></td>
                                        <td><?= $result->duty_time ?></td>
										<td><?= $result->basic ?></td>
                                        <td><?= $result->house ?></td>
                                        <td><?= $result->health ?></td>
                                        <td><?= $result->convence ?></td>
                                        <td><?= $result->total ?></td>
                                        <td><a href="<?= base_url() ?>fishing/salary_edit/<?= $result->id ?>">Edit</a></td>          
										<td class="mailbox-date pull-right no-print">
											<a href="?did=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i></a>
										</td>
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
