<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Details</title>
</head>
<style type="text/css">
	body {
		font-family: Verdana;
		font-size: 14px;
	}
</style>
<body>
<div class="table-responsive mailbox-messages">
                       
                        <? 
           $id= $this->input->post('id', true);
           $sdate= $this->input->post('sdate', true);
           
           ?> 
                        
                       
                            <table width="100%" border="1" align="center" cellpadding="6" cellspacing="0" style="display:none">
                               
                                <thead>
                                    
                                    <tr>
                                        <th>SL</th>
                                        <th>A/C ID</th>
                                        <th>Loan ID</th>
                                        <th >Name</th>                                        
                                        <th >Loan QTY</th>
                                        <th >Loan S-Dt</th>
                                        <th >Loan E-Dt</th>
                                        <th>Loan Amt</th>
                                        <th>Asol</th>
                                        <th>Profit</th>
                                        <th>Total</th>
                                        <th>Saving</th>
                                        <th>Return</th>  
                                        <th>Balance</th>
                                      </tr>
                                    
                                </thead>
                                <tbody>
                                    
                                   <?php 
                                        //$currect_date=date('Y-m-d');
                                        //$currect_date="2021-12-08";
                                        $total_saving = 0;
                                        $total_return = 0;
                                        $balance      = 0;
                                        $totalsv=0;
                                        $totalrt=0;
                                        $totalsbl=0;
                                        $totala=0;
                                        $totalp=0;
                                        $totalap =0;
                                        
                                        $queryto = $this->db->query("select * from account where employee_id = '$id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00') order by sl asc ");
                                        foreach($queryto->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td ><?= $result->sl ?></td>
										<td ><?= $result->id ?></td>
										<td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             //$this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                echo $loan_id=$values->id;
                                                 
                                             }
                                             
                                             
                                             ?>                                                
                                       </td>
                                        <td ><?= $result->name ?></td>
                                         <td >
                                              <?php 
                                                //Loan Status 
                                                
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
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
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                       echo $cnt;
                                                       
                                                } else {
                                                     "<font color=red>0</font>";
                                                } 
                                                
                                                ?> 
                                             
                                			                                      
                                        </td>
                                        <td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                
                                                  $loan_date=$values->loan_date;
                                                echo $newDate = date("d/m/Y", strtotime($loan_date));
                                             }
                                             
                                             
                                             ?>                                          
                                       </td>
                                        <td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                
                                                  $last_date=$values->last_date;
                                                echo $newDate = date("d/m/Y", strtotime($last_date));
                                             }
                                             
                                             
                                             ?>                                          
                                       </td>
                                       <td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                
                                                 
                                                 echo$loan_amount=$values->loan_amount;
                                             }
                                             
                                             
                                             ?>                                             
                                       </td>
                                         
                                        <td >
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $due_asol=0;
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                        $due_qnt = $total_qnt-$cnt;
                                                        echo $due_asol = $due_qnt*$loan_asol;
                                                       
                                                        $totala=$totala+$due_asol;
                                                         $due_asol=0;
                                                        
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td >
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $due_profit=0;
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $due_qnt = $total_qnt-$cnt;
                                                        echo $due_profit = $due_qnt*$loan_profit;
                                                        $totalp=$totalp+$due_profit;
                                                        $due_profit=0;
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td >
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
									                foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                        
                                                        
                                                        $due_qnt = $total_qnt-$cnt;
                                                        $due_asol = $due_qnt*$loan_asol;
                                                        $due_asol;
                                                        
                                                        $due_profit = $due_qnt*$loan_profit;
                                                        echo $total=$due_profit+$due_asol;
                                                           $totalap=$totalap+$total;
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        
                                        
                                        
                                        <td  class='saving'>
                                            <?php 
                                                //total saving 
                                                $querys = $this->db->select('*')->from('saving_collection')->where('pdate <=', $sdate)->where('ac_id', $result->id)->where('sts', 1)->get();                           
                                                foreach ($querys->result() as $values) {
                                                    $total_saving = $total_saving+$values->amount_receive;
                                                }
                                                 echo $total_saving;
                                                 $totalsv=$totalsv+$total_saving;
                                                
                                               
                                            ?>                                                
                                        </td>
                                        <td  class='return'>
                                            <?php 
                                                //total return 
                                                $queryr = $this->db->select('*')->from('saving_collection')->where('pdate <=', $sdate)->where('ac_id', $result->id)->where('sts', 1)->get();
                                          foreach ($querys->result() as $values) {
                                                    $total_return = $total_return+$values->amount_return;
                                                }
                                                echo $total_return;
                                                $totalrt=$totalrt+$total_return;
                                            ?>                                                
                                        </td>
                                        <td >
                                            <?php 
                                                //balance 
                                                echo $balance = $total_saving-$total_return;
                                                $totalsbl=$totalsbl+$balance;
                                                $total_saving=0;
                                                $total_return=0;
                                            ?>                                                
                                        </td>
                                        
                                       
                                       
									
									<?php } ?>
									</tr>
									
                                </tbody>
                                </tfoot>
                                <tr>
                                        <th colspan="8"> Grand Total</th>
                                        
                                        <th><?= $totalaooo=$totala ?></th>
                                        <th><?= $totalp ?></th>
                                        <th><?= $totalap ?></th>
                                        <th><?= $totalsv ?></th>
                                        <th><?= $totalrt ?></th>  
                                        <th><?= $totalsbl ?></th>
                                        
                                        
                                       
                                        
                                    </tr>

                                </tfoot>
                               
                            </table>

