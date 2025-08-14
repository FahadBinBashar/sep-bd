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
            <i class="fa fa-object-group"></i> SSP Returned List 
            
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
                        <?php 
                            $cnt=0; 
                            $query = $this->db->query("select * from diposit_collection where amount_return > '0' and sts != '2' ");
                            foreach($query->result() as $value) {
                                $cnt = $cnt+1;
                            }
                        ?>
                        <h3 class="box-title titlefix">Return List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Account Name</th>                                        
                                        <th>Mobile</th>
                                        <th>Account ID</th>
                                        <th>Employee Name</th>
                                        <th>Current Balance</th>
                                        <th>Amount</th>  
                                        <th>Status</th> 
                                        <th>View</th>
                                        
                                                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total_saving = 0;
                                        $total_return = 0;
                                        $balance      = 0;
                                        foreach($query->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= ++$key ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->pdate ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('account_diposit', $result->ac_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('account_diposit', $result->ac_id, 'mobile') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->ac_id ?></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?= get_name_by_auto_id ('employee', $result->employee_id, 'name') ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //total saving 
                                                $querys = $this->db->select('*')->from('diposit_collection')->where('ac_id', $result->ac_id)->where('sts', 1)->get();
                                                foreach ($querys->result() as $values) {
                                                    $total_saving = $total_saving+$values->amount_receive;
                                                }
                                                $total_saving;

                                                //total return 
                                                $queryr = $this->db->select('*')->from('diposit_collection')->where('ac_id', $result->ac_id)->where('sts', 1)->get();
                                                foreach ($querys->result() as $values) {
                                                    $total_return = $total_return+$values->amount_return;
                                                }
                                                $total_return;

                                                $balance = $total_saving-$total_return;
                                                echo $balance;
                                                $balance = 0;
                                                $total_saving = 0;
                                                $total_return = 0;
                                                
                                            ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;"><font color="red"><?= $result->amount_return ?></font></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //Status 
                                                if ($result->sts=='1') {
                                                    echo "<font color=green>Approved</font>";
                                                } elseif ($result->sts=='2') {
                                                    echo "<font color=red>Pending</font>";
                                                } elseif ($result->sts=='3') {
                                                    echo "<font color=red>Reject</font>";
                                                }
                            
                                            ?>                                                
                                        </td>

                                        <td style="border: 1px solid #ddd;">
                                            <a href="<?= base_url() ?>admin/account_ssp_details/<?= $result->ac_id ?>" target="_blank">View</a>
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