<?php

function weeks($year, $month)
{
	$weeks = array();
	$cantidad_de_dias = cantidad_dias($year, $month);
	$num_day = 1;
	$week = array(1 => 'Sun', 2 => 'Mon', 3 => 'Tue', 4 => 'Wed', 5 => 'Thu', 6 => 'Fri', 7 => 'Sat');
	$start_week = false;
	
	$first_day = date("D", strtotime("$year-$month-01"));
	
	for ($i = 1; $i <= 6; $i++) {
		foreach ($week as $day) {
			
			if ($day == $first_day) $start_week = true;
			if ($num_day > $cantidad_de_dias) $start_week = false;
			
			if($start_week) {
				$weeks[$i][$day] = $num_day;
				$num_day++;
			} else {
				$weeks[$i][$day] = '';
			}
		}
	}
	
	return $weeks;
}

function cantidad_dias($year, $month)
{
	if (((fmod($year, 4) == 0) && (fmod($year, 100) != 0)) || (fmod($year, 400) == 0)) {
		$dias_febrero = 29;
	} else {
		$dias_febrero = 28;
	}
	
	switch ($month) {
		case '01': return 31; break;
		case '02': return $dias_febrero; break;
		case '03': return 31; break;
		case '04': return 30; break;
		case '05': return 31; break;
		case '06': return 30; break;
		case '07': return 31; break;
		case '08': return 31; break;
		case '09': return 30; break;
		case '10': return 31; break;
		case '11': return 30; break;
		case '12': return 31; break;
	}
}

function nombre_mes($mes)
{
	switch ($mes) {
		case '01': return 'Enero'; break;
		case '02': return 'Febrero'; break;
		case '03': return 'Marzo'; break;
		case '04': return 'Abril'; break;
		case '05': return 'Mayo'; break;
		case '06': return 'Junio'; break;
		case '07': return 'Julio'; break;
		case '08': return 'Agosto'; break;
		case '09': return 'Septiembre'; break;
		case '10': return 'Octubre'; break;
		case '11': return 'Noviembre'; break;
		case '12': return 'Diciembre'; break;
	}
}

function dos_digitos($num)
{
	if (strlen($num) == 1) return '0' . $num;
	if (strlen($num) == 2) return $num;
}

function mes_anterior($year, $month)
{
	if ($month == 1) {
		return 'y=' . ($year-1).'&m=12';
	} else {
		$new_month = $month-1;
		if (strlen($new_month) == 1) $new_month = '0' . $new_month;
		return 'y=' . $year.'&m='.$new_month; die;
	}
}

function mes_siguiente($year, $month)
{
	if ($month == 12) {
		return 'y=' . ($year+1).'&m=01';
	} else {
		$new_month = $month+1;
		if (strlen($new_month) == 1) $new_month = '0' . $new_month;
		return 'y=' . $year.'&m='.$new_month; die;
	}
}

?>