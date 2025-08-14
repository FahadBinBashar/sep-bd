<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Details</title>
	<link href="<?php echo base_url(); ?>img/s-favicon.png" rel="shortcut icon" type="image/x-icon">
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
                                        <th >Elapsed Days</th>
                                        <th>Loan Amt</th>
                                        <th>Asol</th>
                                        <th>Profit</th>
                                        <th>Total</th>
                                        <!--<th>Saving</th>-->
                                        <!--<th>Return</th>  -->
                                        <th>Saving</th>
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
                                        <td><?php 
                                            echo !empty($loan_details['loan_start_date']) && preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $loan_details['loan_start_date'], $matches)
                                                ? (new DateTime("{$matches[3]}-{$matches[2]}-{$matches[1]}"))->diff(new DateTime())->days
                                                : '-';
                                        ?></td>
                                        <td><?= $loan_details['loan_amount']?></td>
                                        <td><?  echo $asol=$loan_details['asol'];
                                                $totala=$totala+$asol;
                                                ?></td>
                                        <td><?  echo $profit=$loan_details['profit'];
                                                $totalp=$totalp+$profit;
                                            ?></td>
                                        <td><?= $loan_details['due_total']?></td>
                                        <!--<td  class='saving'>-->
                                                                                   
                                        <!--</td>-->
                                        <!--<td  class='return'>-->
                                            
                                        <!--</td>-->
                                        <td >
                                             <?  $saving_details=$this->admin_model->saving_details($aid);$totalsr=$saving_details['sreceive'];
                                                $totalsv=$totalsv+$totalsr;
                                             ?> 
                                             <?  $totalsre=$saving_details['sreturn'];
                                                    $totalrt=$totalrt+$totalsre;
                                                ?>
                                             <? echo $totalsrre=$saving_details['sbalance'];
                                                $totalsbl=$totalsbl+$totalsrre;
                                                ?>                                             
                                        </td>
                                        
                                       
                                       
									
									<?php } ?>
									</tr>
									
                                </tbody>
                               <tfoot>
                                <tr>
                                        <th colspan="9"> Grand Total</th>
                                        
                                        <th><?= number_format($totala, 0,'.',',')." TK"; ?></th>
                                        <th><?= number_format($totalp, 0,'.',',')." TK"; ?></th>
                                        <th><?= number_format($totala+$totalp, 0,'.',',')." TK"; ?></th>
                                        
                                        <th><?= number_format($totalsbl, 0,'.',',')." TK"; ?></th>
                                        
                                        
                                       
                                        
                                    </tr>

                                </tfoot>
                               
                            </table>

</div>
     

</body>
</html>