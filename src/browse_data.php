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
	if($_POST['year'] == 'alle' && $_POST['personel_type'] == 'alle' && $_POST['category'] == 'alle'){
		$query = "SELECT MIN(date) as min_date, MAX(date) as max_date, MAX(effective_dose) as max_eff, MAX(skin_dose) as max_skin, MAX(finger_dose) as max_finger, AVG(effective_dose) as avg_eff, AVG(skin_dose) as avg_skin, AVG(finger_dose) as avg_finger, SUM(effective_dose) as sum_eff, SUM(skin_dose) as sum_skin, SUM(finger_dose) as sum_finger FROM historik GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
	} elseif(empty($_POST['name']) && $_POST['personel_type'] != 'alle'){
		$personel = $_POST['personel_type'];
		#$query = "SELECT * FROM historik,personale WHERE personale.personel_type = '" . $personel . "'";
		$query = "SELECT historik.name, MAX(historik.id) as id, MAX(historik.date) as date, historik.date, personale.personel_type FROM historik JOIN personale ON historik.name = personale.name WHERE personale.personel_type = '" . $personel . "' GROUP BY historik.name ORDER BY historik.name ASC";
	} elseif(!empty($_POST['date'])){
		$date = $_POST['date'];
		$query = "SELECT * FROM historik WHERE date LIKE '" . $_POST['date'] . "'";
	} else {
		echo '<div class="body_text">Der er ikke angivet nogen søgekriterier</div>';
		#echo(html_footer());
	}
	
	//echo $query;
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


// check if sort and order_by has been passed in query string otherwise default
$order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'date';
$static_order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'date';
$sorting = (isset($_GET['sorting'])) ? $_GET['sorting'] : 'desc';
$static_sorting = (isset($_GET['sorting'])) ? $_GET['sorting'] : 'desc';

//if the user presses the again we'll switch sorting            
switch($sorting) {
	case "asc":
		$sort = 'desc';
		break;
	case "desc":
		$sort = 'asc';
		break;
}

echo(html_header());

?>

<form method="post" action="">
		<table class="edit">
			<?php
				$result_year_list = mysqli_query($conn, "SELECT DISTINCT YEAR(date) FROM historik ORDER BY YEAR(date) DESC");
			?>
			<tr>
				<td>År: </td>
				
				<td>
					<select name="year" id="year">
						<option value="all">Alle år</option>
						<?php
							while($row = mysqli_fetch_array($result_year_list)){
								echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<?php
				$result_personel_list = mysqli_query($conn, "SELECT DISTINCT personel_type FROM personale WHERE personale.name != 'Ekstra' ORDER BY personale.personel_type ASC");
			?>
			<tr>
				<td>Personalegruppe: </td>
				<td>
					<select name="personel_type" id="personel_type">
						<option value="alle">Alle</option>
						<?php
							while($row = mysqli_fetch_array($result_personel_list)){
								echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<?php
				$result_category_list = mysqli_query($conn, "SELECT DISTINCT category FROM personale ORDER BY category ASC");
			?>
			<tr>
				<td>Sektion: </td>
				
				<td>
					<select name="category" id="category">
						<option value="all">Alle</option>
						<?php
							while($row = mysqli_fetch_array($result_category_list)){
								echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
							}
						?>
					</select>
				</td>
			</tr>

			<tr>
				<td colspan="3" align="right">
					<input type="button" value="Annuller" onClick="window.location.href='index.php'">
					<input type="reset" value="Slet">
					<input type="submit" name="submit" value="Søg">
				</td>
			</tr>
		</table>
</form>
