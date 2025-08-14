<?php session_start(); ?>
<?php
	include '../db.php';
	if (($_SESSION['p'] != "") && ($_SESSION['p'] == $_SESSION['pp']))
	{	
	    $deptId = $_POST['dep'];
?>
<option value="" selected="selected" disabled="disabled">Select</option>
	<?php
		$a = "select employee.id as id, employee.name as name, desig.name as desig from employee left join desig on desig.id = employee.desig_id  where employee.depart_id = '$deptId' ORDER BY employee.id";
		 
		$query = mysqli_query($link, $a);
		while($data = mysqli_fetch_array($query)){
		    echo "<option value='{$data['id']}'>{$data['name']} ({$data['desig']})</option>";
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