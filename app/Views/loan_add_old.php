<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a'  || $_SESSION['status']=='u')) {
?>
<!DOCTYPE html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->load->view('head'); ?>
        <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script type="text/javascript" src="<?= base_url() ?>src_admin/jautocalc.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                function autoCalcSetup() {
                    $('form[name=cart]').jAutoCalc('destroy');
                    $('form[name=cart] tr[name=line_items]').jAutoCalc({
                        keyEventsFire: true,
                        decimalPlaces: 2,
                        emptyAsZero: true
                    });
                    $('form[name=cart]').jAutoCalc({
                        decimalPlaces: 2
                    });
                }
                autoCalcSetup();

            });

        </script>


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
            <i class="fa fa-user-plus"></i> OLD Loan Account 
            <?php
                if (isset($_POST['add'])) {   

                    $ac_id = $this->input->post('ac_no', true);
                    $chk = check_loan_ac($ac_id); 
                    if ($chk) {   

                        $interest_amount = $this->input->post('interest_amount', true);
                        $interest_amount = str_replace(',', '', $interest_amount);

                        $total = $this->input->post('total', true);  
                        $total = str_replace(',', '', $total);

                        $installment_amount = $this->input->post('installment_amount', true);
                        $installment_amount = str_replace(',', '', $installment_amount);

                        $installment_asol = $this->input->post('installment_asol', true);
                        $installment_asol = str_replace(',', '', $installment_asol);

                        $installment_profit = $this->input->post('installment_profit', true);
                        $installment_profit = str_replace(',', '', $installment_profit);

                        $installment_qnt = $this->input->post('installment_qnt', true);

                        $last_date = $this->input->post('loan_date', true);
                        $last_date = strtotime($last_date);
                        $last_date = strtotime("+$installment_qnt day", $last_date);
                        $last_date = date('Y-m-d', $last_date);

                        $saving_amount = "00";
                        
                        $data = array(
                            'account_id'         => $this->input->post('ac_no', true),
                            'ac_no'              => $this->input->post('ac_no', true),
                            'loan_amount'        => $this->input->post('loan_amount', true),
                            'loan_date'          => $this->input->post('loan_date', true),
                            'interest'           => $this->input->post('interest', true),
                            'interest_amount'    => $interest_amount,
                            'total'              => $total,
                            'installment_qnt'    => $installment_qnt,
                            'installment_amount' => $installment_amount,
                            'installment_asol'   => $installment_asol,
                            'installment_profit' => $installment_profit,
                            'saving_amount'      => $saving_amount,
                            'loan_time'          => $this->input->post('loan_time', true),
                            'last_date'          => $last_date,
                            'gr1_name'           => $this->input->post('gr1_name', true),
                            'gr1_mobile'         => $this->input->post('gr1_mobile', true),
                            'gr1_address'        => $this->input->post('gr1_address', true),
                            'gr1_nid'            => $this->input->post('gr1_nid', true),
                            'gr2_name'           => $this->input->post('gr2_name', true),
                            'gr2_mobile'         => $this->input->post('gr2_mobile', true),
                            'gr2_address'        => $this->input->post('gr2_address', true),
                            'gr2_nid'            => $this->input->post('gr2_nid', true),
                            'sts'                => 1,
                            'uid'                => $_SESSION['user_id'],
                            'pdate'              => $this->input->post('loan_date', true),
                            'employee_id'        => $employee_id = $this->input->post('employee_id', true)
                        );
                        $this->db->insert('account_loan', $data);

                        $insert_id = $this->db->insert_id();
                        $paid_qnt  = $this->input->post('paid_qnt', true);
                        $pdate     = $this->input->post('loan_date', true);                    

                        for ($i=1; $i<=$paid_qnt; $i++) {

                            $nd = strtotime($pdate);
                            $nd = strtotime("+$i day", $nd);
                            $nd = date('Y-m-d', $nd);

                            $data = array(
                                'loan_id'        => $insert_id,
                                'amount_receive' => $installment_amount,
                                'asol'           => $installment_asol,
                                'profit'         => $installment_profit,
                                'sts'            => 1,
                                'employee_id'    => $employee_id,
                                'uid'            => $_SESSION['user_id'],
                                'pdate'          => $nd,
                                'ptime'          => date('H:i:s'),
                                'qnt'            => 1
                            );
                            $this->db->insert('loan_collection', $data);
                        }

                        if ( $this->db->affected_rows() ) {
                            $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                            redirect(base_url('admin/loan_list'));
                        } else {
                            $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                            redirect(base_url('admin/loan_add'));
                        }                  
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>Loan Account Allready Running!</font>');
                        redirect(base_url('admin/loan_add_old'));
                    }  
                }               
            ?>
			<?php echo $this->session->flashdata('msg'); ?>
		</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="pull-right box-tools" style="position: absolute;right: 14px;top: 13px;">
                        <!--<a href="std_inport.php"><button class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Import Student</button></a>-->
                    </div>

                   
                    <form action="#" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="cart">
                        <div class="box-body">
                            <div class="tshadow mb25 bozero">    
                                <h4 class="pagetitleh2">OLD Loan Account</h4>

                                <div class="around10">
                                    <div class="row">
                                    

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Loan Date</label>
                                                <input id="dob" name="loan_date" type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Account No<?php $emp_id =$_SESSION['user_id']; ?>.</label><br>
                                                <select class="select2" name="ac_no" required style="width:100%;">
                                                    <option value="" selected disabled>Select Account No.</option>
                                                    <?php
                                                    
                                                     if ($_SESSION['status']=='a') { 
                                                               $query = $this->db->select('*')->from('account')->where('sts','1')->order_by('id', 'asc')->get();
                                                        foreach ($query->result() as $key => $value) {
                                                            echo "<option value='$value->id'>$value->id ($value->name)</option>";
                                                        }
                                                            } elseif ($_SESSION['status']=='u') {
                                                               $query = $this->db->select('*')->from('account')->where('sts','1')->where('employee_id',$emp_id)->order_by('id', 'asc')->get();
                                                        foreach ($query->result() as $key => $value) {
                                                            echo "<option value='$value->id'>$value->id ($value->name)</option>";
                                                        }
                                                            }
                                                       
                                                        
                                                    ?>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>

                                        

                                        

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Loan Amount</label>
                                                <input name="loan_amount" type="text" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Installment Quantity</label>
                                                <input name="installment_qnt"  type="number" class="form-control" min="100" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">&nbsp;</div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Interest Amount</label>
                                                <input type="hidden" name="interest" value="2.7">
                                                <input type="hidden" name="l" value="3000">
                                                <input name="interest_amount" value="" jAutoCalc="{loan_amount} * {installment_qnt} * {interest} / {l}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Total</label>
                                                <input name="total" type="text" value="" jAutoCalc="{loan_amount} + {interest_amount}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Installment Amount</label>
                                                <input name="installment_amount" jAutoCalc="{total} / {installment_qnt}" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Installment Asol</label>
                                                <input name="installment_asol" jAutoCalc="{loan_amount} / {installment_qnt}" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Installment Profit</label>
                                                <input name="installment_profit" jAutoCalc="{interest_amount} / {installment_qnt}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        
                                        
                                        <!-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Saving Amount</label>
                                                <input name="saving_amount" type="text" class="form-control">
                                            </div>
                                        </div> -->

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Loan Time</label>
                                                <input name="loan_time" value="1st" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Employee Name</label><br>
                                                <select class="select2" name="employee_id" required style="width:100%;">
                                                    <option value="" selected disabled>Select</option>
                                                    <?php
                                                        if ($_SESSION['status']=='a') { 
                                                            $query = $this->db->select('*')->from('employee')->where('sts', 1)->where('status', 'u')->order_by('id', 'asc')->get();
                                                            foreach ($query->result() as $key => $value) {
                                                                echo "<option value='$value->id'>$value->name</option>";
                                                            }
                                                        } elseif ($_SESSION['status']=='u') { 
                                                            echo "<option value='".$_SESSION['user_id']."'>".$_SESSION['name']."</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Paid Installment Qnt</label>
                                                <input name="paid_qnt" type="text" class="form-control" required>
                                            </div>
                                        </div>




                                        

                                        <div class="col-md-12"><hr><h4>Guarantor 1</h4></div>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="gr1_name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="gr1_mobile" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>NID</label>
                                                <input name="gr1_nid" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="gr1_address" type="text" class="form-control">
                                            </div>
                                        </div>                          
                                        

                                        <div class="col-md-12"><hr><h4>Guarantor 2</h4></div>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input name="gr2_name" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="gr2_mobile" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>NID</label>
                                                <input name="gr2_nid" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input name="gr2_address" type="text" class="form-control">
                                            </div>
                                        </div>

                                        

                                        <div class="col-md-12"><hr>
                                            <button type="submit" class="btn btn-info pull-left" name="add" onclick="return confirm('Are you sure you want to Submit?');">Save</button>
                                        </div>
										
										
                                    </div>
                                </div>
                            </div>
                            
                        </div>        

                            
                    </form>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>