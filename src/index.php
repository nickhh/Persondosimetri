<?php
require('modules/user_authentication.php');
require('modules/common_functions.php');
require('modules/dosage_colors.php');



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
mysqli_set_charset($conn, 'utf8');

echo(html_header());

if (isset($_GET["type"])){
	$page_url = 'index.php?type=' . $_GET["type"] . '&submit=Vis';
}
else{
	$page_url = 'index.php?type=latest&submit=Vis';
	$_GET['type'] = "latest";
}

?>
<p>
<div align="center">
<form action="" method="GET">
	<select name="type">
		<!--<option value="">Vælg tipper</option>-->
		<option value="latest" <?php echo ($_GET['type'] == 'latest') ? 'selected' : '' ?>>Seneste</option>
		<option value="average" <?php echo ($_GET['type'] == 'average') ? 'selected' : '' ?>>Løbende gennemsnit (12 måneder)</option>
		<option value="sum" <?php echo ($_GET['type'] == 'sum') ? 'selected' : '' ?>>Løbende sum (12 måneder)</option>
		<?php year_generator_index(6, true); ?>
		<option value="afdtotal" <?php echo ($_GET['type'] == 'afdtotal') ? 'selected' : '' ?>>Afdelingsopgørelse</option>
	</select>
	<input type="submit" name="submit" value="Vis"/>
</form>

</div>
</p>

<?php
// check if sort and order_by has been passed in query string otherwise default
$order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'name';
$static_order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'name';
$sorting = (isset($_GET['sorting'])) ? $_GET['sorting'] : 'asc';
$static_sorting = (isset($_GET['sorting'])) ? $_GET['sorting'] : 'asc';

