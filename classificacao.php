<?php

session_start();

require_once 'functions.php';

/*
* 
* calculo d'
* 
*/

$meas_inicial = 0;

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

$n = count($umidades);
$i = 0;

foreach ($umidades as $key => $value) {
  $umidades_x[$i] = $value;
  $meas10_y[$i] = $meas10[$key];
  $i++;
}

$reta_d = linear_regression($umidades_x, $meas10_y);

$coef_d = round($reta_d['m'], 2);

/*
* 
* calculo c'
* 
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

for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
  if ($cont_pts[$i] <= 3) {
    foreach ($golpes as $key => $value) {
      if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an'])) {
        $x_r[$key] = $minimcv[$key];
        $y_r[$key] = $_SESSION['amostrax'][$i]['golpes'][$value]['an'];
      }
    }
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

    foreach ($golpes as $key => $value) {
      if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['an']) && $menor_dif[$i] == abs($_SESSION['amostrax'][$i]['golpes'][$value]['an'] - 2)) {
        for ($j=0; $j < 3; $j++) {
          $y_r[$j] = $_SESSION['amostrax'][$i]['golpes'][$golpes[$key - $j]]['an'];
          $x_r[$j] = $minimcv[$key - $j];
        }
        $reta[$i] = linear_regression($x_r, $y_r);
        $minimcv10[$i] = ($cons_y - $reta[$i]['b'])/$reta[$i]['m'];
      }
    }
  }
}

$comp = abs($minimcv10[$_SESSION['quantCp']] - 10);
for ($i=$_SESSION['quantCp'] - 1; $i > 0 ; $i--) {
  $dif = abs($minimcv10[$i] - 10);
  if ($dif < $comp) {
    $comp = $dif;
    $coef_c = round(abs($reta[$i]['m']), 2);
  }
}

$_SESSION['amostrax'][$i]['c'] = $coef_c;
$graf_c = ($coef_c > 3) ? 3 : $coef_c;

/*
* 
* calculo Pi
*
*/

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

  $reta_pi = linear_regression($r_x, $r_y);

  $pi_final = $reta_pi['m'] * $pi_mcv_final + $reta_pi['b'];

  $pi_final = round($pi_final, 2);
  
} elseif (($cont_sup >= 1 && $cont_inf < 1) || ($cont_sup < 1 && $cont_inf >= 1)) {
  $dif = array();

  for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
    $pi[$i] = $_SESSION['amostrax'][$i]['pi'];
    $dif[$i] = abs($minimcv10[$i] - 15);
  }

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

  foreach ($dif_2 as $key => $value) {
    if ($value == min($dif_2)) {
      $r_x[1] = $minimcv10[$key];
      $r_y[1] = $pi[$key];
    }
  }

  $reta_pi = linear_regression($r_x, $r_y);

  $pi_final = $reta_pi['m'] * $pi_mcv_final + $reta_pi['b'];

  $pi_final = round($pi_final, 2);
}

/*
*
* calculo e'
* 
*/

$coef_e = pow(($pi_final/100 + 20/$coef_d), (1/3));
$coef_e = round($coef_e, 2);
$_SESSION['amostrax'][$i]['e'] = $coef_e;

$graf_e = ($coef_e > 2.2) ? 2.2 : $coef_e;

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Projeto TCC: Home</title>
    <link rel="stylesheet" type="text/css" href="_css/estilo.css">
    <script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
      //animationEnabled: true,
      title: {
        text: "Classificação MCT"
      },
      axisX: {
        title: "Coeficiente c'",
        minimum: 0.0,
        maximum: 3.0
      },
      axisY: {
        title: "Índice e'",
        minimum: 0.0,
        maximum: 2.2
      },
      legend: {
        verticalAlign: "bottom",
        horizontalAlign: "center",
        dockInsidePlotArea: false
      },
      toolTip: {
        enabled: true,
        content: "{name}",
        shared: false
      },
      data: [{
        name: "LA",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(40,175,101,0.6)",
        markerSize: 0,
        dataPoints: [
          { x: 0.0, y: 1.4 },
          { x: 0.6, y: 1.4 },
          { x: 0.7, y: 1.15 },
          { x: 0.7, y: 0.0 }
        ]
      },
      {
        name: "NA",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(0,75,141,0.7)",
        markerSize: 0,
        dataPoints: [
          { x: 0, y: 2.2 },
          { x: 0.27, y: 2.2 },
          { x: 0.45, y: 1.75 },
          { x: 0.6, y: 1.4 },
          { x: 0, y: 1.4 }
        ]
      },
      {
        name: "NS'",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(235,10,60,0.4)",
        markerSize: 0,
        dataPoints: [
          { x: 0.27, y: 2.2 },
          { x: 0.45, y: 1.75 },
          { x: 1.5, y: 1.25 },
          { x: 1.5, y: 2.2 },
          { x: 0.27, y: 2.2 }
        ]
      },
      {
        name: "NA'",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(15,125,67,0.7)",
        markerSize: 0,
        dataPoints: [
          { x: 0.45, y: 1.75 },
          { x: 1.7, y: 1.15 },
          { x: 0.7, y: 1.15 },
          { x: 0.45, y: 1.75 }
        ]
      },
      {
        name: "LA'",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(200,95,70,0.7)",
        markerSize: 0,
        dataPoints: [
          { x: 0.7, y: 0 },
          { x: 0.7, y: 1.15 },
          { x: 1.5, y: 1.15 },
          { x: 1.5, y: 0 }
        ]
      },
      {
        name: "LG'",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(240,125,100,0.6)",
        markerSize: 0,
        dataPoints: [
          { x: 1.5, y: 0 },
          { x: 1.5, y: 1.15 },
          { x: 3, y: 1.15 }
        ]
      },
      {
        name: "NG'",
        markerType: "none",
        showInLegend: true,
        legendMarkerType: "square",
        type: "area",
        color: "rgba(255,0,155,0.6)",
        markerSize: 0,
        dataPoints: [
          { x: 1.5, y: 2.2 },
          { x: 1.5, y: 1.25 },
          { x: 1.7, y: 1.15 },
          { x: 3, y: 1.15 },
          { x: 3, y: 2.2 },
          { x: 1.5, y: 2.2 }
        ]
      },
      {
        name: "Amostra X",
        markerType: "circle",
        type: "scatter",
        toolTipContent: "<b>Amostra X</b><br>c: {x}<br>e: {y}",
        color: "rgba(0,0,0,0.8)",
        markerSize: 7,
        dataPoints: [
          { x: <?php echo $graf_c; ?>, y: <?php echo $graf_e; ?> }
        ]
      }]
    });
    chart.render();
    }
    </script>
  </head>
  <body>
    <section id="container">
      <header>
        <h1>Projeto TCC</h1>
        <h2>Ferramenta web para classificação de solos tropicais</h2>
        <nav id="menu">
          <ul>
            <li>
              <a href="index.html">Home</a>
            </li>
            <li>
              <a href="sobre.html">Sobre</a>
            </li>
            <li>
              <a href="classificacao.html">Classificação dos solos</a>
            </li>
            <li>
              <a href="desenvolvedores.html">Desenvolvedores</a>
            </li>
          </ul>
        </nav>
      </header>

      <section id="principal">
        <fieldset>
          <legend>Coeficientes e índices</legend>
          <p>c': <?php echo $coef_c; ?></p>
          <p>d': <?php echo $coef_d; ?></p>
          <p>Pi': <?php echo $pi_final; ?></p>
          <p>e': <?php echo $coef_e; ?></p>
        </fieldset>
        <h1>Gráfico de classificação</h1>
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
      </section>
    </section>
  </body>
</html>