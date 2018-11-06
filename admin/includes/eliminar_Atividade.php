<?php 


	include("data/db_config.php");

	//ELIMINAR Atividade

	$stmt = $pdo->prepare("DELETE FROM nome_atividades WHERE idAtividade = ?");
	$stmt->bind_param('i', $_GET['idAtividade']);
	
	
	
	$stmt->execute();
	


	
	
	header("location: activity_list.php?acao=deleteok");


?>