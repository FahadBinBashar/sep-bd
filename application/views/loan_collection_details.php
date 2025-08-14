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
            <i class="fa fa-object-group"></i> Loan Collection Details of <?= $account_name ?>            
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
                        
                        <h3 class="box-title titlefix">Loan Collection Details of <?= $account_name ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table border="1" width="600">
                            <tr align="center">
                                <td>Loan Date : </td>
                                <td>Loan Amount : </td>
                                <td>Profit Amount : </td>
                                <td>Total Loan : </td>
                                <td>Loan Qnt : </td>
                                <td>Collected : </td>
                                <td>Due : </td>
                            </tr>
                            <tr align="center">
                                <td><?= get_name_by_auto_id('account_loan', $loan_id, 'pdate') ?></td>
                                <td><?= get_name_by_auto_id('account_loan', $loan_id, 'loan_amount') ?></td>
                                <td><?= get_name_by_auto_id('account_loan', $loan_id, 'interest_amount') ?></td>
                                <td><?= $total = get_name_by_auto_id('account_loan', $loan_id, 'total') ?></td>
                                <td>
                                    <?= get_name_by_auto_id('account_loan', $loan_id, 'installment_qnt') ?> /   
                                    <?php
                                        $cnt = 0;
                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                        foreach ($queryc->result() as $valuec) {
                                            $cnt = $cnt+$valuec->qnt;
                                        }
                                        echo $cnt;
                                    ?>
                                </td>
                                <td>                                       
                                    <?php
                                        // collected
                                        $collected = 0;
                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                        foreach ($queryc->result() as $valuec) {
                                            $collected = $collected+$valuec->amount_receive;
                                        }
                                        echo $collected;
                                    ?>
                                </td>
                                <td>                                       
                                    <?php
                                        // due
                                        $due = $total-$collected;
                                        echo $due;
                                    ?>
                                </td>
                            </tr>
                        </table>
                        
                        
                        <br>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th width="50">SL</th>                                        
                                        <th width="100">Date</th>                                        
                                        <th width="150">Receive Amount</th>
                                        <th width="100">Asol</th>
                                        <th>Profit</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $amount_receive = 0;
                                        $asol = 0;
                                        $profit =0;

                                        //$query = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->get();
                                        $query = $this->db->query("select * from loan_collection where loan_id = '$loan_id' order by pdate asc ");
                                        foreach ($query->result() as $key => $value) {

                                            $amount_receive = $amount_receive+$value->amount_receive;
                                            $asol = $asol+$value->asol;
                                            $profit = $profit+$value->profit;
                                    ?>
                                    <tr>                                               
                                        <td style="border: 1px solid #ddd;"><?= ++$key ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->pdate ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->amount_receive ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->asol ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $value->profit ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                                <thead>
                                    <tr>                                               
                                        <th style="border: 1px solid #ddd;"></th>
                                        <th style="border: 1px solid #ddd;"></th>
                                        <th style="border: 1px solid #ddd;"><?= $amount_receive ?></th>
                                        <th style="border: 1px solid #ddd;"><?= $asol ?></th>
                                        <th style="border: 1px solid #ddd;"><?= $profit ?></th>
                                    </tr>
                                </thead>

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