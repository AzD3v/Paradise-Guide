<?php 

	include("data/db_config.php");






//EDITAR ATIVIDADE
$stmt = $pdo->prepare("UPDATE nome_atividades SET idAtividade=?, idCategoria=?, nomeAtividade=?, descricaoAtividade=?,  zonaAtividade=?, imagemAtividade=? WHERE idAtividade = ?");

$stmt->bind_param('ssssss',
	$_GET['idAtividade'],
	$_GET['idCategoria'],
	$_GET['nomeAtividade'],
	$_GET['descricaoAtividade'],
	$_GET['zonaAtividade'],
	$_GET['imagemAtividade']);
	
	
	$stmt->execute();
	

	
	header("location: activity_edit.php?idAtividade=".$_GET['idAtividade'] . "&acao=editok");
	?>