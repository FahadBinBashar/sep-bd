<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (isset($_SESSION['user_id']) && isset($_SESSION['pass']) && ($_SESSION['status'] == 'a' || $_SESSION['status'] == 'u')) { ?>
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
            <i class="fa fa-object-group"></i> Loan List 
            
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
                        
                        <h3 class="box-title titlefix">Loan List</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover" id="posts">
                                <thead>
                                        
                                        <th>Loan ID</th>
                                        <th>Member Name</th>
                                        <th>Member ID</th>
                                        <th>Installment Qnt</th>
                                        <th>Total Loan</th>
                                        <th>Collected Amount</th>
                                        <th>Due Amount</th>
                                        <th>Load Start Date</th>
                                        <th>Loan End Date</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                     	
                                    
                                </thead>
                                
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

<script>
    $(document).ready(function () {
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
		     "url": "<?php echo base_url('admin/fatchLoanData') ?>",
		     "dataType": "json",
		     "type": "POST",
		     "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
		                   },
	    "columns": [
	              
		          { "data": "id" },
		          { "data": "name" },
		          { "data": "ac_no" },
		          { "data": "installment_qnt", "visible":false },
		          { "data": "total" },
		          { "data": "collected","visible":false},
		          { "data": "due", "visible":false },
		          { "data": "loan_date" },
		          { "data": "last_date" },
		          { "data": "link","visible":false },
		          { "data": "action","visible":false },
		         
		       ]	 

	    });
    });
</script>
<script type="text/javascript">
    function confirmClose() {
        return confirm('Are you sure you want to close this Loan?');
    }
</script>
<?php $this->load->view('f9'); ?>

</body>
</html>
<?php } else {redirect('admin');
    echo "<center><div style='margin-top:50px; padding:20px; border-radius:10px; width:150px; background-color:pink;'>";
    echo "<a href='" . base_url() . "admin'>Please Login First</a>";
    echo "</div></center>";}
?>
