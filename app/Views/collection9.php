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

            <?php
                if (isset($_POST['submit'])) {

                    if (!empty($this->input->post('installment', true)) && $this->input->post('installment', true)>0) {                  

                        $qnt    = $this->input->post('qnt', true);
                        $asol   = $this->input->post('asol', true);
                        $profit = $this->input->post('profit', true);

                        $loan_id = $this->input->post('loan_id', true);
                        $employee_id = get_name_by_auto_id('account_loan', $loan_id, 'employee_id');

                        $data = array(
                            'loan_id'        => $loan_id,
                            'amount_receive' => $this->input->post('installment', true),
                            'asol'           => $qnt*$asol,
                            'profit'         => $qnt*$profit,
                            'sts'            => 1,
                            'employee_id'    => $employee_id,
                            'uid'            => $_SESSION['user_id'],
                            'pdate'          => date('Y-m-d'),
                            'ptime'          => date('H:i:s'),
                            'qnt'            => $this->input->post('qnt', true)
                        );
                        $query1 = $this->db->insert('loan_collection', $data);                          
                    } 

                    if ($this->input->post('saving', true)!='' && $this->input->post('saving', true)>0) {                 

                        $ac_id = $this->input->post('ac_id', true);
                        $employee_id = get_name_by_auto_id('account', $ac_id, 'employee_id');

                        $data = array(
                            'ac_id'          => $ac_id,
                            'ac_no'          => $ac_id,
                            'amount_receive' => $this->input->post('saving', true),
                            'amount_return'  => 0,
                            'sts'            => 1,
                            'employee_id'    => $employee_id,
                            'uid'            => $_SESSION['user_id'],
                            'pdate'          => date('Y-m-d'),
                            'ptime'          => date('H:i:s')
                        );
                        $query2 = $this->db->insert('saving_collection', $data);                           
                    } 
                    
                    //$this->session->set_flashdata('msg', '<font color=green>Collection Success!</font>');
                    redirect(base_url('admin/collection'));
                    

                }

            ?>
            
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
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th width="50">LS</th>                                        
                                        <th>Name</th>                                        
                                        <th>Mobile</th>
                                        <th>Zone</th>
                                        <th>Account ID</th>
                                        <th>Installment Qnt</th>
                                        <th>Installment</th>
                                        <th>Saving</th>
                                        <th>Submit</th>                                                                 
                                        
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
                                        <td style="border: 1px solid #ddd;"><?= $result->mobile ?></td>
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('zone', $result->zone_id, 'name') ?></td>                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
                                        
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

                                    <form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="cart">
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

                                                if (isset($installment) && $installment > 0) {
                                                    $collected_amount=0;
                                                    $today = date('Y-m-d');                                                    
                                                    $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('pdate', $today)->where('sts', 1)->get();
                                                
                                                    foreach ($queryc->result() as $keyc => $valuec) {
                                                        
                                                        $collected_amount = $valuec->amount_receive;                                                     
                                                    }

                                                    if ($collected_amount > 0) {
                                                        echo "<font color='green'>$collected_amount</font>";
                                                    } else {
 
                                                        echo "<input type='hidden' name='loan_id' value='$loan_id' >";
                                                        echo "<input type='hidden' name='asol' value='$asol' >";
                                                        echo "<input type='hidden' name='profit' value='$profit' >";            
                                                        echo "<input type='hidden' name='price' id='price$value->id' value='$value->installment_amount' required size='10'>";
                                                        echo "<input name='qnt' id='qnt$value->id' type='number' value='1' min='0' size='3'>";
                                                        echo "<input type='text' name='installment' id='installment$value->id' value='$value->installment_amount' placeholder='$value->installment_amount' size='10'>";
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
                                                    echo "No Loan";
                                                }
                                                $installment=0;                                                
                                            ?>     
                                                                                      
                                        </td>

                                        <td style="border: 1px solid #ddd;">       
                                            <input type="hidden" name="ac_id" value="<?= $result->id ?>">
                                            <input type="hidden" name="ac_no" value="<?= $result->ac_no ?>">
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
                                                    echo "<input type='number' name='saving' size='10' min='0' required>";
                                                } 
                                                // foreach ($querys->result() as $keys => $values) {
                                                //     ++$keys;
                                                //     $saving_amount = $values->amount_receive;
                                                // }

                                                // if (isset($saving_amount) && $saving_amount > 0) {
                                                //     echo "<font color='green'>$saving_amount</font>";
                                                // } else {
                                                //     echo "<input type='number' name='saving' size='10' required>";
                                                // }
                                            ?>                                       
                                                                                           
                                        </td>
                                        <td style="border: 1px solid #ddd;">

                                            <input type="submit" name="submit" value="Submit" onclick="return confirm('Submit?');">
                                        </td>
                                    </form>

                                        
                                    </tr>
                                    <?php } ?>
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