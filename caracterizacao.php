<?php

session_start();

require_once 'functions.php';

/*calculo d
* percorrer o array dos meas para o golpe 10
* pegar os pontos (umidade,meas) do ramo seco: reta crescente - aumenta umidade, aumenta meas
* calcular a inclinação da reta por MMQ
*/

/*for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	if (isset($_SESSION['amostrax'][$i]['golpes'][8]['meas']) && isset($_SESSION['amostrax'][$i]['golpes'][12]['meas'])) {
		$meas[0] = $_SESSION['amostrax'][$i]['golpes'][8]['meas'];
		$meas[1] = $_SESSION['amostrax'][$i]['golpes'][12]['meas'];
		$x[0] = 10*log10(8);
		$x[1] = 10*log10(12);
		$reta = linear_regression($x, $meas);
		$meas10[$i] = $reta["m"]*10*log10(10) + $reta["b"];
	}
}

$meas_inicial = 0;

var_dump($_SESSION['quantCp']);

for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	if ($meas10[$i] > $meas_inicial) {
		$meas_seco[$i] = $meas10[$i];
		$umidades[$i] = $_SESSION['amostrax'][$i]['umidade'] / 100;
		$meas_inicial = $meas10[$i];
	}
	else{
		break;
	}
}*/

for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	if ($_SESSION['amostrax'][$i]['golpes'][12]['meas'] > $meas_inicial) {
		$meas10[$i] = $_SESSION['amostrax'][$i]['golpes'][12]['meas'];
		$umidades[$i] = $_SESSION['amostrax'][$i]['umidade'] / 100;
		$meas_inicial = $_SESSION['amostrax'][$i]['golpes'][12]['meas'];
	}
	else{
		break;
	}
}

print_r($umidades);
print_r($meas10);
//print_r($meas_seco);

$n = count($umidades);
$i = 0;

foreach ($umidades as $key => $value) {
	$umidades_x[$i] = $value;
	//$meas10_y[$i] = $meas_seco[$key];
	$meas10_y[$i] = $meas10[$key];
	$i++;
}

print_r($umidades_x);
print_r($meas10_y);

$reta_d = linear_regression($umidades_x, $meas10_y);

$coef_d = $reta_d['m'];

echo "<br> Coeficiente d': $coef_d ";

/*calculo c
* formar os pontos (mini-mcv,Bn), sendo que mini-mcv = 10 log Bn, com Bn o número de golpes equivalente ao afundamento
* identificar qual dos gráficos intercepta a reta an = 2 mm mais próximo do mini-mcv = 10
* calcular a parte mais inclinada
*/

$mcv_comp = 10;
$cons_y = 2;


$golpes = array_keys($_SESSION['amostrax'][1]['golpes']);

foreach ($golpes as $key => $value) {
	$minimcv[$key] = 10*log10($value);
}

for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	$cont = 1;
	foreach ($golpes as $value) {
		if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an'])){
			$cont_pts[$i] = $cont++;
		}
	}
}

echo "<br>";
print_r($cont_pts);
echo "<br>";

for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	if ($cont_pts[$i] <= 3) {
		foreach ($golpes as $key => $value) {
			if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an'])) {
				$x_r[$key] = $minimcv[$key];
				$y_r[$key] = $_SESSION['amostrax'][$i]['golpes'][$value]['an'];
			}
		}
		print_r($y_r);
		echo "<br>";
		print_r($x_r);
		echo "<br>";
		$reta[$i] = linear_regression($x_r, $y_r);
		$minimcv10[$i] = ($cons_y - $reta[$i]['b'])/$reta[$i]['m'];

	} else{
		$comp = 1000000;
		foreach ($golpes as $value) {
			$dif[$i][$value] = (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an'])) ? abs($_SESSION['amostrax'][$i]['golpes'][$value]['an'] - 2) : NULL;
			if ($dif[$i][$value] < $comp && !is_null($dif[$i][$value])) {
				$comp = $dif[$i][$value];
				$menor_dif[$i] = $dif[$i][$value];
			}
		}

		print_r($dif[$i]);

		echo "<br>";

		foreach ($golpes as $key => $value) {
			if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an']) && $menor_dif[$i] == abs($_SESSION['amostrax'][$i]['golpes'][$value]['an'] - 2)) {
				for ($j=0; $j < 3; $j++) {
					$y_r[$j] = $_SESSION['amostrax'][$i]['golpes'][$golpes[$key - $j]]['an'];
					$x_r[$j] = $minimcv[$key - $j];
				}
				print_r($y_r);
				echo "<br>";
				print_r($x_r);
				echo "<br>";
			    $reta[$i] = linear_regression($x_r, $y_r);
				$minimcv10[$i] = ($cons_y - $reta[$i]['b'])/$reta[$i]['m'];
			}
		}
	}
}

