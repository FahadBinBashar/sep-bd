<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
?>
<!DOCTYPE html>
<html >
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('head'); ?>
         <script>
		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

		}
	</script>
    
 
      
          
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
            <i class="fa fa-object-group"></i>উদ্ধৃর্ত্তপত্র হিসাব        
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
                        
                        <h3 class="box-title titlefix">উদ্ধৃর্ত্তপত্র হিসাব</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                                 
                                Cut of Date: <input id="dob2" name="tdate" type="date"  required style="width:250px;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report"> <button onclick="printDiv('printMe')">Print</button>  
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>

<div id='printMe'>
                        <h4><?php
                                if (isset($_POST['tdate']))
                                {   $tdate = $_POST['tdate'];
                                   
                                    $yrdata= strtotime($tdate);
                                    $month =date('M-Y', $yrdata);
                                    $dt=date('d-m-Y', strtotime($_POST['tdate']));
                                    $pldate = new DateTime($dt);
                                    $pldate->modify("last day of previous month");
                                    $previous=$pldate->format("Y-m-d 12:59:59");
                                    $pfdate=new DateTime($dt);
                                    $pfdate->modify('first day of this month');
                                    $firstdt=$pfdate->format("Y-m-01 00:00:00");
    
                                   // $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
                                    //echo $first_date = date("Y-m-d",$first_date_find);
                                    
                                    //$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
                                    //echo $last_date = date("Y-m-d",$last_date_find);
                                     echo "<table class='table'><tr><td align='center' colspan='2'>উদ্ধৃর্ত্তপত্র হিসাব</center></td></tr>";
                                     echo "<tr><td>মাসের নামঃ ".$month."</td><td align='right'>তারিখ ".$dt."</td></tr></table>";
                                } ?>
                        </h4>
                        
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
                                        
                                        $query2 = $this->db->query("SELECT SUM(acc_transaction.Debit) AS Debit, SUM(acc_transaction.Credit) AS Credit FROM acc_transaction WHERE acc_transaction.IsAppove =1 AND VDate <= '".$previous."' AND ledger_id = '$ledger_id' AND IsAppove = '1' ");
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
                                        
                                        $query2 = $this->db->query("SELECT SUM(acc_transaction.Debit) AS Debit, SUM(acc_transaction.Credit) AS Credit FROM acc_transaction WHERE acc_transaction.IsAppove =1 AND VDate BETWEEN '$firstdt' AND '$tdate' AND ledger_id = '$ledger_id' AND IsAppove = '1' ");
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
                                      <?php  $midprofitloss=$TotalCredit-$TotalDebit;
                        if($midprofitloss!=0)
                        {
                        ?>
                        <tr>
                          <td    style="border: 1px solid #ddd; color: white;" align="left">&nbsp;</td>
                          <td  style="border: 1px solid #ddd;" align="left"><strong>Profit-Loss</strong></td>
                         <?php
                        }
                         if($midprofitloss<0)
                         {
                         ?>
                         <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right"><?php 
                            $TotalDebit += $midprofitloss;
                           echo number_format( abs($midprofitloss),2);
                           ?></td>
                          <td    style="border: 1px solid #ddd; color: white;" align="right"><strong><?php
                           echo number_format('0.00',2);?></strong></td>
                        <?php
                         echo "</tr>";
                        }
                        else if($midprofitloss>0)
                        {
                        ?>
                        <td    style="border: 1px solid #ddd;"align="right"><?php 
                           echo number_format('0.00',2);
                           ?></td>
                          <td   bgcolor="red" style="border: 1px solid #ddd; color: white;" align="right"><strong><?php
                          $TotalCredit+= -$midprofitloss;
                           echo number_format(-$midprofitloss,2);?></strong></td>
                         <?php
                         echo "</tr>";
                        }
                        ?><tr>
                                     <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right" colspan="2"></td>
                                    
                                     <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right"><?php echo number_format($TotalDebit,2,'.',','); ?></td>
                                     <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right"><?php echo number_format($TotalCredit,2,'.',','); ?></td></tr>
                                </tbody>
                             
                                
                            </table>
    
    
    
    
    
    
      
    
    
    
                          
 <div class="row">
