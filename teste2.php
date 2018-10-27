<?php

require_once 'functions.php';

$cp = array(6.30, 5.64, 5.42, 5.35, 5.22, 5.16, 4.72, 4.39, 3.79, 3.39, 2.49, 1.94);
/*$cp[2] = array(4.6, 4.69, 4.76, 4.85, 4.77, 4.53, 4.02, 3.41, 2.48, 2.05, 1.81);
$cp[3] = array(5.41, 5.04, 4.86, 5.01, 4.52, 3.74, 2.99, 2.43, 1.63);
$cp[4] = array(4.09, 4.03, 3.7, 3.32, 2.74, 2.55, 1.96);
$cp[5] = array(4.13, 3.63, 3.41, 3.24, 3.03, 2.93, 2.77, 2.76);*/

$golpes = array(1, 2, 3, 4, 6, 8, 12, 16, 24, 32, 48, 64, 96, 128, 192, 256);

foreach ($golpes as $key => $value) {
	$minimcv[$key] = 10*log10($value);
}

foreach ($cp as $key => $value) {
	$dif[$key] = abs($value - 2);
}

$num = count($cp);
$menor_dif = $dif[0];

for ($i=1; $i < $num ; $i++) { 
	if ($dif[$i] < $menor_dif) {
		$menor_dif = $dif[$i];
	}
}

foreach ($cp as $key => $value) {
	if ($value == abs($menor_dif - 2)) {
		$r_x[2] = $golpes[$key];
		$r_y[2] = $value;
		$r_x[1] = $golpes[$key - 1];
		$r_y[1] = $cp[$key - 1];
		$r_x[0] = $golpes[$key - 2];
		$r_y[0] = $cp[$key - 2];
	}
}

$x = array(11.14, 11.76, 14.31, 15.91, 16.02);
$y = array(129.21, 75.73, 143.59, 141.66, 162.61);

$menor_x = $x[0];
$maior_x = 0;
$menor_y = $y[0];
$maior_y = 0;
$x_c[0] = $x[0];
$y_c[0] = $y[0];
$x_d[0] = $x[0];
$y_d[0] = $y[0];
$cont_c = 0;
$cont_d = 0;

for ($i=0; $i < 5; $i++) { 
	if($x[$i] > $maior_x && $y[$i] > $maior_y){
		$x_c[$i] = $x[$i];
		$y_c[$i] = $y[$i];
		$cont_c++;
		$maior_x = $x[$i];
		$maior_y = $y[$i];
	} else{
		$trash_x = array_pop($x_c);
		$trash_y = array_pop($y_c);
		$maior_x = $x[$i];
		$maior_y = $y[$i];
		$x_c[$i] = $x[$i];
		$y_c[$i] = $y[$i];
		$cont_c = 1;
	}
}

for ($i=1; $i < 5; $i++) { 
	if($x[$i] > $menor_x && $y[$i] < $menor_y){
		$x_d[$i] = $x[$i];
		$y_d[$i] = $y[$i];
		$cont_d++;
		$menor_x = $x[$i];
		$menor_y = $y[$i];
	} else{
		$trash_x = array_pop($x_d);
		$trash_y = array_pop($y_d);
		$menor_x = $x[$i];
		$menor_y = $y[$i];
		$x_d[$i] = $x[$i];
		$y_d[$i] = $y[$i];
	}
}

if ($cont_c >= 2) {
	$keys = array_keys($x_c);
	$n = count($x_c);
	for ($i=0; $i < $n; $i++) { 
		$x_final[$i] = $x_c[$keys[$i]];
		$y_final[$i] = $y_c[$keys[$i]];
	}
	echo "Temos uma reta crescente!<br>";
	print_r($x_final);
	echo "<br>";
	print_r($y_final);
	echo "<br>";
	$resultado = linear_regression($x_final, $y_final);
	print_r($resultado);
}

if ($cont_d > 2) {
	$keys = array_keys($x_d);
	$n = count($x_d);
	for ($i=0; $i < $n; $i++) { 
		$x_final[$i] = $x_d[$keys[$i]];
		$y_final[$i] = $y_d[$keys[$i]];
	}
	echo "Temos uma reta decrescente!<br>";
	print_r($x_final);
	echo "<br>";
	print_r($y_final);
	echo "<br>";
	$resultado = linear_regression($x_final, $y_final);
	print_r($resultado);
}

?>