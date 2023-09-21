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
mysqli_set_charset($conn, 'utf8');
		
// check if sort and order_by has been passed in query string otherwise default
$order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'name,id';
$static_order_by = (isset($_GET['order_by'])) ? $_GET['order_by'] : 'name,id';
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
			
//if ids are passed we should only display those
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$query = "SELECT ANY_VALUE(historik.id) as id, ANY_VALUE(historik.date) as date, 
					ANY_VALUE(historik.TLD) as TLD, 
					ANY_VALUE(historik.name) as name, 
					ANY_VALUE(personale.personel_type) as personel_type, 
					ANY_VALUE(personale.category) as category, 
					MAX(historik.date) as newest_date, 
					COUNT(*) as n_meas 
					FROM historik LEFT JOIN personale on historik.name = personale.name 
					WHERE historik.id IN (" . implode(',', $id) . ") AND historik.name != 'ekstra' GROUP BY personale.name ORDER BY name ASC";
	$result = mysqli_query($conn, $query);
	$total_rows = mysqli_num_rows($result); 
	$page_url = 'database.php?';
	$ids_passed = True;
	for($i=0;$i<sizeof($id);$i++){
		$page_url = $page_url . 'id[]=' . $id[$i];
		//this is not the last element. append & to $page_url string
		if($i < sizeof($id)-1){
			$page_url = $page_url . '&';
		}
	if(isset($_GET['page'])) {
		$page = preg_replace('#[^0-9]#i', '', $_GET['page']); // filter everything but numbers for security
		} 
	else {
		$page = 1;
		$last_page = 1;
		}
	}
	
//if no ids are passed we will display all entries in the database        
} else {
	//$query = "SELECT id, date, TLD, name, MAX(DATE) as newest_date, COUNT(*) as n_meas FROM historik WHERE name != 'ekstra' GROUP BY name ORDER BY " . $order_by . " " . $sorting;
	#$query = "SELECT historik.id, historik.date, historik.TLD, historik.name, personale.personel_type, MAX(historik.date) as newest_date, COUNT(*) as n_meas FROM historik LEFT JOIN personale on historik.name = personale.name WHERE historik.name != 'ekstra' GROUP BY personale.name ORDER BY " . $order_by . " " . $sorting;
	$query = "SELECT ANY_VALUE(historik.id) as id, 
				ANY_VALUE(historik.date) as date, 
				ANY_VALUE(historik.TLD) as TLD, 
				ANY_VALUE(historik.name) as name, 
				ANY_VALUE(personale.personel_type) as personel_type, 
				ANY_VALUE(personale.category) as category, 
				MAX(historik.date) as newest_date, 
				COUNT(*) as n_meas 
					FROM historik LEFT JOIN personale on historik.name = personale.name 
						GROUP BY historik.name ORDER BY " . $order_by . " " . $sorting;
	$result = mysqli_query($conn, $query);
	$total_rows = mysqli_num_rows($result); 
	if(isset($_GET['page'])) {
		$page = preg_replace('#[^0-9]#i', '', $_GET['page']); // filter everything but numbers for security
	} else {
		$page = 1;
	}
	
	//items per page
	$items_per_page = 20;
	$last_page = ceil($total_rows / $items_per_page);

	if ($page < 1) {
		$page = 1;
	} elseif ($page > $last_page) {
		$page = $last_page;
	}

	// define limit for mysql query
	$limit = 'LIMIT ' . ($page - 1) * $items_per_page . ',' . $items_per_page;

	// limit number of rows returned
	//$query = "SELECT id, date, TLD, name, MAX(DATE) as newest_date, COUNT(*) as n_meas FROM historik WHERE name != 'ekstra' GROUP BY name ORDER BY " . $order_by . " " . $sorting . " " . $limit;
	$query = "SELECT historik.id, historik.date, historik.TLD, historik.name, personale.personel_type, MAX(historik.date) as newest_date, COUNT(*) as n_meas FROM historik LEFT JOIN personale on historik.name = personale.name WHERE historik.name != 'ekstra' GROUP BY historik.name ORDER BY " . $order_by . " " . $sorting . " " . $limit;
	$query = "SELECT ANY_VALUE(historik.id) as id, ANY_VALUE(historik.date) as date, ANY_VALUE(historik.TLD) as TLD, ANY_VALUE(historik.name) as name, ANY_VALUE(personale.personel_type) as personel_type, ANY_VALUE(personale.category) as category, MAX(historik.date) as newest_date, COUNT(*) as n_meas FROM historik LEFT JOIN personale on historik.name = personale.name GROUP BY historik.name ORDER BY " . $order_by . " " . $sorting . " " . $limit;
	#echo $query;
	$result = mysqli_query($conn, $query);
	$page_url = 'database.php?';

	
}
			
			
// create numbers to click in between the next and back buttons
$center_pages = "";
$sub_1 = $page - 1;
$sub_2 = $page - 2;
$sub_3 = $page - 3;
$sub_4 = $page - 4;
$add_1 = $page + 1;
$add_2 = $page + 2;
$add_3 = $page + 3;
$add_4 = $page + 4;

