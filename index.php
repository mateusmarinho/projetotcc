<?php
  session_start();
  require_once 'header.php';
?>

<section id="principal">
  <section class="text-center cta">
    <h1 class="cta-title">Ferramenta web<br>para classificação de solos tropicais</h1>
    <span class="cta-button">Começar agora</span>
  </section>

  <p class="how-to-use">É muito fácil usar:</p>
  
  <section class="info-cards" style="width: 100%;">    
    <div class="card">
      Forneça os dados X, Y e Z
      <i class="material-icons">list_alt</i>
    </div>
    <div class="card">
      Tabela de resumo dos dados
      <i class="material-icons">grid_on</i>
    </div>
    <div class="card">
      Gráfico de classificação
      <i class="material-icons">bar_chart</i>
    </div>
  </section>

  <section style="width: 100%; box-sizing: border-box;">
    <p style="width: 50%; margin: 0 auto; text-align: justify;">
      São diversos os sistemas de classificação de solos para a Engenharia Civil. Cada um podendo utilizar diversas características de solos como elemento comparador e definidor de uma classificação. Para isso, são realizados diversos ensaios que caracterizam e identificam aspectos do comportamento do solos. De maneira geral, é possível recorrer facilmente a um sistema de classificação, tendo obtido resultados da composição granulométrica e dos Limites de Atterberg, e encontrar um grupo que contenha propriedades próximas ao material que está sendo estudado.
    </p>
  </section>

  <br>
  <br>
  <br>

  <p>O programa é parte do Trabalho de Conclusão de Curso do discente Mateus Santos Marinho, graduando em Engenharia Civil na Universidade Estadual de Santa Cruz (UESC), sob orientação dos professores Stephanny Conceição Farias do Egito Costa e Hélder Conceição Almeida, lotados na mesma Universidade. É uma iniciativa que parte da necessidade da praticidade e da difusão da classificação de solos tropicais para a Engenharia Civil, de acordo com a metodologia MCT (Miniatura Compactada Tropical), desenvolvida na década de 80.</p>

  <h2>Sistemas de classificação</h2>
  <p>São exemplos de sistemas de classificação de solos:</p>  
  <ul>
    <li>Sistema Universal de Classificação dos Solos (SUCS);</li>
    <li>Transportation Research Board (TRB), da AASHTO;</li>
    <li>Miniatura Compactada Tropical (MCT);</li>
    <li>Classificação Resiliente dos Solos, do DNER.</li>
  </ul>

  <h2>A classificação MCT</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean interdum auctor metus, non blandit quam malesuada fringilla. Suspendisse ultricies diam in massa rutrum, nec iaculis ipsum imperdiet. Proin non neque ut ipsum fringilla rhoncus. Curabitur gravida, tellus non finibus facilisis, purus felis vehicula nisi, ac rutrum orci orci in dolor. Duis varius urna sed felis aliquam pellentesque. In hac habitasse platea dictumst. Duis faucibus lacus velit, a euismod metus venenatis in.</p>

  <h3>Ensaios de classificação:</h3>
  <ul>
    <li>Ensaio de compactação Mini-MCV</li>
    <li>Ensaio de perda de massa por imersão</li>
  </ul>
</section>

<?php require_once 'footer.php'; ?>