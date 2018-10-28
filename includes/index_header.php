<!-- Incluir a configuração da base de dados -->
<?php include_once("data/db_config.php"); ?>

<!-- Definir a messagem de erro como vazia inicialmente -->
<?php $message = ""; ?>

<!-- Session start --> 
<?php session_start(); ?>

<?php 

    # Verificação do formulário de login
    if(isset($_POST["login_submit"])) {

        # Aceder aos campos do formulário
        $username = $_POST["username"];
        $password = $_POST["password"];

        # Verificar que os campos não se encontram vazios
        if (!empty($username) && !empty($password)) { 

            # Eliminar os espaços dos campos de username e password
            $username = trim($username);
            $password = trim($password);

            # Efetuar a query
            $sql = "SELECT COUNT(id_user) FROM users WHERE username = :username ";
            $sql .= "AND password = :password";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(["username" => $username, "password" => $password]);

            $count = $stmt->fetchColumn();

            if ($count == "1") {
                $_SESSION['username'] = $username;
                header("Location:area_cliente.php");
            } else {
                $message = "<div class='alert alert-danger' role='alert'>O seu nome de utilizador ou palavra-passe estão incorretos!</div>";
            }

        }

    }

    # Verificação do formulário de registo
    if(isset($_POST["register_submit"])) {

        # Aceder aos campos do formulário
        $username = $_POST["new_user_username"];
        $email = $_POST["new_user_email"];
        $password = $_POST["new_user_password"];
        $password_rewrite = $_POST["new_user_password_rewrite"];

        # Verificar que os campos não se encontram vazios
        if (!empty($username) && !empty($email) && !empty($password) && !empty($password_rewrite)) { 

            # Eliminar os espaços dos campos de username e password
            $username = trim($username);
            $email = trim($email);
            $password = trim($password);
            $password_rewrite = trim($password_rewrite);

            # Validações dos campos (número de caracteres) 
            if (strlen($username) < 5) {
                $message = "<div class='alertalert-warning' role='alert'>O nome de utilizador necessita ter pelo menos 5 caracteres!</div>";
            } else if (strlen($password) < 8) {
                $message = "<div class='alertalert-warning' role='alert'>A palavra-passe escolhida necessita ter pelo menos 8 caracteres!</div>";
            }

            # Comparação das passwords introduzidas 
            if ($password !== $password_rewrite) {
                $message = "<div class='alertalert-warning' role='alert'>As palavras-passe não coincidem!</div>";
            }

            # Verificar se o nome de utilizador já se encontra registado
            $sql = "SELECT COUNT(username) AS username_num FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":username", $username);
            $stmt->execute();
            
            # "Fetch" à base de dados de modo a retornar cada username
            $usernames = $stmt->fetch(PDO::FETCH_ASSOC);  
            
            # Se o username já existir na base de dados, é mostrada uma mensagem de erro 
            if ($usernames["username_num"] > 0) {
                $message = "Esse nome de utilizador já se encontra registado!";
                die();
            } 

            # Verificar se o email já se encontra registado
            $sql = "SELECT COUNT(email) AS email_num FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":username", $username);
            $stmt->execute();
            
            # "Fetch" à base de dados de modo a retornar cada email
            $emails = $stmt->fetch(PDO::FETCH_ASSOC);  
            
            # Se o username já existir na base de dados, é mostrada uma mensagem de erro 
            if ($emails["num"] > 0) {
                $message = "Esse email já se encontra registado!";
                die();
            }

            # Encriptação da palavra-passe 
            $password_hash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

            # Inserir campos na base de dados
            $sql = "INSERT INTO users(username, email, password) ";
            $sql .= "VALUES(:username, :email, :password)";
            $stmt = $pdo->prepare($sql);

            $result = $stmt->execute(["username" => $username, "email" => $email, "password" => $password_hash]);
            
            # Verificar se o processo de registro foi bem-sucedido 
            if($result) {
                $_SESSION['username'] = $username;
                header("Location:area_cliente.php");
            }

        }

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
    <link rel="stylesheet" type="text/css" href="css/homepage.css">

    <!-- Ionic icons -->
    <script src="https://unpkg.com/ionicons@4.4.6/dist/ionicons.js"></script>

    <!-- Source Sans Pro Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- Page title -->
    <title>Paradise Guide | Bem-vindo</title>
</head>