if($page == 1) {
	$center_pages .= '&nbsp; <b>' . $page . '</b> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_2 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_2 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_3 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_3 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_4 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_4 . '</a> &nbsp;';
} elseif($page == 2) {
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <b>' . $page . '</b> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_2 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_2 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_3 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_3 . '</a> &nbsp;';
} elseif ($page == $last_page) {
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_4 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_4 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_3 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_3 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_2 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_2 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <b>' . $page . '</b> &nbsp;';
} elseif ($page > 2 && $page < ($last_page - 1)) {
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_2 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_2 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <b>' . $page . '</b> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_2 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_2 . '</a> &nbsp;';
} else if ($page > 1 && $page < $last_page) {
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_3 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_3 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_2 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_2 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $sub_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $sub_1 . '</a> &nbsp;';
	$center_pages .= '&nbsp; <b>' . $page . '</b> &nbsp;';
	$center_pages .= '&nbsp; <a href="database.php?page=' . $add_1 . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $add_1 . '</a> &nbsp;';
}

$pagination_display = "";
// more than 1 page
if ($last_page != "1"){
	// page x of y
	//$pagination_display .= 'Side <strong>' . $page . '</strong> af ' . $last_page. '&nbsp;  &nbsp;  &nbsp; ';
	$pagination_display .=  '&nbsp; <a title="Første side (1)" href="database.php?page=1&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '"> << </a> ';
		$previous = $page - 1;
		$pagination_display .=  '&nbsp;  <a title="Forrige side" href="database.php?page=' . $previous . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '"> < </a>';
	if ($page != 1) {
		//not first page
	}
	// center pages between << < & > >>
	//$pagination_display .= $center_pages . '... &nbsp;<a href="database.php?page=' . $last_page . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '">' . $last_page . '</a> ';
	$pagination_display .= $center_pages;
	if ($page != $last_page) {
		//not last page
	}
	$next_page = $page + 1;
	$pagination_display .=  '&nbsp;  <a title="Næste side" href="database.php?page=' . $next_page . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting . '"> ></a> ';
	$pagination_display .=  '&nbsp;  <a title="Sidste side (' . $last_page . ')" href="database.php?page=' . $last_page . '&order_by=' . $static_order_by . '&sorting=' . $static_sorting .'"> >></a> ';
}

echo(html_header());

if(empty($_GET['id'])){
	echo '<div align="center" class="body_text">' . $pagination_display . '</div>';
}
?>
		<div align="center">
			<form method="post" action="">
			<?php
				if( isset( $ids_passed ) && $ids_passed === True){
					echo '<br/><b>Antal personer i personalegruppe: ' . $total_rows . '</b>';
				}
			?>
				<table class="simple_table">
                    <tr>
                        <!--<th><a href="<?php echo $page_url . "&page=" . $page . "&order_by=id&sorting=" . $sort;?>">ID</a></th>-->
                        <th><a class="header_links" href="<?php echo $page_url . "&page=" . $page . "&order_by=date&sorting=" . $sort;?>">Sidste måling</a></th>
                        <th><a class="header_links" href="<?php echo $page_url . "&page=" . $page . "&order_by=name&sorting=" . $sort;?>">Navn</a></th>
                        <th><a class="header_links" href="<?php echo $page_url . "&page=" . $page . "&order_by=personel_type&sorting=" . $sort;?>">Personalegruppe</a></th>
                        <th><a class="header_links" href="<?php echo $page_url . "&page=" . $page . "&order_by=category&sorting=" . $sort;?>">Kategori</a></th>
                        <!--<th><a href="<?php echo $page_url . "&page=" . $page . "&order_by=n_meas&sorting=" . $sort;?>"># målinger</a></th>-->
                        <th><a class="header_links" href="<?php echo $page_url . "&page=" . $page . "&order_by=TLD&sorting=" . $sort;?>">Sidste TLD</a></th>
                        <!--<th>Ret data</th>-->
                        <!--<th>Slet?</th>-->
                    </tr>
			<?php
				while($row = mysqli_fetch_array($result)){
					$name = mb_convert_encoding($row["name"], 'UTF-8', mb_detect_encoding($row["name"], 'UTF-8, ISO-8859-1', true));
			?>
					<tr>
 
                        <td><?php echo date("m/Y", strtotime($row["newest_date"])); ?></td>
                        <td width="40%"><a href="<?php echo "show_dose.php?navn=" . urlencode($name) . "&year=all";?>"><?php echo $name;?></a></td>
                        <td><a href="<?php echo "show_group_dose.php?group=" . single_sql_value($conn, "SELECT personel_type FROM personale WHERE name LIKE '".$name."'", 0) . "&year=all";?>"><?php echo single_sql_value($conn, "SELECT personel_type FROM personale WHERE name LIKE '".$name."'", 0);?></a></td>
                        <td><a href="<?php echo "show_group_dose.php?category=" . single_sql_value($conn, "SELECT category FROM personale WHERE name LIKE '".$name."'", 0) . "&year=all";?>"><?php echo single_sql_value($conn, "SELECT category FROM personale WHERE name LIKE '".$name."'", 0);?></a></td>
                        <td><?php echo $row["TLD"]; ?></td>
                        
                    </tr>
		<?php  
			}
		?>
				</table>
			 </form>
		</div>
<?php
if(empty($_GET['id'])){
		echo '<div align="center" class="body_text">' . $pagination_display . '</div>';
}

echo(html_footer());
?>
     
</body>
</html> 
