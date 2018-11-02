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
            $admin_checked = "SELECT id_user_admin, username_admin, password_admin FROM "; 
            $admin_checked .= "admin_users WHERE admin_username = :admin_username"; 
            $check_admin_stmt = $pdo->prepare($admin_checked);
            $check_admin_stmt->execute([":admin_username" => $admin_username]);
            
            # Fetch efetuado para mais tarde verificar se o username existe na base de dados
            $row = $check_admin_stmt->fetch(PDO::FETCH_ASSOC);
            
            # Verificar que o admin existe
            if ($check_admin_stmt->rowCount() > 0) {
                /* Se o admin de facto existe, o login é efetuado com sucesso e o user é 
                reencaminhado para a área de gestão */
                $_SESSION["admin"] = $admin_username;
                header("Location:area_gestao.php");
            } else {
    
                $error_message_login = "<div class='alert alert-danger' role='alert'>O seu nome de utilizador ou palavra-passe estão incorretos!</div>";

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