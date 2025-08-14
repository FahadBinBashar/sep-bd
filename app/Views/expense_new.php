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
            <i class="fa fa-object-group"></i> New Expense 
			<?php
                if (isset($_POST['add'])) { 
                   
                    $data = array(
                        'category_id'  => $this->input->post('category_id', true),
                        'amount'       => $this->input->post('amount', true),
                        'details'      => $this->input->post('details', true),
                        'sts'          => 1,
                        'uid'          => $_SESSION['id'],
                        'pdate'        => $this->input->post('pdate', true)
                    );
                    $this->db->insert('expense', $data);

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/expense_new'));
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
                        <h3 class="box-title">Add New Expense</h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="#" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">

                            <div class="form-group">
                                <label>Date</label>
                                <input id="dob" name="pdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control">
                                <span class="text-danger"></span>
                            </div>


                            <div class="form-group">
                                <label>Expense Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                        foreach ($category_list as $category) {
                                            echo "<option value='$category->id'>$category->name</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Amount</label>
                                <input name="amount" type="text" class="form-control">
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label>Details</label>
                                <input name="details" type="text" class="form-control">
                                <span class="text-danger"></span>
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" name="add">Save</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Expense Summery </h3>
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
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Details</th>
                                        
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = $this->db->select('*')->from('expense')->where('sts', 1)->order_by('id', 'desc')->get();
                                        foreach($query->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td><?= ++$key ?></td>
                                        <td><?= $result->pdate ?></td>
										<td><?= get_name_by_auto_id ('expense_cat', $result->category_id, 'name') ?></td>
                                        
										<td><?= $result->amount ?></td>
                                        <td><?= $result->details ?></td>
                                        
										<td class="mailbox-date pull-right no-print">
											<a href="#" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i></a>
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
