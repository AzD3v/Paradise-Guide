<?php 

    # Verificação do formulário de login administrativo
    if(isset($_POST["admin_login_submit"])) {

        # Aceder aos campos do formulário
        $admin_username = $_POST["admin_username"];
        $admin_password = $_POST["admin_password"];
                
        # Verificar que os campos não se encontram vazios
        if (!empty($admin_username) && !empty($admin_password)) { 

            # Eliminar os espaços dos campos de username e password
            $admin_username = trim($admin_username);
            $admin_password = trim($admin_password);

            # Proteção contra XSS (Cross-Site Scripting)
            $admin_username = htmlspecialchars($admin_username, ENT_QUOTES, 'UTF-8');
            $admin_password = htmlspecialchars($admin_password, ENT_QUOTES, 'UTF-8');

            # Query que retorna os dados do utilizador pretendido 
            $check_user_sql = "SELECT COUNT(id_user_admin) FROM admin_users WHERE "; 
            $check_user_sql .= "admin_username = :admin_username "; 
            $check_user_sql .= "AND admin_password = :admin_password"; 

            # Preparar e executar a query
            $check_admin_stmt = $pdo->prepare($check_user_sql);
            $check_admin_stmt->execute([":admin_username" => $admin_username, 
            ":admin_password" => $admin_password]);
            
            # Fetch efetuado para mais tarde verificar se o username existe na base de dados
            $count = $check_admin_stmt->fetchColumn();
            
            # Verificar que o admin existe
            if ($count == "1") {
                /* Se o admin de facto existe, o login é efetuado com sucesso e o user é 
                reencaminhado para a área de gestão */
                $_SESSION["admin"] = $admin_username;
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

    <form action="" method="post" role="form">
        
        <!-- Username administrativo --> 
        <input type="text" name="admin_username" placeholder="Digite aqui o seu nome de utilizador" required="required" />
        
        <!-- Palavra-passe admnistrativa -->
        <input type="password" name="admin_password" placeholder="Digite aqui a sua palavra-passe" required="required" />
        
        <!-- Botão de submissão -->
        <button type="submit" class="btn btn-primary btn-block btn-large login_btn" name="admin_login_submit">Iniciar sessão</button>
    
    </form>
    
</div>