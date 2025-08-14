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
            <i class="fa fa-object-group"></i> SSP Return   

            <?php
                if (isset($_POST['f_save'])) {
                    $time=time() + 60*60;
                    $data = array(
                      	
                        'ac_id'          => $this->input->post('ac_no', true),
                        
                        'amount_receive' => 0,
                        'amount_return'  => $this->input->post('amount_return', true),
                        'sts'            => 1,
                       
                        'uid'            => $_SESSION['user_id'],
                        'pdate'          => $this->input->post('pdate', true),
                        'ptime'          => date("H:s:i"),
                        'Vno'            => $time.$this->input->post('ac_id', true)
                    );
                    $this->db->insert('investment_collection', $data);

                    //query for account type
                     $ac_id=$this->input->post('ac_no', true);
                     $query = $this->db->select('*')->from('account_investment')->where('id', $ac_id)->get();
                     foreach ($query->result() as $key => $value) {
                        $type=$value->type;
                      }
                    
                    if($type==0){
                    
                    
                    $INVDCash = array(
    
                        'VNo' => $time.$this->input->post('ac_id', true),
                        'Vtype' => 'AutoINVDC',
                        'VDate' => $this->input->post('pdate', true) ,
                        'ledger_id' => 1,
                        'Narration' => "সদস্য বিনিয়োগ হিসাব ফেরত-" . $_SESSION['name'],
                        'Debit' => 0,
                        'Credit' => $this->input->post('amount_return', true),
                        'IsPosted' => $this->input->post('ac_id', true),
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVDCash);
                    $INVD = array(
                        'VNo' => $time.$this->input->post('ac_id', true),
                        'Vtype' => 'AutoSSPDC',
                        'VDate' => $this->input->post('pdate', true) ,
                        'ledger_id' => 48,
                        'Narration' => "সদস্য বিনিয়োগ হিসাব ফেরত-" . $_SESSION['name'],
                        'Debit' => $this->input->post('amount_return', true),
                        'Credit' => 0,
                        'IsPosted' => $this->input->post('ac_id', true),
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVD);
                        
                    }else{
                       $INVDCash = array(
    
                        'VNo' => $time.$this->input->post('ac_id', true),
                        'Vtype' => 'AutoINVDC',
                        'VDate' => $this->input->post('pdate', true),
                        'ledger_id' => 1,
                        'Narration' => "পরিচালক আমানত হিসাব ফেরত-" . $_SESSION['name'],
                        'Debit' => 0,
                        'Credit' => $this->input->post('amount_return', true),
                        'IsPosted' => $this->input->post('ac_id', true),
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVDCash);
                    $INVD = array(
                        'VNo' => $time.$this->input->post('ac_id', true),
                        'Vtype' => 'AutoSSPDC',
                        'VDate' => $this->input->post('pdate', true) ,
                        'ledger_id' => 42,
                        'Narration' => "পরিচালক আমানত হিসাব  ফেরত-" . $_SESSION['name'],
                        'Debit' => $this->input->post('amount_return', true),
                        'Credit' => 0,
                        'IsPosted' => $this->input->post('ac_id', true),
                        'CreateBy' => $_SESSION['user_id'],
                        'CreateDate' => date('Y-m-d H:i:s') ,
                        'IsAppove' => 1
                    );
                    $query = $this
                        ->db
                        ->insert('acc_transaction', $INVD);
                    }










                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/investment_return'));
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
                        <h3 class="box-title">Add New Return</h3>
                    </div><!-- /.box-header -->
                    <form id="form1" action="#"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label>Date</label>
                                <input id="dob" name="pdate" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Account No.</label><br>
                                <select class="select2" name="ac_no" required style="width:100%;">
                                   <option value="" selected disabled>Select Account No.</option>
                                    <?php
                                   
                                    
                                        $query = $this->db->select('*')->from('account_investment')->where('sts', 1)->order_by('id', 'asc')->get();
                                        foreach ($query->result() as $key => $value) {
                                          echo "<option value=".$value->id.">".$value->name."</option>";
                                          
                                         
                                            
                                        }
                                  
                                    ?>
                                </select>
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label>Return Amount</label>
                                <input name="amount_return" type="text" class="form-control">
                              
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
                        <h3 class="box-title titlefix">Investment Return Summery </h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Return Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = $this->db->select('*')->from('investment_collection ')->where('amount_return >', 0)->where('sts', 1)->order_by('id', 'desc')->get();
                                        foreach ($query->result() as $key => $value) {
                                    ?>
									<tr>                                               
										<td><?= ++$key ?></td>
										<td><?= $value->id ?></td>
                                        <td><?= $value->pdate ?></td>
										<td><?= get_name_by_auto_id ('account_investment', $value->ac_id, 'name') ?></td>
                                        <td><?= $value->amount_return ?></td>
                                        <td>
                                            <?php
                                                if ($value->sts=='1') {
                                                    echo "<font color=green>Approved</font>";
                                                } elseif ($value->sts=='2') {
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
