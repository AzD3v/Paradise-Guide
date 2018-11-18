<!-- Incluir a configuração da base de dados -->
<?php include_once("../data/db_config.php"); ?>

<!-- Incluir a classe Database -->
<?php include_once("../data/database.php"); ?>

<!-- Incluir a classe Admin -->
<?php include_once("../data/admin.php"); ?>

<!-- Incluir a classe Activity -->
<?php include_once("../data/activity.php"); ?>

<!-- Iniciar a sessão --> 
<?php session_start(); ?>

<?php 

    /* Um cliente não poderá ter acesso à área admnistrativa (é redirecionado para a 
    área de cliente) */
    if (isset($_SESSION["client"])) {header("Location:../area_cliente.php");}

    /* Um administrador com sessão iniciada é reencaminhado para a área de gestão */
    if (isset($_SESSION["admin"])) {header("Location:area_gestao.php");}

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
    <title>Paradise Guide | Área de criação de atividades</title>
    
</head>

<body>

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
    
    # Verificação do formulário de inserção de uma nova atividade
    if(isset($_POST["submit_insert"])) {

        # Aceder aos campos do formulário (campos de texto)
        $nomeAtividade = $_POST["nome_atividade"];
        $descricaoAtividade = $_POST["descricao_atividade"];
        $zonaAtividade = $_POST["zona_atividade"];
        $duracaoAtividade = $_POST["duracao_atividade"];
        $precoAtividade = $_POST["preco_atividade"];

        # Permitir que haja a possibilidade da atividade ser grátis
        if ($precoAtividade === "") {$precoAtividade = "Atividade sem custos";}

        # Aceder ao ficheiro da imagem para upload
        $imagemAtividade = $_FILES['ficheiro_imagem']['name'];
        $imagemAtividadeTemp = $_FILES['ficheiro_imagem']['tmp_name'];

        # Verificar que os campos não se encontram vazios
        if (!empty($nomeAtividade) && !empty($descricaoAtividade) && !empty($zonaAtividade) && !empty($duracaoAtividade)) { 

            # Eliminar o espaço em branco dos campos de inserção da nova atividade
            $nomeAtividade = trim($nomeAtividade);
            $imagemAtividade = trim($imagemAtividade);
            $imagemAtividadeTemp = trim($imagemAtividadeTemp);
            $descricaoAtividade = trim($descricaoAtividade);
            $zonaAtividade = trim($zonaAtividade);
            $duracaoAtividade = trim($duracaoAtividade);
            $precoAtividade = trim($precoAtividade);

            # Proteção contra XSS (Cross Site Scripting)
            $nomeAtividade = htmlspecialchars($nomeAtividade, ENT_QUOTES, 'UTF-8');
            $imagemAtividade = htmlspecialchars($imagemAtividade, ENT_QUOTES, 'UTF-8');
            $imagemAtividadeTemp = htmlspecialchars($imagemAtividadeTemp, ENT_QUOTES, 'UTF-8');
            $descricaoAtividade = htmlspecialchars($descricaoAtividade, ENT_QUOTES, 'UTF-8');
            $zonaAtividade = htmlspecialchars($zonaAtividade, ENT_QUOTES, 'UTF-8');
            $duracaoAtividade = htmlspecialchars($duracaoAtividade, ENT_QUOTES, 'UTF-8');
            $precoAtividade = htmlspecialchars($precoAtividade, ENT_QUOTES, 'UTF-8');

            # Mover a imagem carregada para a pasta respetiva
            move_uploaded_file($imagemAtividadeTemp, "img/imgs_atividades/{$imagemAtividade}");
            
            # Inserir campos na base de dados
            $sql = "INSERT INTO atividades (idAdmin, nomeAtividade, descricaoAtividade, zonaAtividade, duracaoAtividade, precoAtividade, imagemAtividade) ";
            $sql .= "VALUES(:idAdmin, :nomeAtividade, :descricaoAtividade, :zonaAtividade, :duracaoAtividade, :precoAtividade, :imagemAtividade)";

            # Preparar o statement
            $stmt = $pdo->prepare($sql);
        
            # Executar o statement
            $stmt->execute([":idAdmin" => $idAdmin, ":nomeAtividade" => $nomeAtividade, ":descricaoAtividade" => $descricaoAtividade, ":zonaAtividade" => $zonaAtividade, ":duracaoAtividade" => $duracaoAtividade, ":precoAtividade" => $precoAtividade, ":imagemAtividade" => $imagemAtividade]); 

            # Refrescar a página com a nova atividade incluída
            echo "<script>alert('A sua nova atividade foi adicionada com sucesso!')</script>";
            header("Location:area_gestao.php");

        }
                
    }
        
