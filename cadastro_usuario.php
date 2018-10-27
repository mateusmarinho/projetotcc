<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Projeto TCC: Home</title>
    <link rel="stylesheet" type="text/css" href="_css/estilo.css">
  </head>
  <body>
    <div id="container">
	    <header>
	      <h1>Projeto TCC</h1>
	      <h2>Ferramenta online para classificação de solos tropicais</h2>
	      <nav id="menu">
	        <ul>
	          <li>
	            <a href="index.html">Home</a>
	          </li>
	          <li>
	            <a href="sobre.html">Sobre o projeto</a>
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
	    		<legend>Cadastro - informações requeridas</legend>
	    		<form name="cadastroUsu" method="post" action="add_usuario.php">
	    			<label>Nome completo:<br>
	    				<input class="input_text" type="text" name="nome" required>
	    			</label>
	    			<br>
	    			<caption></caption>
	    			<label>Tipo de usuário:</label>
	    			<br>
	    			<label>
	    				<input type="radio" name="tipo_usuario" value="Engenheiro/profissional" required>Engenheiro/profissional
	    			</label>
	    			<br>
	    			<label>
	    				<input type="radio" name="tipo_usuario" value="Estudante">Estudante
	    			</label>
	    			<br>
	    			<label>E-mail:
	    				<input class="input_text" type="email" name="email" required>
	    			</label>	
	    			<br>
	    			<label>Telefone:
	    				<input class="input_text" type="tel" name="telefone">
	    			</label>	
	    			<br>
	    			<label>Endereço:
	    				<input class="input_text" type="text" name="endereco" >
    				</label>
	    			<br>
	    			<label>Crie uma senha:
	    				<input class="input_text" type="password" name="senha">
    				</label>
	    			<br>
	    			<input class="input_button" type="submit" name="cadastrar" value="Cadastrar">
	    		</form>
	    	</fieldset>
	    </section>
    </div>
  </body>
</html>
