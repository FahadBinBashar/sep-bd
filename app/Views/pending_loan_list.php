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
            <i class="fa fa-object-group"></i> Loan Disbursement Statement 
            
			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header ptbnull">
                    <?php 
                        $query = $this->db->query("
                            SELECT 
                                al.*, 
                                a.name AS act_name, 
                                e.name AS emp_name,
                                (SELECT SUM(amount_receive) - SUM(amount_return) FROM saving_collection WHERE ac_id = al.ac_no AND sts = 1) AS saving_balance,
                                (SELECT SUM(amount_receive) - SUM(amount_return) FROM diposit_collection WHERE ac_id = al.ac_no AND sts = 1) AS ssp_balance
                            FROM 
                                account_loan al
                            LEFT JOIN 
                                account a ON a.id = al.ac_no  -- Corrected column name
                            LEFT JOIN 
                                employee e ON e.id = al.employee_id  -- Corrected column name
                            WHERE 
                                al.sts = '2'
                        ");
                        $cnt = $query->num_rows();
                    ?>
                    <h3 class="box-title titlefix">Loan pending list (<?= $cnt ?>)</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive mailbox-messages">
                       <table class="table table-striped table-bordered table-hover example">
    <thead>
        <tr>
            <th>opening date</th>
            <th>payment date</th>
            <th>loan id</th>
            <th>member id</th>
            <th>member name</th>
            <th>ssp tk</th>
            <th>employee name</th>
            <th>saving balance</th>
            <th>principal amount</th>
            <th>inst rate</th>
            <th>instrest amount</th>
            <th>total amount</th>
            <th>loan period</th>
            <th>daily asol</th>
            <th>daily profit</th>
            <th>status</th>
            <?php if ($_SESSION['user_id'] == 0 || $_SESSION['user_id'] == 17): ?>

                <th>approve</th>
                <th>reject</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($query->result() as $key => $result): ?>
        <tr>
            <td><?= $result->loan_date ?></td>
            <td><?= $result->last_date ?></td>
            <td><?= $result->id ?></td>
            <td><?= $result->ac_no ?></td>
            <td><?= $result->act_name ?></td>
            <td><?= $result->ssp_balance ?: '-' ?></td>
            <td><?= $result->emp_name ?></td>
            <td><?= $result->saving_balance ?: '-' ?></td>
            <td><?= $result->loan_amount ?></td>
            <td><?= $result->interest ?></td>
            <td><?= $result->interest_amount ?></td>
            <td><?= $result->total ?></td>
            <td><?= $result->installment_qnt ?></td>
            <td><?= $result->installment_asol ?></td>
            <td><?= $result->installment_profit ?></td>
            <td>
                <?= $result->sts == '1' ? "<font color=green>Approved</font>" : "<font color=red>Pending</font>" ?>
            </td>
          <?php if ($_SESSION['user_id'] == 0 || $_SESSION['user_id'] == 17): ?>

                <td>
                    <a href="<?= base_url() ?>admin/loan_confirm/<?= $result->id ?>/<?= $result->Vno ?>" onclick="return confirm('Approve Confirm?');">Approve</a>
                </td>
                <td>
                    <a href="<?= base_url() ?>admin/loan_reject/<?= $result->id ?>/<?= $result->Vno ?>" onclick="return confirm('Reject Confirm?');">Reject</a>
                </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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