<?php

session_start();

require_once 'functions.php';
require_once 'header.php';

?>

<div id="principal">
	<hr/>
	<table id="tabEnsaios" border="0">
		<tr><th class="titulo" colspan="<?php echo ($_SESSION['quantCp']*4 + 1); ?>">Ensaio Mini-MCV</th></tr>
		<tr>
			<th class="colEsq">Cilindro</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['id'] . "</td>" ;
			}
			
			?>

		</tr>
		<tr>
			<th class="colEsq">Massa solo úmido (g)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['massaUmida'] . "</td>" ;
			}
			 			
			?>

		</tr>
		<tr>
			<th class="colEsq">Umidade (%)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['umidade'] . "</td>" ;
			}
						
			?>
		</tr>
		<tr>
			<th class="colEsq">Ka</th>
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
			<th class="colEsq">N° de golpes</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<th>Leitura (mm)</th><th>Altura (mm)</th><th>an (mm)</th><th>MEAS (g/cm³)</th>" ;
			}
			
			?>
		</tr>

		<?php

		$golpes = array_keys($_SESSION['amostrax'][1]['golpes']);

		foreach ($golpes as $value) {
			echo "<tr>";
			echo "<th class='colEsq'>" . $value . "</th>";
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				if (is_numeric($_SESSION['amostrax'][$i]['golpes'][$value]['meas'])) {
					$meas_print = round($_SESSION['amostrax'][$i]['golpes'][$value]['meas'],6);
				} else {
					$meas_print = "-";
				}
				
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['leitura'] . "</td>" ;
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['altura'] . "</td>" ;
				echo "<td>" . $_SESSION['amostrax'][$i]['golpes'][$value]['an'] . "</td>" ;
				echo "<td>" . $meas_print . "</td>" ;
			
			}
			echo "</tr>";
		}

		?>
		<tr><th class="titulo" colspan="<?php echo ($_SESSION['quantCp']*4 + 1); ?>">Ensaio Perda de Massa por Imersão</th></tr>
		<tr>
			<th class="colEsq">Comprimento saliente (cm)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . ($_SESSION['amostrax'][$i]['altExt'] / 10) . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th class="colEsq">Altura final (mm)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . ($_SESSION['amostrax'][$i]['altFinal']) . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th class="colEsq">Massa solo saliente (g)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['massaDesp'] . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th class="colEsq">Massa solo seco (g)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . $_SESSION['amostrax'][$i]['massaSeca'] . "</td>" ;
			}
			 			
			?>
		</tr>
		<tr>
			<th class="colEsq">Perda por Imersão (%)</th>
			<?php
			
			for ($i=$_SESSION['quantCp'] ; $i > 0 ; $i--) { 
				echo "<td colspan = '4'>" . round($_SESSION['amostrax'][$i]['pi'],2) . "</td>" ;
			}
			 			
			?>
		</tr>
	</table>
	<br>
	<p id="redirText">Para proceder à classificação, clique
	<a class="redir" href="classificacao.php" name="classificar">Classificação</a></p>    	
</div>

<br>
<p id="redirText">Para proceder à classificação, clique
<a class="redir" href="caracterizacao.php" name="classificar">Classificação</a></p>
	    
<?php 
//session_destroy();
require_once 'footer.php';
?>