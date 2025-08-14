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
            <i class="fa fa-object-group"></i> সমন্বয় রিপোর্ট             
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
                    <!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                               <input id="dob" name="fdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input id="dob2" name="tdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report">
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>

                        <h3>
                            Report Date : 
                            <?php
                            $total_sc=0;
                            $total_fasol=0;
                                        $total_fprofit=0;
                                        $total_flt=0;
                                         $total_fsv=0;
                                         $total_ftsvl=0;
                                         $total_fsr=0;
                                             $total_lp=0;
                                         $total_tssp=0;
                                         $total_tsspr=0;
                                         $total_cash_d=0;
                                if (isset($_POST['fdate'])) {
                                    $fdate = $_POST['fdate'];
                                    $tdate = $_POST['tdate'];

                                    echo date('d-m-Y', strtotime($_POST['fdate']));
                                    echo " to ";
                                    echo date('d-m-Y', strtotime($_POST['tdate']));
                                    echo '<br>'; }
                            ?>
                        </h3>

                          


                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">SL</th>  
                                        <th>Employee</th>
                                        <th nowrap>Loan Disburse</th>
                                        <th nowrap>Service Charge</th>
                                        <th nowrap>Principle Amount</th>
                                        <th>Profit</th>
                                        <th>Saving</th>
                                        <th nowrap>SSP Collection</th>
                                        <th>Share</th>
                                        <th nowrap>Others Cr.</th>
                                        <th nowrap>Total Collection</th>
                                        <th nowrap>Saving Return</th>
                                        <th nowrap>SSP Return</th>
                                        <th nowrap>Others Dr.</th>
                                        <th nowrap>Office Deposit Cash</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (isset($_POST['fdate'])) {                                            
                                        $total_fasol=0;
                                        $total_fprofit=0;
                                        $total_sc=0;
                                         $total_fsv=0;
                                         $total_ftsvl=0;
                                         $total_fsr=0;
                                         $total_lp=0;
                                         $total_tssp=0;
                                         $total_tsspr=0;
                                         $total_cash_d=0;
                                          foreach($results as $key => $result) { 
                                              $empid=$result->id;
                                            ?>
                                        <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?php echo $key+1; ?></td> 
                                          <td style="border: 1px solid #ddd;">
                                           
                                            <?= $result->name ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //Loan Payment 
                                                $total_loan_payment=0; 
                                                
                                                    $querys = $this->db->query("select * from account_loan where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id='$empid'");
                                                    foreach ($querys->result() as $keys => $values) {
                                                       
                                                        $total_loan_payment = $total_loan_payment+$values->loan_amount;
                                                    }echo $total_loan_payment; $total_lp+=$total_loan_payment;
                                            ?> 
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                        <? $service_ch=0;
                                           $querysc = $this->db->query("SELECT SUM(Credit) Credit FROM acc_transaction WHERE VDate between '$fdate' and '$tdate' AND ledger_id IN (32,40,51,56,55,46,57) AND IsAppove =1 AND CreateBy='$empid'");
                                            foreach ($querysc->result() as $valuetdp) {
                                                echo $service_ch=$service_ch+$valuetdp->Credit;
                                                
                                            }$total_sc +=$service_ch;
                                         ?>
                                          </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                $total_asol=0;
                                                $queryta = $this->db->query("select * from loan_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id='$empid'");
                                                foreach ($queryta->result() as $valueta) {
                                                     $total_asol = $total_asol+$valueta->asol;
                                                }echo $total_asol;
                                                $total_fasol+=$total_asol;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //profit
                                                $total_profit=0;
                                                $querytp = $this->db->query("select * from loan_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id='$empid'");
                                                foreach ($querytp->result() as $valuetp) {
                                                    $total_profit = $total_profit+$valuetp->profit;
                                                }echo $total_profit; $total_fprofit+=$total_profit;
                                            ?><? $total_loan_collection = $total_asol+$total_profit; ?>
                                        </td>
                                        
                                        
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //total saving
                                                $total_saving=0; 
                                                $total_saving_return=0;
                                                    $querys = $this->db->query("select * from saving_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id='$empid'");
                                                    foreach ($querys->result() as $keys => $values) {
                                                        $total_saving = $total_saving+$values->amount_receive;
                                                        $total_saving_return = $total_saving_return+$values->amount_return;
                                                    }echo $total_saving; $total_fsv+=$total_saving;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //SSP Collection
                                              
                                                $total_ssp=0; 
                                                $total_ssp_return=0;
                                                    $querys = $this->db->query("select * from diposit_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id='$empid'");
                                                    foreach ($querys->result() as $keys => $values) {
                                                        $total_ssp = $total_ssp+$values->amount_receive;
                                                        $total_ssp_return = $total_ssp_return+$values->amount_return;
                                                    }echo $total_ssp; $total_tssp+=$total_ssp;
                                           
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            
                                        </td>
                                        
                                        <td style="border: 1px solid #ddd;">
                                           <?= $total_ls_collection = $total_loan_collection+$total_saving+$total_ssp+$service_ch ?>
                                           <?php $total_ftsvl+=$total_ls_collection;?>
                                        </td>
                                       
                                        
                                        <td style="border: 1px solid #ddd;">
                                              <?php
                                                echo $total_saving_return;
                                                $total_fsr+=$total_saving_return;
                                                
                                                 $total_h_saving_return=0;
                                                 $querysrh = $this->db->query("select * from saving_collection where pdate between '$fdate' and '$tdate' and ctype = '1' and sts = '1' and employee_id='$empid'");
                                                 foreach ($querysrh->result() as $keys => $values) {
                                                 $total_h_saving_return = $total_h_saving_return+$values->amount_return;
                                                     
                                                 }
                                            ?>
                                        </td>
                                        
                                        
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //SSP Return
                                                
                                                echo $total_ssp_return;
                                                $total_tsspr+=$total_ssp_return;
                                                
                                                 $total_h_ssp_return=0;
                                                                                             
                                                $queryssrh =  $this->db->query("select * from diposit_collection where pdate between '$fdate' and '$tdate' and ctype = '1' and sts = '1' and employee_id='$empid'");
                                                foreach ($queryssrh->result() as $keys => $values) {
                                                $total_h_ssp_return = $total_h_ssp_return+$values->amount_return;
                                                }
                                            ?>
                                            
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            
                                        </td>
                                         <td style="border: 1px solid #ddd;">
                                            <?php
                                                //Total cash deposit
                                                
                                                $hand_cash_return=$total_h_saving_return+$total_h_ssp_return;
                                                
                                                echo $total_of_cash=$total_ls_collection-$hand_cash_return;
                                                $total_cash_d+=$total_of_cash;
                                            ?>
                                            
                                        </td>
                                        
                                    </tr>
                                    <?php } } ?>
                                       <tr>
                                        <th width="50">SL</th>  
                                        <th><b>Total</b></th>
                                        <th><b><?= $total_lp?></b></th>
                                        <th><b><?=$total_sc?></b></th>
                                        <th><b><?= $total_fasol?></b></th>
                                        <th><b><?= $total_fprofit?></b></th>
                                           
                                        <th><b><?= $total_fsv?></b></th>
                                        <th><b><?=$total_tssp?></b></th>
                                        <th></th>
                                        <th></th>
                                        
                                        <th><b><?=$total_ftsvl?></th>
                                        
                                        <th><b><?=$total_fsr ?></th>
                                        <th><b><?= $total_tsspr?></th>
                                        <th></th>
                                        <th><b><?= $total_cash_d?></th>
                                    </tr>
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