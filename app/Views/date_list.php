<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
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
            <i class="fa fa-object-group"></i> Previous Date  List 
            
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
                        <h3 class="box-title titlefix">Date List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th width="50">ID</th>
                                        
                                        <th>Date</th>
                                        <th>employee</th>
                                        <th>status</th>
                                        <th>Delete</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total_diposit = 0;
                                        foreach($results as $key => $result) { 
                                    ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= $result->id ?></td>										
                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->date ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('employee', $result->employee_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;">
											<?php 
                                                //Status 
                                                if ($result->sts=='1') {
                                                    
                                                    ?>
                                                     <a href="<?= base_url() ?>admin/date_reject/<?= $result->id ?>" onclick="return confirm('Approve Confirm?');">
                                                Active
                                            </a>   
                                            <?
                                                } elseif ($result->sts=='0') {
                                                   
                                                    ?>
                                                     <a href="<?= base_url() ?>admin/date_confirm/<?= $result->id ?>" onclick="return confirm('Disable Confirm?');">
                                                Disable
                                            </a>  
                                            
                                            <?
                                                }
                            
                                            ?>     
										</td>
										<td style="border: 1px solid #ddd;">
										<a href="<?= base_url() ?>admin/date_delete/<?= $result->id ?>" onclick="return confirm('Approve Confirm?');"> Delete</a>   
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