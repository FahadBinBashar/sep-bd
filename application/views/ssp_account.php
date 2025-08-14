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
            <i class="fa fa-object-group"></i> SSP Account List of <?= get_name_by_auto_id('employee', $_GET['employee_id'], 'name') ?>
            
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
                            $cnt=0;
                            $query = $this->db->query("select * from account_diposit where employee_id = '$_GET[employee_id]' and sts = '1' order by id asc ");
                            foreach($query->result() as $key => $result) {
                                ++$key;
                            }
                            if (isset($key)) {
                                $cnt=$key;
                            } 
                        ?>
                        <h3 class="box-title titlefix">SSP Account List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    
                                    <tr>
                                        <th width="50">ID</th>
                                        <th>Name</th>                                        
                                        <th>Mobile</th>                                        
                                        <th>Address</th>
                                        <th>Monthly Amount</th>
                                        <th>Started</th>
                                        <th>Total Diposit</th>
                                      	<th>Total Return</th>
                                        <th>Balance</th>
                                        
                                      	<? if($_SESSION['status']=='a'){?>
     									 <th>Action</th>
    										<? } ?>
                                        
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                    <tr style="background: cadetblue">
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th><span id="sum"></span></th>
                                        <th><span id="sum1"></span></th>  
                                        <th><span id="balance"></span></th>
                                        <th>-</th> 

                                        
                                    </tr>
                                   <?php 
                                        $total_diposit = 0;
                                        $total_return = 0;
                                        $balance      = 0;
                                        
                                        foreach($query->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= $result->id ?></td>
										<td style="border: 1px solid #ddd;"><?= $result->name ?></td>
										<td style="border: 1px solid #ddd;"><?= $result->mobile ?></td>
										<td style="border: 1px solid #ddd;"><?= $result->address ?></td>
										<td style="border: 1px solid #ddd;"><?= $result->monthly_amount ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->start_date ?></td>
                                        <td style="border: 1px solid #ddd;" class='saving'>
                                            <?php
                                                //Total Diposit
                                      			$total_balance=0;
                                                $query = $this->db->select('*')->from('diposit_collection')->where('ac_id', $result->id)->where('sts','1')->get();
                                      			if(!$query==null){
                                                foreach ($query->result() as $value) {
                                                    $total_diposit = $total_diposit+$value->amount_receive;
                                                  	
                                                }
                                                echo $total_diposit;
                                                
                                            }                        

                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;" class='return'>
                                           <?php
                                                //Total Return
                                                $query = $this->db->select('*')->from('diposit_collection')->where('ac_id', $result->id)->where('sts','1')->get();
                                                foreach ($query->result() as $value) {
                                                    $total_return = $total_return+$value->amount_return;
                                                }
                                                echo $total_return;
                                          		
                                               
                                            ?>                                            
                                        </td>
                                        <td style="border: 1p$total_diposit = 0;$total_diposit = 0;x solid #ddd;"  class='balance'>
                                             <?php
                                                //Total Balance
                                                
                                                echo $total_balance=$total_diposit-$total_return;
                                                $total_diposit = 0;
                                                 $total_return = 0;
                                            ?>                                               
                                        </td>
                                        <td class="text-right" style="border: 1px solid #ddd;">
                                            <a href="<?= base_url() ?>admin/account_ssp_details/<?= $result->id ?>" target="_blank">View</a>
                                            <a href="<?= base_url() ?>admin/ssp_account_edit?id=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <? if($_SESSION['status']=='a' && $total_balance==0){?>
                                            
                                            <a href="<?= base_url() ?>admin/ssp_account_close/<?= $result->id ?>/<?= $_GET['employee_id'];?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="AC Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i>SSP AC Close</a>
                                          <?}?>
										</td>
									
									<?php } ?>
									</tr>
									
                                </tbody>
                                
                                
                                
                                <script>
                                       //Saving Sum
                                        calc_total();
                                        function calc_total(){
                                          var sum = 0;
                                          $(".saving").each(function(){
                                            sum += parseFloat($(this).text());
                                          });
                                          $('#sum').text(sum);
                                        }
                                </script>
                                <script>
                                       //Return Sum
                                        calc_total();
                                        function calc_total(){
                                          var sum1 = 0;
                                          $(".return").each(function(){
                                            sum1 += parseFloat($(this).text());
                                          });
                                          $('#sum1').text(sum1);
                                        }
                                </script>
                                <script>
                                       //Balance Sum
                                        calc_total();
                                        function calc_total(){
                                          var balance = 0;
                                          $(".balance").each(function(){
                                            balance += parseFloat($(this).text());
                                          });
                                          $('#balance').text(balance);
                                        }
                                </script>
                                <script>
                                       //Asol Sum
                                        calc_total();
                                        function calc_total(){
                                          var asol = 0;
                                          $(".asol").each(function(){
                                            asol += parseFloat($(this).text());
                                          });
                                          $('#asol').text(asol);
                                        }
                                </script>
                                <script>
                                       //Profit Sum
                                        calc_total();
                                        function calc_total(){
                                          var profit = 0;
                                          $(".profit").each(function(){
                                            profit += parseFloat($(this).text());
                                          });
                                          $('#profit').text(profit);
                                        }
                                </script>
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