</div>


	<table width="100%" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td><img src="<?= base_url() ?>img/pad-head.png" width="100%"></td>
		</tr>
		<tr>
			<td align="center" colspan="2"> <H2>Balance Sheet</H2></td>
		</tr>
	</table>

	<table border="1" width="100%" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td width="50%" >Employee Name : <?= get_name_by_auto_id('employee', $id, 'name') ?> </td>
			<td>Printing Date : <?= date('d-m-Y', strtotime($sdate)) ?></td>
		</tr>
		<tr>
		
			<td>Zone : <?= get_name_by_auto_id('zone', get_name_by_auto_id('employee', $id, 'zone_id'), 'name') ?></td>
			<td>Total Member  <?php 
                            $cnt=0;
                            $query = $this->db->query("select * from account where employee_id = '$id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00') order by sl asc ");
                            foreach($query->result() as $key => $result) {
                                ++$key;
                            }
                            if (isset($key)) {
                                $cnt=$key;
                            } 
                        ?>(<?= $cnt ?>)</td>
		</tr>
	</table>

	<br>

	<table border="1" width="100%" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td>Total Saving : <?php 
                            $ts=0;
                            $tr=0;
                            $querytoo = $this->db->query("select * from account where employee_id = '$id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00') order by sl asc ");
                                        foreach($querytoo->result() as $key => $resultt) { 
                            $querysaving = $this->db->query("select * from saving_collection where pdate <= '$sdate' and ac_id = '$resultt->id' and sts = '1'");
                            foreach($querysaving->result() as $key => $resultsaving) {
                               $ts=$ts+$resultsaving->amount_receive;
                               $tr=$tr+$resultsaving->amount_return;
                            }}
                            
                        ?><?= number_format($ts, 0,'.',',')." TK"; ?> </td>
			<td>Total Return : <?= number_format($tr, 0,'.',',')." TK"; ?></td>
			<td>Total Saving Balance : <?= number_format($ts-$tr, 0,'.',',')." TK"; ?> </td>
		</tr>
		<tr>
			<td>Total Asol : <?= number_format($totala, 0,'.',',')." TK"; ?> </td>
			<td>Total Profit : <?= number_format($totalp, 0,'.',',')." TK"; ?></td>       
			<td>Total Loan Balance : <?= number_format($totalap, 0,'.',',')." TK"; ?></td>
		</tr>
	</table>
	

	<br>


     <div class="table-responsive mailbox-messages">
                       
                        
                        
                       
                            <table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
                               
                                <thead>
                                    
                                    <tr>
                                        <th>SL</th>
                                        <th>A/C ID</th>
                                        <th>Loan ID</th>
                                        <th width="200">Name</th>                                        
                                        <th >Loan QTY</th>
                                        <th >Loan S-Dt</th>
                                        <th >Loan E-Dt</th>
                                        <th>Loan Amt</th>
                                        <th>Asol</th>
                                        <th>Profit</th>
                                        <th>Total</th>
                                        <th>Saving</th>
                                        <th>Return</th>  
                                        <th>Balance</th>
                                      </tr>
                                    
                                </thead>
                                <tbody>
                                    
                                   <?php 
                                        $total_saving = 0;
                                        $total_return = 0;
                                        $balance      = 0;
                                        $totalsv=0;
                                        $totalrt=0;
                                        $totalsbl=0;
                                        $totala=0;
                                        $totalp=0;
                                        $totalap =0;
                                        
                                        $queryto = $this->db->query("select * from account where employee_id = '$id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00') order by sl asc ");
                                        foreach($queryto->result() as $key => $result) { 
                                    ?>
									<tr>                                               
										<td ><?= $result->sl ?></td>
										<td ><?= $result->id ?></td>
										<td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                echo $loan_id=$values->id;
                                                 
                                             }
                                             
                                             
                                             ?>                                                
                                       </td>
                                        <td ><?= $result->name ?></td>
                                         <td >
                                              <?php 
                                                //Loan Status 
                                                
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
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
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                  foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                       echo $cnt;
                                                       
                                                } else {
                                                     "<font color=red>0</font>";
                                                } 
                                                
                                                ?> 
                                             
                                			                                      
                                        </td>
                                        <td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                
                                                  $loan_date=$values->loan_date;
                                                echo $newDate = date("d/m/Y", strtotime($loan_date));
                                             }
                                             
                                             
                                             ?>                                          
                                       </td>
                                       <td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                
                                                  $last_date=$values->last_date;
                                                echo $newDate = date("d/m/Y", strtotime($last_date));
                                             }
                                             
                                             
                                             ?>                                          
                                       </td>
                                       <td >
                                          <?php 
                                             $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                             foreach ($queryl->result() as $values) {
                                                
                                                 
                                                 echo$loan_amount=$values->loan_amount;
                                             }
                                             
                                             
                                             ?>                                             
                                       </td>
                                         
                                        <td >
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $due_asol=0;
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                        $due_qnt = $total_qnt-$cnt;
                                                        echo $due_asol = $due_qnt*$loan_asol;
                                                       
                                                        $totala=$totala+$due_asol;
                                                         $due_asol=0;
                                                        
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td >
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $due_profit=0;
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $due_qnt = $total_qnt-$cnt;
                                                        echo $due_profit = $due_qnt*$loan_profit;
                                                        $totalp=$totalp+$due_profit;
                                                        $due_profit=0;
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        <td >
                                            <?php 
                                                //Loan Status 
                                                $loan_status=0;
                                                $query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                $total_row = $query->num_rows();
                                                if ( $total_row > 0 ) {
                                                 
                                                         //loan Total
                                                 
                                                    $queryll = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$sdate' AND (cdate>'$sdate' OR cdate='0000-00-00')");
                                                        foreach ($queryll->result() as $values) {
                                                           $total_loan = $values->total;
                                                           $total_qnt = $values->installment_qnt;
                                                           $loan_id = $values->id;
                                                           $loan_asol=$values->installment_asol;
                                                           $loan_profit=$values->installment_profit;
                                                        }
                                                        
                                                        //loan qty
                                                        
                                                        $cnt = 0;
                                                        $queryc = $this->db->select('*')->from('loan_collection')->where('pdate <=', $sdate)->where('loan_id', $loan_id)->where('sts', 1)->get();
                                                        foreach ($queryc->result() as $valuec) {
                                                            $cnt = $cnt+$valuec->qnt;
                                                        }
                                                        $cnt;
                                                        
                                                        
                                                        $due_qnt = $total_qnt-$cnt;
                                                        $due_asol = $due_qnt*$loan_asol;
                                                        $due_asol;
                                                        
                                                        $due_profit = $due_qnt*$loan_profit;
                                                        echo $total=$due_profit+$due_asol;
                                                           $totalap=$totalap+$total;
                                                 
                                                } else {
                                                    echo "<font color=red>0</font>";
                                                } 
                                                
                                                ?>                                                
                                        </td>
                                        
                                        
                                        
                                        <td  class='saving'>
                                            <?php 
                                                //total saving 
                                                $querys = $this->db->select('*')->from('saving_collection')->where('pdate <=', $sdate)->where('ac_id', $result->id)->where('sts', 1)->get();
                                                
                                                foreach ($querys->result() as $values) {
                                                    $total_saving = $total_saving+$values->amount_receive;
                                                }
                                                 echo $total_saving;
                                                 $totalsv=$totalsv+$total_saving;
                                                
                                               
                                            ?>                                                
                                        </td>
                                        <td  class='return'>
                                            <?php 
                                                //total return 
                                                $queryr = $this->db->select('*')->from('saving_collection')->where('pdate <=', $sdate)->where('ac_id', $result->id)->where('sts', 1)->get();
                                                foreach ($querys->result() as $values) {
                                                    $total_return = $total_return+$values->amount_return;
                                                }
                                                echo $total_return;
                                                $totalrt=$totalrt+$total_return;
                                            ?>                                                
                                        </td>
                                        <td >
                                            <?php 
                                                //balance 
                                                echo $balance = $total_saving-$total_return;
                                                $totalsbl=$totalsbl+$balance;
                                                $total_saving=0;
                                                $total_return=0;
                                            ?>                                                
                                        </td>
                                        
                                       
                                       
									
									<?php } ?>
									</tr>
									
                                </tbody>
                                </tfoot>
                                <tr>
                                        <th colspan="8"> Grand Total</th>
                                        
                                        <th><?= $totalaooo=$totala ?></th>
                                        <th><?= $totalp ?></th>
                                        <th><?= $totalap ?></th>
                                        <th><?= $totalsv ?></th>
                                        <th><?= $totalrt ?></th>  
                                        <th><?= $totalsbl ?></th>
                                        
                                        
                                       
                                        
                                    </tr>

                                </tfoot>
                               
                            </table>

</div>

</body>
</html>