<!-- Funcionalidade de logout --> 
<?php 

    # Verificar se o utilizador não chegou à página pelo link
    session_start();
        if(!isset($_SESSION["cliente"])) {
    }

    # Destruir a variável de sessão
    session_destroy();
    
    # Redirecionar o cliente para o índex
    header('location:../../index.php');

?>