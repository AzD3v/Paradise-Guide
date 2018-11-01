<?php 

    # Verificação do formulário de login
    if(isset($_POST["login_submit"])) {

        # Aceder aos campos do formulário
        $username = $_POST["username"];
        $password_attempt = $_POST["password"];
        
        # Verificar que os campos não se encontram vazios
        if (!empty($username) && !empty($password_attempt)) { 

            # Eliminar os espaços dos campos de username e password
            $username = trim($username);
            $password_attempt = trim($password_attempt);

            # Proteção contra XSS (Cross-Site Scripting)
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $password_attempt = htmlspecialchars($password_attempt, ENT_QUOTES, 'UTF-8');

            // Desencriptar a palavra-passe
            # Query que retorna os dados do utilizador pretendido 
            $user_checked = "SELECT id_user, username, password FROM users "; 
            $user_checked .= "WHERE username = :username";
            $check_user_stmt = $pdo->prepare($user_checked);
            $check_user_stmt ->execute([":username" => $username]);
            
            # Fetch efetuado para mais tarde verificar se o username existe na base de dados
            $user = $check_user_stmt->fetch(PDO::FETCH_ASSOC);
            
            # Verificar se o username existe - true ou false 
            if ($user === false) {
                $error_message_login = "<div class='alert alert-danger' role='alert'>O seu 
                nome de utilizador ou palavra-passe estão incorretos!</div>";
            } else {
               
                /* No caso do utilizador de facto existir, comparar a password dada no 
                login com a password encriptada existente na base de dados */
                $valid_password = password_verify($password_attempt, $user["password"]);

                /* Se a password que o utilizador submeteu e password encriptada coincidirem,
                o login é efetuado com sucesso */
                if ($valid_password) {
                    $_SESSION["client"] = $username;
                    header("Location:area_cliente.php");
                } else {
                    $error_message_login = "<div class='alert alert-danger' role='alert'>O seu nome de utilizador ou palavra-passe estão incorretos!</div>";
                }

            }

        }

    }

?>