<?php
   defined('BASEPATH') or exit('No direct script access allowed');
   if ((isset($_SESSION['user_id'])) && (isset($_SESSION['pass'])) && ($_SESSION['status'] == 'a' || $_SESSION['status'] == 'u'))
   {
       error_reporting(0);
   ?>
<!DOCTYPE html>
<html >
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <?php $this
         ->load
         ->view('head'); ?>
         
   </head>
   <body class="hold-transition skin-blue fixed sidebar-mini">
      <div class="wrapper">
      <header class="main-header" id="alert">
         <?php $this
            ->load
            ->view('header'); ?>
      </header>
      <?php $this
         ->load
         ->view('menu_left'); ?>
      <div class="content-wrapper">
         <section class="content-header">
            <h1>
               <i class="fa fa-object-group"></i> Today's Collection (<?=date('d-m-Y') ?>)            
               <?php echo $this
                  ->session
                  ->flashdata('msg');
                  
                  
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
                     
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                           <?php echo "চিন্তা করনা ডাটা সেভ হয়ছে।";?><?php echo $this
                  ->session
                  ->flashdata('msg');
                  
                  
                  ?>
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
      <?php $this
         ->load
         ->view('f9'); ?>
   </body>
</html>
<?php
   }
   else
   {
       redirect('admin');
       echo "<center><div style='margin-top:50px; padding:20px; border-radius:10px; width:150px; background-color:pink;'>";
       echo "<a href='" . base_url() . "admin'>Please Login First</a>";
       echo "</div></center>";
   }
   ?>