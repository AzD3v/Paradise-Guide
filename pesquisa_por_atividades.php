<!-- Incluir a configuração da base de dados -->
<?php include_once("data/db_config.php"); ?>

<!-- Incluir a classe Database -->
<?php include_once("data/database.php"); ?>

<!-- Incluir a classe Activity -->
<?php include_once("data/activity.php"); ?>

<?php 

    # Filtro de atividades por nome
    if (isset($_POST["pesquisa_por_atividades"])) {
        
        # Aceder ao select de pesquisa por localização geográfica
        $zonaAtividade = $_POST["localizacao_geografica"];

        # Aceder ao campo de pesquisa 
        $termoPesquisa = $_POST["nome_atividade"];

        # Escolha da query consoante o modo de pesquisa do utilizador
        if (empty($zonaAtividade)) {

            # Query de pesquisa 
            $filtro_sql = "SELECT * FROM atividades WHERE nomeAtividade LIKE :nomeAtividade"; 
            
            # Definir o prepared statement
            $filtro_stmt = $pdo->prepare($filtro_sql);

            # Executar o prepared statement
            $filtro_stmt->execute([":nomeAtividade" => "%".$termoPesquisa."%"]); 

        } else {

            # Query de pesquisa
            $filtro_sql = "SELECT * FROM atividades WHERE nomeAtividade LIKE :nomeAtividade ";
            $filtro_sql .= "AND zonaAtividade LIKE :zonaAtividade";  
            
            # Definir o prepared statement
            $filtro_stmt = $pdo->prepare($filtro_sql);

            # Executar o prepared statement
            $filtro_stmt->execute([":nomeAtividade" => "%".$termoPesquisa."%", ":zonaAtividade" => $zonaAtividade]); 

        }

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
    <link rel="stylesheet" type="text/css" href="css/area_cliente.css">    
    <link rel="stylesheet" type="text/css" href="css/homepage.css">

    <!-- Ionic icons -->
    <script src="https://unpkg.com/ionicons@4.4.6/dist/ionicons.js"></script>

    <!-- Source Sans Pro Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- MetaTags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Título da página -->
    <title>Paradise Guide | Resultados de pesquisa</title>
    
</head>

<body class="search_page_not_log">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="index.php"><img class="logo_index" src="img/logo.png"></a>
        
        <!-- Navbar collapse -->
        <div class="collapse navbar-collapse" id="navbarColor03">

            <ul class="navbar-nav mr-auto"></ul>

                <!-- Search form -->
                <form action="" autocomplete="off" method="post" class="searchform cf">
                <select name="localizacao_geografica" class="form-control">
                    <option value="">Em toda a ilha</option>
                    <option value="Ponta Delgada">Ponta Delgada</option>
                    <option value="Lagoa">Lagoa</option>
                    <option value="Ribeira Grnade">Ribeira Grande</option>
                    <option value="Vila Franca do Campo">Vila Franca do Campo</option>
                    <option value="Lagoa">Lagoa</option>
                    <option value="Nordeste">Nordeste</option>
                </select>
                    <input type="text" name="nome_atividade" placeholder="Pesquise aqui por atividades">
                    <button type="submit" name="pesquisa_por_atividades">Pesquisar!</button>
                </form>
                
            </ul>

        </div>
    </nav>
    <!-- Navbar end -->

    <div id="not_log_search">

         <?php  if (empty($resultados_pesquisa)) {
        
        ?>

        <h1>Não existem resultados</h1>

        <?php } else {

        ?>

        <h1>Resultados da sua pesquisa</h1>

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

            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group">
            <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
            <!-- Título da atividade -->
            <div class="text-center">
                <h5 class="mb-3r"><?php echo $nomeAtividade ?></h5>
            </div>
            
            <!-- Descrição da atividade --> 
            <p class="mb-3"><?php echo $descricaoAtividade; ?></p>

            <!-- Zona da atividade --> 
            <p class="mb-2"><span class="subtitulo_listagem">Zona:</span> <?php echo $zonaAtividade; ?></p>

            <!-- Duração média da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Duração média:</span> <?php echo $duracaoAtividade; ?></p>  

             <?php 

                # Mostrar o símbolo do euro apenas caso a atividade possuir um preço
                if ($precoAtividade !== "Atividade sem custos") {

            ?>

            <!-- Preço da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $precoAtividade ?>€</p>

            <?php } else { ?>

            <!-- Preço da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $precoAtividade ?></p>

            <?php } ?>

                <!-- Imagem de destaque da atividade -->
                <img src=<?php echo "admin/img/imgs_atividades/{$imagemAtividade} class='img-responsive';" ?>>

                    <!-- Botão de submissão --> 
                    <div style="text-align: center">
                        <a href="area_cliente.php#<?php echo $idAtividade; ?>"><button name="reservar_atividade">Interessa-lhe? Preencha o formulário de reserva respetivo!</button></a>
                    </div>

                </form>

            </div>
        
        </div>

        <?php } } ?>

    </div>
                    
    </div>

</body>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- Custom JS files -->
<script src="js/client.js"></script>

</html>