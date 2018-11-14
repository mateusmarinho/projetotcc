<?php
	require_once("libs/mysql.lib");
	$dados_corretos = false;

	$nome = isset($_POST['nome']) ? $_POST['nome']  : NULL;
	$tipo_usuario = isset($_POST['tipo_usuario']) ? $_POST['tipo_usuario']  : NULL;
	$email = isset($_POST['email']) ? $_POST['email']  : NULL;
	$senha = isset($_POST['senha']) ? $_POST['senha']  : NULL;
	$endereco = isset($_POST['endereco']) ? $_POST['endereco']  : NULL;
	$telefone = isset($_POST['telefone']) ? $_POST['telefone']  : NULL;

	//fazer validação dos dados enviados pelo formulário
	$dados_corretos = true;

	if($dados_corretos){
		$sql = "INSERT INTO usuario VALUES ";
		$sql .= "('','$nome', '$tipo_usuario', '$email', '$senha', '$endereco', '$telefone')"; 
		mysqli_query($db_link, $sql) or die($sql);
		mysqli_close($db_link); 
		echo "Cliente cadastrado com sucesso!";
	}
?>