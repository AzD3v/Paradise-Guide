<!-- Incluir a configuração da base de dados -->
<?php include_once("data/db_config.php"); ?>

<!-- Incluir a classe Database -->
<?php include_once("data/database.php"); ?>

<!-- Iniciar a sessão -->
<?php session_start(); ?>

<?php 

    # Obter ID do cliente em questão 
    $client = $_SESSION["client"];

     # Prepared statement que retorna o ID do admin em questão
    $client_id_sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $client_id_stmt = $pdo->prepare($client_id_sql);
    $client_id_stmt->execute([":username" => $client]);

    # Fetch à base de dados de modo a retornar o ID do utilizador
    $client_id_result = $client_id_stmt->fetch(PDO::FETCH_ASSOC);
    $idUser = $client_id_result["idUser"];
    
?>

<?php 

    # Obter dados da atividade que se deseja comentar
    if (isset($_POST["comentar_reserva"])) {

        # Obter o ID da atividade que se deseja comentar 
        $idAtividadeComentario = $_POST["idAtividade"];
        
        # Query à base de dados 
        $sql_atividade_comentario = "SELECT * FROM atividades WHERE idAtividade = :idAtividade";

        # Definir o prepared statement
        $stmt_atividade_comentario = $pdo->prepare($sql_atividade_comentario);

        # Executar o prepared statement
        $stmt_atividade_comentario->execute([":idAtividade" => $idAtividadeComentario]);

        # Obter dados da atividade em questão 
        $atividadeParaComentar = $stmt_atividade_comentario->fetchAll();

    }

    # Inserir comentário 
    if (isset($_POST["inserir_comentario"])) {
        
        # Obter o ID da atividade em questão 
        $idAtividade = $_POST["idAtividadeFormComentario"];

            # Acesso aos campos do formulário
            echo $tituloComentario = $_POST["titulo_comentario"];
            echo $textoComentario = $_POST["texto_comentario"];
            echo $autorComentario = $_POST["nome_comentario"];
            
            echo $idUser;
            echo $idAtividade;

            # Proteção contra XSS (Cross Site Scripting)
            $idAtividade = htmlspecialchars($idAtividade, ENT_QUOTES, 'UTF-8');
            $idUser = htmlspecialchars($idUser, ENT_QUOTES, 'UTF-8');
            $tituloComentario = htmlspecialchars($tituloComentario, ENT_QUOTES, 'UTF-8');
            $textoComentario = htmlspecialchars($textoComentario, ENT_QUOTES, 'UTF-8');
            $autorComentario = htmlspecialchars($autorComentario, ENT_QUOTES, 'UTF-8');

            # Query à base de dados 
            $sql_inserir_comentario = "INSERT INTO comentarios (idAtividade, idUser, tituloComentario, textoComentario, autorComentario) ";
            $sql_inserir_comentario .= "VALUES(:idAtividade, :idUser, :tituloComentario, :textoComentario, :autorComentario)";

            # Preparar o statement
            $stmt_inserir_comentario = $pdo->prepare($sql_inserir_comentario);
        
            # Executar o statement
            $stmt_inserir_comentario->execute([":idAtividade" => $idAtividade, ":idUser" => $idUser, ":tituloComentario" => $tituloComentario, ":textoComentario" => $textoComentario, ":autorComentario" => $autorComentario]); 

            # Reencaminhar o cliente para a sua área
            header("Location:area_cliente.php");

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
    <title>Paradise Guide | Comentário à atividade</title>
    
</head>

<body id="comentario_page">

    <?php 

    foreach ($atividadeParaComentar as $atividade) {
        
        # Acesso ao nome da atividade proveniente da base de dados
        $nomeAtividade = $atividade["nomeAtividade"];
        $idAtividade = $atividade["idAtividade"];

    ?>
    
        <!-- Grupo que contém os detalhes de cada atividade -->
        <div class="list-group">

        <div class="list-group-item list-group-item-action flex-column align-items-start active">

        <!-- Botão de regresso -->
        <a class="return_button" href="area_cliente.php"><button>Regressar à área de cliente</button></a>
        
        <!-- Título da atividade -->
        <div class="text-center">
            <h5 class="mb-3r">Inserir comentário à atividade: <?php echo $nomeAtividade ?></h5>
            <br>
        </div>

        <form action="" method="post" role="form">
        
            <!-- Título do comentário --> 
            <div class="form-group">
                <label for="titulo_comentario">Título do comentário</label>
                <input type="text" name="titulo_comentario" placeholder="Digite aqui o título que deseja dar ao comentário" required>
            </div>

            <!-- Texto do comentário --> 
            <div class="form-group">
                <label for="texto_comentario">Comentário</label>
                <textarea rows="12" name="texto_comentario" placeholder="Gostou da atividade em questão? Exprima aqui o seu agrado no comentário. Pode também deixar reparos e aspetos a melhorar que poderão ajudar os administradores a realizar atividades cada vez melhores" required></textarea>
            </div>

            <!-- Nome de utilizador escolhido --> 
            <div class="form-group">
                <label for="nome_comentario">Nome de utilizador</label>
                <input type="text" name="nome_comentario" placeholder="Digite aqui o seu nome" required>
            </div>

            <!-- Input type "hidden" - ID da atividade --> 
            <input type="hidden" name="idAtividadeFormComentario" value="<?php echo $idAtividade; ?>">

            <!-- Botão de submissão do comentário -->
            <div style="text-align: center">
                <button type="submit" name="inserir_comentario" id=""class="btn">Inserir comentário à atividade</button></a>
            </div>

        </form>

        </div>
        
    </div>

    <?php } ?>

    </div>

</body>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- Custom JS files -->
<script src="js/client.js"></script>

</html>