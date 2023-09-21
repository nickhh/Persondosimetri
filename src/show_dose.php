<?php
require('modules/user_authentication.php');
require('modules/common_functions.php');
require('modules/monthFromDates.php');

echo(html_header());



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

if (!mysqli_query($conn, "SET NAMES UTF8")) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$name = (isset($_GET["navn"]) ) ? htmlspecialchars($_GET["navn"]) : "John+Doe";
$year = (isset($_GET["year"]) ) ? htmlspecialchars($_GET["year"]) : "all";
$date_array = array();
$effective_dose_array = array();
$skin_dose_array = array();
$finger_dose_array = array();
$total_effective_dose = 0;
$total_skin_dose = 0;
$total_finger_dose = 0;


if($_GET["year"] != 'all'){
	$year = $_GET["year"];
	$query_full = True;
} else {
	$query_full = False;
}


if($query_full){
	$query = "SELECT * FROM historik WHERE name='" . $name . "' AND YEAR(date)='" . $year . "' ORDER BY date DESC";
} else {
	$query = "SELECT * FROM historik WHERE name='" . $name . "' ORDER BY date DESC";
}
$result = mysqli_query($conn, $query);
$position = single_sql_value($conn, "SELECT personel_type FROM personale WHERE name='" . $name . "' LIMIT 1", 0);


$result_years = mysqli_query($conn, "SELECT DISTINCT YEAR(date) FROM historik WHERE name = '" . $name . "' ORDER BY YEAR(date) DESC");
$year_array = array();
while($row = mysqli_fetch_array($result_years, MYSQLI_NUM)){
	$year_array[] = $row[0];
}



echo '<div class="body_text"><b>Viser data for ' . $name . ' (<a href="show_group_dose.php?group=' . $position . '&year=all">' . $position . '</a>)</b></div>';

?>

<div align="center">
	<form method="GET" action="">
		<select name="year" id="year">
			<option value="all">Alle år</option>
			<?php
				foreach($year_array as $years){
					$is_selected = (trim($_GET['year']) == trim($years)) ? 'selected' : '';
					echo '<option value="' . $years . '" ' . $is_selected . '>' . $years .'</option>';
				}
			?>
		</select>
		<input type="hidden" name="navn" value="<?php echo htmlspecialchars($_GET['navn']);?>">
		<input type="submit" name="submit" value="Vis"><br>
	</form>
</div>

