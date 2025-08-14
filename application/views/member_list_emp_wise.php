<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')): 
$employee_id = $this->input->get('employee_id', true);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <?php $this->load->view('head'); ?>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
<header class="main-header" id="alert"><?php $this->load->view('header'); ?></header>
<?php $this->load->view('menu_left'); ?>
<div class="content-wrapper">
<section class="content-header">
  <h1><i class="fa fa-object-group"></i> Account List of <?= get_name_by_auto_id('employee', $employee_id, 'name') ?> <?= $this->session->flashdata('msg'); ?></h1>
</section>

<section class="content">
<div class="row"><div class="col-md-12">
<div class="box box-primary">
  <div class="box-header ptbnull">
    <?php
      $previousYear = date('Y');
      $q = $this->db->query("SELECT * FROM account WHERE employee_id=? AND sts='0' AND DATE_FORMAT(cdate,'%Y')<=?", [$employee_id, $previousYear]);
      $cnt = $q->num_rows();
    ?>
    <h3 class="box-title titlefix">Account List (<?= $cnt ?>)</h3>
  </div>

  <div class="box-body">
    <div class="table-responsive mailbox-messages">
      <form action="<?= base_url('admin/old_data_delete_confirm') ?>" method="post" enctype="multipart/form-data" id="form" name="cart">
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th><input type="checkbox" id="select-all-acc" /> A&S</th>
              <th><input type="checkbox" id="select-all-loan" /> Loan</th>
              <th>SL</th><th>Name</th><th>Zone</th><th>A/C ID</th>
              <th>Saving</th><th>Return</th><th>Balance</th>
              <th>Loan ID</th><th>Loan Date</th><th>Loan Amount</th>
              <th>Loan QTY</th><th>Asol</th><th>Profit</th>
            </tr>
          </thead>
          <tbody>
          <?php 
            $total_saving = $total_return = $balance = 0;
            foreach ($q->result() as $result): 
          ?>
            <tr>
              <!-- A&S checkbox: give it its own class -->
              <td style="border:1px solid #ddd;">
                <input type="checkbox" class="chk-acc" name="checkbox[]" value="<?= $result->id ?>">
              </td>

              <!-- Loan checkboxes: use class; don't reuse id -->
              <td style="border:1px solid #ddd;">
                <?php 
                  $queryl = $this->db->select('*')->from('account_loan')->where('account_id', $result->id)->get();
                  foreach ($queryl->result() as $values): ?>
                    <input type="checkbox" class="chk-loan" name="checkboxl[]" value="<?= $values->id ?>">
                <?php endforeach; ?>
              </td>

              <td style="border:1px solid #ddd;"><?= $result->sl ?></td>
              <td style="border:1px solid #ddd;"><?= $result->name ?></td>
              <td style="border:1px solid #ddd;"><?= get_name_by_auto_id('zone', $result->zone_id, 'name') ?></td>
              <td style="border:1px solid #ddd;"><?= $result->id ?></td>

              <!-- Saving -->
              <td style="border:1px solid #ddd;" class="saving">
                <?php
                  $sum_s = 0;
                  $querys = $this->db->select('amount_receive')->from('saving_collection')->where('ac_id', $result->id)->get();
                  foreach($querys->result() as $v){ $sum_s += $v->amount_receive; }
                  echo $sum_s;
                ?>
              </td>

              <!-- Return (fixed loop variable) -->
              <td style="border:1px solid #ddd;" class="return">
                <?php
                  $sum_r = 0;
                  $queryr = $this->db->select('amount_return')->from('saving_collection')->where('ac_id', $result->id)->get();
                  foreach($queryr->result() as $v){ $sum_r += $v->amount_return; }
                  echo $sum_r;
                ?>
              </td>

              <!-- Balance -->
              <td style="border:1px solid #ddd;" class="balance">
                <?php echo $sum_s - $sum_r; ?>
              </td>

              <!-- Loan ID -->
              <td style="border:1px solid #ddd;">
                <?php foreach ($queryl->result() as $v){ echo $v->id; } ?>
              </td>

              <!-- Loan Date -->
              <td style="border:1px solid #ddd;">
                <?php foreach ($queryl->result() as $v){ echo $v->loan_date; } ?>
              </td>

              <!-- Loan Amount -->
              <td style="border:1px solid #ddd;">
                <?php foreach ($queryl->result() as $v){ echo $v->loan_amount; } ?>
              </td>

              <!-- Loan QTY (paid/total) + due calc once -->
              <td style="border:1px solid #ddd;">
                <?php
                  $loan_id = $total_qnt = $loan_asol = $loan_profit = 0;
                  if ($queryl->num_rows() > 0){
                    foreach ($queryl->result() as $v){ 
                      $loan_id = $v->id; $total_qnt = $v->installment_qnt;
                      $loan_asol = $v->installment_asol; $loan_profit = $v->installment_profit;
                    }
                    $cnt = 0;
                    $queryc = $this->db->select('qnt')->from('loan_collection')->where('loan_id', $loan_id)->get();
                    foreach ($queryc->result() as $vc){ $cnt += $vc->qnt; }
                    echo ($total_qnt ?: 0) . "/" . $cnt;
                    $due_qnt = max(0, $total_qnt - $cnt);
                    $due_asol = $due_qnt * $loan_asol;
                    $due_profit = $due_qnt * $loan_profit;
                  } else {
                    echo "<font color=red>0/0</font>"; $due_asol = $due_profit = 0;
                  }
                ?>
              </td>

              <!-- Asol due -->
              <td style="border:1px solid #ddd;" class="asol"><?= $due_asol ?></td>

              <!-- Profit due -->
              <td style="border:1px solid #ddd;" class="profit"><?= $due_profit ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>

          <tr>
            <th colspan="6">Total Balance :</th>
            <th><span id="sum"></span></th>
            <th><span id="sum1"></span></th>
            <th><span id="balance"></span></th>
            <th></th><th></th><th></th><th></th>
            <th><span id="asol"></span></th>
            <th><span id="profit"></span></th>
          </tr>
        </table>

        <br>
        <select name="emp" required class="form-control" style="width:250px; float:left;">
          <option value="" selected disabled>Transfer To Select Employee</option>
          <?php
            $queryse = $this->db->query("SELECT * FROM employee");
            foreach ($queryse->result() as $valuese) {
              $key = $valuese->id; $value= $valuese->name;
              echo '<option '.(($key==$employee_id)?'selected="selected"':'').' value="'.$key.'">'.$value.'</option>';
            }
          ?>
        </select>
        &nbsp;&nbsp;
        <input type="submit" class="btn-danger" name="ss" value="Delete Confirm" onclick="return confirm('Delete Confirm?');">
      </form>
    </div>
  </div>
