<?php 
   defined('BASEPATH') OR exit('No direct script access allowed'); 
   if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
       
   ?>
<!DOCTYPE html>
<html >
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
               <i class="fa fa-object-group"></i> Investment List of Member
               
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
                           $query = $this->db->query("select * from account_investment where sts = '1'");
                           foreach($query->result() as $key => $result) {
                               ++$key;
                           }
                           if (isset($key)) {
                               $cnt=$key;
                           } 
                           ?>
                        <h3 class="box-title titlefix">Account List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div>
                        <!-- /.box-tools -->
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                          <form action="<?=base_url() ?>admin/multi_invest_confirm" id="collectionform" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="cart">
                              <table class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th><input type="checkbox" name="select-all" id="select-all" /> A&S</th>
                                        <th width="50">ID</th>
                                        <th>Type</th>
                                        <th>Name</th>                                        
                                        <th>Mobile</th>                                        
                                        <th>Address</th>
                                        <th>Started</th>
                                        <th>Amount</th>
                                        <th>Total Diposit</th>
                                      	<th>Total Return</th>
                                        <th>Balance</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                        $total_diposit = 0;
                                        $total_return = 0;
                                        $total_return_F=0;
                                        foreach($results as $key => $result) { 
                                       ?>
                                    <tr>
                                       <td style="border: 1px solid #ddd;"><input type="checkbox"  name="id[]" value="<?= $result->id ?>"></td>
                                       <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
                                       <td style="border: 1px solid #ddd;"><?
										if($result->type==0){echo "Member";}else{echo "Director";}
										
										 ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->name ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->mobile ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->address ?></td>
                                        
                                        <td style="border: 1px solid #ddd;"><?= $result->start_date ?></td>
                                        <td style="border: 1px solid #ddd;"><?= $result->amount ?></td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //Total Diposit
                                      			$total_balance=0;
                                                $query = $this->db->select('*')->from('investment_collection')->where('ac_id', $result->id)->get();
                                      			if(!$query==null){
                                                foreach ($query->result() as $value) {
                                                    $total_diposit = $total_diposit+$value->amount_receive;
                                                  	$total_return_F = $total_return_F+$value->amount_return;
                                                    $total_balance=$total_diposit-$total_return_F;
                                                }
                                                echo $total_diposit;
                                                $total_diposit = 0;
                                    }                        

                                            ?>
                                        </td>
                                      <td style="border: 1px solid #ddd;">
                                            <?php
                                                //Total Return
                                                $query = $this->db->select('*')->from('investment_collection')->where('ac_id', $result->id)->get();
                                                foreach ($query->result() as $value) {
                                                    $total_return = $total_return+$value->amount_return;
                                                }
                                                echo $total_return;
                                          		
                                                $total_return = 0;
                                            ?>
                                        </td>
                                        <td style="border: 1px solid #ddd;">
                                            <?php
                                                //Total Balance
                                                
                                                echo $total_balance;
                                                
                                            ?>
                                        </td>	
                                       <?php } ?>
                                    </tr>
                                 </tbody>
                                 
                                 
                              </table>
                              <div class="box-body">
                            
                            <div class="form-group">
                                <label>Date</label>
                                <input name="pdate" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Deposit Amount</label>
                                <input name="amount_receive" type="text" class="form-control" required>
                             
                                <span class="text-danger"></span>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" name="f_save" onclick="return confirm('Proceed?');">Save</button>
                        </div>
                              
                           </form>
                        </div>
                        <!-- /.mail-box-messages -->
                     </div>
                     <!-- /.box-body -->
                  </div>
               </div>
               <!--/.col (left) -->
               <!-- right column -->
            </div>
            <div class="row">
               <!-- left column -->
               <!-- right column -->
               <div class="col-md-12">
               </div>
               <!--/.col (right) -->
            </div>
            <!-- /.row -->
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <script>
         $('#select-all').click(function(event) {   
         if(this.checked) {
             // Iterate each checkbox
             $(':checkbox').each(function() {
                 this.checked = true;                        
             });
         } else {
             $(':checkbox').each(function() {
                 this.checked = false;                       
             });
         }
         });
         
      </script>
      <script>
         $('#select-all-loan').click(function(event) {   
         if(this.checked) {
             // Iterate each checkbox
             $(':checkbox').each(function() {
                 this.checked = true;                        
             });
         } else {
             $(':checkbox').each(function() {
                 this.checked = false;                       
             });
         }
         });
         
      </script>
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