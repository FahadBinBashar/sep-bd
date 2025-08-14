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
            <i class="fa fa-object-group"></i> Total Collection Report             
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
                        
                        <h3 class="box-title titlefix">Total Collection Report</h3>
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
                                    echo '<br>';                                                               

                                    $total_asol=0;
                                    $queryta = $this->db->query("select * from loan_collection where pdate between '$fdate' and '$tdate' and sts = '1' ");
                                    foreach ($queryta->result() as $valueta) {
                                        $total_asol = $total_asol+$valueta->asol;
                                    }

                                    $total_profit=0;
                                    $querytp = $this->db->query("select * from loan_collection where pdate between '$fdate' and '$tdate' and sts = '1' ");
                                    foreach ($querytp->result() as $valuetp) {
                                        $total_profit = $total_profit+$valuetp->profit;
                                    }

                                    $total_collection = $total_asol+$total_profit;                                    

                                    $total_saving=0;                                                   
                                    $querys = $this->db->query("select * from saving_collection where pdate between '$fdate' and '$tdate' and sts = '1' ");
                                    foreach ($querys->result() as $keys => $values) {
                                        $total_saving = $total_saving+$values->amount_receive;
                                    }
                                    // echo "Total Saving : ".$total_saving;
                                    // echo '<br>';

                                    $total = $total_collection+$total_saving;

                                    // echo "Total Collection : ".$total;
                                    // echo '<br>'; 
                                } 


                            ?>
                        </h3>

                        <table width="500" border="1"> 
                            <tr align="center">
                                <td>Asol Collection</td>
                                <td>Profit Collection</td>
                                <td>Total Loan Collection</td>
                                <td>Saving Collection</td>
                                <td>Total Collection</td>
                            </tr>
                            <tr align="center">
                                <td><?php if(isset($total_asol)){echo $total_asol;} ?></td>
                                <td><?php if(isset($total_profit)){echo $total_profit;} ?></td>
                                <td><?php if(isset($total_collection)){echo $total_collection;} ?></td>
                                <td><?php if(isset($total_saving)){echo $total_saving;} ?></td>
                                <td><?php if(isset($total)){echo $total;} ?></td>
                            </tr>
                        </table>
                        <br>   


                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">LS</th>                                        
                                        <th>Date</th>                                        
                                        <th>Asol Collection</th>
                                        <th>Profit Collection</th>
                                        <th>Total Loan Collection</th>                                        
                                        <th>Saving Collection</th>
                                        <th>Total Collection</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (isset($_POST['tdate'])) {                                            
                                        
                                            $end = $tdate;
                                            $start = $fdate;
                                            $datediff = strtotime($end) - strtotime($start);
                                            $datediff = floor($datediff/(60*60*24));
                                            for($i = 0; $i < $datediff + 1; $i++){
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?php echo $i+1; ?></td>                                        
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                $cdate = date("Y-m-d", strtotime($start . ' + ' . $i . 'day')); 
                                                echo $cdate;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //asol
                                                $total_asol2=0;
                                                $queryta2 = $this->db->select('*')->from('loan_collection')->where('pdate', $cdate)->where('sts', 1)->get();
                                                foreach ($queryta2->result() as $valueta2) {
                                                    $total_asol2 = $total_asol2+$valueta2->asol;
                                                }
                                                echo $total_asol2;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //profit
                                                $total_profit2=0;
                                                $querytp2 = $this->db->select('*')->from('loan_collection')->where('pdate', $cdate)->where('sts', 1)->get();
                                                foreach ($querytp2->result() as $valuetp2) {
                                                    $total_profit2 = $total_profit2+$valuetp2->profit;
                                                }
                                                echo $total_profit2;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //total loan
                                                $total_loan2=0;
                                                $querytl2 = $this->db->select('*')->from('loan_collection')->where('pdate', $cdate)->where('sts', 1)->get();
                                                foreach ($querytl2->result() as $valuetl2) {
                                                    $total_loan2 = $total_loan2+$valuetl2->amount_receive;
                                                }
                                                echo $total_loan2;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //total saving
                                                $total_saving2=0;                                                    
                                                $querys2 = $this->db->select('*')->from('saving_collection')->where('pdate', $cdate)->where('sts', 1)->get();
                                                foreach ($querys2->result() as $keys => $values2) {
                                                    $total_saving2 = $total_saving2+$values2->amount_receive;
                                                }
                                                echo $total_saving2;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //total collection
                                                $total_collection2 = $total_loan2+$total_saving2;
                                                echo $total_collection2;
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <?php } } ?>
                                    
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