<?php 

    # Verificação do formulário de login administrativo
    if(isset($_POST["admin_login_submit"])) {

        # Aceder aos campos do formulário
        $usernameAdmin = $_POST["username_admin"];
        $passwordAdmin = $_POST["password_admin"];
                
        # Verificar que os campos não se encontram vazios
        if (!empty($usernameAdmin) && !empty($passwordAdmin)) { 

            # Eliminar os espaços dos campos de username e password
            $usernameAdmin = trim($usernameAdmin);
            $passwordAdmin = trim($passwordAdmin);

            # Proteção contra XSS (Cross-Site Scripting)
            $usernameAdmin = htmlspecialchars($usernameAdmin, ENT_QUOTES, 'UTF-8');
            $passwordAdmin = htmlspecialchars($passwordAdmin, ENT_QUOTES, 'UTF-8');

            # Query que retorna os dados do utilizador pretendido 
            $check_user_sql = "SELECT COUNT(idAdmin) FROM admin_users WHERE "; 
            $check_user_sql .= "usernameAdmin = :usernameAdmin "; 
            $check_user_sql .= "AND passwordAdmin = :passwordAdmin"; 

            # Preparar e executar a query
            $check_admin_stmt = $pdo->prepare($check_user_sql);
            $check_admin_stmt->execute([":usernameAdmin" => $usernameAdmin, 
            ":passwordAdmin" => $passwordAdmin]);
            
            # Fetch efetuado para mais tarde verificar se o username existe na base de dados
            $count = $check_admin_stmt->fetchColumn();
            
            # Verificar que o admin existe
            if ($count == "1") {
                /* Se o admin de facto existe, o login é efetuado com sucesso e o user é 
                reencaminhado para a área de gestão */
                $_SESSION["admin"] = $usernameAdmin;
                header("Location:area_gestao.php");
            } else {
                # Caso não haja sucesso no login, é mostrada uma mensagem de erro
                $error_message_login = "<div class='alert alert-danger text-center' role='alert'>O seu nome de utilizador ou palavra-passe estão incorretos!</div>";
            }

        }

    }

?>

<!-- Área de ogin administrativo --> 
<div class="admin_login">

    <!-- Título do formulário --> 
    <h1>Login administrativo</h1>
    
    <!-- Mensagem de erro caso o login administrativo não seja bem sucedido -->    
    <?php echo $error_message_login; ?>

    <form action="" method="post" role="form" autocomplete="off">
        
        <!-- Username administrativo --> 
        <input type="text" name="username_admin" placeholder="Digite aqui o seu nome de utilizador" required="required" />
        
        <!-- Palavra-passe admnistrativa -->
        <input type="password" name="password_admin" placeholder="Digite aqui a sua palavra-passe" required="required" />
        
        <!-- Botão de submissão -->
        <button type="submit" class="btn btn-primary btn-block btn-large login_btn" name="admin_login_submit">Iniciar sessão</button>
    
    </form>
    
</div>