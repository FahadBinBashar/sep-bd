<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='sa' || $_SESSION['status']=='u')) {
?>

<!DOCTYPE html>
<html >
    <head>
        <?php $this->load->view('head'); ?>
        <style type="text/css">
            .txt_normal{font-size:14px;font-weight:normal;}
        </style>
            
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header" id="alert">
				<?php $this->load->view('header'); ?>
			</header>
            <?php $this->load->view('menu_left'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- Main content -->

    <section class="content">
        <div class="row">


            <?php if ($_SESSION['status']=='a') { ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-credit-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Zone</span>
                            <span class="info-box-number">
                                <?php
                                    //total zone
                                    foreach ($zone_list as $keyz => $zone) {
                                        ++$keyz;
                                    }
                                    if (isset($keyz)) {
                                        echo $keyz;
                                    } else {
                                        echo 0;
                                    }
                                    
                                ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Employee</span>
                            <span class="info-box-number">
                                <?php
                                    //total employee
                                    foreach ($employee_list as $keye => $employee) {
                                        ++$keye;
                                    }
                                    if (isset($keye)) {
                                        echo $keye;
                                    } else {
                                        echo 0;
                                    }
                                ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Account</span>
                            <span class="info-box-number">
                                <?php
                                    //total account
                                    foreach ($account_list as $keya => $account) {
                                        ++$keya;
                                    }
                                    if (isset($keya)) {
                                        echo $keya;
                                    } else {
                                        echo 0;
                                    }
                                ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="info-box" style="padding:10px;">
                    <a href="#">                        
                        
                            <span class="info-box-text">Savings Status</span>
                            <span class="info-box-number">

                                <table border="1">
                                    <tr align="center">
                                        <td width="100"><span class="txt_normal">Total Saving</span></td>
                                        <td width="100"><span class="txt_normal">Total Return</span></td>
                                        <td width="100"><span class="txt_normal">Total Balance</span></td>
                                    </tr>
                                    <tr align="center">
                                        <td>
                                            <?php
                                                //total saving
                                                $total_saving = 0;
                                                $query = $this->db->query("select * from saving_collection where amount_receive > '0' ");
                                                foreach ($query->result() as $key => $value) {
                                                    $total_saving = $total_saving+$value->amount_receive;
                                                }
                                            ?>
                                            <span class="txt_normal"><?= $total_saving ?></span>
                                        </td>
                                        <td>
                                            <?php
                                                //total return
                                                $total_return = 0;
                                                $query = $this->db->query("select * from saving_collection where amount_return > '0' and sts = '1' ");
                                                foreach ($query->result() as $key => $value) {
                                                    $total_return = $total_return+$value->amount_return;
                                                }
                                            ?>
                                            <span class="txt_normal"><?= $total_return ?></span>
                                        </td>
                                        <td>
                                            <span class="txt_normal"><?= $total_saving-$total_return ?></span>
                                        </td>
                                    </tr>
                                </table>
            
                            </span>
                        
                    </a>
                </div>
            </div>


            <div class="col-md-12">
                <div class="info-box" style="padding:10px;">
                    <a href="#">                        
                        
                            <span class="info-box-text">Loan Status</span>
                            <span class="info-box-number">

                                <table border="1">
                                    <tr align="center">
                                        <td width="100"><span class="txt_normal">Total Loan</span></td>
                                        <td width="100"><span class="txt_normal">Total Collected</span></td>
                                        <td width="100"><span class="txt_normal">Total Due</span></td>
                                    </tr>
                                    <tr align="center">
                                        <td>
                                            <?php
                                                //total loan
                                                $total_loan = 0;
                                                $query = $this->db->query("select * from account_loan where sts = '1' ");
                                                foreach ($query->result() as $key => $value) {
                                                    $total_loan = $total_loan+$value->total;
                                                }
                                            ?>
                                            <span class="txt_normal"><?= $total_loan ?></span>
                                        </td>
                                        <td>
                                            <?php
                                                //total collected
                                                $total_collected = 0;
                                                $query = $this->db->query("select * from loan_collection where sts = '1' ");
                                                foreach ($query->result() as $key => $value) {
                                                    $total_collected = $total_collected+$value->amount_receive;
                                                }
                                            ?>
                                            <span class="txt_normal"><?= $total_collected ?></span>
                                        </td>
                                        <td>
                                            <span class="txt_normal"><?= $total_loan-$total_collected ?></span>
                                        </td>
                                    </tr>
                                </table>
            
                            </span>
                        
                    </a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="info-box" style="padding:10px;">
                    <a href="#">                        
                        
                            <span class="info-box-text">Diposit Status</span>
                            <span class="info-box-number">

                                <table border="1">
                                    <tr align="center">
                                        <td width="100"><span class="txt_normal">Total Diposit</span></td>
                                        <td width="100"><span class="txt_normal">Total Return</span></td>
                                        <td width="100"><span class="txt_normal">Total Balance</span></td>
                                    </tr>
                                    <tr align="center">
                                        <td>
                                            
                                            <span class="txt_normal">00</span>
                                        </td>
                                        <td>
                                            
                                            <span class="txt_normal">00</span>
                                        </td>
                                        <td>
                                            <span class="txt_normal">00</span>
                                        </td>
                                    </tr>
                                </table>
            
                            </span>
                        
                    </a>
                </div>
            </div>


            <?php } ?>


            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php 
                                if ($_SESSION['status']=='a') { 
                                    echo "অ্যাডমিন প্যানেলে স্বাগতম";
                                } elseif ($_SESSION['status']=='u') {
                                    echo "কর্মচারী প্যানেলে স্বাগতম";











                                }
                            ?>
                            
                        </h3></br></br>
                       <? if ($_SESSION['status']=='u') { ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-sign-in"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Saving Collection</span>
                            <span class="info-box-number">
                                <?= number_format($total_saving_collection, 0,'.',',')." TK"; ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-sign-out"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Saving Return</span>
                            <span class="info-box-number">
                                <?= number_format($total_saving_return, 0,'.',',')." TK"; ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-balance-scale"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Saving Balance</span>
                            <span class="info-box-number">
                                <?= number_format($tsb=$total_saving_collection-$total_saving_return, 0,'.',',')." TK"; ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Principal Amount(Dues)</span>
                            <span class="info-box-number">
                                <?= number_format($totala, 0,'.',',')." TK"; ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-bar-chart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Profit Amount (Dues)</span>
                            <span class="info-box-number">
                                <?= number_format($totalp, 0,'.',',')." TK"; ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>

                         <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="#">
                        <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Loan Balance (Dues)</span>
                            <span class="info-box-number">
                                <?= number_format($totalp+$totala, 0,'.',',')." TK"; ?>
                            </span>
                        </div>
                    </a>
                </div>
            </div>
                       
                       
	<?}?>
                       
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
						
                            <!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (right) -->
        </div>

    </section><!-- /.content -->


</div><!-- /.content-wrapper -->


<?php $this->load->view('f9'); ?>

</body>
</html>
<?php
    } else {
        redirect('admin');
    }
?>