//if the user presses the again we'll switch sorting
switch($sorting) {
	case "asc":
		$sort = 'desc';
		break;
	case "desc":
		$sort = 'asc';
		break;
}



	if(isset($_GET['submit'])){
		$type = !isset($_GET['type']) ? 'NA' : mysqli_real_escape_string($conn,$_GET['type']);

		if($type == 'average'){
			$result_max = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(date) as max_date FROM historik LIMIT 1"));
			$max_date_value = $result_max['max_date'];
			#SELECT * FROM historik WHERE MONTH(CURRENT_DATE())-MONTH(date)<=3 AND YEAR(date) = YEAR(CURRENT_DATE()) AND name LIKE '%due%' ORDER BY `id` DESC
			#$sql = "SELECT MIN(date) as min_date, MAX(date) as max_date, name, MAX(effective_dose) as max_eff, MAX(skin_dose) as max_skin, MAX(finger_dose) as max_finger, AVG(effective_dose) as sum_eff, AVG(skin_dose) as sum_skin, AVG(finger_dose) as sum_finger FROM historik WHERE date BETWEEN (CURRENT_DATE() - INTERVAL 3.5 MONTH) AND CURRENT_DATE() AND name!='ekstra' GROUP BY name";
			$sql = "SELECT COUNT(*),
			MIN(historik.date) as min_date,
			MAX(historik.date) as max_date,
			historik.name,
			MAX(historik.effective_dose) as max_eff,
			MAX(historik.skin_dose) as max_skin,
			MAX(historik.finger_dose) as max_finger,
			AVG(historik.effective_dose) as sum_eff,
			AVG(historik.skin_dose) as sum_skin,
			AVG(historik.finger_dose) as sum_finger,
			ANY_VALUE(personale.personel_type) as personel_type,
			ANY_VALUE(personale.category) as category
			FROM historik LEFT JOIN personale on historik.name = personale.name
			WHERE date >= DATE_SUB('$max_date_value', INTERVAL 11 MONTH) AND historik.name!='ekstra'
			GROUP BY historik.name ORDER BY " . $order_by . " " . $sorting;
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				echo("Error description: " . mysqli_error($conn));
			  }
		} elseif($type == 'sum'){
			$result_max = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(date) as max_date FROM historik LIMIT 1"));
			$max_date_value = $result_max['max_date'];
			#$sql = "SELECT MIN(date) as min_date, MAX(date) as max_date, name, MAX(effective_dose) as max_eff, MAX(skin_dose) as max_skin, MAX(finger_dose) as max_finger, SUM(effective_dose) as sum_eff, SUM(skin_dose) as sum_skin, SUM(finger_dose) as sum_finger FROM historik WHERE date BETWEEN (CURRENT_DATE() - INTERVAL 3.5 MONTH) AND CURRENT_DATE() AND name!='ekstra' GROUP BY name";
			$sql = "SELECT MIN(date) as min_date,
			MAX(date) as max_date,
			historik.name,
			MAX(historik.effective_dose) as max_eff,
			MAX(historik.skin_dose) as max_skin,
			MAX(historik.finger_dose) as max_finger,
			SUM(historik.effective_dose) as sum_eff,
			SUM(historik.skin_dose) as sum_skin,
			SUM(historik.finger_dose) as sum_finger,
			ANY_VALUE(personale.personel_type) as personel_type,
			ANY_VALUE(personale.category) as category
			FROM historik LEFT JOIN personale on historik.name = personale.name
			WHERE date >= DATE_SUB('$max_date_value', INTERVAL 11 MONTH) AND historik.name!='ekstra'
			GROUP BY historik.name ORDER BY " . $order_by . " " . $sorting;
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				echo("Error description: " . mysqli_error($conn));
			  }

		} elseif($type <= '2050' && $type >= '2000'){
			$sql = "SELECT MIN(historik.date) as min_date,
			MAX(historik.date) as max_date,
			historik.name,
			MAX(historik.effective_dose) as max_eff,
			MAX(historik.skin_dose) as max_skin,
			MAX(historik.finger_dose) as max_finger,
			SUM(historik.effective_dose) as sum_eff,
			SUM(historik.skin_dose) as sum_skin,
			SUM(historik.finger_dose) as sum_finger,
			ANY_VALUE(personale.personel_type) as personel_type,
			ANY_VALUE(personale.category) as category
			FROM historik LEFT JOIN personale on historik.name = personale.name
			WHERE YEAR(date) = '$type' GROUP BY historik.name ORDER BY " . $order_by . " " . $sorting;

			$result = mysqli_query($conn, $sql);
		} elseif($type == 'latest'){
			#$sql = "SELECT MAX(date) as max_date, MAX(date) as min_date, name, effective_dose as max_eff, skin_dose as max_skin, finger_dose as max_finger, effective_dose as sum_eff, skin_dose as sum_skin, finger_dose as sum_finger FROM historik WHERE name != 'ekstra' GROUP BY name";
			#$sql = "SELECT historik.name, date as max_date, date as min_date, effective_dose as max_eff, skin_dose as max_skin, finger_dose as max_finger, effective_dose as sum_eff, skin_dose as sum_skin, finger_dose as sum_finger FROM historik t2 INNER JOIN( SELECT MAX(date) as MaxDate, name FROM historik GROUP BY name ) t1 ON t1.MaxDate = t2.date and t1.name = t2.name ORDER BY t2.name";
			#$sql = "SELECT historik.name, historik.date as max_date, historik.date as min_date, historik.effective_dose as max_eff, historik.skin_dose as max_skin, historik.finger_dose as max_finger, historik.effective_dose as sum_eff, historik.skin_dose as sum_skin, historik.finger_dose as sum_finger FROM historik INNER JOIN( SELECT MAX(date) as MaxDate, name FROM historik GROUP BY name) t1 ON t1.MaxDate = historik.date and t1.name = historik.name ORDER BY ". $order_by . " " . $sorting;
			$sql = "SELECT historik.name,
			historik.date as max_date,
			historik.date as min_date,
			historik.effective_dose as max_eff,
			historik.skin_dose as max_skin,
			historik.finger_dose as max_finger,
			historik.effective_dose as sum_eff,
			historik.skin_dose as sum_skin,
			historik.finger_dose as sum_finger,
			personale.personel_type as personel_type,
			personale.category as category
			FROM historik
			INNER JOIN(SELECT MAX(DATE_FORMAT(date, '%Y-%m')) as newest_date FROM historik) m ON m.newest_date = DATE_FORMAT(historik.date, '%Y-%m')
			LEFT JOIN personale on historik.name = personale.name
			WHERE historik.name != 'ekstra' ORDER BY " . $order_by . " " . $sorting;
			$result = mysqli_query($conn, $sql);
		} elseif($type == 'afdtotal'){
			#$sql = "SELECT MIN(date) as min_date, MAX(date) as max_date, name, MAX(effective_dose) as max_eff, MAX(skin_dose) as max_skin, MAX(finger_dose) as max_finger, AVG(effective_dose) as avg_eff, AVG(skin_dose) as avg_skin, AVG(finger_dose) as avg_finger, SUM(effective_dose) as sum_eff, SUM(skin_dose) as sum_skin, SUM(finger_dose) as sum_finger FROM historik WHERE YEAR(date)> '2014' GROUP BY YEAR(date) ORDER BY " . $order_by . " " . $sorting;
			#$sql = "SELECT MIN(date) as min_date, MAX(date) as max_date, name, MAX(effective_dose) as max_eff, MAX(skin_dose) as max_skin, MAX(finger_dose) as max_finger, AVG(effective_dose) as avg_eff, AVG(skin_dose) as avg_skin, AVG(finger_dose) as avg_finger, SUM(effective_dose) as sum_eff, SUM(skin_dose) as sum_skin, SUM(finger_dose) as sum_finger FROM historik WHERE YEAR(date)> '2014' GROUP BY YEAR(date) ORDER BY date DESC";
			$sql = "SELECT MIN(date) as min_date,
			MAX(date) as max_date,
			MAX(effective_dose) as max_eff,
			MAX(skin_dose) as max_skin,
			MAX(finger_dose) as max_finger,
			AVG(effective_dose) as avg_eff,
			AVG(skin_dose) as avg_skin,
			AVG(finger_dose) as avg_finger,
			SUM(effective_dose) as sum_eff,
			SUM(skin_dose) as sum_skin,
			SUM(finger_dose) as sum_finger
			FROM historik
			WHERE YEAR(date)> '2014'
			GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
			$result = mysqli_query($conn, $sql);
			#$sql_med = "SELECT SUM(effective_dose) as effective, SUM(skin_dose) as skin FROM historik WHERE YEAR(date)=2016 GROUP BY name";
			#$result_med = mysqli_query($conn, $sql_med);
			$n_examinations = array('2015'=>'31472', '2016'=>'35467', '2017'=>'36113', '2018'=>'36209', '2019'=>'37563', '2020'=>'');
		} else {
			$sql = "SELECT id, MIN(date) as min_date, MAX(date) as max_date, name, MAX(effective_dose) as max_eff, MAX(skin_dose) as max_skin, SUM(effective_dose) as sum_eff, SUM(skin_dose) as sum_skin FROM (SELECT * FROM historik ORDER BY id DESC) AS x GROUP BY name ORDER BY " . $order_by . " " . $sorting;
			$result = mysqli_query($conn, $sql);
		}


		if($type!='afdtotal'){
		?>
		<div align="center">
			<table class="simple_table">
				<tr>
					<th>Datointerval</th>
					<th><a class="header_links" href="<?php echo $page_url . "&order_by=name&sorting=" . $sort;?>">Navn</a></th>
					<th>Stilling</th>
					<th>Category</th>
					<th><a class="header_links" href="<?php echo $page_url . "&order_by=sum_eff&sorting=" . $sort;?>">Effektiv dosis</a></th>
					<th><a class="header_links" href="<?php echo $page_url . "&order_by=sum_skin&sorting=" . $sort;?>">Huddosis</a></th>
					<th><a class="header_links" href="<?php echo $page_url . "&order_by=sum_finger&sorting=" . $sort;?>">Fingerdosis</th>
				</tr>
		<?php
		} else {
		?>
		<div align="center">
			<table class="simple_table">
				<tr>
					<th>Datointerval</a></th>
					<!--<th># undersøgelser</a></th>-->
					<th>&Sigma;(effektiv dosis)</a></th>
					<!--<th>&Sigma;(effektiv dosis) / us.</a></th>-->
					<th>&mu;(effektiv dosis)</a></th>
					<th>&Sigma;(huddosis)</a></th>
					<th>&mu;(huddosis)</a></th>
					<th>&Sigma;(fingerdosis)</th>
					<th>&mu;(fingerdosis)</th>
				</tr>
		<?php
		}

		while($row = mysqli_fetch_array($result)){
			if($type != 'afdtotal'){
				$name = mb_convert_encoding($row["name"], 'UTF-8', mb_detect_encoding($row["name"], 'UTF-8, ISO-8859-1', true));
				$color_eff 		= color_dose($type, $row["sum_eff"], "eff");
				$color_skin 	= color_dose($type, $row["sum_skin"], "skin");
				$color_finger 	= color_dose($type, $row["sum_finger"], "finger");

		?>
				<tr>
					<td><?php echo date("m/Y", strtotime($row["min_date"])) . ' - ' . date("m/Y", strtotime($row["max_date"])); ?></td>
					<td width="35%"><a href="<?php echo "show_dose.php?navn=" . urlencode($name) . "&year=all";?>"><?php echo $name;?></a></td>
					<td><?php echo $row['personel_type']?></td>
					<td><?php echo $row['category']?></td>

						<td align="center"><?php echo '<span style="color: ' . $color_eff . '">' . number_format($row["sum_eff"],1) . ' (' . $row["max_eff"] . ') mSv</span>'; ?></td>
						<td align="center"><?php echo '<span style="color: ' . $color_skin . '">' . number_format($row["sum_skin"],1) . ' (' . $row["max_skin"] . ') mSv</span>'; ?></td>
						<td align="center"><?php echo is_null($row["sum_finger"]) ? '/' : '<span style="color: ' . $color_finger . '">' . number_format($row["sum_finger"],1) . ' (' . $row["max_finger"] . ') mSv</span>'; ?> </td>

				</tr>
			<?php
			} else {
			?>
				<tr>
					<td><?php echo date("m/Y", strtotime($row["min_date"])) . ' - ' . date("m/Y", strtotime($row["max_date"])); ?></td>

					<td align="center"><?php echo number_format($row["sum_eff"],1);?> mSv</td>

					<td align="center"><?php echo number_format($row["avg_eff"],1);?> mSv</td>
					<td align="center"><?php echo number_format($row["sum_skin"],1);?> mSv</td>
					<td align="center"><?php echo number_format($row["avg_skin"],1);?> mSv</td>
					<td align="center"><?php echo number_format(empty($row["sum_finger"]) ? '0' : $row["sum_finger"],1);?> mSv</td>
					<td align="center"><?php echo number_format(empty($row["avg_finger"]) ? '0' : $row["avg_finger"],1);?> mSv</td>

				</tr>

			<?php
				#print_r(mysqli_fetch_array($result_med));
			}
		}
	?>
			</table>
		</div>

		<!--PERSONEL CUMULATIVE-->

	<?php
		if($type == 'afdtotal'){
	?>
			<div align="center">
				<form>
					<select name="year" onchange="showData(this.value)">
						<option value="sum">Totalt</option>
						<?php year_generator(5); ?>
					</select>
				</form>
			</div>
			<div id="dynamicdata">tabeloutput</div>
	<?php
		}
	}
	?>



<?php
echo(html_footer());
?>

</body>
</html>
