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

if($_GET["year"] != 'all'){
	$year = $_GET["year"];
	if(!empty($_GET["month"])){
		  $month = $_GET["month"];
		  $query_month = True;
	}
	else{
		$query_month = False;
	}
	$query_year = True;
	
} else {
	$query_year = False;
	$query_month = False;
}

$result = mysqli_query($conn, "SELECT DISTINCT YEAR(date) as years FROM historik ORDER BY YEAR(date) DESC");
$year_array = array();
while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
	$year_array[] = $row[0];
}
mysqli_free_result($result);

if(isset($_GET['group'])){
	$group = $_GET['group'];
	if($query_year == True && $query_month == False){
		$query = "SELECT DATE_FORMAT(ANY_VALUE(historik.date), '%Y-%m') as date, SUM(historik.effective_dose) as sum_eff, SUM(historik.skin_dose) as sum_skin, MAX(historik.effective_dose) as max_eff, COUNT(*) as count FROM historik LEFT JOIN personale on historik.name = personale.name WHERE personale.personel_type = '" . $group . "' AND YEAR(date) = '" . $year . "' GROUP BY YEAR(date), MONTH(date) ORDER BY " . $order_by . " " . $sorting;
		$page_url = 'show_group_dose.php?year=' . $year . '&group=' . $_GET["group"] . '&submit=Vis';
	} elseif($query_year == True && $query_month == True) {
		$query = "SELECT historik.name as name, SUM(historik.effective_dose) as sum_eff, SUM(historik.skin_dose) as sum_skin, SUM(historik.finger_dose) as sum_finger FROM historik JOIN personale ON historik.name = personale.name WHERE personale.personel_type = '" . $group . "' AND YEAR(date)='" . $year . "' AND MONTH(date) = '" . $month . "' GROUP BY historik.name ORDER BY historik.name ASC";
		$page_url = 'show_group_dose.php?year=' . $year . '&month=' . $month . '&group=' . $_GET["group"] . '&submit=Vis';
	} else {
		$query = "SELECT DATE_FORMAT(ANY_VALUE(historik.date), '%Y-%m') as date, SUM(historik.effective_dose) as sum_eff, SUM(historik.skin_dose) as sum_skin, MAX(historik.effective_dose) as max_eff, COUNT(*) as count FROM historik LEFT JOIN personale on historik.name = personale.name WHERE personale.personel_type = '" . $group . "' GROUP BY YEAR(date), MONTH(date) ORDER BY " . $order_by . " " . $sorting;
		$page_url = 'show_group_dose.php?year=all&group=' . $_GET["group"] . '&submit=Vis';
	}
} elseif(isset($_GET['category'])){
	$category = $_GET['category'];
	if($query_year == True && $query_month == False){
		$query = "SELECT DATE_FORMAT(ANY_VALUE(historik.date), '%Y-%m') as date, SUM(historik.effective_dose) as sum_eff, SUM(historik.skin_dose) as sum_skin, MAX(historik.effective_dose) as max_eff, COUNT(*) as count FROM historik LEFT JOIN personale on historik.name = personale.name WHERE personale.category = '" . $category . "' AND YEAR(date) = '" . $year . "' GROUP BY YEAR(date), MONTH(date) ORDER BY " . $order_by . " " . $sorting;
		$page_url = 'show_group_dose.php?year=' . $year . '&category=' . $_GET["category"] . '&submit=Vis';
	} elseif($query_year == True && $query_month == True) {
		$query = "SELECT historik.name as name, SUM(historik.effective_dose) as sum_eff, SUM(historik.skin_dose) as sum_skin, SUM(historik.finger_dose) as sum_finger FROM historik JOIN personale ON historik.name = personale.name WHERE personale.category = '" . $category . "' AND YEAR(date)='" . $year . "' AND MONTH(date) = '" . $month . "' GROUP BY historik.name ORDER BY historik.name ASC";
		$page_url = 'show_group_dose.php?year=' . $year . '&month=' . $month . '&category=' . $_GET["category"] . '&submit=Vis';
	} else {
		$query = "SELECT DATE_FORMAT(ANY_VALUE(historik.date), '%Y-%m') as date, SUM(historik.effective_dose) as sum_eff, SUM(historik.skin_dose) as sum_skin, MAX(historik.effective_dose) as max_eff, COUNT(*) as count FROM historik LEFT JOIN personale on historik.name = personale.name WHERE personale.category = '" . $category . "' GROUP BY YEAR(date), MONTH(date) ORDER BY " . $order_by . " " . $sorting;
		$page_url = 'show_group_dose.php?year=all&category=' . $_GET["category"] . '&submit=Vis';
	}
	
}

