<?php
session_start();

if(!isset($_POST['form_cp_id']))
  $_SESSION['quantCp'] = 0;
else{
  $_SESSION['quantCp'] = isset($_SESSION['quantCp']) ? $_SESSION['quantCp']+1 : 1;

  $numCilindro = $_SESSION['quantCp'];

  //$_SESSION['amostra'] = 'x';
  
  //recebimento dos dados do formulário Mini-MCV
  $nomeOperador = isset($_POST['nomeOperador']) ? $_POST['nomeOperador']  : NULL;
  $identCilindro = isset($_POST['identCilindro']) ? $_POST['identCilindro']  : NULL;
  $massaUmida = isset($_POST['massaUmida']) ? $_POST['massaUmida']  : NULL;
  $umidade = isset($_POST['umidade']) ? $_POST['umidade']  : NULL;
  $areaMolde = isset($_POST['areaMolde']) ? $_POST['areaMolde']  : NULL;
  $altCilindro = isset($_POST['altCilindro']) ? $_POST['altCilindro']  : NULL;
  $leituraAf = isset($_POST['leituraAf']) ? $_POST['leituraAf']  : NULL;
  $leituras[1] = isset($_POST['leitura1']) ? $_POST['leitura1']  : NULL;
  $leituras[2] = isset($_POST['leitura2']) ? $_POST['leitura2']  : NULL;
  $leituras[3] = isset($_POST['leitura3']) ? $_POST['leitura3']  : NULL;
  $leituras[4] = isset($_POST['leitura4']) ? $_POST['leitura4']  : NULL;
  $leituras[6] = isset($_POST['leitura6']) ? $_POST['leitura6']  : NULL;
  $leituras[8] = isset($_POST['leitura8']) ? $_POST['leitura8']  : NULL;
  $leituras[12] = isset($_POST['leitura12']) ? $_POST['leitura12']  : NULL;
  $leituras[16] = isset($_POST['leitura16']) ? $_POST['leitura16']  : NULL;
  $leituras[24] = isset($_POST['leitura24']) ? $_POST['leitura24']  : NULL;
  $leituras[32] = isset($_POST['leitura32']) ? $_POST['leitura32']  : NULL;
  $leituras[48] = isset($_POST['leitura48']) ? $_POST['leitura48']  : NULL;
  $leituras[64] = isset($_POST['leitura64']) ? $_POST['leitura64']  : NULL;
  $leituras[96] = isset($_POST['leitura96']) ? $_POST['leitura96']  : NULL;
  $leituras[128] = isset($_POST['leitura128']) ? $_POST['leitura128']  : NULL;
  $leituras[192] = isset($_POST['leitura192']) ? $_POST['leitura192']  : NULL;
  $leituras[256] = isset($_POST['leitura256']) ? $_POST['leitura256']  : NULL;

  //tratamento dos dados recebidos Mini-MCV
  $ka = $altCilindro - $leituraAf;

  $_SESSION['amostrax'][$numCilindro]['id'] = $identCilindro; 
  $_SESSION['amostrax'][$numCilindro]['nomeOperador'] = $nomeOperador;
  $_SESSION['amostrax'][$numCilindro]['massaUmida'] = $massaUmida;
  $_SESSION['amostrax'][$numCilindro]['umidade'] = $umidade;
  $_SESSION['amostrax'][$numCilindro]['altCilindro'] = $altCilindro;
  $_SESSION['amostrax'][$numCilindro]['leituraAf'] = $leituraAf;

  $_SESSION['amostrax'][$numCilindro]['golpes'] = array();
  foreach ($leituras as $key => $value) {
    if ($key <= 64 && $leituras[$key * 4] != NULL) {
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['an'] = $value - $leituras[$key * 4];
    } else {
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['an'] = "-";
    }
    
    if ($value != NULL) {
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['leitura'] = $value;
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['altura'] = $ka + $value;
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['meas'] = (100 * $massaUmida) / ((100 + $umidade) * ($areaMolde * ($_SESSION['amostrax'][$numCilindro]['golpes'][$key]['altura']/10)));
    }else{
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['leitura'] = "-";
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['altura'] = "-";
      $_SESSION['amostrax'][$numCilindro]['golpes'][$key]['meas'] = "-";
    }
  }

  //recebimento dos dados do formulário PMI
  $massaSeca = isset($_POST['massaSeca']) ? $_POST['massaSeca']  : NULL;
  $massaDesp = isset($_POST['massaDesp']) ? $_POST['massaDesp']  : NULL;
  $altExt = isset($_POST['altExt']) ? $_POST['altExt']  : NULL;
  $fc = ($_POST['fatorC'] == "normal") ?  1 : 0.5;

  //tratamento dos dados PMI
  $golpes = array_keys($_SESSION['amostrax'][$numCilindro]['golpes']);

  foreach ($golpes as $key => $value) {
    if (is_numeric($_SESSION['amostrax'][$numCilindro]['golpes'][$value]['altura'])) {
      $_SESSION['amostrax'][$numCilindro]['altFinal'] = $_SESSION['amostrax'][$numCilindro]['golpes'][$value]['altura'];
      $altFinal = $_SESSION['amostrax'][$numCilindro]['altFinal'];
    }
  }

  $_SESSION['amostrax'][$numCilindro]['massaSeca'] = $massaSeca;
  $_SESSION['amostrax'][$numCilindro]['massaDesp'] = $massaDesp;
  $_SESSION['amostrax'][$numCilindro]['altExt'] = $altExt;
  
  $_SESSION['amostrax'][$numCilindro]['pi'] = 100*$fc*$massaDesp/$massaSeca;
  //$_SESSION['amostrax'][$numCilindro]['pi'] = 100*$fc*$massaDesp*$altFinal/($massaSeca*$altExt);

}

