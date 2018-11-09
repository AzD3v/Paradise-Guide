<!-- Incluir a classe Database -->
<?php include_once("../data/database.php"); ?>

<!-- Definir as messagens de erro de login como vazia inicialmente -->
<?php $error_message_login = ""; ?>

<!-- Session start --> 
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

    <!-- Ionic icons -->
    <script src="https://unpkg.com/ionicons@4.4.6/dist/ionicons.js"></script>

    <!-- Source Sans Pro Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- Page title -->
    <title>Paradise Guide | Área de Gestão</title>
    
</head>

<body>

    <!-- Login administrativo -->
    <?php include_once("admin_login.php"); ?>

</body>
</html>