<div class="col-lg-6">
 <table class="table" >
                              <tbody>   
                                
                                    <tr>
                                        <td align="center"><strong>ক্রম</strong></td>
                                        <td align="left"><strong>মূলধন হিসাব</strong></td>
                                         <td align="right"><strong></strong></td>
                                        <td align="right"><strong>টাকা</strong></td>
                                        
                                    </tr>
                               
                                 
                               
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
                                          
                                          $previousprofitloss=number_format($ProfitLoss,2);
										  $previousprofitloss = str_replace(',', '', $previousprofitloss);
										  $currentprofitloss=number_format(-$midprofitloss,2);
										  $currentprofitloss = str_replace(',', '', $currentprofitloss);
										  $balanceprofitloss=$previousprofitloss+$currentprofitloss;
                                            echo "ক্রমাগত    ".number_format($ProfitLoss,2)."</br>";
                                               
                                               if($currentprofitloss>0)
                                                {
                                                echo "লাভ ".number_format(-$midprofitloss,2)."</br>";
                                                }else if($currentprofitloss<0){
                                                 echo "ক্ষতি ".number_format(-$midprofitloss,2);
                                                 }
                                                
                                    ?>
                                        
                                        
                                       
                                        
                                        </td>
										<td style="border: 1px solid #ddd;" align="right"><? 
										$TotalDebit +=$balanceprofitloss;
                                          
                                            echo number_format($balanceprofitloss,2);
                                                
                                            
                                       
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
                                            
                                            $query2 = $this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate <= '$previous' AND ledger_id LIKE '$ledger_id' AND IsAppove = '1'");
                                         foreach ($query2->result() as $key => $valuee) { 
                                             
                                            echo "ক্রমাগত   ".number_format($valuee->Credit-$valuee->Debit,2)."</br>";
                                          }
                                            
                                          $query9=$this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate BETWEEN '$firstdt' AND '$tdate' AND ledger_id LIKE '$ledger_id' AND IsAppove = '1' ");
                                            foreach ($query9->result() as $key => $valueer) { 
                                                      echo "আদায়  ". $valueer->Credit."</br>";
                                             echo "ফেরত  ".$valueer->Debit;
                                           
                                           
                                            
                                            
                                            }
                                        }
                                       
                                    ?>
                                        
                                        
                                       
                                        
                                        </td>
                                        
                                        
                                        <td style="border: 1px solid #ddd;" align="right"><? 
                                        
                                        $query = $this->db->query("select * from ledger_list where sts='1' AND ledger_bs_cat = '$ledger_bs_cat' ");
                                        foreach ($query->result() as $key => $value) {
                                             $ledger_id=$value->id;
                                            
                                            $query2 = $this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate <= '$tdate' AND ledger_id LIKE '$ledger_id' AND IsAppove = '1'");
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
                                  <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right" colspan="4"><?php echo number_format($TotalDebit,2,'.',','); ?></td>
                               </tr>
                                </tbody>
                                </table>
</div>
<div class="col-lg-6">
 <table  class="table" >
         <tbody>
         <tr>
                                       <td align="center"><strong>ক্রম</strong></td>
                                        <td align="left"><strong>সম্পদ ও পরিসম্পদ</strong></td>
                                         <td align="right"><strong></strong></td>
                                        <td align="right"><strong>টাকা</strong></td>
                                        
                                    </tr>
                                
                                 
                               
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
                                            
                                            $query2 = $this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate <= '$previous' AND ledger_id LIKE '$ledger_id' AND IsAppove = '1'");
                                         foreach ($query2->result() as $key => $valuee) { 
                                             
                                            echo "ক্রমাগত  ".number_format($valuee->Debit-$valuee->Credit,2)."</br>";
                                          }
                                            
                                          $query9=$this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate BETWEEN '$firstdt' AND '$tdate' AND ledger_id LIKE '$ledger_id' AND IsAppove = '1'");
                                            foreach ($query9->result() as $key => $valueer) { 
                                                      echo "আদায়  ". $valueer->Debit."</br>";
                                             echo "ফেরত ".$valueer->Credit;
                                           
                                           
                                            
                                            
                                            }
                                        }
                                       
                                    ?>
                                        
                                        
                                       
                                        
                                        </td>
                                        
                                        <td style="border: 1px solid #ddd;" align="right"><? 
                                        
                                        $query = $this->db->query("select * from ledger_list where sts='1' AND ledger_bs_cat = '$ledger_bs_cat' ");
                                        foreach ($query->result() as $key => $value) {
                                             $ledger_id=$value->id;
                                            
                                            $query2 = $this->db->query("SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, ledger_id FROM acc_transaction WHERE VDate <= '$tdate' AND ledger_id LIKE '$ledger_id' AND IsAppove = '1'");
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
                                  <td   bgcolor="green" style="border: 1px solid #ddd; color: white;" align="right" colspan="4"><?php echo number_format($TotalCredit,2,'.',','); ?></td>
                               </tr>
                                    
                                </tbody>
                                
                            </table>
</div>
</div></div>
    
  
     
  
                            
                            
                            
                             
                                   
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