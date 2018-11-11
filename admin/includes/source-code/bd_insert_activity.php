<?php
//VERIFICAR se todos os campos estão preenchidos
				if($_POST['nomeAtividade'] 
				&& $_POST['descricao'] 
				&& $_POST['duracaoAtividade'] 
				&& $_POST['zonaAtividade']
				&& $_POST['imagemAtividade']
				&&$_POST['preco'])
				{
					//INSERIR atividade
					
					$statement = $ligacao->prepare ("INSERT INTO atividades (nomeAtividade, descricao, zonaAtividade, imagemAtividade, preco, idCategoria) VALUES ( ?, ?, ?, ?, ?, ?)");
					
					$statement->bind_param('ssssii', $_POST['nomeAtividade'], $_POST['descricao'], $_POST['zonaAtividade'], $_POST['imagemAtividade'], $_POST['preco'], $_POST['idCategoria']);	

					$statement->execute();
					$statement->close();
					
					$last_id = $ligacao->insert_id;
					$ligacao->close();
				
				
					header("location: insert_activity.php?acao=sucesso");
					
				}
				else
				{
				//Abre a página do formulário e apresenta a mensagem:
				header("location: insert_activity.php?acao=camposobrigatorios");
				}

?>	