/*
for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	$comp = 1000000;
	foreach ($golpes as $value) {
		$dif[$i][$value] = (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an'])) ? abs($_SESSION['amostrax'][$i]['golpes'][$value]['an'] - 2) : NULL;
		if ($dif[$i][$value] < $comp && !is_null($dif[$i][$value])) {
			$comp = $dif[$i][$value];
			$menor_dif[$i] = $dif[$i][$value];
		}
	}
}

print_r($dif[5]);

echo "<br>";
for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	foreach ($golpes as $key => $value) {
		if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an']) && $menor_dif[$i] == abs($_SESSION['amostrax'][$i]['golpes'][$value]['an'] - 2)) {
			for ($j=0; $j < 3; $j++) {
				$y_r[$j] = ($key - $j >= 0) ? $_SESSION['amostrax'][$i]['golpes'][$golpes[$key - $j]]['an'] : 0;
				$x_r[$j] = ($key - $j >= 0) ? $minimcv[$key - $j] : 0;
			}
			print_r($y_r);
			echo "<br>";
			print_r($x_r);
			echo "<br>";
		    $reta[$i] = linear_regression($x_r, $y_r);
			$minimcv10[$i] = ($cons_y - $reta[$i]['b'])/$reta[$i]['m'];
		}
	}
}*/
echo "<br>";
print_r($minimcv10);
echo "<br>";
print_r($reta[4]);

$comp = abs($minimcv10[$_SESSION['quantCp']] - 10);
for ($i=$_SESSION['quantCp'] - 1; $i > 0 ; $i--) {
	$dif = abs($minimcv10[$i] - 10);
	if ($dif < $comp) {
		$comp = $dif;
		$coef_c = abs($reta[$i]['m']);
	}
}

$_SESSION['amostrax'][$i]['c'] = $coef_c;
echo "<br>";
echo $comp;
echo "<br> Coeficiente c': $coef_c ";
echo "<br>";

/*calculo pi
* verificar altura final e definir pi para mini-mcv = 10 ou mini-mcv = 15
* interpolar valor para pi
*/

//pegar a altura final de cada corpo de prova (menor valor)


for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
	$pi_mcv[$i] = ($_SESSION['amostrax'][$i]['altFinal'] > 53) ? 10 : 15;
}

$cont10 = 0;
$cont15 = 0;

foreach ($pi_mcv as $value) {
	$cont10 = ($value == 10) ? $cont10 + 1 : $cont10 + 0;
	$cont15 = ($value == 15) ? $cont15 + 1 : $cont15 + 0;
}

$pi_mcv_final = ($cont10 > $cont15) ? 10 : 15;

$cont_sup = 0;
$cont_inf = 0;

foreach ($minimcv10 as $value) {
	$cont_sup = ($value > 15) ? $cont_sup + 1 : $cont_sup + 0;
	$cont_inf = ($value < 15) ? $cont_inf + 1 : $cont_inf + 0;
}

echo "<br>";
echo $cont_sup;
echo "<br>";
echo $cont_inf;

if ($cont_sup >= 1 && $cont_inf >= 1) {
	$dif = array();

	for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
		$pi[$i] = $_SESSION['amostrax'][$i]['pi'];
		$dif[$i] = $minimcv10[$i] - 15;
	}

	for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
		if ($dif[$i] > 0) {
			$pos[$i] = $dif[$i];
		} else {
			$neg[$i] = $dif[$i];
		}
				
	}

	foreach ($pos as $key => $value) {
		if ($value == min($pos)) {
			$r_x[0] = $minimcv10[$key];
			$r_y[0] = $pi[$key];
		}
	}

	foreach ($neg as $key => $value) {
		if ($value == max($neg)) {
			$r_x[1] = $minimcv10[$key];
			$r_y[1] = $pi[$key];
		}
	}

	echo "<br>";
	print_r($r_x);
	echo "<br>";
	print_r($r_y);
	echo "<br>";
	$reta_pi = linear_regression($r_x, $r_y);

	echo "<br>";
	print_r($reta_pi);

	$pi_final = $reta_pi['m'] * $pi_mcv_final + $reta_pi['b'];
	
} elseif (($cont_sup >= 1 && $cont_inf < 1) || ($cont_sup < 1 && $cont_inf >= 1)) {
	$dif = array();

	for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
		$pi[$i] = $_SESSION['amostrax'][$i]['pi'];
		$dif[$i] = abs($minimcv10[$i] - 15);
	}

	echo "<br>";
	print_r($dif);

	for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
		if ($dif[$i] == min($dif)) {
			$r_x[0] = $minimcv10[$i];
			$r_y[0] = $pi[$i];
		}
	}

	for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
		if ($dif[$i] != min($dif)) {
			$dif_2[$i] = $dif[$i];
		}
	}

	echo "<br>";
	echo min($dif_2);

	foreach ($dif_2 as $key => $value) {
		if ($value == min($dif_2)) {
			$r_x[1] = $minimcv10[$key];
			$r_y[1] = $pi[$key];
		}
	}

	echo "<br>";
	print_r($r_x);
	print_r($r_y);

	$reta_pi = linear_regression($r_x, $r_y);

	echo "<br>";
	print_r($reta_pi);

	$pi_final = $reta_pi['m'] * $pi_mcv_final + $reta_pi['b'];
}

echo "<br>";
echo $pi_final;

//verificar se a altura final é maior ou menor que 53
//estabelecer mini-mcv comparador (10 ou 15)
//interpolar linearmente verificando a tendência do gráfico



/*calculo e
* aplicar formula que relaciona pi e d
*/

echo "<br>";
$coef_e = pow(($pi_final/100 + 20/$coef_d), (1/3));
echo $coef_e;

$_SESSION['amostrax'][$i]['e'] = $coef_e;

//5 pontos
//Ponto 1(4, 12)
//Ponto 2()

?>




