<!-- Incluir a configuração da base de dados -->
<?php 

	include("data/db_config.php");
		
	$sql = "SELECT * FROM nome_atividades ORDER BY zonaAtividade;";



	$stmt = $pdo->prepare($sql);


?>
<!DOCTYPE html>
<html lang="en">

	<h6>Atividades</h6>
				
							
						<table>
							
								<b>
									<tr style="border: 1px solid black;padding: 10px;">
									
									
									<td style="padding: 10px;text-align:center">idAtividade<b></b></td>
									<td style="padding: 10px;text-align:center">idCategoria<b></b></td>
									<td style="padding: 10px;text-align:center">Nome da Atividade<b></b></td>
									<td style="padding: 10px;text-align:center">Descrição<b></b></td>
									<td style="padding: 10px;text-align:center">Local da Atividade<b></b></td>
									<td style="padding: 10px;text-align:center">Imagem<b></b></td>
								
									
									<td style="padding: 10px;text-align:center"></td>
									<td style="padding: 10px;text-align:center"></td>
									</tr>
									</b>
									
										
											<?php 
										while($row = $result->fetch_assoc())
										{
                                              ?>
											  
							
									
									<td style="padding: 10px;text-align:center"><?php echo $row["idAtividade"]?></td>
									<td style="padding: 10px;text-align:center"><?php echo $row["idCategoria"]?></td>
									<td style="padding: 10px;text-align:center"><?php echo $row["nomeAtividade"]?></td>
									<td style="padding: 10px;text-align:center"><?php echo $row["descricaoAtividade"]?></td>
									<td style="padding: 10px;text-align:center"><?php echo $row["zonaAtividade"]?></td>
									<td style="padding: 10px;text-align:center"><?php echo $row["imagemAtividade"]?></td>
									
									<td style="padding: 10px;text-align:center"><a href="editar_atividade.php?id_Atividade=<?php echo $row["id_Atividade"]?>"><img src="../img/back_end/lapis.png"  height="25" width="25"></a></td>
									<td style="padding: 10px;text-align:center"><a href="eliminar_Atividade.php?id_Atividade=<?php echo $row["id_Atividade"]?>"><img src ="../img/back_end/caixote.png" height="25" width="25"></a></td>
									<td style="padding: 10px;text-align:center"></td>
									
									
									</tr>	
									</b>
								
									
								<?php
								}
								?>		