<!-- Incluir a configuração da base de dados -->
<?php include_once("../data/db_config.php"); ?>

<!-- Incluir a classe Database -->
<?php include_once("../data/database.php"); ?>

<!-- Incluir a classe Activity -->
<?php include_once("../data/activity.php"); ?>

<!-- Iniciar a sessão -->
<?php session_start(); ?>

<?php if (isset($_SESSION["client"])) {header("Location:../index.php");} ?>

<?php 

    # Obter o ID do admin que possui sessão iniciada
    $admin = $_SESSION["admin"];

    # Prepared statement que retorna o ID do admin em questão
    $admin_id_sql = "SELECT * FROM admin_users WHERE usernameAdmin = :usernameAdmin LIMIT 1";
    $admin_id_stmt = $pdo->prepare($admin_id_sql);
    $admin_id_stmt->execute([":usernameAdmin" => $admin]);

    # Fetch à base de dados de modo a retornar o ID do utilizador
    $admin_id_result = $admin_id_stmt->fetch(PDO::FETCH_ASSOC);
    $idAdmin = $admin_id_result["idAdmin"];

    # Filtro de atividades por nome
    if (isset($_POST["filtrar_atividades"])) {
        
        # Aceder ao campo de pesquisa 
        $termoPesquisa = $_POST["nome_atividade"];

        # Query de pesquisa 
        $filtro_sql = "SELECT * FROM atividades WHERE nomeAtividade LIKE :nomeAtividade ";
        $filtro_sql .= "AND idAdmin = :idAdmin";
        
        # Definir o prepared statement
        $filtro_stmt = $pdo->prepare($filtro_sql);

        # Executar o prepared statement
        $filtro_stmt->execute([":nomeAtividade" => "%".$termoPesquisa."%", ":idAdmin" => $idAdmin]);

        $resultados_pesquisa = $filtro_stmt->fetchAll();

    }

    # Atalho para edição de atividades
    if (isset($_POST["edit_button_shortcut"])) {

        # Obter o ID da atividade em questão
        $idAtividade = $_POST["idAtividadeEditarShortcut"];
        
        # Acesso aos dados do formulário 
        $novoNomeatividade = $_POST["novo_nome_atividade"];
        $novaDescricaoAtividade = $_POST["nova_descricao_atividade"];
        $novaZonaAtividade = $_POST["nova_zona_atividade"];
        $novaDuracaoAtividade = $_POST["nova_duracao_atividade"];
        $novoCustoAtividade = $_POST["novo_custo_atividade"];

        # Permitir que haja a possibilidade da atividade ser grátis
        if ($novoCustoAtividade === "") {$novoCustoAtividade = "Atividade sem custos";}

        # Obter a referência à antiga imagem
        $antigaImagem = $_POST["antiga_imagem"]; 

        # Aceder ao ficheiro da imagem para upload
        $novaImagemAtividade = $_FILES['novo_ficheiro_imagem']['name'];
        $novaImagemAtividadeTemp = $_FILES['novo_ficheiro_imagem']['tmp_name'];

        # Eliminar os espaços dos campos do formulário
        $novoNomeatividade = trim($novoNomeatividade);
        $novaImagemAtividade = trim($novaImagemAtividade);
        $novaImagemAtividadeTemp = trim($novaImagemAtividadeTemp);
        $novaDescricaoAtividade = trim($novaDescricaoAtividade);
        $novaZonaAtividade = trim($novaZonaAtividade);
        $novaDuracaoAtividade = trim($novaDuracaoAtividade);
        $novoCustoAtividade = trim($novoCustoAtividade);
        $idAtividade = trim($idAtividade);

        # Proteção contra XSS (Cross Site Scripting) - dados do formulário
        $novoNomeatividade = htmlspecialchars($novoNomeatividade, ENT_QUOTES, 'UTF-8');
        $novaImagemAtividade = htmlspecialchars($novaImagemAtividade, ENT_QUOTES, 'UTF-8');
        $novaImagemAtividadeTemp = htmlspecialchars($novaImagemAtividadeTemp, ENT_QUOTES, 'UTF-8');
        $novaDescricaoAtividade = htmlspecialchars($novaDescricaoAtividade, ENT_QUOTES, 'UTF-8');
        $novaZonaAtividade = htmlspecialchars($novaZonaAtividade, ENT_QUOTES, 'UTF-8');
        $novaDuracaoAtividade = htmlspecialchars($novaDuracaoAtividade, ENT_QUOTES, 'UTF-8');
        $novoCustoAtividade = htmlspecialchars($novoCustoAtividade, ENT_QUOTES, 'UTF-8');
        $idAtividade = htmlspecialchars($idAtividade, ENT_QUOTES, 'UTF-8');

        # Não permitir que exista uma atualização sem alterações aos dados
        if (empty($novoNomeatividade) && empty($novaDescricaoAtividade) && empty($novaDuracaoAtividade) && empty($novaZonaAtividade) && empty($novoCustoAtividade)) {

            echo "<script>alert('Não procedeu a qualquer tipo de alteração à atividade!')</script>";

        }

        # Mover a imagem carregada para a pasta respetiva
        move_uploaded_file($novaImagemAtividadeTemp, "img/imgs_atividades/{$novaImagemAtividade}");

        # Certificação de que existe sempre uma imagem de destaque na atividade
        if(empty($novaImagemAtividade)) { $novaImagemAtividade = $antigaImagem; }

        # Atualizar campos da base de dados 
        $sql = "UPDATE atividades SET ";
        $sql .= "nomeAtividade = :novoNomeAtividade, ";
        $sql .= "descricaoAtividade = :novaDescricaoAtividade, ";
        $sql .= "zonaAtividade = :novaZonaAtividade, ";
        $sql .= "duracaoAtividade = :novaDuracaoAtividade, ";
        $sql .= "precoAtividade = :novoPrecoAtividade, ";
        $sql .= "imagemAtividade = :novaImagemAtividade ";
        $sql .= "WHERE idAtividade = :idAtividade ";

        # Preparar o statement
        $stmt = $pdo->prepare($sql);

        # Executar o statement
        $stmt->execute([":novoNomeAtividade" => $novoNomeatividade, ":novaDescricaoAtividade" => $novaDescricaoAtividade, ":novaZonaAtividade" => $novaZonaAtividade, ":novaDuracaoAtividade" => $novaDuracaoAtividade, ":novoPrecoAtividade" => $novoCustoAtividade, ":novaImagemAtividade" => $novaImagemAtividade, ":idAtividade" => $idAtividade]);

        # Refrescar a página com a atividade em questão atualizada
        echo "<script>alert('A atividade foi atualizada com sucesso!')</script>";
        header("Location:area_gestao.php");
        echo "<script>location.reload();</script>"; 

    }

    # Eliminação de um dada atividade 
    if (isset($_POST["eliminar_atividade"])) {

        # Obter o ID da atividade que se deseja eliminar
        $idAtividadeEliminar = $_POST["idAtividadeEliminar"];

        //  # Proteção contra XSS (Cross Site Scripting)
        $idAtividadeEliminar = htmlspecialchars($idAtividadeEliminar, ENT_QUOTES, 'UTF-8');

        // # Query que eliminará a atividade da base de dados 
        $sql = "DELETE FROM atividades WHERE idAtividade = :idAtividade";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":idAtividade" => $idAtividadeEliminar]); 

        # Refrescar a página com a atividade em questão eliminada
        echo "<script> if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); } </script>";
        header("Location:area_gestao.php");
        echo "<script>alert('A atividade foi eliminada com sucesso!')</script>";
            
    }