?>

    <div id="new_activity">

        <div class="top_nav_new_activity">

            <!-- Opção de regresso à área de gestão --> 
            <a href="area_gestao.php"><button class="btn btn-primary return_button"><ion-icon class="return_button_icon" name="arrow-round-back"></ion-icon>Regressar à administração geral</button></a>

            <!-- Título da área -->
            <h1>Área de criação de atividades</h1> 
            
            <!-- Opção de logout -->
            <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>

        </div>

        <!-- Formulário de inserção de uma nova atividade -->
        <div id="insert_activity_form">
            
            <form action="" method="post" autocomplete="off" role="form" enctype="multipart/form-data"> 
                
                <!-- Inserir o nome da atividade --> 
                <div class="form-group">
                    <label for="nome_atividade">Nome da atividade</label>
                    <div class="input-group nome_atividade">
                        <ion-icon name="bonfire" class="nome_atividade_icon"></ion-icon>
                        <input type="text" name="nome_atividade" placeholder="Digite aqui o nome da nova atividade" class="form-control nome_atividade" required>
                    </div>
                </div>

                <!-- Inserir a descrição da atividade --> 
                <div class="form-group">
                    <label for="new_user_email">Descrição da atividade</label>
                    <div class="input-group descricao_atividade">
                        <ion-icon name="book"></ion-icon>
                        <textarea rows="5" name="descricao_atividade" placeholder="Descreva aqui de forma concisa e explicativa de que se trata a atividade em questão" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="inline_fields_labels">

                    <!-- Inserir a zona da atividade --> 
                    <label for="zona_atividade">Zona da atividade</label>

                    <!-- Duração média da atividade --> 
                    <label for="duracao_atividade">Duração média</label>

                    <!-- Preço da atividade -->
                    <label for="preco_atividade">Preço base da atividade</label>

                </div>

                <div class="form-inline">

                    <!-- Inserir zona da atividade -->
                    <div class="input-group zona_atividade">
                        <ion-icon name="compass"></ion-icon>
                        <input type="text" name="zona_atividade" placeholder="Ex: Sete Cidades" class="form-control" required>
                    </div>
                    
                    <!-- Inserir duração da atividade -->
                    <div class="input-group duracao_atividade">
                        <ion-icon name="time"></ion-icon>
                        <input type="text" name="duracao_atividade" placeholder="Ex: Aprox 2h" class="form-control" required>
                    </div>

                    <!-- Inserir preço da atividade -->
                    <div class="input-group preco_atividade">
                        <ion-icon name="cash"></ion-icon>
                        <input type="text" name="preco_atividade" placeholder="Ex: Desde 30€" class="form-control">
                    </div>

                </div>

                <!-- Upload da imagem de destaque da atividade --> 
                <div class="form-group upload_imagem_label">
                    <label for="zona_atividade">Upload da imagem de destaque da atividade</label>
                    <br>
                    <input type="file" name="ficheiro_imagem" accept="*/image">
                </div>
                
                <!-- Botão de submissão -->
                <div style="text-align: center">
                    <button type="submit" name="submit_insert" id="insert_button" 
                    class="btn">Inserir nova atividade</button>
                </div>
            
            </form>

        </div>

    </div>

</body>
</html>