<?php session_start(); ?>
<?php
	include '../db.php';
	if (($_SESSION['p'] != "") && ($_SESSION['p'] == $_SESSION['pp']))
    {		
        if($_POST['id'] == "user") {
            $campId = $_POST['camp'];
        ?>
        <option value="" selected="selected">Select</option>
        <?php
        	$a = "select * from user where status = 'u' and camp_id = '$campId'";
        	$query = mysqli_query($link, $a);
        	while($data = mysqli_fetch_array($query)){
        		echo "<option value='{$data[0]}'>{$data[1]}</option>";
        	}
        } 
        
        if($_POST['id'] == "gate") {
            $campId = $_POST['camp'];
        ?>
            <option value="" selected="selected">Select</option>
            <?php
            	$a = "select * from camp_gate where camp_id = '$campId'";
            	$query = mysqli_query($link, $a);
            	while($data = mysqli_fetch_array($query)){
            		echo "<option value='{$data[0]}'>{$data[2]} ({$data[3]})</option>";
            	}
        }
    }
	?>