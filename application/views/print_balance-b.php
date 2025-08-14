<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>

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
			<td>Printing Date : <?= date('d-m-Y') ?></td>
		</tr>
		<tr>
		
			<td>Zone : <?= get_name_by_auto_id('zone', get_name_by_auto_id('employee', $id, 'zone_id'), 'name') ?></td>
			<td>Total Member (<?= $count ?>)</td>
		</tr>
	</table>

	<br>

	<table border="1" width="100%" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td>Total Saving :<?= number_format($total_saving_collection, 0,'.',',')." TK"; ?> </td>
			<td>Total Return :<?= number_format($total_saving_return, 0,'.',',')." TK"; ?></td>
			<td>Total Saving Balance :<?= number_format($totalsaving, 0,'.',',')." TK"; ?></td>
		</tr>
		<tr>
			<td>Total Asol : <?= number_format($totala, 0,'.',',')." TK"; ?> </td>
			<td>Total Profit :<?= number_format($totalp, 0,'.',',')." TK"; ?> </td>       
			<td>Total Loan Balance :<?= number_format($totalloan, 0,'.',',')." TK"; ?> </td>
		</tr>
	</table>
	

	<br>

<div class="table-responsive mailbox-messages">
                       
                        
                        
                       
                            <table width="100%" border="1" align="center" cellpadding="6" cellspacing="0">
                               
                                <thead>
                                    
                                    <tr>
                                        <th>SL</th>
                                        <th>A/C ID</th>
                                        <th width="200">Name</th>                                        
                                        <th>Loan ID</th>
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
                                        $sl=1;
                                        $loan_id='';
                                        foreach($account_list as $key => $result) { 
                                            
                                           
                                    ?>
									<tr>                                               
										<td><?= $sl++ ?></td>
										<td><?= $aid=$result->id; ?></td>
										<td><?= $result->name ?></td>
										<td><?  $loan_details=$this->admin_model->loan_details($aid);echo $loan_details['id'];?></td>
                                        <td><?  if(!empty($loan_details['cnt'])){ echo $loan_details['installment_qnt']."/".$loan_details['cnt'];}elseif($loan_details['cnt']==0 && $loan_details['installment_qnt'] != NULL ){ echo $loan_details['installment_qnt']."/0";} ?></td>
                                        <td><?= $loan_details['loan_start_date']?></td>
                                        <td><?= $loan_details['loan_end_date']?></td>
                                        <td><?= $loan_details['loan_amount']?></td>
                                        <td><?  echo $asol=$loan_details['asol'];
                                                // $totala=$totala+$asol;
                                                ?></td>
                                        <td><?  echo $profit=$loan_details['profit'];
                                                // $totalp=$totalp+$profit;
                                            ?></td>
                                        <td><?= $loan_details['due_total']?></td>
                                        <td  class='saving'>
                                             <?  $saving_details=$this->admin_model->saving_details($aid);echo $totalsr=$saving_details['sreceive'];
                                                //  $totalsv=$totalsv+$totalsr;
                                             ?>                                        
                                        </td>
                                        <td  class='return'>
                                            <? echo $totalsre=$saving_details['sreturn'];
                                                    // $totalrt=$totalrt+$totalsre;
                                                ?>
                                            
                                        </td>
                                        <td >
                                             <? echo $totalsrre=$saving_details['sbalance'];
                                                // $totalsbl=$totalsbl+$totalsrre;
                                                ?>                                             
                                        </td>
                                        
                                       
                                       
									
									<?php } ?>
									</tr>
									
                                </tbody>
                                <!--<tfoot>-->
                                <!--<tr>-->
                                <!--        <th colspan="8"> Grand Total</th>-->
                                        
                                <!--        <th><?= $totala ?></th>-->
                                <!--        <th><?= $totalp ?></th>-->
                                <!--        <th><?= $totala+$totalp ?></th>-->
                                <!--        <th><?= $totalsv ?></th>-->
                                <!--        <th><?= $totalrt ?></th>  -->
                                <!--        <th><?= $totalsbl ?></th>-->
                                        
                                        
                                       
                                        
                                <!--    </tr>-->

                                <!--</tfoot>-->
                               
                            </table>

</div>
     

</body>
</html>