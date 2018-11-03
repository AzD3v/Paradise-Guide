<!-- Incluir a classe Database -->
<?php include_once("data/database.php"); ?>

<!-- Definir as messagens de erro de login e registro como vazias inicialmente -->
<?php $error_message_login = ""; ?>
<?php $message_error_register  = ""; ?>

<!-- Session start --> 
<?php session_start(); ?>

<!-- Incluir o login do cliente --> 
<?php include("client_login.php"); ?>

<!-- Incluir o processo de registo do cliente -->
<?php include("client_registration.php"); ?>

<?php 

    # Se um utilizador se encontra com o login efetuado, é redirecionado para a sua área de cliente 
    if (isset($_SESSION["client"])) {header("Location:area_cliente.php");}

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