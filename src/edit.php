<?php

require('modules/user_authentication.php');
include('modules/common_functions.php');



//configuration of database
$db_host = getenv('mysql_addr');
$db_user = getenv('mysql_user');
$db_password = getenv('mysql_pass');
$db = getenv('mysql_dosedb');

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo html_header();

$name = $_GET['name'];
$year = ( isset( $_GET['year'] ) ) ? $_GET['year'] : NULL;
$TLD = $_GET['TLD'];

//get the elements from the form and insert them into the database
if(isset($_POST['submit'])){
		$comment = $_POST['comment'];

		$creation_date = date('Y-m-d H:i:s');
		$query = "UPDATE historik SET comment='$comment' where TLD='$TLD'";
		
		if($result = mysqli_query($conn, $query)){
			header('location:show_dose.php?navn=' . $name . '&year=all');
		} else {
			echo 'Ups. Pinligt!<br>' . mysqli_error($conn) . '<br>';
		}
}
		
//MySQL data for TLD
$result = mysqli_query($conn, "SELECT * FROM historik WHERE TLD='" . $TLD . "'");
$row = mysqli_fetch_array($result);
?>

<form method="post" action="">
	<table class="edit">
		<tr>
			<td>Dato:</td>
			<!--<td><input type="date" name="date" value="<?php echo $row['date'] == '' ? '' : $row['date']; ?>" /></td>-->
			<td><?php echo $row['date']; ?></td>
		</tr>
		<tr>
			<td>Navn:</td>
			<!--<td><input type="text" name="name" value="<?php echo $row['name'] == '' ? '' : $row['name']; ?>" /></td>-->
			<td><?php echo $row['name']; ?></td>
		</tr>
		<tr>
			<td>TLD:</td>
			<!--<td><input type="text" name="TLD" value="<?php echo $row['TLD'] == '' ? '' : $row['TLD']; ?>" /></td>-->
			<td><?php echo $row['TLD']; ?></td>
		</tr>
		<tr>
			<td>Kommentar:</td>
			<!--<td><input type="text" name="comment" value="<?php echo $row['comment'] == '' ? '' : $row['comment']; ?>" /></td>-->
			<td><textarea name="comment" rows="10" cols="70" /><?php echo $row['comment'] == '' ? '' : $row['comment']; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="button" value="Annuller" onClick="window.history.go(-1);return false;">
				<input type="submit" name="submit" value="Gem">
			</td>
		</tr>
	</table>
</form>
<?php

echo(html_footer());

?>