?>

<!DOCTYPE html>
<html lang="pt">
<head>

    <!-- MetaTags --> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom CSS stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/area_gestao.css">    

    <!-- Ionic icons -->
    <script src="https://unpkg.com/ionicons@4.4.6/dist/ionicons.js"></script>

    <!-- Source Sans Pro Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- Título da página -->
    <title>Paradise Guide | Filtro de atividades</title>
    
</head>

<body>

    <div id="listagem_filtro">

        <div class="top_nav_filtro_atividades"> 

            <!-- Opção de regresso à área de gestão -->
            <a href="area_gestao.php"><button class="btn btn-primary return_button"><ion-icon class="return_button_icon" name="arrow-round-back"></ion-icon>Regressar à administração geral</button></a>

            <!-- Título da área -->
            <h1>Resultado da filtragem por atividades</h1> 
            
            <!-- Opção de logout -->
            <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>
        
        </div>  

        <?php 

            foreach ($resultados_pesquisa as $resultado_pesquisa) {
                
                # Acesso aos campos da base de dados 
                $idAtividade = $resultado_pesquisa["idAtividade"];
                $nomeAtividade = $resultado_pesquisa["nomeAtividade"];
                $descricaoAtividade = $resultado_pesquisa["descricaoAtividade"];
                $zonaAtividade = $resultado_pesquisa["zonaAtividade"];
                $duracaoAtividade = $resultado_pesquisa["duracaoAtividade"];
                $precoAtividade = $resultado_pesquisa["precoAtividade"];
                $imagemAtividade = $resultado_pesquisa["imagemAtividade"];

        ?>

        <div id="resultados_filtro">

            <!-- Lista com os resultados da filtragem das atividades por nome -->
            <div class="list-group">
                
                <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
                <!-- Título da atividade -->
                <h5 class="mb-3 text-center"><?php echo $nomeAtividade; ?></h5>

                <!-- Imagem de destaque da atividade -->
                <img src=<?php echo "img/imgs_atividades/{$imagemAtividade} class='img-responsive edit_img';" ?>>
                
                <!-- Descrição da atividade --> 
                <p class="mb-3"><?php echo $descricaoAtividade;?></p>

                <!-- Zona da atividade --> 
                <p class="mb-2"><span class="subtitulo_listagem">Zona:</span> <?php echo $zonaAtividade; ?></p>

                <!-- Duração média da atividade -->
                <p class="mb-2"><span class="subtitulo_listagem">Duração média:</span> <?php echo $duracaoAtividade; ?></p>  

                <!-- Preço da atividade -->
                <?php 

                    # Mostrar o símbolo do euro apenas caso a atividade possuir um preço
                    if ($precoAtividade !== "Atividade sem custos") {

                ?>

                <p class="mb-2"><span class="subtitulo_listagem">Preço: </span><?php echo $precoAtividade; ?>€</p>

                <?php  } else { ?>
                    
                <!-- Preço da atividade -->
                <p class="mb-2"><span class="subtitulo_listagem">Preço: </span><?php echo $precoAtividade; ?></p>

                <?php } ?>

                <!-- Manager buttons -->
                <div class="manager_buttons">   

                    <!-- Botão para shortcut de edição -->
                    <button type="button" id="edit_button_filter" class="btn">Editar esta atividade</button>


                    <!-- Botão e formulário que elimina uma atividade -->
                    <div>
                        <form method="post" role="form">

                        <!-- Input type "hidden" - ID da atividade --> 
                        <input type="hidden" name="idAtividadeEliminar" value="<?php echo $idAtividade ?>">

                        <button type="submit" name="eliminar_atividade" id="delete_button" 
                        class="btn">Eliminar atividade</button>
                    </div>
                </div>        

        </div>

    </div>

    </div>

    <!-- Shortcut para edição da atividade em questão -->
    <div id="listagem_edicao">
        
            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group">
                
                <div class="list-group-item list-group-item-action flex-column align-items-start active">

                <form action="" method="post" enctype="multipart/form-data">
            
                    <!-- Título da atividade -->
                    <label class="new_name_label" for="novo_ficheiro_atividade">Insira aqui um novo título para a atividade</label>
                    <h5 class="mb-3"><input type="text" class="form-control" name="novo_nome_atividade" value="<?php echo $nomeAtividade ?>"></h5>
                    
                    <!-- Imagem de destaque da atividade -->
                    <label for="nova_imagem">Substituir imagem de destaque</label>
                    <br><br>
                    <img src=<?php echo "img/imgs_atividades/{$imagemAtividade} class='img-responsive edit_img';" ?>>
                    <br>
                    
                    <!-- Opção de substituir a imagem de destaque --> 
                    <input class="new_image" type="file" name="novo_ficheiro_imagem" accept="*/image">
                    <br>

                    <!-- Input type "hidden" - Antiga imagem -->
                    <input type="hidden" name="antiga_imagem" value="<?php echo $imagemAtividade ?>">
                    
                    <!-- Descrição da atividade --> 
                    <label class="new_description_label" for="nova_descricao_atividade">Insira aqui uma nova descrição para a atividade</label>
                    <textarea rows="5" name="nova_descricao_atividade" class="form-control"><?php echo $descricaoAtividade ?></textarea>

                    <!-- Zona da atividade --> 
                    <p class="mb-2"><span class="subtitulo_listagem">Modifique a zona da atividade:</span> <input type="text" name="nova_zona_atividade" class="form-control" value="<?php echo $zonaAtividade ?>"></p>

                    <!-- Duração média da atividade -->
                    <p class="mb-2"><span class="subtitulo_listagem">Modifique a duração da atividade:</span><input class="form-control" type="text" name="nova_duracao_atividade" value="<?php echo $duracaoAtividade ?>"></p>  

                    <!-- Preço da atividade -->
                    <p class="mb-2"><span class="subtitulo_listagem">Modifique o preço da atividade:</span> <input type="text" name="novo_custo_atividade" value="<?php echo $precoAtividade ?>" class="form-control"></p>

                    <!-- Input type "hidden" - idAtividade -->
                    <input type="hidden" name="idAtividadeEditarShortcut" value="<?php echo $idAtividade ?>">

                    <!-- Botão de confirmação da edição -->
                    <button type="submit" name="edit_button_shortcut" id="edit_button_confirm" class="btn">Concluir edição da atividade</button>

                </form>
                
            </div>
            
        </div>

    <?php } ?>

</body>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- Custom JS files -->
<script src="js/admin.js"></script>

</html>