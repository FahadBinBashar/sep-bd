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
				<?php $this->load->view('admin/header'); ?>
			</header>
            <?php $this->load->view('admin/menu_left'); ?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-object-group"></i> Student List 
            <?php
                if (isset($_GET['sid'])) {
                    $this->db->where("id", $_GET['sid'])->delete("student");
                    echo "<font color='red'>Deleted Success!</font>";
                    $msg = '';
                }
            ?>
			<?php if(isset($msg)){echo $msg;} ?>
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
                        <?php $sl=0; foreach($results as $result) { ++$sl; } ?>
                        <h3 class="box-title titlefix">Student List (<?php echo $sl; ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>BMDC No.</th>
                                        <th>Name</th>
                                        
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Medical College</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl=0; foreach($results as $result) { ?>
									<tr>                                               
										<td><?php echo ++$sl; ?></td>
										<td><?php echo $result->student_id; ?></td>
                                        <td><?php echo $result->name; ?></td>
                                        
                                        <td><?php echo $result->mobile; ?></td>
                                        <td><?php echo $result->email; ?></td>
                                        <td><?php echo $result->pass; ?></td>
                                        <td><?= get_name_by_auto_id( 'medical_college', $result->college_id, 'name' ) ?></td>
										
										<td class="mailbox-date pull-right no-print">
											<a href="<?php echo base_url(); ?>admin/student_edit?id=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
											<a href="?sid=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i></a>
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

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = 'mm/dd/yyyy';

        $('#date').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

    });
</script>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>
	
	
<?php include 'f9.php'; ?>

</body>
</html>
<?php
    } else {
        //redirect('http://ok.com');
        echo "<a href='admin'>Please Login First</a>";
    }
?>