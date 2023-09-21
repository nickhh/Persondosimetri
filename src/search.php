<?php
require('modules/user_authentication.php');
require('modules/common_functions.php');



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


if(isset($_POST['submit'])){
	
	if(!empty($_POST['name']) && $_POST['personel_type'] == 'alle'){
		$patient_cpr = $_POST['name'];
		$query = "SELECT * FROM historik WHERE name LIKE '%" . $_POST['name'] . "%'";
	} elseif(empty($_POST['name']) && $_POST['personel_type'] != 'alle'){
		$personel = $_POST['personel_type'];
		#$query = "SELECT * FROM historik,personale WHERE personale.personel_type = '" . $personel . "'";
		$query = "SELECT historik.name, MAX(historik.id) as id, MAX(historik.date) as date, personale.personel_type FROM historik JOIN personale ON historik.name = personale.name WHERE personale.personel_type = '" . $personel . "' GROUP BY historik.name ORDER BY historik.name ASC";
	} elseif(!empty($_POST['date'])){
		$date = $_POST['date'];
		$query = "SELECT * FROM historik WHERE date LIKE '" . $_POST['date'] . "'";
	} else {
		echo '<div class="body_text">Der er ikke angivet nogen søgekriterier</div>';
		#echo(html_footer());
	}

	$result = mysqli_query($conn, $query);
	$list_of_ids = array();

	while($row = mysqli_fetch_array($result)){
		array_push($list_of_ids,$row['id']);
	}
	if(sizeof($list_of_ids) == 0){
		echo '<div class="body_text">Ingen resultater. Prøv venligst igen</div>';
	} else {
		$redirect_url = 'database.php?';
		for($i=0;$i<sizeof($list_of_ids);$i++){
			$redirect_url = $redirect_url . 'id[]=' . $list_of_ids[$i];
			//do not add '&' in the last iteration
			if($i<sizeof($list_of_ids)-1){
				$redirect_url = $redirect_url . '&';
			}
		}
		#echo $redirect_url;
		header("location:" . $redirect_url);
	}
}

echo(html_header());


echo '<div class="body_text">Wildcards er allerede inkluderet
                             i søgningen (søgningen "søren" vil også giv hit på "sørensen"). Anvend derfor ikke * eller lignende'; 



?>

<form method="post" action="">
		<table class="simple_table">
			<tr>
				<td>Navn: </td>
				<td colspan="2">
					<input type="text" name="name" size="30">
				</td>
			</tr>
			<?php
				$query_select = "SELECT DISTINCT personel_type FROM personale WHERE personale.name != 'Ekstra' ORDER BY personale.personel_type ASC";
				$result_select = mysqli_query($conn, $query_select);
			?>
			<tr>
				<td>Personalegruppe</td>
				<td colspan="2">
					<select name="personel_type">
						<option value="alle">Alle</option>
						<?php
							while($row = mysqli_fetch_array($result_select)){
								echo "<option value='" . $row['personel_type'] . "'>" . $row['personel_type'] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>
<!--
			<tr>
				<td>Undersøgelsesdato</td>
				<td>
					<input type="date" name="patient_exam_date" size="10">
				</td>
				<td>
					format: YYYY-mm-dd
			</tr>
-->
			<tr>
				<td colspan="3" align="right">
					<input type="button" value="Annuller" onClick="window.location.href='index.php'">
					<input type="reset" value="Slet">
					<input type="submit" name="submit" value="Søg">
				</td>
			</tr>
		</table>
	</form>
	</div>
<p></p>
<?php

    echo(html_footer());
        
?>