</div>
</div></div>
</section>
</div>

<!-- JS: separate select-alls -->
<script>
  // toggle only A&S column
  document.getElementById('select-all-acc').addEventListener('change', function(){
    document.querySelectorAll('.chk-acc').forEach(cb => cb.checked = this.checked);
  });
  // toggle only Loan column
  document.getElementById('select-all-loan').addEventListener('change', function(){
    document.querySelectorAll('.chk-loan').forEach(cb => cb.checked = this.checked);
  });
  // optional: if any child unchecked, also uncheck header
  document.addEventListener('change', function(e){
    if(e.target.classList.contains('chk-acc')){
      const all = document.querySelectorAll('.chk-acc');
      const anyUnchecked = Array.from(all).some(cb => !cb.checked);
      document.getElementById('select-all-acc').checked = !anyUnchecked;
    }
    if(e.target.classList.contains('chk-loan')){
      const all = document.querySelectorAll('.chk-loan');
      const anyUnchecked = Array.from(all).some(cb => !cb.checked);
      document.getElementById('select-all-loan').checked = !anyUnchecked;
    }
  });

  // Totals (no function name collisions)
  const sumByClass = cls => Array.from(document.querySelectorAll('.'+cls))
    .reduce((s, el) => s + (parseFloat(el.textContent)||0), 0);
  document.getElementById('sum').textContent     = sumByClass('saving');
  document.getElementById('sum1').textContent    = sumByClass('return');
  document.getElementById('balance').textContent = sumByClass('balance');
  document.getElementById('asol').textContent    = sumByClass('asol');
  document.getElementById('profit').textContent  = sumByClass('profit');
</script>

<?php $this->load->view('f9'); ?>
</div>
</body>
</html>
<?php else: redirect('admin'); ?>
<?php endif; ?>
