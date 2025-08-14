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
            <i class="fa fa-object-group"></i> Today's Collection (<?= date('d-m-Y') ?>)            

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
                        <h3 class="box-title titlefix">Today's Collection (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <form action="<?= base_url() ?>admin/collection_confirm" id="form" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="cart">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="40">LS</th>                                        
                                        <th width="120">Name</th>                                        
                                        <th width="70">Install. Qnt</th>
                                        <th width="260">Installment</th>
                                        <th>Saving</th>                                                              
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($results as $key => $result) { 
                                            // $today = date('Y-m-d');                                                    
                                            // $querys = $this->db->select('*')->from('saving_collection')->where('ac_no', $result->id)->where('pdate', $today)->where('sts', 1)->get();
                                            // $total_row = $querys->num_rows();
                                            // if ( $total_row == 0 ) {
                                            
                                            
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= ++$key ?></td>                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->name ?></td>
                                        <!-- <td style="border: 1px solid #ddd;"><?= $result->mobile ?></td> -->
                                        <!-- <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('zone', $result->zone_id, 'name') ?></td>                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td> -->
                                        
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                $installment_qnt=0;
                                                $loan_id='';
                                                $queryq = $this->db->select('*')->from('account_loan')->where('ac_no', $result->id)->where('sts', 1)->get();
                                                foreach ($queryq->result() as $valueq) {
                                                    $loan_id = $valueq->id;
                                                    echo $installment_qnt = $valueq->installment_qnt;
                                                    echo "/";
                                                }
                                                
                                                $cnt = 0;
                                                $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                foreach ($queryc->result() as $valuec) {
                                                    $cnt = $cnt+$valuec->qnt;
                                                }
                                                echo $cnt;
                                            
                                            ?>
                                        </td>

                                    
                                        <td style="border: 1px solid #ddd;">
                                            
                                            <?php 
                                                //today's loan collection 


                                                $querys = $this->db->select('*')->from('account_loan')->where('ac_no', $result->id)->where('sts', 1)->get();
                                                foreach ($querys->result() as $value) {
                                                    $total       = $value->total;
                                                    $installment = $value->installment_amount;
                                                    $loan_id     = $value->id;
                                                    $asol        = $value->installment_asol;
                                                    $profit      = $value->installment_profit;
                                                }
                                                if($installment_qnt==$cnt && !$installment_qnt==0){
                                                     echo "<font color=green>Loan Paid</font>";
                                                }elseif (isset($installment) && $installment > 0) {
                                                    $collected_amount=0;
                                                    $today = date('Y-m-d');                                                    
                                                    $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('pdate', $today)->where('sts', 1)->get();
                                                
                                                    foreach ($queryc->result() as $keyc => $valuec) {
                                                        
                                                        $collected_amount = $valuec->amount_receive;                                                     
                                                    }
                                                    if (!$collected_amount == 0) {
                                                        echo "<font color='green'>$collected_amount</font>";
                                                    } else {
                                                        $installment_amount = round($value->installment_amount);
                                                        echo "<input id='loan_id$result->id' type='hidden' name='loan_id[]' value='$loan_id' >";
                                                        
                                                        echo "<input name='qnt[]' id='qnt$value->id' type='number' value='0' min='0' max='999' size='4'>";
                                                        echo "<input type='text' name='asol[]' value='$asol' size='5' disabled >";
                                                        echo "<input type='text' name='profit[]' value='$profit' size='5' disabled >";            
                                                        echo "<input type='hidden' name='price' id='price$value->id' value='$value->installment_amount' required size='10'>";
                                                        echo "<input type='text' name='installment[]' id='installment$value->id' value='0' size='5' disabled>";
                                                        echo "<input type='hidden' name='xx[]' value='1'>";
                                                            ?>
                                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                                        <script type="text/javascript">
                                                            $(function() {
                                                                $('#qnt<?=$value->id?>').on("change", function() {calculatePrice();});
                                                                $('#price<?=$value->id?>').on("change", function() {calculatePrice();});
                                                                function calculatePrice(){
                                                                    var quantity = $('#qnt<?=$value->id?>').val();
                                                                    var rate = $('#price<?=$value->id?>').val();
                                                                    if(quantity != "" && rate != ""){
                                                                        var price = quantity * rate;
                                                                    }
                                                                    $('#installment<?=$value->id?>').val(price.toFixed(0));
                                                                }
                                                            });
                                                        </script>
                                            <?php
                                                    }

                                                } else {
                                                    echo "<font color=red>No Loan</font>";
                                                }
                                                $installment=0;                                                
                                            ?>     
                                                                                      
                                        </td>

                                        <td style="border: 1px solid #ddd;">       
                                            <input type="hidden" name="ac_id[]" id="ac_id" value="<?= $result->id ?>">
                                            <input type="hidden" name="ac_no[]" value="<?= $result->ac_no ?>">

                                            <input type="hidden" name="zz[]" value="1">
                                            <?php
                                                //$saving_amount=0;
                                                $today = date('Y-m-d');                                                    
                                                $querys = $this->db->select('*')->from('saving_collection')->where('ac_no', $result->id)->where('pdate', $today)->where('sts', 1)->get();
                                                $total_row = $querys->num_rows();
                                                if ( $total_row > 0 ) {
                                                    foreach ($querys->result() as $key => $value) {
                                                        echo $value->amount_receive;
                                                    }
                                                } else {
                                                    echo "<input type='number' name='saving[]' size='10' min='0' value='0' required>";
                                                } 
                                                
                                            ?>                                       
                                                                                           
                                        </td>
                                        
                                    </tr>
                                    <?php } ?>

                                    <tr>
                                        <td colspan="5"><input type="submit" name="ss" value="Submit Confirm" onclick="return confirm('Submit Confirm?');"></td>
                                        
                                    </tr>


                                </tbody>
                            </table>
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


