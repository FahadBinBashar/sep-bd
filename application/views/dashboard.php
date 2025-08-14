<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {

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
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Welcome to admin panel</h3>
                </div><!-- /.box-header -->
                    <div class="box-body">
                     
                    <div class="col-md-4">
                    <form action="" method="post">
                    <strong>View book by search a Member ID: </strong> <input name="mid" value="" type="text" style="width:250px;" >
                    &nbsp;&nbsp;
                    <input type="submit" name="submit" value="View Book">
                    
                    
                    <?php if(isset($_POST["submit"])){
                            $id=$_POST["mid"];
                            
                           $url= "admin/account_details/".$id;
                           ?>
                             <script type="text/javascript">
                            
                            window.open( "/<?php echo $url;?>" )
                            </script> 
                           
                         <?php  
                         
                        }
                        ?>
                    </from>
                        </div>
                        <div class="col-md-4">
                            <form action="" method="post">
                    <strong>View SSP by search a Member ID: </strong> <input name="sspmid" value="" type="text" style="width:250px;">
                    &nbsp;&nbsp;
                    <input type="submit" name="ssubmit" value="View SSP Book">
                    
                    
                    <?php if(isset($_POST["ssubmit"])){
                            $sid=$_POST["sspmid"];
                            
                           $surl= "admin/account_ssp_details/".$sid;
                           ?>
                             <script type="text/javascript">
                            
                            window.open( "/<?php echo $surl;?>" )
                            </script> 
                           
                         <?php  
                         //header('Location: '.$url);
                        }
                        ?>
                        </from>
                            </div>
                            <div class="col-md-4">
                <form action="" method="post">
                    <strong>Print QR by Member ID: </strong> 
                    <input name="qr_mid" value="" type="text" style="width:250px;">
                    &nbsp;&nbsp;
                    <input type="submit" name="qr_submit" value="Print QR">
                    <?php if (isset($_POST["qr_submit"])) {
                        $qrid = $_POST["qr_mid"];
                        $qr_url = "admin/qr_single/" . $qrid;
                    ?>
                        <script type="text/javascript">
                            window.open("/<?= $qr_url ?>", "_blank");
                        </script>
                    <?php } ?>
                </form>
            </div>
                    <hr>
                </div>
            </div>

           



            <?php }else{ ?>


            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Welcome to employee panel</h3>
                        
                       </br></br>
                       
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
                       
                       
	                
                       
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
						
                            <!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (right) -->
            <?php } ?>
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