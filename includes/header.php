<!-- Incluir a configuração da base de dados -->
<?php include_once("data/db_config.php"); ?>

<!-- Session start --> 
<?php session_start(); ?>

<?php 

    if(isset($_POST["login_submit"])) {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT COUNT(id_user) FROM users WHERE username = :username ";
        $sql .= "AND password = :password";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(["username" => $username, "password" => $password]);

        $count = $stmt->fetchColumn();

        if ($count == "1") {
            $_SESSION['username'] = $username;
        } else {
            
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