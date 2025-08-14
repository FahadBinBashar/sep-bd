<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
?>
<!DOCTYPE html>
<html>
<head>
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
            <h1><i class="fa fa-object-group"></i> Collection Report <?php echo $this->session->flashdata('msg'); ?></h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix">Collection Report</h3>
                        </div>
                        <div class="box-body">
                            <form action="" method="post">
                                <div class="col-md-12">
                                    <input id="dob" name="rdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required style="width:250px; float:left;">
                                    &nbsp;&nbsp;
                                    <input type="submit" name="submit" value="Show Report">
                                </div>
                                <div class="col-md-12"><hr></div>
                            </form>

                            <?php
                            if (isset($_POST['rdate'])) {
                                $rdate = $_POST['rdate'];
                                $employee_id = $_SESSION['user_id'];
                                echo "Report Date :".date('d-m-Y', strtotime($rdate)) . '<br>';

                                $loan_collections = $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])->get('loan_collection')->result();
                                $loan_collection_map = [];
                                $total_asol = 0;
                                $total_profit = 0;
                                foreach ($loan_collections as $row) {
                                    $loan_collection_map[$row->loan_id] = $row;
                                    $total_asol += $row->asol;
                                    $total_profit += $row->profit;
                                }

                                $savings = $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])->get('saving_collection')->result();
                                $saving_map = [];
                                $total_saving = 0;
                                $total_saving_return = 0;
                                $total_h_saving_return = 0;
                                foreach ($savings as $s) {
                                    $saving_map[$s->ac_no] = $s;
                                    $total_saving += $s->amount_receive;
                                    $total_saving_return += $s->amount_return;
                                    if ($s->ctype == 1) $total_h_saving_return += $s->amount_return;
                                }

                                $ssps = $this->db->where(['employee_id' => $employee_id, 'pdate' => $rdate, 'sts' => 1])->get('diposit_collection')->result();
                                $ssp_map = [];
                                $total_ssp = 0;
                                $total_ssp_return = 0;
                                $total_h_ssp_return = 0;
                                foreach ($ssps as $s) {
                                    $ssp_map[$s->ac_no] = $s;
                                    $total_ssp += $s->amount_receive;
                                    $total_ssp_return += $s->amount_return;
                                    if ($s->ctype == 1) $total_h_ssp_return += $s->amount_return;
                                }

                                $querysc = $this->db->query("SELECT SUM(Credit) AS Credit FROM acc_transaction WHERE VDate = '$rdate' AND ledger_id IN (32,40,51,56,55,46,57) AND IsAppove =1 AND CreateBy='$employee_id'");
                                $service_ch = $querysc->row()->Credit ?? 0;

                                $total_collection = $total_asol + $total_profit;
                                $total = $total_collection + $total_saving + $total_ssp + $service_ch;
                                $hand_cash_return = $total_h_saving_return + $total_h_ssp_return;
                                $total_of_cash = $total - $hand_cash_return;

                                $accounts = $this->db->where('employee_id', $employee_id)->where('sts', 1)->order_by('sl', 'ASC')->get('account')->result();
                            ?>
                            <table width="800" border="1">
                                <tr align="center">
                                    <td>Asol Collection</td><td>Profit Collection</td><td>Total Loan</td>
                                    <td>Saving</td><td>SSP</td><td>Service Charge</td>
                                    <td>Total</td><td>Saving Return</td><td>SSP Return</td><td>Office Cash</td>
                                </tr>
                                <tr align="center">
                                    <td><?= $total_asol ?></td><td><?= $total_profit ?></td><td><?= $total_collection ?></td>
                                    <td><?= $total_saving ?></td><td><?= $total_ssp ?></td><td><?= $service_ch ?></td>
                                    <td><?= $total ?></td><td><?= $total_saving_return ?></td><td><?= $total_ssp_return ?></td><td><?= $total_of_cash ?></td>
                                </tr>
                            </table>
                            <br>

                            <div class="table-responsive mailbox-messages">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr><th>LS</th><th>Name</th><th>Mobile</th><th>Zone</th><th>Account ID</th><th>Installment</th><th>Saving</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($accounts as $key => $result) : ?>
                                        <tr>
                                            <td><?= ++$key ?></td>
                                            <td><?= $result->name ?></td>
                                            <td><?= $result->mobile ?></td>
                                            <td><?= get_name_by_auto_id('zone', $result->zone_id, 'name') ?></td>
                                            <td><?= $result->id ?></td>
                                            <td>
                                                <?php
                                                $loan = $this->db->where('ac_no', $result->id)->where('sts', 1)->get('account_loan')->row();
                                                if ($loan) {
                                                    $data = $loan_collection_map[$loan->id] ?? null;
                                                    echo $data ? ($data->amount_receive . " ({$data->asol}/{$data->profit})") : "0";
                                                } else {
                                                    echo "No Loan";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $saving = $saving_map[$result->id] ?? null;
                                                echo $saving ? $saving->amount_receive : "-";
                                                ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
<script>
$(document).ready(function () {
    $('#dob').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
});
</script>
