<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
?>

<!DOCTYPE html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('head'); ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <i class="fa fa-object-group"></i> Debit Voucher   

            <?php
                if (isset($_POST['f_save'])) {
                    $time=time() + 60*60;
                    if($this->input->post('emp_id', true) >0){ $is=$this->input->post('emp_id', true); }else{$is=0;}
                $Dr = array(
                    
                  'VNo'            =>  $time,
                  'Vtype'          =>  'Dr',
                  'VDate'          => $this->input->post('pdate', true),
                  'ledger_id'      =>  $this->input->post('ac_no', true),
                  'Narration'      =>  $this->input->post('narration', true),
                  'Debit'          =>  $this->input->post('amount_receive', true),
                  'Credit'         =>  0,
                  'IsPosted'       =>  $is,
                  'CreateBy'       =>  $_SESSION['user_id'],
                  'CreateDate'     =>  date('Y-m-d H:i:s'),
                  'IsAppove'       =>  1
                ); 
                $query =$this->db->insert('acc_transaction',$Dr); 
                $Cr = array(
                  'VNo'            =>  $time,
                  'Vtype'          =>  'Dr',
                  'VDate'          =>  $this->input->post('pdate', true),
                  'ledger_id'      =>  1,
                  'Narration'      =>  $this->input->post('narration', true),
                  'Debit'          =>  0,
                  'Credit'         =>  $this->input->post('amount_receive', true),
                  'IsPosted'       =>  $is,
                  'CreateBy'       =>  $_SESSION['user_id'],
                  'CreateDate'     =>  date('Y-m-d H:i:s'),
                  'IsAppove'       =>  1
                ); 
                $query =$this->db->insert('acc_transaction',$Cr); 
                
                 if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/dr_voucher'));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                    }                  
                             
                }               
            ?>

			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Debit Voucher</h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="#"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label>Date</label>
                                <input id="dob" name="pdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Account No.</label><br>
                                <select class="select2" name="ac_no" required style="width:100%;" onchange="showDiv(this)">
                                    <option value="" selected disabled>Select Ledger</option>
                                    <?php
                                   
                                    
                                        $query = $this->db->select('*')->from('ledger_list')->where('id !=', 1)->where('sts', 1)->order_by('id', 'asc')->get();
                                        foreach ($query->result() as $key => $value) {
                                          echo "<option value=".$value->id.">".$value->ledger_name."</option>";
                                          
                                          $diposit_id=$value->id;
                                            
                                        }
                                  
                                    ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>
                            
                            <div class="form-group" id="hidden_div" style="display:none;">
                                <label>Tag Account</label>
                                <select class="select2" name="emp_id" required style="width:100%;">
                                    <option value="0" selected>Select Employee</option>
                                    <?php
                                   $query = $this->db->select('*')->from('office_emp')->where('sts', 1)->order_by('id', 'asc')->get();
                                        foreach ($query->result() as $key => $value) {
                                          echo "<option value=".$value->id.">".$value->name."</option>";
                                          }
                                  
                                    ?>
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label>Dabit Amount</label>
                                <input name="amount_receive" type="text" class="form-control">
                              <input id="diposit_id" type="hidden" name="diposit_id" value="<?php echo $diposit_id?>" >
                                <span class="text-danger"></span>
                            </div>
                            
                            <div class="form-group">
                                <label>Narration</label>
                                <textarea name="narration" class="form-control"></textarea>
                              
                                <span class="text-danger"></span>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right" name="f_save" onclick="return confirm('Proceed?');">Save</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Debit Voucher Summery </h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>VNo</th>
                                        <th>Vtype</th>
                                        <th>Vdate</th>
                                        <th>Ledger Name</th>
                                        <th>Tag Account</th>
                                        <th>Narration</th>
                                        <th>Amount</th>
                                       
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = $this->db->select('*')->from('acc_transaction ')->where('Vtype =','Dr')->where('ledger_id !=', 1)->where('IsAppove', 1)->order_by('id', 'desc')->get();
                                        foreach ($query->result() as $key => $value) {
                                    ?>
									<tr>                                               
										<td><?= ++$key ?></td>
										<td><?= $value->VNo ?></td>
										<td><?= $value->Vtype ?></td>
                                        <td><?= $value->VDate ?></td>
										<td><?= get_name_by_auto_id ('ledger_list', $value->ledger_id, 'ledger_name') ?></td>
										<td><?= get_name_by_auto_id ('office_emp', $value->IsPosted, 'name') ?></td>
                                        <td><?= $value->Narration ?></td>
                                        <td><?= $value->Debit ?></td>
                                        
                                        <td>
                                            <?php
                                                if ($value->IsAppove=='1') {
                                                    echo "<font color=green>Approved</font>";
                                                } elseif ($value->IsAppove=='2') {
                                                    echo "<font color=red>Pending</font>";
                                                }
                                            ?>
                                        </td>
									</tr>
                                    <?php } ?>
									
                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->

        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
	
<?php $this->load->view('f9'); ?>

</body>
</html>
<?php
    } else {
        redirect('admin');
    }
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
    
    function showDiv(select){
   if(select.value==14){
    document.getElementById('hidden_div').style.display = "block";
   } else{
    document.getElementById('hidden_div').style.display = "none";
   }
} 

</script>

<script type="text/javascript">
    $(document).ready(function () {
        var date_format = 'yyyy-mm-dd';
        $('#dob,#dob2').datepicker({
            format: date_format,
            autoclose: true
        });
        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });
    });
</script>
