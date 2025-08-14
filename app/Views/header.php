<?php //echo "Please Renew Your Hosting & Domain Service. Server Will be Down at 5th December 2024"; ?>
                <a href="<?php echo base_url(); ?>admin/dashboard" class="logo">                 
                    <span class="logo-mini">S</span>                 
                    <span class="logo-lg"><img src="<?php echo base_url(); ?>img/s_logo.png" alt="" /></span>
                </a>             
                <nav class="navbar navbar-static-top" role="navigation">                  
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="col-md-5 col-sm-3 col-xs-5"> 
                        <span href="#" class="sidebar-session" style="font-family:Verdana;">
                            <?php 
                                if ($_SESSION['status']=='a') { 
                                    echo "ADMIN PANEL: SEP";
                                } elseif ($_SESSION['status']=='u') {
                                    echo "EMPLOYEE: SEP";
                                }
                            ?>
                            
                            <span id="updateTime"></span>
                        </span>
                    </div>
                    <div class="col-md-7 col-sm-9 col-xs-7">
                        <div class="pull-right">    
                            <span id="updateTime"></span>
                            
							<div class="navbar-custom-menu">
                                <ul class="nav navbar-nav"> 

									
									<li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
										<?php echo $_SESSION['name']; ?> (<?php echo $_SESSION['user_id']; ?>)								
										<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-user">
                                            <li><a href="<?= base_url() ?>/admin/change_password"><i class="fa fa-key"></i> Change Password</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="<?php echo base_url(); ?>logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                            </li>
                                        </ul>                             
                                    </li> 
									
                                </ul>
                            </div>
                        </div>
                    </div>   
                </nav>
				
<!--<script type="text/javascript">
	
	$(document).ready(function() {
		$('#updateTime').load('<?= base_url() ?>ajax/time.php');
	    $.ajaxSetup({ cache: false }); // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
	  
	  setInterval(function() {
	    $('#updateTime').load('<?= base_url() ?>ajax/time.php');
	  }, 100); // the "3000" 
	});

</script>-->