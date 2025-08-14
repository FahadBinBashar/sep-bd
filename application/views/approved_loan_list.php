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
            <i class="fa fa-object-group"></i> Approved Loan List 
            
			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <form action="" method="post">
            <div class="col-md-12">
                <select name="employee_id" required class="form-control" style="width:250px; float:left;">
                    <option value="" selected disabled>Select</option>
                    <?php
                    $query = $this->db->query("SELECT * FROM employee WHERE sts = '1' AND status = 'u'");
                    foreach ($query->result() as $value) {
                        echo "<option value='$value->id'>$value->name</option>";
                    }
                    ?>
                </select>
                &nbsp;&nbsp;
                <input name="fdate" type="date" value="<?= date('Y-m-d') ?>" class="form-control" required style="width:250px; float:left;">
                &nbsp;&nbsp;
                <input name="tdate" type="date" value="<?= date('Y-m-d') ?>" class="form-control" required style="width:250px; float:left;">
                &nbsp;&nbsp;
                <input type="submit" name="submit" value="Show Report">
            </div>
            <div class="col-md-12"><hr></div>
        </form>

        <?php if (isset($_POST['fdate'])): 
            $fdate = $_POST['fdate'];
            $tdate = $_POST['tdate'];
            $emp_id = $_POST['employee_id'];
        ?>    
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <?php 
                        $query = $this->db->query("
                            SELECT al.*, 
                                   a.name AS act_name, 
                                   e.name AS emp_name,
                                   COALESCE((SELECT SUM(amount_receive) - SUM(amount_return) FROM saving_collection WHERE ac_id = al.ac_no AND sts = 1), 0) AS saving_balance,
                                   COALESCE((SELECT SUM(amount_receive) - SUM(amount_return) FROM diposit_collection WHERE ac_id = al.ac_no AND sts = 1), 0) AS ssp_balance
                            FROM account_loan al
                            JOIN account a ON a.id = al.ac_no  -- Adjust this if necessary
                            JOIN employee e ON e.id = al.employee_id  -- Adjust this if necessary
                            WHERE al.pdate BETWEEN '$fdate' AND '$tdate' 
                              AND al.loan_amount > '0' 
                              AND al.sts != '2' 
                              AND al.employee_id = '$emp_id'
                        ");
                        $cnt = $query->num_rows();
                        ?>
                        <h3 class="box-title titlefix">Approved Loan List (<?= $cnt ?>) <?= date('d-m-Y', strtotime($fdate)) ?> to <?= date('d-m-Y', strtotime($tdate)) ?> of <?= get_name_by_auto_id('employee', $emp_id, 'name') ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Loan ID</th>
                                        <th>Opening Date</th>
                                        <th>Account ID</th>
                                        <th>Account Name</th>
                                        <th>Employee Name</th>
                                        <th>Saving BL</th>
                                        <th>SSP BL</th>
                                        <th>Amount</th>
                                        <th>Interest %</th>
                                        <th>Interest TK</th>
                                        <th>Total Amount</th>
                                        <th>Installment Period</th>
                                        <th>Principal TK</th>
                                        <th>Profit TK</th>
                                        <th>Last Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($query->result() as $key => $result): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $result->id ?></td>
                                        <td><?= $result->loan_date ?></td>
                                        <td><?= $result->ac_no ?></td>
                                        <td><?= $result->act_name ?></td>
                                        <td><?= $result->emp_name ?></td>
                                        <td><?= $result->saving_balance ?: '-' ?></td>
                                        <td><?= $result->ssp_balance ?: '-' ?></td>
                                        <td><?= $result->loan_amount ?></td>
                                        <td><?= $result->interest ?></td>
                                        <td><?= $result->interest_amount ?></td>
                                        <td><?= $result->total ?></td>
                                        <td><?= $result->installment_qnt ?></td>
                                        <td><?= $result->installment_asol ?></td>
                                        <td><?= $result->installment_profit ?></td>
                                        <td><?= $result->last_date ?></td>
                                        <td>
                                            <?= $result->sts == '1' ? "<font color=green>Approved</font>" : "<font color=red>Pending</font>" ?>
                                        </td>
                                        <td>
                                            <?php if ($_SESSION['user_id'] == 0): ?>
                                            <a href="<?= base_url('Admin/loan_delete/' . $result->id.'/'. $result->Vno ) ?>" onclick="return confirm('Are you sure you want to delete this row?')">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->

        <?php else: ?>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <?php 
                        $query = $this->db->query("
                            SELECT al.*, 
                                   a.name AS act_name, 
                                   e.name AS emp_name,
                                   COALESCE((SELECT SUM(amount_receive) - SUM(amount_return) FROM saving_collection WHERE ac_no = al.ac_no AND sts = 1), 0) AS saving_balance,
                                   COALESCE((SELECT SUM(amount_receive) - SUM(amount_return) FROM diposit_collection WHERE ac_id = al.ac_no AND sts = 1), 0) AS ssp_balance
                            FROM account_loan al
                            JOIN account a ON a.id = al.ac_no  -- Adjust this if necessary
                            JOIN employee e ON e.id = al.employee_id  -- Adjust this if necessary
                            WHERE al.loan_amount > '0' 
                              AND al.sts != '2' 
                            ORDER BY al.pdate DESC 
                            LIMIT 20
                        ");
                        $cnt = $query->num_rows();
                        ?>
                        <h3 class="box-title titlefix">Approved Loan List (<?= $cnt ?>)</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Loan ID</th>
                                        <th>Opening Date</th>
                                        <th>Account ID</th>
                                        <th>Account Name</th>
                                        <th>Employee Name</th>
                                        <th>Saving BL</th>
                                        <th>SSP BL</th>
                                        <th>Amount</th>
                                        <th>Interest %</th>
                                        <th>Interest TK</th>
                                        <th>Total Amount</th>
                                        <th>Installment Period</th>
                                        <th>Principal TK</th>
                                        <th>Profit TK</th>
                                        <th>Last Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($query->result() as $key => $result): ?>
                                    <tr>
                                        <td><?= ++$key ?></td>
                                        <td><?= $result->id ?></td>
                                        <td><?= $result->loan_date ?></td>
                                        <td><?= $result->ac_no ?></td>
                                        <td><?= $result->act_name ?></td>
                                        <td><?= $result->emp_name ?></td>
                                        <td><?= $result->saving_balance ?: '-' ?></td>
                                        <td><?= $result->ssp_balance ?: '-' ?></td>
                                        <td><?= $result->loan_amount ?></td>
                                        <td><?= $result->interest ?></td>
                                        <td><?= $result->interest_amount ?></td>
                                        <td><?= $result->total ?></td>
                                        <td><?= $result->installment_qnt ?></td>
                                        <td><?= $result->installment_asol ?></td>
                                        <td><?= $result->installment_profit ?></td>
                                        <td><?= $result->last_date ?></td>
                                        <td>
                                            <?= $result->sts == '1' ? "<font color=green>Approved</font>" : "<font color=red>Pending</font>" ?>
                                        </td>
                                        <td>
                                            <?php if ($_SESSION['user_id'] == 0): ?>
                                            <a href="<?= base_url('Admin/loan_delete/' . $result->id.'/'. $result->Vno ) ?>" onclick="return confirm('Are you sure you want to delete this row?')">Delete</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
        <?php endif; ?>
    </div><!-- /.row -->
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