<?php

$arr1 = array('class' => 'a', '0', '2', '4', '6');
$arr2 = array('class' => 'b', '1', '3', '5', '7');

array_merge_diff($arr1, $arr2);

function array_merge_diff($arr1, $arr2)
{
	$merge_arrs = array_merge_recursive($arr1, $arr2);
	
	$merge_values = array();
	foreach ($merge_arrs as $key => $value) {
		
		$merge_values[$key] = $value;
		
		if (is_array($value)) 
		{
			$merge_values[$key] = implode(' ', $value);
		}
	}
	var_dump($merge_values);
}


?>
