<?php

session_start();

require_once 'functions.php';
require_once 'header.php';

?>

<section id="principal">
	<h2>Ensaio Mini-MCV</h2>
	<hr/>
	<!--<p>
		<?php 

		/*$meas_inicial = 0;

		for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) {
			if ($_SESSION['amostrax'][$i]['golpes'][12]['meas'] > $meas_inicial) {
				$meas10[$i] = $_SESSION['amostrax'][$i]['golpes'][12]['meas'];
				$umidades[$i] = $_SESSION['amostrax'][$i]['umidade'];
				$meas_inicial = $_SESSION['amostrax'][$i]['golpes'][12]['meas'];
			}
			else{
				break;
			}
		}

		$coef_d = linear_regression($umidades, $meas10);

		print_r($coef_d);
		*/
		?>	
	</p>-->
	<table border="1">
		<tr><th colspan="<?php echo ($_SESSION['quantCp']*4 + 1); ?>">Ensaio Mini-MCV</th></tr>
		<tr>
			<th>Cilindro</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['id'] . "</td>" ;
			}
			
			?>

		</tr>
		<tr>
			<th>Massa solo úmido a compactar(g)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['massaUmida'] . "</td>" ;
			}
			 			
			?>

		</tr>
		<tr>
			<th>Umidade (%)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['umidade'] . "</td>" ;
			}
						
			?>

			<!--<td colspan="4"><?php //echo $umidade ?></td>-->
		</tr>
		<tr>
			<th>Ka</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td>Ac (mm)</td>";
				echo "<td>" . $_SESSION['amostrax'][$i]['altCilindro'] . "</td>" ;
				echo "<td>La (mm)</td>";
				echo "<td>" . $_SESSION['amostrax'][$i]['leituraAf'] . "</td>" ;
			}
						
			?>
		</tr>
		<tr>
			<th>N° de golpes</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<th>Leitura (mm)</th><th>Altura (mm)</th><th>&Delta;h (mm)</th><th>MEAS (g/cm³)</th>" ;
			}
			
			?>
		</tr>

		<?php

		$golpes = array_keys($_SESSION['amostrax'][1]['golpes']);

		foreach ($golpes as $value) {
			echo "<tr>";
			echo "<th>" . $value . "</th>";
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				
				
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['leitura'] . "</td>" ;
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['altura'] . "</td>" ;
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['an'] . "</td>" ;
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['meas'] . "</td>" ;
			
			}
			echo "</tr>";
		}

		?>
		<tr><th colspan="<?php echo ($_SESSION['quantCp']*4 + 1); ?>">Ensaio Perda de Massa por Imersão</th></tr>
		<tr>
			<th>Comprimento saliente (cm)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . ($_SESSION['amostrax'][$i]['altExt'] / 10) . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th>Altura final (cm)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . ($_SESSION['amostrax'][$i]['altFinal'] / 10) . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th>Massa solo saliente (g)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['massaDesp'] . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th>Massa solo seco (g)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['massaSeca'] . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th>Perda por Imersão (%)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['pi'] . "</td>" ;
			}
			 			
			?>
		</tr>
	</table>
	    	
</section>

<br>
<a href="classificacao.php" name="classificar">Classificação</a>
	    
<?php 
//session_destroy();
require_once 'footer.php';
?>