<div align="center">
	<table class="simple_table">
		<tr>
			<th>Dato</th>
			<th>TLD-film</th>
			<th>Effektiv dosis (mSv)</th>
			<th>Huddosis (mSv)</th>
			<th>Fingerdosis (mSv)</th>
			<th>Kommentar</th>
		</tr>
		<?php
		while($row = mysqli_fetch_array($result)){
			$total_effective_dose += $row["effective_dose"];
			$total_skin_dose += $row["skin_dose"];
			$total_finger_dose += $row["finger_dose"];
			if (isset( $n_meas ) ){
				$n_meas++;
			}
			else{
				$n_meas = 1;
			}
			array_push($date_array, date('Y-m-d', strtotime($row["date"])));
			array_push($effective_dose_array, $row["effective_dose"]);
			array_push($skin_dose_array, $row["skin_dose"]);
			array_push($finger_dose_array, $row["finger_dose"]);
			
			$bool_finger_dose = True;
			
	        if($row["effective_dose"] > 1){
				$color_eff = "#D8000C";
			} elseif($row["effective_dose"] >= 0.5){
				$color_eff = "#FBB117";
			} elseif($row["effective_dose"] >= 0){
				$color_eff = "#4F8A10";
			} else {
				$color_eff = "black";
			}
			
			if($row["skin_dose"] > 50){
				$color_skin = "#D8000C";
			} elseif($row["skin_dose"] > 25){
				$color_skin = "#FBB117";
			} elseif($row["skin_dose"] >= 0){
				$color_skin = "#4F8A10";
			} else {
				$color_skin = "black";
			}
				
			if($bool_finger_dose){		
				if($row["finger_dose"] > 40){
					$color_finger = "#D8000C";
				} elseif($row["finger_dose"] > 20){
					$color_finger = "#FBB117";
				} elseif($row["finger_dose"] >= 0){
					$color_finger = "#4F8A10";
				} else {
					$color_finger = "black";
				}
			} else {
				$color_finger = "black";
			}
		
			
		?>
			<tr>
				<td><?php echo $row["date"]; ?></td>
				<td><a href="edit.php?TLD=<?php echo $row["TLD"]; ?>&name=<?php echo $row["name"]; ?>"><?php echo $row["TLD"]; ?></a></td>
				<td align="center"><?php echo '<span style="color: ' . $color_eff . '">' . $row["effective_dose"]; ?></td>
				<td align="center"><?php echo '<span style="color: ' . $color_skin . '">' . $row["skin_dose"]; ?></td>
				<?php
				if(!is_null($row["finger_dose"])){
					echo '<td align="center"><span style="color: ' . $color_finger . '">' . $row["finger_dose"] . '</td>';
				} else {
					echo '<td align="center">Ikke målt</td>';
				}
				?>
				<td><?php echo $row["comment"]; ?></td>
			</tr>
	<?php  
		}
	?>
		<tr>
			<td colspan="2"><b>Total dosis</b></td>
			<td align="center"><b><?php echo number_format($total_effective_dose,1); ?></b></td>
			<td align="center"><b><?php echo number_format($total_skin_dose,1); ?></b></td>
			<?php
			if($bool_finger_dose){
				echo '<td align="center"><b>' . number_format($total_finger_dose,1) . '</b></td>';
			} else {
				echo '<td>/</td>';
			}
			?>
			
		</tr>
		<tr>
			<td colspan="2"><b>Middelværdi</b></td>
			<td align="center"><b><?php echo number_format($total_effective_dose/$n_meas,1); ?></b></td>
			<td align="center"><b><?php echo number_format($total_skin_dose/$n_meas,1); ?></b></td>
			<?php
			if($bool_finger_dose){
				echo '<td align="center"><b>' . number_format($total_finger_dose/$n_meas,1) . '</b></td>';
			} else {
				echo '<td>/</td>';
			}
			?>
		</tr>
		<tr>
			<td colspan="2"><b>Median</b></td>
			<td align="center"><b><?php echo number_format(median($effective_dose_array),1); ?></b></td>
			<td align="center"><b><?php echo number_format(median($skin_dose_array),1); ?></b></td>
			<?php
			if($bool_finger_dose){
				echo '<td align="center"><b>' . number_format(median($finger_dose_array),1) . '</b></td>';
			} else {
				echo '<td>/</td>';
			}
			?>
		</tr>
		<tr>
			<td colspan="2"><b>&sigma;</b></td>
			<td align="center"><b><?php echo number_format(standard_deviation($effective_dose_array),1); ?></b></td>
			<td align="center"><b><?php echo number_format(standard_deviation($skin_dose_array),1); ?></b></td>
			<?php
			if($bool_finger_dose){
				echo '<td align="center"><b>' . number_format(standard_deviation($finger_dose_array),1) . '</b></td>';
			} else {
				echo '<td></td>';
			}
			?>
		</tr>
	</table>
</div>

<?php

$months_for_chart = extract_months(array_reverse($date_array));
$months_for_chart = implode(',', $months_for_chart);
$effective_dose_array_chart = array_reverse($effective_dose_array);
$skin_dose_array_chart = array_reverse($skin_dose_array);

?>


<div class="chart-container">
	<canvas id="doseChart" height="400px"></canvas>
</div>
<script>
const ctx = document.getElementById('doseChart');
const labels = [<?php echo $months_for_chart; ?>];
const data = {
  labels: labels,
  datasets: [
    {
      label: 'Effektiv dosis',
      data: [<?php echo implode(',', $effective_dose_array_chart); ?>],
      borderColor: 'rgba(39, 56, 245, 0.8)',
      backgroundColor: 'rgba(39, 56, 245, 0.8)',
	  minBarLength: 7
    },
    {
      label: 'Huddosis',
      data: [<?php echo implode(',', $skin_dose_array_chart); ?>],
      borderColor: 'rgba(0, 199, 0, 0.8)',
      backgroundColor: 'rgba(0, 199, 0, 0.8)',
	  minBarLength: 7
    }
  ]};

const doseChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
		responsive: true,
		maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
				suggestedMax: 1
            }
        }
    }
});
</script>


<?php

echo '<br/>';
mysqli_close($conn);

echo html_footer();

?>

