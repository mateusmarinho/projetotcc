<?php
	require_once 'header.php';
?>
	    <section id="principal">
	    	<h2>Informações do Usuário</h2>
	    	<hr/>
	    	<ul>
	    		<li>Nome:<?php echo " ".$nome; ?></li>
	    		<li>Tipo:<?php echo " ".$tipo_usuario; ?></li>
	    		<li>E-mail:<?php echo " ".$email; ?></li>
	    		<li>Endereço:<?php echo " ".$endereco; ?></li>
	    		<li>Telefone:<?php echo " ".$telefone; ?></li>
	    	</ul>
	    </section>
<?php require_once 'footer.php';