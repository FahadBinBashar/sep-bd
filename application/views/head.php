        <meta charset="utf-8">
        <title><?php 
                                if ($_SESSION['status']=='a') { 
                                    echo "SEP : ADMIN PANEL";
                                } elseif ($_SESSION['status']=='u') {
                                    echo "SEP : EMPLOYEE PANEL";
                                }
                            ?></title>       
                
        <link href="<?php echo base_url(); ?>img/s-favicon.png" rel="shortcut icon" type="image/x-icon">
        
	<link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/bootstrap.min.css">    
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/style-main.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/skin-darkblue.css">
	
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/font-awesome.min.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/ionicons.min.css">       
		
	<link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/blue.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/morris.css">       
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/jquery-jvectormap-1.2.2.css">        
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/datepicker3.css">       
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/daterangepicker-bs3.css">      
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/bootstrap3-wysihtml5.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/custom_style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>src_admin/src/bootstrap-datetimepicker.css">
        <!--print table-->
        <link href="<?php echo base_url(); ?>src_admin/src/jquery.dataTables.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>src_admin/src/buttons.dataTables.min.css" rel="stylesheet">
        
        <script src="<?php echo base_url(); ?>src_admin/src/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>src_admin/src/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>src_admin/src/bootstrap-datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>src_admin/src/date.js"></script>       
        <script src="<?php echo base_url(); ?>src_admin/src/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>src_admin/src/school-custom.js"></script>
        