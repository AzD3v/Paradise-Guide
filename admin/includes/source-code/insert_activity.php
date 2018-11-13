<?php

include 'restricao.php';

include("../data/db_config.php");

$sql = "SELECT * FROM atividades ORDER BY zonaAtividade;";



$result = $ligacao->query($sql);


?>
<html>
		<body style="background-color:powderblue;">
					<title>Atividades</title>
					<h1>Inserir Atividade</h1>
					<form action="bd_insert_activity.php" method="post" enctype="multipart/form-data">
					
							<table>
								<tr>
									<td>Nome da Ativvidade</td>
									<td><input type="text" name="nomeAtividade"></td>
								</tr>
								<tr>
									<td>Descrição</td>
									<td><textarea rows="5" cols="100"  type="text" name="descricao"></textarea></td>
								</tr>
								<tr>
									<td>duracão da atividade</td>
									<td><input type="time" name="duracaoAtividade"   min="1:00" max="18:00" required></td>
								</tr>
								<tr>
									<td>Zona da atividade</td>
									<td><input type="text" name="zonaAtividade"></td>
								</tr>
								<tr>
									<td>Imagem da atividade</td>
									<td><input type="text" name="imagemAtividade"></td>
								</tr>
								<tr>
									<td>Preço da atividade</td>
									<td><input type="decimal" name="preco"></td>
								</tr>
								<tr>
									<td>
										<a href="activity_list.php"><input type=button value=Voltar></a>
										</td>
									<td>
										<input type="submit" value="Inserir">
										</td>
									</tr>
							</table>
							
								<?php //Se ação for: camposobrigatorios, então mostra mensagem
							if (isset($_GET['acao']) && $_GET['acao'] == "camposobrigatorios")
							{
							
								echo "Todos os campos são de preenchimento obrigatório.";
							
							}
							elseif (isset($_GET['acao']) && $_GET['acao'] == "sucesso")
							{
							
								echo "Atividade inserida com sucesso.";
							
							}
							?>
							
							
			
							
						</body>
</html>				