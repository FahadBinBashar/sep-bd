<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (isset($_SESSION['user_id']) && isset($_SESSION['pass']) && ($_SESSION['status'] == 'a' || $_SESSION['status'] == 'u')) {
?>
<!DOCTYPE html>
<html >
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <?php
    $this->load->view('head');
?>
   </head>
   <body class="hold-transition skin-blue fixed sidebar-mini">
      <div class="wrapper">
      <header class="main-header" id="alert">
         <?php
    $this->load->view('header');
?>
      </header>
      <?php
    $this->load->view('menu_left');
?>
      <div class="content-wrapper">
         <section class="content-header">
            <h1>
               <i class="fa fa-object-group"></i> Account List of <?= get_name_by_auto_id('employee', $_GET['employee_id'], 'name') ?>
               <?php
    echo $this->session->flashdata('msg');
?>
            </h1>
         </section>
         <!-- Main content -->
         <section class="content">
            <div class="row">
               <!-- left column -->
               <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">
                     <div class="box-header ptbnull">
                        <h3 class="box-title titlefix">Account List (<?= $cnt ?>)</h3>
                        <div class="box-tools pull-right">
                        </div>
                        <!-- /.box-tools -->
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                           <table class="table table-striped table-bordered table-hover example">
                              <thead>
                                 <tr>
                                    <th>SL</th>
                                    <th width="50">Picture</th>
                                    <th>Name</th>
                                    <th>Zone</th>
                                    <th>A/C ID</th>
									<th>SBL</th>
									<th>Loan ID</th>
									<th>L-figure</th>
									<th>Installment</th>
                                    <th>View</th>
                                    <?
    								if ($_SESSION['status'] == 'a') {
									?>
                                    <th>Action</th>
                                    <?
    }
?>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr style="background: cadetblue">
                                                                        
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
									<th>-</th>
									<th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
									<th>-</th>
                                   
                                   
                                 </tr>
                                 <?php
  	$SL=1;
    foreach ($list as $key => $result) {
?>
		  <tr>
		  <td style="border: 1px solid #ddd;"><?= $SL++ ?></td>
 	      <td style="border: 1px solid #ddd;">
            
            <img src="<?php echo base_url();?>img/<?= $result->pic ?>" style="width:40px; height:40px; border-radius:40px;"> 
          	
            <?  $total_qnt='';
				$loan_id='';
      			$currect_date=date('Y-m-d');
    			$query = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00')");
        		$rows = $query->num_rows();
      			if ( $rows > 0 ) 
                
                {                
      				 $queryll =  $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00')");
                     foreach ($queryll->result() as $values) {
                     $loan_id=$values->id;
					 $loan_amt=$values->loan_amount;
                     $total_qnt = $values->installment_qnt;
                     }
                     $cnnt = 0;
                     $queryc = $this->db->select('*')->from('loan_collection')->where('loan_id', $loan_id)->where('sts', 1)->get();
                     foreach ($queryc->result() as $valuec) {
                     $cnnt = $cnnt+$valuec->qnt;
                     }
                 $cnnt;
                   
                } else {} 
                 $queryl = $this->db->query("select * from account_loan where account_id = '$result->id' and pdate <= '$currect_date' AND (cdate>'$currect_date' OR cdate='0000-00-00')");
                  foreach ($queryl->result() as $values) {
                                                
                    $loan_date=$values->last_date;
                    $today=date('Y-m-d');
                    if($loan_date <= $today &&  $total_qnt!=$cnnt){
                     echo"<i class='fa fa-legal' style='font-size:24px;color:red'></i>";
                     }
                                                
                   }
                 ?> 
            
            
            
            
          </td>
          <td style="border: 1px solid #ddd;"><?= $result->name ?></td>
          <td style="border: 1px solid #ddd;"><?= get_name_by_auto_id('zone', $result->zone_id, 'name') ?></td>
          <td style="border: 1px solid #ddd;"><?= $result->id ?></td>
		  <td style="border: 1px solid #ddd;"><? $sb=$this->admin_model->saving_balance($result->id);if($sb!=''){echo $sb;}else{ echo "<font color=red>0</font>";} ?></td>
		  <td style="border: 1px solid #ddd;"><? if($loan_id!=''){echo $loan_id;}else{ echo "<font color=red>0</font>";} ?></td>
		  <td style="border: 1px solid #ddd;"><? if($loan_id!=''){echo $loan_amt;}else{$loan_amt = 0;  echo "<font color=red>0</font>";}?></td>
		  <td style="border: 1px solid #ddd;"><? if($loan_id!=''){echo $total_qnt."/".$cnnt;}else{$total_qnt = 0;$cnnt = 0; $loan_id = '';  echo "<font color=red>0</font>";}?></td>
		  <td style="border: 1px solid #ddd;">
                                             
                                            <a href="<?= base_url() ?>admin/account_details/<?= $result->id ?>" target="_blank">View</a>
                                        </td> 
          <td class="text-right" style="border: 1px solid #ddd;">
        <?
		
        if ($_SESSION['status'] == 'a' && $total_qnt == $cnnt && $loan_id != null) {
            
?>
                                       <!--<a href="<?= base_url() ?>admin/account_loan_close/<?= $loan_id ?>/<?= $_GET['employee_id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Loan Delete" onclick="return confirm('Are you sure you want to close this loan ?');"><i class="fa fa-remove"></i>Loan Close</a>-->
                                       <button type="button" class="btn btn-warning btn-xs lcdelete" data-id="<?php echo $loan_id ?>"><i class="fa fa-remove"></i> Loan Close</button>
                                       <?
        } elseif ($_SESSION['status'] == 'a') {
?>
                                       <?
        }
?>
                                       <a href="<?= base_url() ?>admin/account_edit?id=<?= $result->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                       <?
        if ($_SESSION['status'] == 'a' && $sb=='0' && $loan_id=='') {
?>
                                       <!--<a href="<?= base_url() ?>admin/account_close/<?= $result->id ?>/<?= $_GET['employee_id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="AC Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-remove"></i>AC Close</a>-->
                                       <button type="button" class="btn btn-danger btn-xs acdelete" data-id="<?php echo $result->id ?>"><i class="fa fa-remove"></i> AC Close</button>
                                        <?
        }
?>
                                    </td>
                                    <?php
    }
?>
                                 </tr>
                              </tbody>
                              
                           </table>
                           <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                     </div>
                     <!-- /.box-body -->
                  </div>
               </div>
               <!--/.col (left) -->
               <!-- right column -->
            </div>
            <div class="row">
               <!-- left column -->
               <!-- right column -->
               <div class="col-md-12">
               </div>
               <!--/.col (right) -->
            </div>
            <!-- /.row -->
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      
      <script>
$(document).ready(function() {
	
	$(document).on("click", ".acdelete", function() { 

if (confirm("Are you sure you want to delete this record?")) {
		var $ele = $(this).parent().parent();
		$.ajax({
			url: "<?php echo base_url("admin/account_close");?>",
			type: "POST",
			cache: false,
			data:{
				type: 2,
				id: $(this).attr("data-id")
			},
			success: function(dataResult){
				//alert(dataResult);
				var dataResult = JSON.parse(dataResult);
				if(dataResult.statusCode==200){
					$ele.fadeOut().remove();
				}
			}
		});
        }
	});
	
	$(document).on("click", ".lcdelete", function() { 

if (confirm("Are you sure you want to delete this Loan?")) {
		var $loan = $(this).parent().parent();
		$.ajax({
			url: "<?php echo base_url("admin/account_loan_close");?>",
			type: "POST",
			cache: false,
			data:{
				type: 2,
				id: $(this).attr("data-id")
			},
			success: function(dataResult){
				//alert(dataResult);
				var dataResult = JSON.parse(dataResult);
				if(dataResult.statusCode==200){
					$loan.fadeOut().remove();
				}
			}
		});
        }
	});
});
</script>
      <?php
    $this->load->view('f9');
?>
   </body>
</html>
<?php
} else {
    redirect('admin');
    echo "<center><div style='margin-top:50px; padding:20px; border-radius:10px; width:150px; background-color:pink;'>";
    echo "<a href='" . base_url() . "admin'>Please Login First</a>";
    echo "</div></center>";
}
?>
