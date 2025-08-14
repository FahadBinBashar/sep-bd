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
            <i class="fa fa-object-group"></i> Update SL 




            <?php
                if (isset($_GET['did'])) {
                    $data = array('sts' => 0);
                    $this->db->update( 'account', $data, ['id' => $_GET['did']] );
                    $this->session->set_flashdata('msg', '<font color=red>Update Success!</font>');
                   
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
                        <h3 class="box-title titlefix">Update SL (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <form action="<?= base_url() ?>admin/account_sl_update" method="post">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th width="50">SL</th>
                                        <th>Loan Status</th>
                                        <th>Name</th>                                        
                                        <th>Zone</th>
                                        <th>Account No.</th>
                                        <th>Saving</th>
                                        <th>Return</th>  
                                        <th>Balance</th> 
                                        
                                        </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total_saving = 0;
                                        $total_return = 0;
                                        $balance      = 0;
                                        foreach($results as $key => $result) { 
                                    ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;">
                                            <input type="text" name="sl[]" value="<?= $result->sl ?>">
                                            <input type="hidden" name="id[]" value="<?= $result->id ?>">   
                                            <input type="hidden" name="ss[]" value="1">  
                                        </td>
                                         <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //Loan Status 
                                                $loan_status='';
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts', 1)->get();
                                                foreach ($query->result() as $values) {
                                                    $loan_status = 1;
                                                }

                                                if (isset($loan_status) && $loan_status > 0) {
                                                    echo "<font color=red>Yes</font>";
                                                } else {
                                                    echo "No";
                                                }
                                                
                                                
                                            ?>                                                
                                        </td>
										<td style="border: 1px solid #ddd;"><?= $result->name ?></td>
										
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('zone', $result->zone_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //total saving 
                                                $querys = $this->db->select('*')->from('saving_collection')->where('ac_id', $result->id)->get();
                                                foreach ($querys->result() as $values) {
                                                    $total_saving = $total_saving+$values->amount_receive;
                                                     $total_return = $total_return+$values->amount_return;
                                                }
                                                echo $total_saving;
                                                
                                            ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //total return 
                                                // $queryr = $this->db->select('*')->from('saving_collection')->where('ac_id', $result->id)->get();
                                                // foreach ($querys->result() as $values) {
                                                //     $total_return = $total_return+$values->amount_return;
                                                // }
                                                echo $total_return;
                                                
                                            ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //balance 
                                                $balance = $total_saving-$total_return;
                                                echo $balance;
                                                $balance = 0;
                                                $total_saving = 0;
                                                $total_return = 0;
                                            ?>                                                
                                        </td>

                                       

                                        
									</tr>
									<?php } ?>

                                </tbody>
                            </table><!-- /.table -->
                            <input type="submit" name="submit" value="Update All" onclick="return confirm('Submit Confirm?');">
                            </form>


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