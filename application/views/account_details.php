<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
// echo $_SESSION['user_id'];
?>
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



	<table width="900" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td><img src="<?= base_url() ?>img/pad-head.png" width="900"></td>
		</tr>
	</table>

	<table border="1" width="900" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td width="50%">Employee Name : <?= get_name_by_auto_id('employee', get_name_by_auto_id('account', $id, 'employee_id'), 'name') ?> </td>
			<td>Printing Date : <?= date('d-m-Y') ?></td>
		</tr>
		<tr>
			<td>A/C No : <?=  $id ?>  || Account Name : <?= get_name_by_auto_id('account', $id, 'name') ?></td>
			<td>Zone : <?= get_name_by_auto_id('zone', get_name_by_auto_id('account', $id, 'zone_id'), 'name') ?></td>
		</tr>
	</table>

	<br>

	<!-- <center><b>Saving Information : </b></center> -->
	<table border="1" width="900" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td colspan="2"><b>Saving Information : </b></td>
		</tr>
		<tr>
			<td width="200">Total Saving : </td>
			<td>
				<?php
					$total_saving = 0;
					$query = $this->db->query("select * from saving_collection where ac_id = '$id' and sts = '1' ");
					foreach ($query->result() as $key => $value) {
						$total_saving = $total_saving+$value->amount_receive;
					}
					echo number_format($total_saving);
				?>
			</td>
		</tr>
		<tr>
			<td>Total Return : </td>
			<td>
				<?php
					$total_return = 0;
					$query = $this->db->query("select * from saving_collection where ac_id = '$id' and sts = '1' ");
					foreach ($query->result() as $key => $value) {
					   if(!$value->amount_return == 0){echo "(".$value->amount_return.")&nbsp;";}
					    
						$total_return = $total_return+$value->amount_return;
					}
					echo "&nbsp; &nbsp;&nbsp;Total =".number_format($total_return);
				?>
			</td>
		</tr>
		<tr>
			<td>Total Balance : </td>
			<td>
				<?php
					$total_balance = $total_saving-$total_return;
					echo number_format($total_balance);
				?>
			</td>
		</tr>		
	</table>

	<br>

	<?php
		$query = $this->db->query("select * from account_loan where account_id = '$id' and sts = '1' ");
		foreach ($query->result() as $key => $value) {
	?>

	<table border="1" width="900" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td colspan="2"><b>Running Loan Information : </b></td>
		</tr>
		<tr>
			<td width="200">Loan Date : </td>
			<td><?= date('d-m-Y', strtotime($value->loan_date)) ?></td>
		</tr>
		<tr>
			<td width="200">Principal Amount : </td>
			<td><?= number_format($value->loan_amount) ?></td>
		</tr>
		<tr>
			<td>Profit Amount : </td>
			<td><?= number_format($value->interest_amount) ?></td>
		</tr>
		<tr>
			<td>Total Loan : </td>
			<td>
				<?php
					$total_loan = $value->total; 
					echo number_format($total_loan);
				?>
			</td>
		</tr>	
		<tr>
			<td>Loan Quantity : </td>
			<td>
				<?= $total_qnt = $value->installment_qnt ?> /
				<?php
					$cnt = 0;
                    $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $value->id)->where('sts', 1)->get();
                    foreach ($queryc->result() as $valuec) {
                        $cnt = $cnt+$valuec->qnt;
                    }
                    echo $cnt;
				?>
			</td>
		</tr>	
		<tr>
			<td>Total Collected : </td>
			<td>
				<?php
					$total_collected = 0;
                    $querytc = $this->db->select('*')->from('loan_collection')->where('loan_id', $value->id)->where('sts', 1)->get();
                    foreach ($querytc->result() as $valuetc) {
                        $total_collected = $total_collected+$valuetc->amount_receive;
                    }
                    echo number_format($total_collected);
				?>
			</td>
		</tr>
		<tr>
			<td>Total Due : </td>
			<td>
				<?php 
					$total_due = $total_loan-$total_collected;
					echo number_format($total_due); 
				?>				
			</td>
		</tr>
		<tr>
			<td>Due Principal : </td>
			<td>
				<?php
					$due_qnt = $total_qnt-$cnt;
					$due_asol = $due_qnt*$value->installment_asol;
					echo number_format($due_asol);
				?>
			</td>
		</tr>
		<tr>
			<td>Due Profit : </td>
			<td>
				<?php
					$due_profit = $due_qnt*$value->installment_profit;
					echo number_format($due_profit);
				?>
			</td>
		</tr>
	</table>
    <?php } ?>

	<br>
	<br>

	<?php
		$query = $this->db->query("select * from account_loan where account_id = '$id' and sts = '1' ");
		foreach ($query->result() as $key => $value) {
		    $Preqty=0;
		    
	?>
        
	<table border="1" width="900" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td colspan="7"><b>Date wise Loan Collection History: </b></td>
		</tr>
		<tr>
		    <td>Action</td>
			<td>Date</td>
			<td>Loan ID</td>
			<td>Received Amount</td>
			<td>Principal Amount</td>
			<td>Profit Amount</td>
			<td>Times(qty)</td>
			<td>Total</td>
		
		
		</tr>
		<? $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $value->id)->where('sts', 1)->get();
                    foreach ($queryc->result() as $valuec) {?>
		<tr>
		    <td><?php if($_SESSION['user_id'] == 0){?><a href="<?= base_url() ?>admin/delete_lentry/<?= $valuec->id ?>/<?= $valuec->Vno ?>/<?= $id?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Entry Delete" onclick="return confirm('Are you sure you want to delete this Entry?');"><i class="fa fa-remove"></i>delete</a><?php } ?></td>
		    <td><?= date('d-m-Y', strtotime($valuec->pdate)) ?></td>
			<td><?= $valuec->loan_id ?></td>
			<td><?= number_format($valuec->amount_receive) ?></td>
			<td><?= number_format($valuec->asol) ?></td>
			<td><?= number_format($valuec->profit) ?></td>
			<td><?= number_format($valuec->qnt) ?>
			<? $Preqty += $valuec->qnt; ?></td>
			<td><?= $Preqty ?></td>
			
		</tr>
		<? } ?>
	</table>
    <?php } ?>
    <br>
    	<br>

	<?php
		$query = $this->db->query("select * from account where id = '$id' and sts = '1' ");
		foreach ($query->result() as $key => $value) {
		    
		    
	?>
        
	<table border="1" width="900" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td colspan="6"><b>Date wise Saving Collection History: </b></td>
		</tr>
		<tr>
		    <td>Action</td>
			<td>Date</td>
		
			<td>Received Amount</td>
			<td>Return Amount</td>
			<td>Total</td>
			
		
		
		</tr>
		<? $PreBalance=0;
		
		$queryc = $this->db->select('*')->from('saving_collection')->where('ac_no', $value->id)->where('sts', 1)->get();
                    foreach ($queryc->result() as $valuec) {
                     
                    ?>
		<tr>
		    <td><?php if($_SESSION['user_id'] == 0){?><a href="<?= base_url() ?>admin/delete_sentry/<?= $valuec->id ?>/<?= $valuec->Vno ?>/<?= $value->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Entry Delete" onclick="return confirm('Are you sure you want to delete this Saving Entry?');"><i class="fa fa-remove"></i>delete</a><?php } ?></td>
		    <td><?= date('d-m-Y', strtotime($valuec->pdate)) ?></td>
			<td><?= number_format($valuec->amount_receive)?>
			 <? $PreBalance += $valuec->amount_receive;
			?></td>
			<td><?= number_format($valuec->amount_return) ?>
			 <? $PreBalance -= $valuec->amount_return; ?></td>
			<td><?php echo number_format((!empty($PreBalance)?$PreBalance:0),0,'.',','); ?></td>
		
			
		</tr>
		<? } ?>
	</table>
    <?php } ?>
    <br><br><br><br>

	<!-- <table border="1" width="900" align="center" cellpadding="6" cellspacing="0">
		<tr>
			<td colspan="2">Preveus Loan Information : </td>
		</tr>
		<tr>
			<td width="200">Loan Date : </td>
			<td></td>
		</tr>
		<tr>
			<td>Loan Amount : </td>
			<td></td>
		</tr>
		<tr>
			<td>Status : </td>
			<td></td>
		</tr>		
	</table> -->



</body>
</html>
<?php
    } else {
        redirect('admin');
    }
?>