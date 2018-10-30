<!-- Incluir a classe Database -->
<?php include_once("data/database.php"); ?>

<!-- Incluir a classe Activity -->
<?php include_once("data/activity.php"); ?>

<!-- Incluir a configuração da base de dados -->
<?php include_once("data/db_config.php"); ?>

<!-- Session start --> 
<?php session_start(); ?>

<!-- Restringir a página para apenas um user registado conseguir aceder à mesma --> 
<?php if (!isset($_SESSION["client"])) {header("Location:index.php");} ?>

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
    <link rel="stylesheet" type="text/css" href="css/area_cliente.css">    

    <!-- Ionic icons -->
    <script src="https://unpkg.com/ionicons@4.4.6/dist/ionicons.js"></script>

    <!-- Source Sans Pro Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- MetaTags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Título da página -->
    <title>Paradise Guide | Área de Cliente</title>
    
</head>