$result = mysqli_query($conn, $query);


$date_array = array();
$effective_dose_array = array();
$skin_dose_array = array();
$finger_dose_array = array();
$persons_array = array();
$n_meas = 0;

if(isset($_GET['group'])){
	$query_list = "SELECT historik.name, MAX(historik.id) as id, MAX(historik.date) as date, ANY_VALUE(historik.date), personale.personel_type FROM historik JOIN personale ON historik.name = personale.name WHERE personale.personel_type = '" . $group . "' GROUP BY historik.name ORDER BY historik.name ASC";
} elseif(isset($_GET['category'])){
	$query_list = "SELECT historik.name, MAX(historik.id) as id, MAX(historik.date) as date, ANY_VALUE(historik.date), personale.category FROM historik JOIN personale ON historik.name = personale.name WHERE personale.category = '" . $category . "' GROUP BY historik.name ORDER BY historik.name ASC";
}
$result_list = mysqli_query($conn, $query_list);
$list_of_ids = array();

while($row = mysqli_fetch_array($result_list)){
	array_push($list_of_ids,$row['id']);
}
if(sizeof($list_of_ids) == 0){
	echo '<div class="body_text">Ingen resultater. Prøv venligst igen</div>';
	echo html_footer();
	exit;
} else {
	$redirect_url = 'database.php?';
	for($i=0;$i<sizeof($list_of_ids);$i++){
		$redirect_url = $redirect_url . 'id[]=' . $list_of_ids[$i];
		//do not add '&' in the last iteration
		if($i<sizeof($list_of_ids)-1){
			$redirect_url = $redirect_url . '&';
		}
	}
}

