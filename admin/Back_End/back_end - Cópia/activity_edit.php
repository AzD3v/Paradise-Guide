<?php 

	include("data/db_config.php");

	
	$idAtividade = " ";
	$idCategoria = " ";
	$nomeAtividade = " ";
	$descricaoAtividade = " ";
	$zonaAtividade = " ";
	$imagemAtividade = " ";

	
	
		
	//CONSULTA (obter os dados da atividade)
	
	$stmt = $ligacao->prepare("SELECT * FROM nome_atividades WHERE idAtividade = ?");
	$stmt->bind_param('i', $_GET['idAtividade']);
	$stmt->execute();
	
	$pdo = $stmt->get_result();
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	$idAtividade = $row["idAtividade"];
	$idCategoria = $row["idCategoria"];
	$nomeAtividade = $row["nomeAtividade"];
	$descricaoAtividade = $row["descricaoAtividade"];
	$zonaAtividade = $row["zonaAtividade"];
	$imagemAtividade = $row["imagemAtividade"];
	
	$stmt->close();
	$pdo->close();

?>
<html>
		<body style="background-color:powderblue;">
		<title> Editar Atividade </title>
		<h1> Editar Atividade </h1>
			<form action="bd_editar_atividade.php" method="get">
					
							<table>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>idAtividade</td>
									<td><input type="text" name="nome" value="<?php echo $idAtividade ?>"></td>
								</tr>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>idCategoria</td>
									<td><input type="text" name="morada" value="<?php echo $idCategoria ?>"></td>
								</tr>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>Nome da Atividade</td>
									<td><input type="email" name="email" value="<?php echo $nomeAtividade ?>"></td>
								</tr>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>Descrição da Atividade</td>
									<td><input type="number" name="contacto" value="<?php echo $descricaoAtividade ?>"></td>
								</tr>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>Local da Atividade</td>
									<td><input type="text" name="localidade" value="<?php echo $zonaAtividade ?>"></td>
								</tr>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>Imagem da Atividade</td>
									<td><input type="text" name="codigo_postal" value="<?php echo $imagemAtividade ?>"></td>
								</tr>
								<tr style="border: 1px solid black;padding: 10px;">
									<td>
										<a href="activity_list.php"><input type=button value=Voltar></a>
										</td>
									<td>
										<input type="submit" value="Guardar">
										</td>
									</tr>
								</table>
								<input type="hidden" name="id_carrinho" value="<?php echo $idAtividade ?>">
							</form>
							<?php
							if(isset($_GET['acao']) && $_GET['acao'] == "editok")
	{
	echo "Atividade alterada com sucesso.";
	}

?>
						</body>
</html>			