<?php 
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    if((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status']=='a' || $_SESSION['status']=='u')) {
?>
<!DOCTYPE html>
<html >
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
            <i class="fa fa-user-plus"></i> Add New Balance Sheet Head Name 
            <?php
                if (isset($_POST['add'])) {      

                    $data = array(
                        
                        'ledger_name'         => $this->input->post('name', true),
                        'ledger_type'        => $this->input->post('type', true),
                        'ledger_cat'        => $this->input->post('cat', true),
                        'sts'                => $this->input->post('sts', true)
                    );
                    $this->db->insert('bs_ledger_list', $data);

                    if ( $this->db->affected_rows() ) {
                        $this->session->set_flashdata('msg', '<font color=green>Save Success!</font>');
                        redirect(base_url('admin/bs_ledger_list'));
                    } else {
                        $this->session->set_flashdata('msg', '<font color=red>NOT Success!</font>');
                        redirect(base_url('admin/bs_ledger_add'));
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
                                <h4 class="pagetitleh2">Add New Balance Sheet Head Name</h4>

                                <div class="around10">
                                    <div class="row">
                                     <div class="col-md-3">
                                            <div class="form-group">
                                        <label>BS Head Name</label>
                                        <input autofocus="" name="name" type="text" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                    </div>
                                     <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value='Dr'>Debit</option>
                                                    <option value='Cr'>Credit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Categoy</label>
                                                <select name="cat" class="form-control" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value='A'>Asset</option>
                                                     <option value='L'>Liabilities</option>
                                                    <option value='I'>Income</option>
                                                    <option value='E'>Expense</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="sts" class="form-control" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option value='1'>Active</option>
                                                    <option value='0'>Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">&nbsp;</div>

                                       <div class="col-md-12"><hr>
                                            <button type="submit" class="btn btn-info pull-left" name="add">Save</button>
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