<?php
require('modules/user_authentication.php');

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
$year_afdtotal = mysqli_real_escape_string($conn,$_GET['year']);
$n_examinations = array('2015'=>'31472', '2016'=>'35467', '2017'=>'36113', '2018'=>'36209', '2019'=>'37563', '2020'=>'');
if($year_afdtotal == 'sum'){
	$sql = "SELECT COUNT(*) as entries, p.personel_type, SUM(historik.effective_dose) as sum_eff, AVG(historik.effective_dose) as avg_eff, SUM(historik.skin_dose) as sum_skin, AVG(historik.skin_dose) as avg_skin, SUM(historik.finger_dose) as sum_finger, AVG(historik.finger_dose) as avg_finger FROM historik INNER JOIN (SELECT name, personel_type FROM personale) p ON p.name = historik.name WHERE p.name != 'ekstra' GROUP BY p.personel_type ORDER BY avg_eff DESC";
	$result = mysqli_query($conn, $sql);
	$total_n_examinations = array_sum($n_examinations);
} elseif($year_afdtotal <= '2050' && $year_afdtotal >= '2000'){
	$sql = "SELECT COUNT(*) as entries, 
	p.personel_type, 
	SUM(historik.effective_dose) as sum_eff, 
	SUM(historik.skin_dose) as sum_skin, 
	SUM(historik.finger_dose) as sum_finger, 
	AVG(historik.finger_dose) as avg_finger 
	FROM historik 
	INNER JOIN (SELECT name, 
						personel_type 
						FROM personale) 
						p ON p.name = historik.name 
						WHERE p.name != 'ekstra' AND YEAR(date)=$year_afdtotal GROUP BY p.personel_type ORDER BY personel_type DESC";
	$result = mysqli_query($conn, $sql);
}
			
				
?>
<div align="center">
	<table class="simple_table">
		<tr>
			<th>Personaletype</a></th>
			<th># målinger</a></th>
			<th>&Sigma;(eff. dosis)</a></th>
			<th>&Sigma;(huddosis)</a></th>
			<th>&Sigma;(fingerdosis)</th>
			<th>&mu;(fingerdosis)</th>
		</tr>
					
		<?php
			

			while($row = mysqli_fetch_array($result)){
				$entries 	= (is_numeric($row["entries"]) ? number_format($row["entries"], 0) : 'N/A');
				$sum_eff 	= (is_numeric($row["sum_eff"]) ? number_format($row["sum_eff"], 1) . ' mSv' : 'N/A');
				$sum_skin 	= (is_numeric($row["sum_eff"]) ? number_format($row["sum_skin"], 1) . ' mSv' : 'N/A');
				$sum_finger = ($row["sum_finger"] == NULL || !is_numeric($row["sum_finger"]) ? '/' : number_format($row["sum_finger"],1) . ' mSv');
				$avg_finger = ($row["avg_finger"] == NULL || !is_numeric($row["avg_finger"]) ? '/' : number_format($row["avg_finger"], 1) . ' mSv');

				echo '<tr>';
					echo '<td><a href="show_group_dose.php?group=' . $row["personel_type"] . '&year=all">' . $row["personel_type"] . '</a></td>';
					echo '<td align="center">' . $entries . '</td>';
					echo '<td align="center">' . $sum_eff . '</td>';
					echo '<td align="center">' . $sum_skin . '</td>';
					echo '<td align="center">' . $sum_finger . ' </td>';
					echo '<td align="center">' . $avg_finger . '</td>';
				echo '</tr>';
			}
		?>
		</tr>	
	</table>
</div>
