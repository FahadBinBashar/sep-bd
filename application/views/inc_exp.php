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
            <i class="fa fa-object-group"></i>আয়/ব্যয় হিসাব             
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
                        
                        <h3 class="box-title titlefix">আয়/ব্যয় হিসাব</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                                 
                                <input id="dob" name="fdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input id="dob2" name="tdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report"> <button onclick="printDiv('printMe')">Print</button>  
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>
<div id='printMe'>
                        <h4>
                            <?php
                                if (isset($_POST['fdate']))
                                {
                                    $fdate = $_POST['fdate'];
                                    $tdate = $_POST['tdate'];
                                    $yrdata= strtotime($tdate);
                                    $month =date('M-Y', $yrdata);
                                    $dt=date('d-m-Y', strtotime($_POST['tdate']));
                                    
                                   echo "<table class='table'><tr><td align='center' colspan='2'>আয়/ব্যয় হিসাব</center></td></tr>";
                                     echo "<tr><td>মাসের নামঃ ".$month."</td><td align='right'>তারিখ ".$dt."</td></tr></table>";
                                    
                                } ?>
                        </h4>
                        <br>   
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
                                
                                <thead>
                                    <tr>
                                        <td width="20%"><strong>ক্রমিক</strong></td>
                                        <td width="50%" align="left"><strong>প্রাপ্তি/প্রদান খাতের বিবরণ</strong></td>
                                        <td width="15%" align="right"><strong>ডেবিট টাকা</strong></td>
                                        <td width="15%" align="right"><strong>ক্রেডিট টাকা</strong></td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                   
                                    <?php 
                                    $TotalCredit=0;
                                    $TotalDebit=0;
                                     $key=1;
                                        if (isset($_POST['fdate'])) {                                            
                                        $fdate = $_POST['fdate'];
                                        $tdate = $_POST['tdate'];
                                        $query = $this->db->query("select * from ledger_list where sts='1' AND id != '1' AND id != '2' AND ledger_cat IN ('I','E') ORDER BY ledger_cat DESC");
                                        //$query = $this
                                                   //  ->db
                                                    // ->select('*')
                                                     //->from('ledger_list')
                                                    // ->where('id !=', '1')->where('id !=', '2')->where('ledger_cat', 'I')->where('ledger_cat', 'E')->where('sts', 1)
                                                    // ->get();
                                                    
                                    foreach ($query->result() as $key => $value) {
                                       $ledger_id=$value->id;
                                       
                                       
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= $key+1 ?></td>
                                        <td style="border: 1px solid #ddd;" align="left"><?= $value->ledger_name ?></td>
                                        <?php
                                        
                                        $query2 = $this->db->query("SELECT SUM(acc_transaction.Debit) AS Debit, SUM(acc_transaction.Credit) AS Credit FROM acc_transaction WHERE acc_transaction.IsAppove =1 AND VDate BETWEEN '".$fdate."' AND '".$tdate."' AND ledger_id = '$ledger_id' ");
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
                          <td  style="border: 1px solid #ddd;" align="left"><strong>নিট লাভ /ক্ষতি </strong></td>
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
                             
                                
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                        </div>
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