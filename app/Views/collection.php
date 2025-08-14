<?php
   defined('BASEPATH') or exit('No direct script access allowed');
   if ((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status'] == 'a' || $_SESSION['status'] == 'u'))
   {
       error_reporting(0);
   ?>
<!DOCTYPE html>
<html >
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <?php $this
         ->load
         ->view('head'); ?>
         
   </head>
   <body class="hold-transition skin-blue fixed sidebar-mini">
      <div class="wrapper">
      <header class="main-header" id="alert">
         <?php $this
            ->load
            ->view('header'); ?>
      </header>
      <?php $this
         ->load
         ->view('menu_left'); ?>
      <div class="content-wrapper">
         <section class="content-header">
            <h1>
               <i class="fa fa-object-group"></i> Today's Collection (<?=date('d-m-Y') ?>)            
               <?php echo $this
                  ->session
                  ->flashdata('msg'); ?>
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
                        <?php $cnt = 0;
                           foreach ($results as $result)
                           {
                               ++$cnt;
                           } ?>
                        <h3 class="box-title titlefix">Today's Collection (<?=$cnt
                           ?>)</h3>
                        <div class="box-tools pull-right">
                        </div>
                        <!-- /.box-tools -->
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                           <form action="<?=base_url() ?>admin/collection_confirm" id="collectionform" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="cart">
                              <table class="table table-striped table-bordered table-hover" style="width: 51%;">
                                 <thead>
                                    <tr>
                                       <th >LS</th>
                                       <th >Name</th>
                                       <th >loan Amt</th>
                                       <th width="260" >Installment</th>
                                       <th width="50">Saving</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       foreach ($results as $key => $result)
                                       {
                                           // $today = date('Y-m-d');
                                           // $querys = $this->db->select('*')->from('saving_collection')->where('ac_no', $result->id)->where('pdate', $today)->where('sts', 1)->get();
                                           // $total_row = $querys->num_rows();
                                           // if ( $total_row == 0 ) {
                                           
                                       
                                           
                                       ?>
                                    <tr>
                                       <td style="border: 1px solid #ddd;"><?=++$key
                                          ?></td>
                                       <td style="border: 1px solid #ddd;"><?=$result->name
                                          ?></td>
                                       <!-- <td style="border: 1px solid #ddd;"><?=$result->mobile
                                          ?></td> -->
                                       <!-- <td style="border: 1px solid #ddd;"><?=get_name_by_auto_id('zone', $result->zone_id, 'name') ?></td>                                        
                                          <td style="border: 1px solid #ddd;"><?=$result->id ?></td> -->
                                       <td style="border: 1px solid #ddd;">
                                          <?php
                                             $installment_qnt = 0;
                                             $loan_id = '';
                                             $queryq = $this
                                                 ->db
                                                 ->select('*')
                                                 ->from('account_loan')
                                                 ->where('ac_no', $result->id)
                                                 ->where('sts', 1)
                                                 ->get();
                                             foreach ($queryq->result() as $valueq)
                                             {
                                                 $loan_id = $valueq->id;
                                                 echo $loan_amt = $valueq->loan_amount;
                                                  $installment_qnt = $valueq->installment_qnt;
                                                 
                                             }
                                             
                                             $cnt = 0;
                                             $queryc = $this
                                                 ->db
                                                 ->select('*')
                                                 ->from('loan_collection')
                                                 ->where('loan_id', $loan_id)->where('sts', 1)
                                                 ->get();
                                             foreach ($queryc->result() as $valuec)
                                             {
                                                 $cnt = $cnt + $valuec->qnt;
                                             }
                                             $cnt;
                                             
                                             ?>
                                       </td>
                                       <td style="border: 1px solid #ddd;">
                                          <?php
                                             //today's loan collection
                                             
                                             
                                             $querys = $this
                                                 ->db
                                                 ->select('*')
                                                 ->from('account_loan')
                                                 ->where('ac_no', $result->id)
                                                 ->where('sts', 1)
                                                 ->get();
                                             foreach ($querys->result() as $value)
                                             {
                                                 $total = $value->total;
                                                 $installment = $value->installment_amount;
                                                 $loan_id = $value->id;
                                                 $asol = $value->installment_asol;
                                                 $profit = $value->installment_profit;
                                             }
                                             if ($cnt == $installment_qnt && !$cnt == 0)
                                             {
                                                 echo "<font color=green>Loan Paid</font>";
                                             
                                             }
                                             elseif (isset($installment) && $installment > 0)
                                             
                                             {
                                             
                                                 $collected_amount = 0;
                                                 $today = date('Y-m-d');
                                                 $queryc = $this
                                                     ->db
                                                     ->select('*')
                                                     ->from('loan_collection')
                                                     ->where('loan_id', $loan_id)->where('pdate', $today)->where('sts', 1)
                                                     ->get();
                                             
                                                 foreach ($queryc->result() as $keyc => $valuec)
                                                 {
                                             
                                                     $collected_amount = $valuec->amount_receive;
                                                 }
                                             
                                                 if ($collected_amount > 0)
                                                 {
                                                     echo "<font color='green'>$collected_amount</font>";
                                                 }
                                                
                                                 else
                                                 {
                                                        error_reporting(0);
                                                         $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                                        $res = "";
                                                        for ($i = 0; $i < 4; $i++) {
                                                         $res .= $chars[mt_rand(0, strlen($chars)-1)];
                                                        }
                                                        $res;
                                                     $installment_amount = round($value->installment_amount);
                                                     echo "<input type='hidden' name='Vno[]' value='$res$result->id' >";
                                                     echo "<input id='loan_id$result->id' type='hidden' name='loan_id[]' value='$loan_id' >";
                                                     echo "<input type='hidden' name='asol[]' value='$asol' >";
                                                     echo "<input type='hidden' name='profit[]' value='$profit' >";
                                                     echo "<input type='hidden' name='price' id='price$value->id' value='$value->installment_amount' required size='10'>";
                                                     // Start Fahad
                                                     echo "<input name='qnt[]' onblur='findTotalqty()' class='qty' id='qnt$value->id' type='number' value='0' min='0' size='5' max='999'>";
                                                     echo "<input type='hidden' name='asodl' id='asol$value->id' value='$asol' >";
                                                     echo "<input type='hidden' name='profidt' id='profit$value->id' value='$profit' >";
                                                     //Fahad
                                                     echo "<input type='text'  onblur='findTotalasol()' class='asol' name='asolm' id='asolm$value->id' value='0' size='5' readonly >";
                                                     echo "<input type='text'  onblur='findTotalprofit()' class='profit' name='profitm' id='profitm$value->id' value='0' size='5' readonly>";
                                                     echo "<input type='text' onblur='findTotal()' class='amount' name='installment[]'  id='installment$value->id' value='0' size='5' readonly >";
                                                     //end Fahad
                                                     echo "<input type='hidden' name='xx[]' value='0'>";
                                             ?>
                                             
                                             
                                          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                          <script type="text/javascript">
                                             $(function() {
                                                 $('#qnt<?=$value->id
                                                ?>').on("change", function() {calculatePrice();});
                                                 $('#price<?=$value->id
                                                ?>').on("change", function() {calculatePrice();});
                                                 function calculatePrice(){
                                                     var quantity = $('#qnt<?=$value->id
                                                ?>').val();
                                                     var rate = $('#price<?=$value->id
                                                ?>').val();
                                                     if(quantity != "" && rate != ""){
                                                         var price = quantity * rate;
                                                     }
                                                     $('#installment<?=$value->id
                                                ?>').val(price.toFixed(0));
                                                 }
                                             });
                                          </script>
                                          <script type="text/javascript">
                                             $(function() {
                                                 $('#qnt<?=$value->id
                                                ?>').on("change", function() {calculateAsol();});
                                                 $('#asol<?=$value->id
                                                ?>').on("change", function() {calculateAsol();});
                                              	
                                                 function calculateAsol(){
                                                     var qty = $('#qnt<?=$value->id
                                                ?>').val();
                                                     var as = $('#asol<?=$value->id
                                                ?>').val();
                                                     if(qty != "" && qty != ""){
                                                         var asol = qty * as;
                                                     }
                                                     $('#asolm<?=$value->id
                                                ?>').val(asol.toFixed(0));
                                                 }
                                             });
                                          </script>
                                          <script type="text/javascript">
                                             $(function() {
                                                 $('#qnt<?=$value->id
                                                ?>').on("change", function() {calculateProfit();});
                                                 $('#profit<?=$value->id
                                                ?>').on("change", function() {calculateProfit();});
                                              	
                                                 function calculateProfit(){
                                                     var qtty = $('#qnt<?=$value->id
                                                ?>').val();
                                                     var ps = $('#profit<?=$value->id
                                                ?>').val();
                                                     if(qtty != "" && ps != ""){
                                                         var profit = qtty * ps;
                                                     }
                                                     $('#profitm<?=$value->id
                                                ?>').val(profit.toFixed(0));
                                                 }
                                             });
                                          </script>
                                          <?php
                                             }
                                             
                                             }
                                             else
                                             {
                                             echo "<font color=red>No Loan</font>";
                                             }
                                             $installment = 0;
                                             ?>     
                                       </td>
                                       <td style="border: 1px solid #ddd;">       
                                          <?php
                                             $saving_amount = 0;
                                             $today = date('Y-m-d');
                                             $querys = $this
                                                 ->db
                                                 ->select('*')
                                                 ->from('saving_collection')
                                                 ->where('ac_no', $result->id)
                                                 ->where('pdate', $today)->where('sts', 1)
                                                 ->get();
                                             $total_row = $querys->num_rows();
                                             
                                             foreach ($querys->result() as $key => $value)
                                             {
                                                 $saving_amount = $value->amount_receive;
                                             }
                                             if ($saving_amount > 0)
                                             {
                                                 echo "<font color='green'>$saving_amount</font>";
                                             }
                                             else
                                             {
                                             ?>
                                          <input type="hidden" name="ac_id[]" id="ac_id" value="<?=$result->id
                                             ?>">
                                          <input type="hidden" name="ac_no[]" value="<?=$result->ac_no
                                             ?>">
                                          <?
                                               error_reporting(0);
                                                $charss = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                                $ress = "";
                                                for ($i = 0; $i < 4; $i++) {
                                                $ress .= $charss[mt_rand(0, strlen($charss)-1)];
                                                }
                                                $ress;
                                               
                                                echo "<input type='hidden' name='VSno[]' value='$ress$result->id' >";
                                             echo "<input type='number' onblur='findTotalsaving()' class='saving' id='saving' name='saving[]' size='3' min='0' value='0' required style='
    width: 92px
'>";
                                             
                                             ?>                                       
                                          <input type="hidden" name="zz[]" value="0">                                           
                                       </td>
                                       <?
                                          }
                                          $saving = 0;
                                          ?>
                                    </tr>
                                    <?php
                                       } ?>
                                       
                                    <tr>
                                        
                                       <td  colspan="5">
                                         L:<input type="text" id="totalqty"  size="7" disabled />
                                         A:<input type="text" id="totalasol"  size="7" disabled />
                                         P:<input type="text" id="totalprofit"size="7" disabled />
                                         T:<input type="text" id="totalordercost" onblur='findTotalcollection()' class='collection' size="7" readonly/>
                                         S.:<input type="text" id="totalsaving" onblur='findTotalcollection()' class='collection'  size="7" readonly />
                                         GT:<input type="text" id="totalcollection"  size="7" disabled /></td>
                                       <script>
                                          function findTotal(){
                                              var arr = document.getElementsByClassName('amount');
                                              var tot=0;
                                              for(var i=0;i<arr.length;i++){
                                                  if(parseFloat(arr[i].value))
                                                      tot += parseFloat(arr[i].value);
                                              }
                                              document.getElementById('totalordercost').value = tot;
                                          }
                                            
                                          function findTotalqty(){
                                              var arr = document.getElementsByClassName('qty');
                                              var tot=0;
                                              for(var i=0;i<arr.length;i++){
                                                  if(parseFloat(arr[i].value))
                                                      tot += parseFloat(arr[i].value);
                                              }
                                              document.getElementById('totalqty').value = tot;
                                          }   
                                            
                                            
                                            
                                          function findTotalasol(){
                                              var arr = document.getElementsByClassName('asol');
                                              var tot=0;
                                              for(var i=0;i<arr.length;i++){
                                                  if(parseFloat(arr[i].value))
                                                      tot += parseFloat(arr[i].value);
                                              }
                                              document.getElementById('totalasol').value = tot;
                                          }
                                          function findTotalprofit(){
                                              var arr = document.getElementsByClassName('profit');
                                              var tot=0;
                                              for(var i=0;i<arr.length;i++){
                                                  if(parseFloat(arr[i].value))
                                                      tot += parseFloat(arr[i].value);
                                              }
                                              document.getElementById('totalprofit').value = tot;
                                          }
                                            function findTotalsaving(){
                                              var arr = document.getElementsByClassName('saving');
                                              var tot=0;
                                              for(var i=0;i<arr.length;i++){
                                                  if(parseFloat(arr[i].value))
                                                      tot += parseFloat(arr[i].value);
                                              }
                                              document.getElementById('totalsaving').value = tot;
                                          }
                                         function findTotalcollection(){
                                              var arr = document.getElementsByClassName('collection');
                                              var tot=0;
                                              for(var i=0;i<arr.length;i++){
                                                  if(parseFloat(arr[i].value))
                                                      tot += parseFloat(arr[i].value);
                                              }
                                              document.getElementById('totalcollection').value = tot;
                                          }
                                            
                                       </script> 
                                    </tr>
                                    <tr>
                                       <td colspan="5"><center><input type="submit" class="btn-success"name="ss" value="Submit Confirm" onclick="return confirm('Submit Confirm?');"></center></td>
                                       </tr>
                                 </tbody>
                              </table>
                           </form>
                           <?php
                                
                                    $emp_id= $_SESSION['user_id'];
                                    $ttoday = date('Y-m-d');
                                    $total_asol_collection=0;
                                    $total_profit_collection=0;
                                    $querytc = $this->db->select('*')->from('loan_collection')->where('employee_id', $emp_id)->where('pdate', $ttoday)->where('sts', 1)->get();
                                    foreach ($querytc->result() as $valuetc) {
                                       $total_asol_collection = $total_asol_collection+$valuetc->asol;
                                       $total_profit_collection = $total_profit_collection+$valuetc->profit;
                                    }
                                    $total_saving=0;
                                    $querys = $this->db->select('*')->from('saving_collection')->where('employee_id', $emp_id)->where('pdate', $ttoday)->where('sts', 1)->get();
                                    foreach ($querys->result() as $keys => $values) {
                                        $total_saving = $total_saving+$values->amount_receive;
                                    }
                                    $total = $total_asol_collection+$total_profit_collection+$total_saving;

                                    
                                
                            ?>
                            
                             <table width="500" border="1"> 
                            <tr align="center">
                                <td>Loan Asol Collection</td>
                                <td>Loan Profit Collection</td>
                                <td>Saving Collection</td>
                                <td>Total Collection</td>
                            </tr>
                            <tr align="center">
                                <td><?php if(isset($total_asol_collection)){echo $total_asol_collection;} ?></td>
                                <td><?php if(isset($total_profit_collection)){echo $total_profit_collection;} ?></td>
                                <td><?php if(isset($total_saving)){echo $total_saving;} ?></td>
                                <td><?php if(isset($total)){echo $total;} ?></td>
                            </tr>
                        </table>
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
      <script type="text/javascript">

    $(document).ready(function() {
        $('#collectionform').submit(function() {
            $('input[type=submit]', this).prop("disabled", true);
        });
    });

</script>
      <!-- /.content-wrapper -->
      <?php $this
         ->load
         ->view('f9'); ?>
   </body>
</html>
<?php
   }
   else
   {
       redirect('admin');
       echo "<center><div style='margin-top:50px; padding:20px; border-radius:10px; width:150px; background-color:pink;'>";
       echo "<a href='" . base_url() . "admin'>Please Login First</a>";
       echo "</div></center>";
   }
   ?>