if(isset($_GET['group'])){
	echo '<div class="body_text"><b>Viser samlede data for <a href="' . $redirect_url . '">' . $group . '</a></b></div>';
} elseif(isset($_GET['category'])){
	echo '<div class="body_text"><b>Viser samlede data for <a href="' . $redirect_url . '">' . $category . '</a></b></div>';
}

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
		<?php
			if(isset($_GET['group'])){
				echo('<input type="hidden" name="group" value="' . htmlspecialchars($_GET['group']) . '">');
			} elseif(isset($_GET['category'])){
				echo('<input type="hidden" name="category" value="' . htmlspecialchars($_GET['category']) . '">');
			}
		?>
		<input type="submit" name="submit" value="Vis"><br>
	</form>
	<table class="simple_table">
		<tr>
			<?php
				if($query_year == True && $query_month == True){	
					echo '<th><a class="header_links" href="' . $page_url . '"&order_by=name&sorting="' . $sort .'">Navn</a></th>';
				} else {
					echo '<th><a class="header_links" href="' . $page_url . '"&order_by=date&sorting="' . $sort . '">Dato</a></th>';
				}
			?>
			<th><a class="header_links" href="<?php echo $page_url . "&order_by=sum_eff&sorting=" . $sort;?>">Effektiv dosis (mSv)</a></th>
			<th><a class="header_links" href="<?php echo $page_url . "&order_by=sum_skin&sorting=" . $sort;?>">Huddosis (mSv)</a></th>
			<?php
				//if($query_year == False && $query_month == False){
				if($query_month == False){
					echo '<th># personer</th>';
					echo '<th>&mu;(effektiv dosis)</th>';
					echo '<th>&mu;(huddosis)</th>';
				}
			?>
		</tr>
		<?php
		$total_effective_dose = NULL;
		$total_skin_dose = NULL;
		$total_persons = NULL;

		while($row = mysqli_fetch_array($result)){
			$total_effective_dose += $row["sum_eff"];
			$total_skin_dose += $row["sum_skin"];
			$total_persons += (isset($row["count"]) ? $row["count"] : 0);
			
			if(isset($row["date"]) && isset($row["count"])){
				array_push($persons_array, $row["count"]);
				array_push($date_array, date('Y-m-d', strtotime($row["date"])));
			}
			array_push($effective_dose_array, $row["sum_eff"]);
			array_push($skin_dose_array, $row["sum_skin"]);
			
			$n_meas++;
			
		?>
			<tr>
				<?php
					if($query_year == True && $query_month == True){
						echo '<td>' . $row["name"] . '</td>';
					} else {
						$year = date('Y', strtotime($row["date"]));
						$month = date('m', strtotime($row["date"]));
						if(isset($_GET['group'])){
							echo '<td><a href="show_group_dose.php?year=' . $year . '&month=' . $month . '&group=' . $group . '">' . $row["date"] . '</a></td>';
						} elseif(isset($_GET['category'])){
							echo '<td><a href="show_group_dose.php?year=' . $year . '&month=' . $month . '&category=' . $category . '">' . $row["date"] . '</a></td>';
						}
					}
				?>
				<td align="center"><?php echo $row["sum_eff"]; ?></td>
				<td align="center"><?php echo $row["sum_skin"]; ?></td>
				<?php
					//if($query_year == False && $query_month == False){
					if($query_month == False){
						echo '<td align="center">' . $row["count"] . '</td>';
						echo '<td align="center">' . number_format($row["sum_eff"]/$row["count"],1) . '</td>';
						echo '<td align="center">' . number_format($row["sum_skin"]/$row["count"],1) . '</td>';
					}
				?>
			</tr>
	<?php  
		}
	?>
		<tr>
			<td colspan="1"><b>Total</b></td>
			<td align="center"><b><?php echo number_format($total_effective_dose,1); ?></b></td>
			<td align="center"><b><?php echo number_format($total_skin_dose,1); ?></b></td>
			<?php
				if($query_month == False){
					echo '<td align="center"><b>' . $total_persons . '</b></td>';
				}
			?>
			
		</tr>
		<tr>
			<td colspan="1"><b>Middelværdi</b></td>
			<td align="center"><b><?php echo number_format($total_effective_dose/$n_meas,1); ?></b></td>
			<td align="center"><b><?php echo number_format($total_skin_dose/$n_meas,1); ?></b></td>
			<?php
				if($query_month == False){
					echo '<td align="center"><b>' . number_format($total_persons/$n_meas) . '</b></td>';
				}
			?>
		</tr>
		<tr>
			<td colspan="1"><b>Median</b></td>
			<td align="center"><b><?php echo number_format(median($effective_dose_array),1); ?></b></td>
			<td align="center"><b><?php echo number_format(median($skin_dose_array),1); ?></b></td>
			<?php
				if($query_month == False){
					echo '<td align="center"><b>' . number_format(median($persons_array),1) . '</b></td>';
				}
			?>
		</tr>
		<tr>
			<td colspan="1"><b>&sigma;</b></td>
			<td align="center"><b><?php echo number_format(standard_deviation($effective_dose_array),1); ?></b></td>
			<td align="center"><b><?php echo number_format(standard_deviation($skin_dose_array),1); ?></b></td>
			<?php
				if($query_month == False){
					echo '<td align="center"><b>' . number_format(standard_deviation($persons_array),1) . '</b></td>';
				}
			?>
		</tr>
	</table>
</div>

<?php

if($query_year == False && $query_month == False){

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
}
echo '<br/>';
mysqli_close($conn);

echo html_footer();

?>

