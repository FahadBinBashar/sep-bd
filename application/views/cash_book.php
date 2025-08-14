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
            <i class="fa fa-object-group"></i>Cash Book Report             
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
                        
                        <h3 class="box-title titlefix">Cash Book Report</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                                 
                                <input id="dob" name="fdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input id="dob2" name="tdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report">
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>

                        <h3>
                            Report Date : 
                            <?php
                                if (isset($_POST['fdate'])) {
                                    $fdate = $_POST['fdate'];
                                    $tdate = $_POST['tdate'];
                                    echo date('d-m-Y', strtotime($_POST['fdate']));
                                    echo " to ";
                                    echo date('d-m-Y', strtotime($_POST['tdate']));
                                    echo " of ";
                                    echo " (".get_name_by_auto_id('ledger_list', 1, 'ledger_name').")";
                                    echo '<br>';                                                               

                                    $total_debit=0;
                                     
                                    $queryta = $this->db->query("select * from acc_transaction where VDate between '$fdate' and '$tdate' and IsAppove = '1' and ledger_id = '1' ");
                                    foreach ($queryta->result() as $valueta) {
                                        
                                        $total_debit = $total_debit+$valueta->Debit;
                                       
                                    }

                                    $total_credit=0;
                                    $querytp = $this->db->query("select * from acc_transaction where VDate between '$fdate' and '$tdate' and IsAppove = '1' and ledger_id = '1' ");
                                    foreach ($querytp->result() as $valuetp) {
                                        $total_credit = $total_credit+$valuetp->Credit;
                                    }

                                    $total_Balance = $total_debit-$total_credit;                                    
                                    
                                     //$oResult=$this->db->query("SELECT * from acc_transaction WHERE VDate < '$fdate' AND ledger_id = '1' AND IsAppove ='1'");
                                     $oResult=$this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate < '$fdate' AND ledger_id LIKE '1' AND IsAppove =1 GROUP BY IsAppove, ledger_id");
                                      $PreBalance=0;
                                    foreach ($oResult->result() as $valuetdp) {
                                    
                                         $PreBalance=$valuetdp->Debit;
                                         $PreBalance=$PreBalance- $valuetdp->Credit;
                                     
                                        }
                                     
                                     
                                     
                                     
                                     
                                     
                                     
                                } 


                            ?>
                        </h3>

                      
                        <br>   


                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                
                                <thead>
                                    <tr>
                                        <td><strong>SL</strong></td>
                                        <td><strong>Date</strong></td>
                                        <td><strong>Voucher No</strong></td>
                                        <td><strong>Voucher Type</strong></td>
                                        <td><strong>Narration</strong></td>
                                        <td align="right"><strong>Debit</strong></td>
                                        <td align="right"><strong>Credit</strong></td>
                                        <td align="left" ><strong>Balance</strong></td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr class="table_data">
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td align="center">&nbsp;</td>
                            <td colspan="3" align="right">Opening balance</td>
                            <td align="left"><?php echo number_format((!empty($PreBalance)?$PreBalance:0),2,'.',','); ?></td>
                            </tr>
                                    <?php 
                                    $TotalCredit=0;
                                    $TotalDebit=0;
                                    
                                        if (isset($_POST['tdate'])) {                                            
                                        $fdate = $_POST['fdate'];
                                        $tdate = $_POST['tdate'];
                                           $query = $this->db->query("select * from acc_transaction where VDate between '$fdate' and '$tdate' and IsAppove = '1' and ledger_id = '1' ORDER BY VDate ASC ");
                                    foreach ($query->result() as $key => $value) {
                                       
                                       
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= ++$key ?></td>                                        
                                        <td style="border: 1px solid #ddd;"><?= $value->VDate ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->VNo ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->Vtype ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->Narration ?></td>
                                        <td style="border: 1px solid #ddd;"><?php 
                                        $TotalDebit += $value->Debit;
                                        $PreBalance += $value->Debit;
                                        
                                        echo number_format($value->Debit,2,'.',',');
                                        
                                        ?></td>
                                        <td style="border: 1px solid #ddd;"><?php 
                                        $TotalCredit += $value->Credit;
                                        $PreBalance -= $value->Credit;
                                        
                                        echo number_format($value->Credit,2,'.',','); 
                                        
                                        ?></td>
                                        <td style="border: 1px solid #ddd;"><?php echo number_format((!empty($PreBalance)?$PreBalance:0),2,'.',','); ?></td>
                                        
                                    </tr>
                                    <?php } } ?>
                                    
                                </tbody>
                             </tfoot>
                            <tr>
                            <th  bgcolor="green">&nbsp;</th>
                            <th   bgcolor="green">&nbsp;</th>
                            <th   bgcolor="green">&nbsp;</th>
                            <th   bgcolor="green">&nbsp;</th>
                            <th  align="right"  bgcolor="green" style="color: white;"><strong>Total</strong></th>
                            <th  align="right"  bgcolor="green" style="color: white;"><?php echo number_format($TotalDebit,2,'.',','); ?></th>
                            <th  align="right"  bgcolor="green" style="color: white;"><?php echo number_format($TotalCredit,2,'.',','); ?></th>
                            <th  align="right"  bgcolor="green" style="color: white;"><?php echo number_format((!empty($PreBalance)?$PreBalance:0),2,'.',','); ?></th>
                            
                            </tr>
                              </tfoot>
                                
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