require_once 'header.php';

?>


<section id="principal">
  <?php print_r($_SESSION['quantCp']) ?>
  <fieldset>
    <legend>Cadastro corpo de prova</legend>
    <form name="cadastroEnsaioM" method="post" action="cadastrar_ensaios.php">
      <h3>Ensaio Mini-MCV</h3>
      <label>Operador:
        <input class="input_text" type="text" name="nomeOperador" value="">
      </label>
      <br>
      <label>Cilindro:
        <input class="input_text" type="text" name="identCilindro" value="">
      </label>
      <br>
      <label>Massa solo úmido a compactar (g):
        <input class="input_text" type="text" name="massaUmida" value="">
      </label>
      <br>
      <label>Umidade (%):
        <input class="input_text" type="text" name="umidade" value="">
      </label>
      <br>
      <label>Área da seção interna do molde (cm²):
        <input class="input_text" type="text" name="areaMolde" value="">
      </label>
      <br>
      <label>Dados de aferição do equipamento</label><br>
      <label>Altura do cilindro (mm):
        <input class="input_text" type="text" name="altCilindro" value="">
      </label>
      <br>
      <label>Leitura de aferição do extensômetro (mm):
        <input class="input_text" type="text" name="leituraAf" value="">
      </label>
      <br>
      <label>Abaixo, entre com os dados da leitura do extensômetro (em mm) para cada número de golpes do soquete:</label><br>
      <label>1:
        <input class="input_text" type="text" name="leitura1" value="">
      </label>
      <br>
      <label>2:
        <input class="input_text" type="text" name="leitura2" value="">
      </label>
      <br>
      <label>3:
        <input class="input_text" type="text" name="leitura3" value="">
      </label>
      <br>
      <label>4:
        <input class="input_text" type="text" name="leitura4" value="">
      </label>
      <br>
      <label>6:
        <input class="input_text" type="text" name="leitura6" value="">
      </label>
      <br>
      <label>8:
        <input class="input_text" type="text" name="leitura8" value="">
      </label>
      <br>
      <label>10:
        <input class="input_text" type="text" name="leitura10" value="">
      </label>
      <br>
      <label>12:
        <input class="input_text" type="text" name="leitura12" value="">
      </label>
      <br>
      <label>16:
        <input class="input_text" type="text" name="leitura16" value="">
      </label>
      <br>
      <label>24:
        <input class="input_text" type="text" name="leitura24" value="">
      </label>
      <br>
      <label>32:
        <input class="input_text" type="text" name="leitura32" value="">
      </label>
      <br>
      <label>40:
        <input class="input_text" type="text" name="leitura40" value="">
      </label>
      <br>
      <label>48:
        <input class="input_text" type="text" name="leitura48" value="">
      </label>
      <br>
      <label>64:
        <input class="input_text" type="text" name="leitura64" value="">
      </label>
      <br>
      <label>96:
        <input class="input_text" type="text" name="leitura96" value="">
      </label>
      <br>
      <label>128:
        <input class="input_text" type="text" name="leitura128" value="">
      </label>
      <br>
      <label>160:
        <input class="input_text" type="text" name="leitura160" value="">
      </label>
      <br>
      <label>192:
        <input class="input_text" type="text" name="leitura192" value="">
      </label>
      <br>
      <label>256:
        <input class="input_text" type="text" name="leitura256" value="">
      </label>
      <br>
      <label>Observações do operador:<br>
        <textarea class="input_text" name="obs" cols="30" rows="10" value=""></textarea>
      </label>
      <br>

      <h3>Ensaio Perda de Massa por Imersão</h3>
      <br>
      <label>Massa solo seco após compactação (g):
        <input class="input_text" type="text" name="massaSeca" value="">
      </label>
      <br>
      <label>Massa seca de solo desprendido (g):
        <input class="input_text" type="text" name="massaDesp" value="">
      </label>
      <br>
      <label>Altura do CP extrudado (mm):
        <input class="input_text" type="text" name="altExt" value="10">
      </label>
      <br>
      <label>Tipo de desprendimento (fator de correção):</label>
      <br>
      <label>
        <input type="radio" name="fatorC" value="normal" required> Normal (fc=1,0)
      </label>
      <br>
      <label>
        <input type="radio" name="fatorC" value="bloco"> Bloco (fc=0,5)
      </label>
      <br>            
      <label>Observações do operador:<br>
        <textarea class="input_text" name="obs" cols="30" rows="10" value=""></textarea>
      </label>
      <br>
      <input class="input_button" type="submit" name="cadastrar" value="Cadastrar ensaio">
      <input type="hidden" name="form_cp_id" value="<?php echo $_SESSION['quantCp']; ?>">
    </form>
    <?php

    echo "<br>";

    if ($_SESSION['quantCp'] >= 1) {
      echo "<a target='_blank' href='tabela_resumo.php'>Terminar ensaio</a>";
    }

    ?>
  </fieldset>
</section>

<?php

require_once 'footer.php';

?>