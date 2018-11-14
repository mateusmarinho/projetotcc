<?php

session_start();

require_once 'header.php';

?>

<div id="principal">
  <div id="apresentacao">
    <h2>Ferramenta web para classificação de solos tropicais</h2>
    <p>Para realizar classificação, clique: </p>
    <a id="classificar" target="_blank" href="cadastrar_ensaios.php">Classificar</a>
  </div>
  <div id="manual">
    No formulário de ensaio Mini-MCV:
    1- Entre com os dados do corpo de prova, começando pelo de maior umidade;
    2- Na compactação, insira as leituras do extênsometro para cada quantidade de golpes do soquete.
    No formulário de ensaio Perda de Massa por Imersão:
    1- Entre com a massa de solo compactado após a secagem e a massa de solo desprendido seco;
    2- Defina a altura extrudada do corpo de prova submetido ao ensaio;
    3- Selecione a forma de desprendimento do solo.
    Cadastre 5 corpos de prova, e se não houver mais, clique em "Finalizar". 
  </div>
  <div id="">
    <p>A classificação MCT foi criada por Nogami e Villibor (1981) para fins rodoviários e utiliza corpos de prova de dimensões reduzidas em ensaio de compactação com equipamento miniatura e perda de massa por imersão.</p>
    <p>Grupos de classificação:</p>
    <ul>
      <li>LA: areias lateríticas</li>
      <li>LA': solos arenosos lateríticos</li>
      <li>LG': solos argilosos lateríticos</li>
      <li>NA: areias não lateríticas</li>
      <li>NA': solos arenosos não lateríticos</li>
      <li>NS': solos siltosos não lateríticos</li>
      <li>NG': solos argilosos não lateríticos</li>
    </ul>
  </div>
</div>

<?php

session_start();

require_once 'footer.php';

?>