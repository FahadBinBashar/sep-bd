<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (isset($_SESSION['user_id']) && isset($_SESSION['pass']) && ($_SESSION['status'] == 'a' || $_SESSION['status'] == 'u')) { ?>
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
            <i class="fa fa-object-group"></i> Loan List 
            
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
                        <?php
                        $cnt = 0;
                        foreach ($results as $result) {
                            ++$cnt;
                        }
                        ?>
                        <h3 class="box-title titlefix">Loan List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th width="50">SL</th>
                                        <th width="50">ID</th>
                                        <th>Name</th>                                        
                                        <th>Account ID</th>
                                        <th>Loan Date</th>
                                        <th>Installment Qnt</th>
                                        <th>Total Loan</th>
                                        <th>Collected</th>
                                        <th>Due</th>
                                        <th>Details</th>
                                      <? if($_SESSION['status']=='a'){?>
     									 <th>Action</th>
    										<? } ?>
                                     	
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $collected = 0;
                                    foreach ($results as $key => $result) { ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= ++$key ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
										
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id('account', $result->account_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->account_id ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->loan_date ?></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                            echo $result->installment_qnt;
                                            echo "/";

                                            $cnt = 0;
                                            $queryc = $this->db
                                                ->select('*')
                                                ->from('loan_collection')
                                                ->where('loan_id', $result->id)
                                                ->where('sts', 1)
                                                ->get();
                                            foreach ($queryc->result() as $valuec) {
                                                $cnt = $cnt+$valuec->qnt;
                                            }
                                            echo $cnt;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;"><?= $result->total ?></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                            //Collected
                                            $query = $this->db
                                                ->select('*')
                                                ->from('loan_collection')
                                                ->where('loan_id', $result->id)
                                                ->get();
                                            foreach ($query->result() as $value) {
                                                $collected = $collected + $value->amount_receive;
                                            }
                                            echo $collected;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                            //Due
                                            echo $result->total - $collected;
                                            $collected = 0;
                                            ?>
                                        </td>
                                        
										
										<td style="border: 1px solid #ddd;">
                                          <a href="<?= base_url() ?>admin/loan_collection_details?loan_id=<?= $result->id ?>">Details</a>
										</td>
                                           <? if($_SESSION['status']=='a'  && $result->installment_qnt==$cnt){?>
                                          
                                                    <td style="border: 1px solid #ddd;">
                                                      <a href="<?= base_url() ?>admin/loan_close/<?= $result->id ?>" onclick="return confirm('Are you sure? this loan will be closed')">Closed</a>
                                                      </td>
                                        
                                            <? }elseif($_SESSION['status']=='a'){?>
                                                    <td style="border: 1px solid #ddd;">
                                                      <a href="#">Open</a>
                                                    </td>
                                       <? } ?>
									</tr>
									<?php }
                                    ?>
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
<?php } else {redirect('admin');
    echo "<center><div style='margin-top:50px; padding:20px; border-radius:10px; width:150px; background-color:pink;'>";
    echo "<a href='" . base_url() . "admin'>Please Login First</a>";
    echo "</div></center>";}
?>
