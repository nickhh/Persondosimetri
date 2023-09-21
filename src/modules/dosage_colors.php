<?php

function color_dose($type, $dose, $measurement_type){
$monthly_eff_max = 0.5;
$monthly_eff_mid = 0.3;
$monthly_eff_low = 0;

$monthly_skin_max = 12.5;
$monthly_skin_mid = 8.3;
$monthly_skin_low = 0;

$color_max = "#D8000C"; //red
$color_mid = "#FBB117"; //yellow/orange
$color_low = "#4F8A10"; //green
$color_default = "black"; //well.... 

$dose = (empty($dose)) ? 0 : $dose;
$type = (is_numeric($type) && $type >= 1990 && $type <= 2050) ? 'year' : $type;


switch ($type) {
    case "average":
        $month_count = 12;
        break;
    case "latest":
        $month_count = 1;
        break;
    case "sum":
        $month_count = 12;
        break;
    case "year":
        $month_count = 12;
        break;

    default:
        $month_count = 1;
}

//set the correct values for low,mid,max
if ($measurement_type == 'skin' || $measurement_type == 'finger'){
    $max = $monthly_skin_max * $month_count;
    $mid = $monthly_skin_mid * $month_count;
    $low = $monthly_skin_low * $month_count;
}
else{
    $max = $monthly_eff_max * $month_count;
    $mid = $monthly_eff_mid * $month_count;
    $low = $monthly_eff_low * $month_count;    
}


//color logic
if (abs($dose) > $max){ //check if dose is max
    
    return $color_max;
}

elseif(abs($dose) > $mid){ //check if dose is mid
    return $color_mid;
}

elseif(abs($dose) >= $low){ //check if dose is low
    return $color_low;
}

else{ // no match return black
    return $color_default;
}

}

?>