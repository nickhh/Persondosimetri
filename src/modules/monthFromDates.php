<?php
function extract_months($date_array){
if (!is_array($date_array)){
    return false;
    }

$weekdays_da = $arrayName = array('Monday' => 'Mandag', 'Tuesday' => 'Tirsdag', 'Wednesday' => 'Onsdag',
    'Thursday' => 'Torsdag', 'Friday' => 'Fredag', 'Saturday' => 'Lørdag',
    'Sunday' => 'Søndag');
$month_array = array();

foreach($date_array as $date){
    $month = date("F",strtotime($date));
    $year = date("Y",strtotime($date));
    if (array_key_exists($month,$weekdays_da)){
        $da_month = $weekdays_da[$month];
        $month_array[] = "'$da_month $year'";
    }
    else{
        $month_array[] = "'$month $year'";
    }

}

return $month_array;

}
?>