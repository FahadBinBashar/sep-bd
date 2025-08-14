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
            <i class="fa fa-object-group"></i>Emp Total SSP Report             
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
                        
                        <h3 class="box-title titlefix">Emp Total SSP Report</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="" method="post">

                            <div class="col-md-12">
                                <?php if ($_SESSION['status']=='u') { ?>
                  
                    
                                 <select name="employee_id" required class="form-control" style="width:250px; float:left;">
                                    <option value="<?=$_SESSION['user_id']?>" selected><?= get_name_by_auto_id('employee', $_SESSION['user_id'], 'name')?></option>
                                    
                                </select>
                                <?php }else{ ?>
                                <select name="employee_id" required class="form-control" style="width:250px; float:left;">
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                        $query = $this->db->query("select * from employee where sts = '1' ");
                                        foreach ($query->result() as $key => $value) {
                                            echo "<option value='$value->id'>$value->name</option>";
                                        }
                                    ?>
                                </select>
                                 <?php } ?>
                                  &nbsp;&nbsp;
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
                                    $emp_id=$_POST['employee_id'];
                                    
                                    echo date('d-m-Y', strtotime($_POST['fdate']));
                                    echo " to ";
                                    echo date('d-m-Y', strtotime($_POST['tdate']));
                                    echo " of ";
                                    echo " (".get_name_by_auto_id('employee', $emp_id, 'name').")";
                                    echo '<br>';                                                               

                                    $total_amount_receive=0;
                                    $queryta = $this->db->query("select * from diposit_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id = '$emp_id' ");
                                    foreach ($queryta->result() as $valueta) {
                                        $total_amount_receive = $total_amount_receive+$valueta->amount_receive;
                                    }

                                    $total_amount_return=0;
                                    $querytp = $this->db->query("select * from diposit_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id = '$emp_id' ");
                                    foreach ($querytp->result() as $valuetp) {
                                        $total_amount_return = $total_amount_return+$valuetp->amount_return;
                                    }

                                    $total_balance = $total_amount_receive-$total_amount_return;                                    

                                    
                                    
                                } 


                            ?>
                        </h3>

                        <table width="500" border="1"> 
                            <tr align="center">
                                <td>SSP Collection</td>
                                <td>SSP Return</td>
                                <td>Total balance</td>
                                
                            </tr>
                            <tr align="center">
                                <td><?php if(isset($total_amount_receive)){echo $total_amount_receive;} ?></td>
                                <td><?php if(isset($total_amount_return)){echo $total_amount_return;} ?></td>
                                <td><?php if(isset($total_balance)){echo $total_balance;} ?></td>
                                
                            </tr>
                        </table>
                        <br>   


                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                                                     
                                        <th>Date</th>                                        
                                        <th>Name</th>
                                        <th>SSP Collection</th>
                                        <th>SSP Return</th>                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (isset($_POST['tdate'])) {                                            
                                        
                                            $end = $tdate;
                                            $start = $fdate;
                                            $emp_id=$_POST['employee_id'];
                                            $queryta2 = $this->db->query("select * from diposit_collection where pdate between '$fdate' and '$tdate' and sts = '1' and employee_id = '$emp_id' ");
                                                foreach ($queryta2->result() as $valueta2) {
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;">
                                            <?= $valueta2->pdate;?>
                                        </td>
                                         <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id('account_diposit', $valueta2->ac_id, 'name')?></td>  
                                        <td style="border: 1px solid #ddd;">
                                             <?= $valueta2->amount_receive;?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?= $valueta2->amount_return;?>
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