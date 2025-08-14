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
            <i class="fa fa-object-group"></i>Balance Sheet             
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
                        
                        <h3 class="box-title titlefix">Balance Sheet</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                                 
                                Cut of Date: <input id="dob2" name="tdate" type="date" value="<?php echo date("Y-m-d"); ?>" required style="width:250px;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report">
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>

                        <h3>
                            Report Date : 
                            <?php
                                if (isset($_POST['tdate']))
                                {   $tdate = $_POST['tdate'];
                                    echo "Balance Sheet";
                                    echo " of ";
                                    
                                    echo date('d-m-Y', strtotime($_POST['tdate']));
                                    echo '<br>';
                                    
                                } ?>
                        </h3>
                        <br>   
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover" style="display:none;">
                                
                                <thead>
                                    <tr>
                                        <td width="20%" align="center"><strong>Ledger ID</strong></td>
                                        <td width="50%" align="left"><strong>Ledger Name</strong></td>
                                        <td width="15%" align="right"><strong>Debit</strong></td>
                                        <td width="15%" align="right"><strong>Credit</strong></td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                   
                                    <?php 
                                    $TotalCredit=0;
                                    $TotalDebit=0;
                                    
                                        if (isset($_POST['tdate'])) {                                            
                                       
                                        $tdate = $_POST['tdate'];
                                        $query = $this->db->query("select * from ledger_list where sts='1' AND id != '1' AND id != '2' AND ledger_cat IN ('I','E') ORDER BY ledger_cat DESC");
                                        
                                    foreach ($query->result() as $key => $value) {
                                       
                                       
                                       
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= $ledger_id=$value->id ?></td>
                                        <td style="border: 1px solid #ddd;" align="left"><?= $value->ledger_name ?></td>
                                        <?php
                                        
                                        $query2 = $this->db->query("SELECT SUM(acc_transaction.Debit) AS Debit, SUM(acc_transaction.Credit) AS Credit FROM acc_transaction WHERE acc_transaction.IsAppove =1 AND VDate < '".$tdate."' AND ledger_id = '$ledger_id' ");
                                         foreach ($query2->result() as $key => $valuee) { 
                                           if($valuee->Debit>$valuee->Credit)
                                            {
                                          ?>
                                          <td  style="border: 1px solid #ddd;" align="right"><?php 
                                           echo number_format('0.00',2);
                                           ?></td>
                                          <td  style="border: 1px solid #ddd;" align="right"><?php 
                                            $TotalCredit += $valuee->Debit-$valuee->Credit;
                                           echo number_format($valuee->Debit-$valuee->Credit,2);?></td>
                                           <?php
                                            }
                                            else
                                            {
                                            ?>
                                             
                                           <td  style="border: 1px solid #ddd;" align="right"><?php 
                                            $TotalDebit += $valuee->Credit-$valuee->Debit;
                                           echo number_format($valuee->Credit-$valuee->Debit,2);
                                           ?></td>
                                          <td  style="border: 1px solid #ddd;" align="right"><?php
                                           echo number_format('0.00',2);?></td>
                                           <?php
                                            } }
                                            ?>
                                      
                                        
                                    </tr>
                                    <?php } } ?>
                                      <?php  $ProfitLoss=$TotalCredit-$TotalDebit;
                        if($ProfitLoss!=0)
                        {
                        ?>
                        <tr>
                          <td    style="border: 1px solid #ddd; color: white;" align="left">&nbsp;</td>
                          <td  style="border: 1px solid #ddd;" align="left"><strong>Profit-Loss</strong></td>
                         <?php
                        }
                         if($ProfitLoss<0)
                         {
                         ?>
                         <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right"><?php 
                            $TotalDebit += $ProfitLoss;
                           echo number_format( abs($ProfitLoss),2);
                           ?></td>
                          <td    style="border: 1px solid #ddd; color: white;" align="right"><strong><?php
                           echo number_format('0.00',2);?></strong></td>
                        <?php
                         echo "</tr>";
                        }
                        else if($ProfitLoss>0)
                        {
                        ?>
                        <td    style="border: 1px solid #ddd;"align="right"><?php 
                           echo number_format('0.00',2);
                           ?></td>
                          <td   bgcolor="red" style="border: 1px solid #ddd; color: white;" align="right"><strong><?php
                          $TotalCredit+= -$ProfitLoss;
                           echo number_format(-$ProfitLoss,2);?></strong></td>
                         <?php
                         echo "</tr>";
                        }
                        ?><tr>
                                     <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right" colspan="2"></td>
                                    
                                     <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right"><?php echo number_format($TotalDebit,2,'.',','); ?></td>
                                     <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right"><?php echo number_format($TotalCredit,2,'.',','); ?></td></tr>
                                </tbody>
                             
                                
                            </table>
                            <table class="table table-striped table-bordered table-hover example">
                                
                                <thead>
                                    <tr>
                                        <td align="center"><strong>SL</strong></td>
                                        <td align="left"><strong>Capital & Liabilities</strong></td>
                                        <td align="right"><strong>Taka</strong></td>
                                        
                                    </tr>
                                </thead>
                                 
                                <tbody>
                                    <?php 
                                    $TotalCredit=0;
                                    $TotalDebit=0;
                                    
                                    if (isset($_POST['tdate'])) {                                            
                                       
                                        $tdate = $_POST['tdate'];
                                        $query = $this->db->query("select * from bs_ledger_list where sts='1' AND ledger_cat = 'L'  AND id = '1'");
                                        
                                        $key=1;
                                    foreach ($query->result() as $key => $value) {
                                       $ledger_bs_cat = $value->id;
                                       
                                       
                                    ?>
                                   <tr>    
                                   
                                        <td style="border: 1px solid #ddd;"><?= $key+1 ?></td>
                                        <td style="border: 1px solid #ddd;" align="left"><?=$value->ledger_name ?> </td>
                                        <td style="border: 1px solid #ddd;" align="right"><? 
                                        $TotalDebit +=abs($ProfitLoss);
                                            echo number_format(abs($ProfitLoss),2);
                                           
                                       
                                    ?>
                                        
                                        
                                       
                                        
                                        </td>
                                        
                                        
                                    </tr>
                                     <?php }} ?>
                                    <?php 
                                    
                                    
                                    if (isset($_POST['tdate'])) {                                            
                                       
                                        $tdate = $_POST['tdate'];
                                        $query = $this->db->query("select * from bs_ledger_list where sts='1' AND ledger_cat = 'L'  AND id != '1'");
                                        
                                        $key=1;
                                    foreach ($query->result() as $key => $value) {
                                       $ledger_bs_cat = $value->id;
                                       
                                       
                                    ?>
                                   <tr>    
                                   
                                        <td style="border: 1px solid #ddd;"><?= $key+2 ?></td>
                                        <td style="border: 1px solid #ddd;" align="left"><?= $value->ledger_name ?></td>
                                        <td style="border: 1px solid #ddd;" align="right"><? 
                                        
                                        $query = $this->db->query("select * from ledger_list where sts='1' AND ledger_bs_cat = '$ledger_bs_cat' ");
                                        foreach ($query->result() as $key => $value) {
                                             $ledger_id=$value->id;
                                            
                                            $query2 = $this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate < '$tdate' AND ledger_id LIKE '$ledger_id' ");
                                         foreach ($query2->result() as $key => $valuee) { 
                                           $TotalDebit += $valuee->Credit-$valuee->Debit;
                                            echo number_format($valuee->Credit-$valuee->Debit,2);
                                            
                                            }
                                        }
                                       
                                    ?>
                                        
                                        
                                       
                                        
                                        </td>
                                        
                                        
                                    </tr>
                                     <?php }} ?>
                                     <tr>
                                  <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right" colspan="3"><?php echo number_format($TotalDebit,2,'.',','); ?></td>
                               </tr>
                                </tbody>
                             
                                    <tr>
                                        <td align="center"><strong>SL</strong></td>
                                        <td align="left"><strong>Assets</strong></td>
                                        <td align="right"><strong>Taka</strong></td>
                                        
                                    </tr>
                                
                                 
                                <tbody>
                                    <?php 
                                    $TotalCredit=0;
                                    $TotalDebit=0;
                                    
                                    if (isset($_POST['tdate'])) {                                            
                                       
                                        $tdate = $_POST['tdate'];
                                        $query = $this->db->query("select * from bs_ledger_list where sts='1' AND ledger_cat = 'A' ");
                                        
                                        $key=1;
                                    foreach ($query->result() as $key => $value) {
                                       $ledger_bs_cat = $value->id;
                                       
                                       
                                    ?>
                                   <tr>    
                                   
                                        <td style="border: 1px solid #ddd;"><?= $key+1 ?></td>
                                        <td style="border: 1px solid #ddd;" align="left"><?= $value->ledger_name ?></td>
                                        <td style="border: 1px solid #ddd;" align="right"><? 
                                        
                                        $query = $this->db->query("select * from ledger_list where sts='1' AND ledger_bs_cat = '$ledger_bs_cat' ");
                                        foreach ($query->result() as $key => $value) {
                                             $ledger_id=$value->id;
                                            
                                            $query2 = $this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate < '$tdate' AND ledger_id LIKE '$ledger_id' ");
                                         foreach ($query2->result() as $key => $valuee) { 
                                           $TotalCredit += $valuee->Debit-$valuee->Credit;
                                            echo number_format($valuee->Debit-$valuee->Credit,2);
                                            
                                            }
                                        }
                                       
                                    ?>
                                        
                                        
                                       
                                        
                                        </td>
                                        
                                        
                                    </tr>
                                     <?php }} ?>
                                   <tr>
                                  <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right" colspan="3"><?php echo number_format($TotalCredit,2,'.',','); ?></td>
                               </tr>
                                    
                                </tbody>
                                
                            </table>
                            <!-- /.table -->



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