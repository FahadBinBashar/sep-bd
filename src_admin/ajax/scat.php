<?php session_start(); ?>
<?php
	include '../db.php';
	if (($_SESSION['p'] != "") && ($_SESSION['p'] == $_SESSION['pp']))
	{	
	    $cat_id = $_POST['cat_id'];
?>
<option value="" selected="selected" disabled="disabled">Select</option>
	<?php
		$a = "select * from scat where sts = '1' AND cat_id = $cat_id";
		$query = mysqli_query($link, $a);
		while($data = mysqli_fetch_array($query)){
			echo "<option value='{$data[0]}'>{$data[1]}</option>";
		}
	?>
	
	
<?php
}
else {
		echo "<script>";
		echo "self.location='index.php?msg=Please Login First.';";
		echo "</script>";
	}	
?>