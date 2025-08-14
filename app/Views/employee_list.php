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
            <i class="fa fa-object-group"></i> Employee List 
            <?php
                if (isset($_GET['did'])) {
                    $data = array('sts' => 0);
                    $this->db->update( 'employee', $data, ['id' => $_GET['did']] );
                    $this->session->set_flashdata('msg', '<font color=red>Deleted Success!</font>');
                    redirect(base_url('admin/employee_list'));
                }
            ?>
            
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
                        <?php $cnt=0; foreach($results as $result) { ++$cnt; } ?>
                        <h3 class="box-title titlefix">Employee List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="50">Pic</th>
                                        <?php if($_SESSION['user_id']==0){?>
                                        <th>QR</th></th>
                                        <?php }?>
                                        <th>Name</th>                                        
                                        <th>Mobile</th>
                                        <th>Zone</th>
                                        <th>Login Password</th>
                                        <th>Print</th>
                                        <th>Loan AC List</th>
                                        <th>SSP AC List</th>
                                                                               
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($results as $key => $result) { ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= ++$key ?></td>
										<td style="border: 1px solid #ddd;">
                                            <img src="<?php echo base_url(); ?>img/<?= $result->pic ?>" style="width:40px; height:40px; border-radius:40px;">
                                        </td>
                                        <?php if($_SESSION['user_id']==0){?>
                                        <td style="border: 1px solid #ddd;">
                                            <a href="<?= base_url("admin/qr_print/{$result->id}?per_page=10") ?>" target="_blank" class="btn btn-primary btn-xs">
                                                QR Print
                                            </a>
                                        </td>
                                        <?php } ?>
                                        <td style="border: 1px solid #ddd;"><?= $result->name ?></td>
                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->mobile ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('zone', $result->zone_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->pass ?></td>
                                        <!-- <td style="border: 1px solid #ddd;"><?= $result->address ?></td> -->
                                        <td style="border: 1px solid #ddd;">
                                             <a href="<?= base_url() ?>admin/print_balance/<?= $result->id ?>" target="_blank">Balance Print</a>
                                             <form action="<?php echo base_url();?>admin/custom_print_balance/" method="post" target="_blank">
                                                       <input type="hidden" name="id" value="<?= $result->id ?>"id="id">
                                                       <input type="date" name="sdate" id="sdate" required>
                                                       <input type="Submit" id='Search' value="Search">
                                              </form>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <a href="<?= base_url() ?>admin/account_employee?employee_id=<?= $result->id ?>" target="_blank">Loan AC List
                                        </td>
                                         <td style="border: 1px solid #ddd;">
                                            <a href="<?= base_url() ?>admin/ssp_account?employee_id=<?= $result->id ?>" target="_blank">SSP AC List
                                        </td>
                                        
										
										<td class="text-right" style="border: 1px solid #ddd;">
										    <?php if($_SESSION['user_id']==0){?>
											<a href="<?php echo base_url(); ?>admin/employee_edit?id=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
											
											<a href="?did=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i></a>
											<?php }?>
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