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
            <i class="fa fa-object-group"></i> Account List of <?= get_name_by_auto_id('employee', $_GET['employee_id'], 'name') ?>
            
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
                            $query = $this->db->query("select * from account where employee_id = '$_GET[employee_id]' and sts = '1' order by sl asc ");
                            foreach($query->result() as $key => $result) {
                                ++$key;
                            }
                            if (isset($key)) {
                                $cnt=$key;
                            } 
                        ?>
                        <h3 class="box-title titlefix">Account List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    
                                    <tr>
                                        <th>SL</th>
                                        <th width="50">Picture</th>
                                        <th>Name</th>                                        
                                        <th>Zone</th>
                                        <th>A/C ID</th>
                                        <th>Saving</th>
                                        <th>Return</th>  
                                        <th>Balance</th>
                                        <th>Loan ID</th>
                                       <th>Loan S-Dt</th>
                                       <th>Loan E-Dt</th>
                                       <th>Loan Amt</th>
                                         <th>Loan QTY</th>
                                        <th>Asol</th>
                                        <th>Profit</th>
                                       <th>Total</th>
                                        <th>View</th>    
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
                                        <th><span id="sum"></span></th>
                                        <th><span id="sum1"></span></th>  
                                        <th><span id="balance"></span></th>
                                        <th>-</th>
                                        <th>-</th>
                                        <th>-</th> 
                                        <th>-</th>
                                        <th>-</th>
                                        <th><span id="asol"></span></th>
                                        <th><span id="profit"></span></th>
                                        <th>-</th> 
                                        <th>-</th> 
                                        <th>-</th>
                                    </tr>
                                   <?php 
                                        $total_saving = 0;
                                        $total_return = 0;
                                        $balance      = 0;
                                        
                                        foreach($query->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td style="border: 1px solid #ddd;"><?= $result->sl ?></td>
										<td style="border: 1px solid #ddd;">
										    <img src="<?php echo base_url(); ?>img/<?= $result->pic ?>" style="width:40px; height:40px; border-radius:40px;">
										     <?
										     
                                               $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           $loan_id=$values->id;
                                                           $total_qnt = $values->installment_qnt;
                                                         }
                                                        $cnnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnnt = $cnnt+$valuec->qnt;
                                                        }
                                                        $cnnt;
                                                 } else {} 
                                             $queryl = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                             foreach ($queryl->result() as $values) {
                                                
                                                 $loan_date=$values->last_date;
                                                 $today=date('Y-m-d');
                                                 if($loan_date <= $today &&  $total_qnt!=$cnnt){
                                                     
                                                    echo"<i class='fa fa-legal' style='font-size:24px;color:red'></i>";
                                                    
                                                         }
                                                
                                             }
                                             
                                             
                                             ?> 
                                             
                                            
                                        </td>
                                        <td style="border: 1px solid #ddd;"><?= $result->name ?></td>
                                        
                                        
                                        <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id ('zone', $result->zone_id, 'name') ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
                                        <td style="border: 1px solid #ddd;" class='saving'>
                                            <?php 
                                                //total saving 
                                                $querys = $this->db->select('*')->from('saving_collection')->where('ac_id', $result->id)->where('sts', 1)->get();
                                                //$querys = $this->db->select('*')->from('saving_collection')->where('ac_id', $result->id)->get();
                                                foreach ($querys->result() as $values) {
                                                    $total_saving = $total_saving+$values->amount_receive;
                                                }
                                                echo $total_saving;
                                                
                                            ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;" class='return'>
                                            <?php 
                                                //total return 
                                                $queryr = $this->db->select('*')->from('saving_collection')->where('ac_id', $result->id)->get();
                                                foreach ($querys->result() as $values) {
                                                    $total_return = $total_return+$values->amount_return;
                                                }
                                                echo $total_return;
                                                
                                            ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;"  class='balance'>
                                            <?php 
                                                //balance 
                                                $balance = $total_saving-$total_return;
                                                echo $balance;
                                                $balance = 0;
                                                $total_saving = 0;
                                                $total_return = 0;
                                            ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                          <?php 
                                             $queryl = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                             foreach ($queryl->result() as $values) {
                                                echo $loan_id=$values->id;
                                                 
                                             }
                                             
                                             
                                             ?>                                                
                                       </td>
                                       <td style="border: 1px solid #ddd;">
                                          <?php 
                                             $queryl = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                             foreach ($queryl->result() as $values) {
                                                
                                                 echo $loan_date=$values->loan_date;
                                                
                                             }
                                             
                                             
                                             ?>                                          
                                       </td>
                                       <td style="border: 1px solid #ddd;">
                                          <?
                                              
                                                //Loan Status 
                                               
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           
                                                           $total_qnt = $values->installment_qnt;
                                                         }
                                                        
                                                        //loan qty
                                                        
                                                        $cnnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnnt = $cnnt+$valuec->qnt;
                                                        }
                                                        $cnnt;
                                                 } else {
                                                  
                                                   
                                                } 
                                               
                                                 
                                             ?>
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          <?php 
                                             $queryl = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                             foreach ($queryl->result() as $values) {
                                                
                                                 echo $loan_date=$values->last_date;
                                                 
                                             }
                                             
                                             
                                             ?>                                          
                                       </td>
                                       <td style="border: 1px solid #ddd;">
                                          <?php 
                                             $queryl = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                             foreach ($queryl->result() as $values) {
                                                
                                                 
                                                 echo$loan_amount=$values->loan_amount;
                                             }
                                             
                                             
                                             ?>                                             
                                       </td>
                                          <td style="border: 1px solid #ddd;">
                                              <?php 
                                                //Loan Status 
                                                
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           echo $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        echo "/";
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                       echo $cnt;
                                                         //echo "Loan A/P =";
                                                        
                                                        $due_qnt = $total_qnt-$cnt;
                                                        $due_asol = $due_qnt*$loan_asol;
                                                         $due_asol;
                                                       
                                                        $due_profit = $due_qnt*$loan_profit;
                                                        $due_profit;
                                                        
                                                 
                                                } else {
                                                     "<font color=red>0</font>";
                                                } 
                                                
                                                ?> 
                                             
                                			                                      
                                        </td>
                                        <td style="border: 1px solid #ddd;" class='asol'>
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                         //echo "Loan A/P =";
                                                        
                                                        $due_qnt = $total_qnt-$cnt;
                                                        $due_asol = $due_qnt*$loan_asol;
                                                        echo $due_asol;
                                                       
                                                        $due_profit = $due_qnt*$loan_profit;
                                                        $due_profit;
                                                        
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;" class='profit'>
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                         //echo "Loan A/P =";
                                                        
                                                        $due_qnt = $total_qnt-$cnt;
                                                        $due_asol = $due_qnt*$loan_asol;
                                                        $due_asol;
                                                        
                                                        $due_profit = $due_qnt*$loan_profit;
                                                        echo $due_profit;
                                                        
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;" class='profit'>
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                        
                                                        
                                                        $due_qnt = $total_qnt-$cnt;
                                                        $due_asol = $due_qnt*$loan_asol;
                                                        $due_asol;
                                                        
                                                        $due_profit = $due_qnt*$loan_profit;
                                                        echo$total=$due_profit+$due_asol;
                                                        
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                             
                                            <a href="<?= base_url() ?>admin/account_details/<?= $result->id ?>" target="_blank">View</a>
                                        </td>
                                        
										
										<td class="text-right" style="border: 1px solid #ddd;">
                                             <?
                                              
                                                //Loan Status 
                                                $loan_status=0;
                                                $query = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->where('sts !=', 0)->get();
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnnt = $cnnt+$valuec->qnt;
                                                        }
                                                        $cnnt;
                                                        
                                                        
                                                       
                                                        
                                                 
                                                } else {
                                                   $total_qnt=0;
                                                   $cnnt=0;
                                                   $loan_id='';
                                                } 
                                                 
                                                 if($_SESSION['status']=='a' && $total_qnt==$cnnt && $loan_id !=null){
                                                 
                                             ?>
                                             <a href="<?= base_url() ?>admin/account_loan_close/<?= $loan_id ?>/<?= $_GET['employee_id'];?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Loan Delete" onclick="return confirm('Are you sure you want to close this loan ?');"><i class="fa fa-remove"></i>Loan Close</a>
                                            
                                            <? }elseif($_SESSION['status']=='a'){?>
                                                   
                                                     
                                                  
                                                    <? } ?>
											<a href="<?= base_url() ?>admin/account_edit?id=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
											<? if($_SESSION['status']=='a'){?>
                                            <a href="<?= base_url() ?>admin/account_close/<?= $result->id ?>/<?= $_GET['employee_id'];?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="AC Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i>AC Close</a>
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