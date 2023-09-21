<?php

//return a single value from the database
function single_sql_value($con,$query,$column){
    $result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) == 0) {
		return('ikke oprettet');
		}
    $row = mysqli_fetch_array($result);
    $value = $row[$column];
    mysqli_free_result($result);
    return($value);
}


//return a standard html header
function html_header(){
	$site_page = basename($_SERVER['PHP_SELF']);
	$header = "";
	$header = $header . "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
	$header = $header . "<html>\n";
	$header = $header . "    <head>\n";
	$header = $header . "		 <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7; IE=EmulateIE9;\" >"; 
	$header = $header . "        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n";
	$header = $header . "        <title>Stråledosis - " . getenv('hospital_name') . "</title>\n";
	$header = $header . "        <link rel=\"stylesheet\" href=\"css/style.css\" type=\"text/css\" media=\"screen\" />\n";
	$header = $header . "		 <script src=\"js/ajax.js\"></script>\n";
	$header = $header . "		 <script src=\"js/chart.js\"></script>\n";
	$header = $header . "    </head>\n";
	$header = $header . "    <body onload=showData('sum')>\n";
	$header = $header . "        <div class=\"container\">\n";
	$header = $header . "			<ul>\n";
	$header = $header . "				<li><a " . ($site_page == 'index.php' ? 'class="active" ' : '') . "href=\"index.php?type=latest&submit=Vis\">Forside</a></li>\n";
	$header = $header . "				<li><a " . ($site_page == 'database.php' ? 'class="active" ' : '') . "href=\"database.php\">Database</a></li>\n";
	$header = $header . "				<li><a " . ($site_page == 'search.php' ? 'class="active" ' : '') . "href=\"search.php\">Søg</a></li>\n";
	$header = $header . "				<li style=\"float:right\"><a href=\"logout.php\">Log ud</a></li>\n";
	$header = $header . "			</ul>\n";

	return($header);
}

//return a standard html footer
function html_footer(){
	$footer = "";
	$footer = $footer . "<div class=\"copyright\">" . getenv('hospital_location') . "\n";
	$footer = $footer . "        </div>\n";
	$footer = $footer . "        </div>\n";
	$footer = $footer . "    </body>\n";
	$footer = $footer . "</html>\n";
  
	return($footer);
}

//using usort to sort multidimensional arrays
function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strcmp($a[$key], $b[$key]);
    };
}

function standard_deviation($aValues, $bSample = false){
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i){
        $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
}

function median($arr){
    if($arr){
        $count = count($arr);
        sort($arr);
        $mid = floor(($count-1)/2);
        return ($arr[$mid]+$arr[$mid+1-$count%2])/2;
    }
    return 0;
}


function year_generator($yearsToGoBack){
	$current_year = date('Y');
	$end_year = $current_year - $yearsToGoBack;

	for($index=$current_year;$index > $end_year; $index--) {
		echo '<option value="' . $index . '">' . $index . '</option>';
	}
}

function year_generator_index($yearsToGoBack, $selector = false){
	$current_year = date('Y');
	$end_year = $current_year - $yearsToGoBack;

	for($index=$current_year;$index > $end_year; $index--) {
		if ($selector = true){
			$selected = ($_GET['type'] == $index) ? 'selected' : '';
			echo '<option value="' . $index . '"' . $selected . '> Årsopgørelse for ' . $index . '</option>';
		}
		else{
			echo '<option value="' . $index . '">' . $index . '</option>';
		}
		
	}
}

?>
