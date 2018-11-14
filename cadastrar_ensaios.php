<?php
session_start();

if(!isset($_POST['form_cp_id']))
  $_SESSION['quantCp'] = 0;
else{
  $_SESSION['quantCp'] = isset($_SESSION['quantCp']) ? $_SESSION['quantCp']+1 : 1;

  $numCilindro = $_SESSION['quantCp'];
  
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


<div id="principal">
  <h3 id="titulo">Cadastro de corpo de prova</h3>
  <div id="forms">
    <form name="cadastroEnsaioM" method="post" action="cadastrar_ensaios.php">
      <fieldset id="dadosMcv">
        <legend><h4>Ensaio Mini-MCV</h4></legend>
        <fieldset id="preliminaresMcv">
          <legend><h5>Dados preliminares</h5></legend>
          <label><span>Operador</span>
            <input class="input_text" type="text" name="nomeOperador" value="">
          </label>
          <br>
          <label><span>Cilindro</span>
            <input class="input_text" type="text" name="identCilindro" value="" required>
          </label>
          <br>
          <label><span>Massa solo úmido a compactar (g)</span>
            <input class="input_text" type="text" name="massaUmida" value="" required>
          </label>
          <br>
          <label><span>Umidade (%)</span>
            <input class="input_text" type="text" name="umidade" value="" required>
          </label>
          <br>
          <label><span>Área da seção interna do molde (cm²)</span>
            <input class="input_text" type="text" name="areaMolde" value="19.60" required>
          </label>
          <br>
        </fieldset>

        <fieldset id="afericaoMcv">
          <legend><h5>Dados de aferição do equipamento</h5></legend>
          <label><span>Altura do cilindro (mm)</span>
            <input class="input_text" type="text" name="altCilindro" value="50" required>
          </label>
          <br>
          <label><span>Leitura de aferição do extensômetro (mm)</span>
            <input class="input_text" type="text" name="leituraAf" value="" required>
          </label>
          <br>
        </fieldset>

        <fieldset id="leituraMcv">
          <legend><h5>Dados da leitura do extensômetro (em mm)</h5></legend>
          <label><span>1</span>
            <input class="input_text" type="text" name="leitura1" value="" size="6" required>
          </label>
          <br>
          <label class="col2"><span>2</span>
            <input class="input_text" type="text" name="leitura2" value="" size="6" required>
          </label>
          <br>
          <label><span>3</span>
            <input class="input_text" type="text" name="leitura3" value="" size="6" required>
          </label>
          <br>
          <label class="col2"><span>4</span>
            <input class="input_text" type="text" name="leitura4" value="" size="6" required>
          </label>
          <br>
          <label><span>6</span>
            <input class="input_text" type="text" name="leitura6" value="" size="6" required>
          </label>
          <br>
          <label class="col2"><span>8</span>
            <input class="input_text" type="text" name="leitura8" value="" size="6" required>
          </label>
          <br>
          <label><span>12</span>
            <input class="input_text" type="text" name="leitura12" value="" size="6">
          </label>
          <br>
          <label class="col2"><span>16</span>
            <input class="input_text" type="text" name="leitura16" value="" size="6">
          </label>
          <br>
          <label><span>24</span>
            <input class="input_text" type="text" name="leitura24" value="" size="6">
          </label>
          <br>
          <label class="col2"><span>32</span>
            <input class="input_text" type="text" name="leitura32" value="" size="6">
          </label>
          <br>
          <label><span>48</span>
            <input class="input_text" type="text" name="leitura48" value="" size="6">
          </label>
          <br>
          <label class="col2"><span>64</span>
            <input class="input_text" type="text" name="leitura64" value="" size="6">
          </label>
          <br>
          <label><span>96</span>
            <input class="input_text" type="text" name="leitura96" value="" size="6">
          </label>
          <br>
          <label class="col2"><span>128</span>
            <input class="input_text" type="text" name="leitura128" value="" size="6">
          </label>
          <br>
          <label><span>192</span>
            <input class="input_text" type="text" name="leitura192" value="" size="6">
          </label>
          <br>
          <label class="col2"><span>256</span>
            <input class="input_text" type="text" name="leitura256" value="" size="6">
          </label>
        </fieldset>
      </fieldset>

      <fieldset id="dadosPi">
        <legend><h4>Ensaio Perda de Massa por Imersão</h4></legend>
        <fieldset>
          <legend><h5>Características</h5></legend>
          <label><span>Massa solo seco compactado (g)</span>
            <input class="input_text" type="text" name="massaSeca" value="">
          </label>
          <br>
          <label><span>Massa solo seco desprendido (g)</span>
            <input class="input_text" type="text" name="massaDesp" value="">
          </label>
          <br>
          <label><span>Altura do CP extrudado (mm)</span>
            <input class="input_text" type="text" name="altExt" value="10">
          </label>
        </fieldset>
        
        <fieldset>
          <legend><h5>Tipo de desprendimento (fator de correção)</h5></legend>
          <label class="radio">
            <input type="radio" name="fatorC" value="normal" required> Normal (fc=1,0)
          </label>
          <br>
          <label class="radio">
            <input type="radio" name="fatorC" value="bloco"> Bloco (fc=0,5)
          </label>
        </fieldset>
      </fieldset>
      <br>
      <div id="buttons">
        <input class="button" type="submit" name="cadastrar" value="Cadastrar">
        <input type="hidden" name="form_cp_id" value="<?php echo $_SESSION['quantCp']; ?>">
        <?php

        if ($_SESSION['quantCp'] >= 0) {
          echo "<button><a class='fimEnsaio' target='_blank' href='tabela_resumo.php'>Finalizar</a></button>";
        }

        ?>
      </div>
    </form>
  </div>
</div>

<?php

require_once 'footer.php';

?>