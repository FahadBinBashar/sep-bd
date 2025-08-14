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
            <i class="fa fa-object-group"></i>এসএসপি হিসাব            
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
                        
                        <h3 class="box-title titlefix">এসএসপি হিসাব </h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                                  <select name="employee_id" required class="form-control" style="width:250px; float:left;">
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                        $query = $this->db->query("select * from employee where sts = '1' and status = 'u' ");
                                        foreach ($query->result() as $key => $value) {
                                            echo "<option value='$value->id'>$value->name</option>";
                                        }
                                    ?>
                                </select>
                                  &nbsp;&nbsp;
                                <input name="fdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input name="tdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report">
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>

                        <h4>
                            
                            <?php
                                if (isset($_POST['fdate']))
                                {
                                    $fdate = $_POST['fdate'];
                                    $tdate = $_POST['tdate'];
                                   $yrdata= strtotime($tdate);
                                    $month =date('M-Y', $yrdata);
                                    $dt=date('d-m-Y', strtotime($_POST['tdate']));
                                    $emp_id=$_POST['employee_id'];
                                    
                                   echo "<table class='table table-striped table-bordered table-hover example'><tr><td align='center' colspan='2'><b>এসএসপি হিসাব</b></center></td></tr>";
                                   echo "<tr><td align='center' colspan='2'>".get_name_by_auto_id('employee', $emp_id, 'name')."</center></td></tr>";

                                     echo "<tr><td>মাসের নামঃ ".$month."</td><td align='right'>তারিখ ".$dt."</td></tr></table>";
                                    
                                 } ?>
                        </h4>
                        <br>   
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
                                
                                <thead>
                                    <tr>
                                         <td><strong>ক্রমিক</strong></td>
                                         <td ><strong>সদস্যদের আইডি</strong></td>
                                        <td ><strong>সদস্যদের নাম</strong></td>
                                        <td ><strong>পূর্বের স্থিতি</strong></td>
                                        <td ><strong>আদায়</strong></td>
                                        <td ><strong>উত্তোলন</strong></td>
                                        <td ><strong>বর্তমান স্থিতি</strong></td>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                   
                                    <?php 
                                    
                                    $key=1;
                                        if (isset($_POST['fdate'])) {                                            
                                        $fdate = $_POST['fdate'];
                                        $tdate = $_POST['tdate'];
                                        $emp_id=$_POST['employee_id'];
                                          $total_now_balance=0;
                                          $total_tamount_return=0;
                                          $total_tamount_receive=0;
                                          $total_t_balance=0;
                                        $query = $this->db->query("select * from account_diposit where sts='1' and employee_id='$emp_id' ");
                                    foreach ($query->result() as $key => $value) {
                                       $member_id=$value->id;
                                       
                                    $total_amount_receive=0;
                                    $total_amount_return=0;
                                    $queryta = $this->db->query("select * from diposit_collection where pdate between '0000-00-00' and '$fdate' and sts = '1' and ac_id = '$member_id' ");
                                    foreach ($queryta->result() as $valueta) {
                                        $total_amount_receive = $total_amount_receive+$valueta->amount_receive;
                                        $total_amount_return = $total_amount_return+$valueta->amount_return;
                                    }

                                   $total_balance = $total_amount_receive-$total_amount_return; 
                                   $amount_receive=0;
                                   $amount_return=0;
                                   
                                   
                                   $query2 = $this->db->query("select * from diposit_collection where pdate between '$fdate' and '$tdate' and sts = '1' and ac_id = '$member_id' ");
                                    foreach ($query2->result() as $valuetaa) {
                                        $amount_receive = $amount_receive+$valuetaa->amount_receive;
                                        $amount_return = $amount_return+$valuetaa->amount_return;
                                    } 
                                      
                                   $now_amount_receive=0;
                                    $now_amount_return=0;
                                      
                                    $querytanow = $this->db->query("select * from diposit_collection where pdate between '0000-00-00' and '$tdate' and sts = '1' and ac_id = '$member_id' ");
                                    foreach ($querytanow->result() as $valuetanow) {
                                        $now_amount_receive = $now_amount_receive+$valuetanow->amount_receive;
                                        $now_amount_return = $now_amount_return+$valuetanow->amount_return;
                                    }

                                   $now_balance = $now_amount_receive-$now_amount_return;    
                                      
                                      
                                       
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= $key+1; ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->id ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->name ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $total_balance ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $amount_receive ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $amount_return ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $now_balance ?></td>
                                  </tr>  
                                    <?php 
                                    
                                    
                                    $total_t_balance=$total_t_balance+$total_balance;
                                    $total_tamount_receive=$total_tamount_receive+$amount_receive;
                                    $total_tamount_return=$total_tamount_return+$amount_return;
                                    $total_now_balance=$total_now_balance+$now_balance;
                                    
                                    
                                    
                                    } 
                                        
                                        
                                        
                                        } ?>
                                     
                                     
                                </tbody>
                            	 <tr>                                               
                                        
                                        <td colspan="3"><b>Grand Total</b></td>
                                        <td style="border: 1px solid #ddd;"><b><?= $total_t_balance ?></b></td>
                                        <td style="border: 1px solid #ddd;"><b><?= $total_tamount_receive ?></b></td>
                                        <td style="border: 1px solid #ddd;"><b><?= $total_tamount_return ?></b></td>
                                        <td style="border: 1px solid #ddd;"><b><?= $total_now_balance ?></b></td>
                                  </tr>
                                
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