<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
    error_reporting(0);
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
            <i class="fa fa-object-group"></i> দৈনিক কালেকশন সিট             
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
                                <input name="rdate" type="date"  class="form-control" required style="width:250px; float:left;">
                                &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Show Report">
                            </div>
                            
                            <div class="col-md-12"><hr></div>
                        </form>

                        <h3>
                            Report Date : 
                            <?php
                                if (isset($_POST['rdate'])) {
                                    $rdate = $_POST['rdate'];
                                    $today = $_POST['rdate'];
                                    $employee_id = $_POST['employee_id'];
                                    echo date('d-m-Y', strtotime($_POST['rdate']));
                                    echo " (".get_name_by_auto_id('employee', $employee_id, 'name').")";
                                    echo '<br>';                                                               

                                    $total_asol=0;
                                    $queryta = $this->db->select('*')->from('loan_collection')->where('employee_id', $employee_id)->where('pdate', $today)->where('sts', 1)->get();
                                    foreach ($queryta->result() as $valueta) {
                                        $total_asol = $total_asol+$valueta->asol;
                                    }

                                    $total_profit=0;
                                    $querytp = $this->db->select('*')->from('loan_collection')->where('employee_id', $employee_id)->where('pdate', $today)->where('sts', 1)->get();
                                    foreach ($querytp->result() as $valuetp) {
                                        $total_profit = $total_profit+$valuetp->profit;
                                    }

                                    $total_collection = $total_asol+$total_profit;                                    

                                    $total_saving=0;
                                    $total_saving_return=0;
                                    $today = $rdate;                                                    
                                    $querys = $this->db->select('*')->from('saving_collection')->where('employee_id', $employee_id)->where('pdate', $today)->where('sts', 1)->get();
                                    foreach ($querys->result() as $keys => $values) {
                                        $total_saving = $total_saving+$values->amount_receive;
                                         $total_saving_return = $total_saving_return+$values->amount_return;
                                         
                                    }
                                    
                                   
                                    $total_h_saving_return=0;
                                    $today = $rdate;                                                    
                                    $querysrh = $this->db->select('*')->from('saving_collection')->where('employee_id', $employee_id)->where('pdate', $today)->where('sts', 1)->where('ctype', 1)->get();
                                    foreach ($querysrh->result() as $keys => $values) {
                                    $total_h_saving_return = $total_h_saving_return+$values->amount_return;
                                         
                                    }
                                    
                                    
                                    
                                    
                                    
                                    $service_ch=0;
                                    $today = $rdate; 
                                    $querysc = $this->db->query("SELECT SUM(Credit) Credit FROM acc_transaction WHERE VDate = '$rdate' AND ledger_id IN (32,40,51,56,55,46,57) AND IsAppove =1 AND CreateBy='$employee_id'");
                                    foreach ($querysc->result() as $valuetdp) {
                                        $service_ch=$service_ch+$valuetdp->Credit;
                                    }
                                    
                                    
                                     //SSP Collection
                                              
                                     $total_ssp=0; 
                                     $total_ssp_return=0;
                                     $querys = $this->db->select('*')->from('diposit_collection')->where('employee_id', $employee_id)->where('pdate', $today)->where('sts', 1)->get();
                                     foreach ($querys->result() as $keys => $values) {
                                     $total_ssp = $total_ssp+$values->amount_receive;
                                     $total_ssp_return = $total_ssp_return+$values->amount_return;
                                     }
                                    
                                    $total_h_ssp_return=0;
                                    $today = $rdate;                                                    
                                    $queryssrh = $this->db->select('*')->from('diposit_collection')->where('employee_id', $employee_id)->where('pdate', $today)->where('sts', 1)->where('ctype', 1)->get();
                                    foreach ($queryssrh->result() as $keys => $values) {
                                    $total_h_ssp_return = $total_h_ssp_return+$values->amount_return;
                                         
                                    }
                                    
                                    
                                    $hand_cash_return=$total_h_saving_return+$total_h_ssp_return;
                                    $total = $total_collection+$total_saving+$total_ssp+$service_ch;
                                    $total_of_cash=$total-$hand_cash_return;
                                    
                                    
                                } 


                            ?>
                        </h3>

                        <table width="auto" border="1"> 
                            <tr align="center">
                                <td>Asol Collection</td>
                                <td>Profit Collection</td>
                                <td>Total Loan Collection</td>
                                <td>Saving Collection</td>
                                <td>SSP Collection</td>
                                <td>Service Charge</td>
                                <td>Total Collection</td>
                                <td>Saving Return</td>
                                <td>SSP Return</td>
                                <td>Office Deposit Cash</td>
                                <td>Action</td>
                                
                            </tr>
                            <tr align="center">
                                <td><?php if(isset($total_asol)){echo $total_asol;} ?></td>
                                <td><?php if(isset($total_profit)){echo $total_profit;} ?></td>
                                <td><?php if(isset($total_collection)){echo $total_collection;} ?></td>
                                <td><?php if(isset($total_saving)){echo $total_saving;} ?></td>
                                <td><?php if(isset($total_ssp)){echo $total_ssp;} ?></td>
                                <td><?php if(isset($service_ch)){echo $service_ch;} ?></td>
                                <td><?php if(isset($total)){echo $total;} ?></td>
                                <td><?php if(isset($total_saving_return)){echo $total_saving_return;} ?></td>
                                <td><?php if(isset($total_ssp_return)){echo $total_ssp_return;} ?></td>
                                <td><?php if(isset($total_of_cash)){echo $total_of_cash;} ?></td>
                                <td><?php if($_SESSION['user_id']==0){?>
                                    <a href="<?= base_url() ?>admin/delete_alll_entry_today/<?= $today?>/<?= $employee_id?>" class="btn btn-danger btn-xs"  data-toggle="tooltip" title="Entry Delete" onclick="return confirm('Are you sure you want to delete Today Enties?');"><i class="fa fa-remove"></i>Delete All</a>
                                    <?php } ?></td>
                            </tr>
                        </table>
                        <br>   


                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">LS</th>                                        
                                        <th>Name</th>                                        
                                        <th>Mobile</th>
                                        <th>Zone</th>
                                        <th>Account ID</th>                                        
                                        <th>Installment</th>
                                        <th>Saving</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (isset($_POST['rdate'])) {
                                            
                                        
                                        $employee_id = $employee_id;
                                        
                                        $query = $this->db->query("select * from account where employee_id = '$employee_id' and pdate <= '$today' AND (cdate>'$today' OR cdate='0000-00-00') order by sl asc");
                                        foreach($query->result() as $key => $result) { 
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= ++$key ?></td>                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->name ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->mobile ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('zone', $result->zone_id, 'name') ?></td>                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php 
                                                //Report Date loan collection 
                                            
                                                $querys = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$today' AND (cdate>'$today' OR cdate='0000-00-00')");
                                                foreach ($querys->result() as $value) {
                                                    $total       = $value->total;
                                                    $installment = $value->installment_amount;
                                                    $loan_id     = $value->id;
                                                    $asol        = $value->installment_asol;
                                                    $profit      = $value->installment_profit;
                                                }

                                                if (isset($installment) && $installment > 0) {
                                                    $collected_amount=0;
                                                    $today = $rdate;                                                    
                                                    $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('pdate', $today)->where('sts', 1)->get();
                                                    foreach ($queryc->result() as $keyc => $valuec) {
                                                        $collected_amount = $valuec->amount_receive;
                                                    }
                                                    echo $collected_amount; 
                                                    $collected_amount=0;
                                                    
                                                } else {
                                                    echo "No Loan";
                                                }
                                                $installment=0;
                                                                                               
                                            ?>     
                                                                                      
                                        </td>

                                        <td style="border: 1px solid #ddd;">       
                                            
                                            <?php
                                                $saving_amount=0;
                                                $today = $rdate;                                                    
                                                $querys = $this->db->select('*')->from('saving_collection')->where('ac_no', $result->id)->where('pdate', $today)->where('sts', 1)->get();
                                                foreach ($querys->result() as $keys => $values) {
                                                    $saving_amount = $values->amount_receive;
                                                }
                                                echo $saving_amount;
                                                
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