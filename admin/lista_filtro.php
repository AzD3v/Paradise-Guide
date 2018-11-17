<!-- Incluir a configuração da base de dados -->
<?php include_once("../data/db_config.php"); ?>

<!-- Incluir a classe Database -->
<?php include_once("../data/database.php"); ?>

<!-- Incluir a classe Activity -->
<?php include_once("../data/activity.php"); ?>

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

                

        </div>

        

    </div>

    <?php } ?>

</body>
</html>