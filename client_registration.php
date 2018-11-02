 <?php 

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

            # Proteção contra XSS (Cross-Site Scripting)
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
            $password_rewrite = htmlspecialchars($password_rewrite, ENT_QUOTES, 'UTF-8');

            # Encriptação da palavra-passe 
            $password_hash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

            # Variável do resultado da query de registo é definido como verdadeiro inicialmente 
            $result = true;
               
            # Validações dos campos (número de caracteres e correspondência das palavras-passe) 
            if(strlen($username) < 5 && strlen($password) < 8) {
                $message_error_register = "<div class='alert alert-warning text-center' role='alert'> O nome de utilizador necessita ter pelo menos 5 caracteres e a palavra-passe necessita de ter pelo ter menos 8 caracteres!</div>";
                $result = false;
            } else if (strlen($password) < 8) {
                $message_error_register = "<div class='alert alert-warning text-center' role='alert'> A palavra-passe escolhida necessita ter pelo menos 8 caracteres!</div>";
                $result = false;
            } else if (strlen($username) < 5) {
                $message_error_register = "<div class='alert alert-warning text-center' role='alert'> O nome de utilizador necessita ter pelo menos 5 caracteres!</div>";
                $result = false;
            } else {
                /* Comparação das palavras-passe introduzidas (condição a ser verificada após
                as validações do número de caracteres) */ 
                if ($password !== $password_rewrite) {
                    $message_error_register = "<div class='alert alert-warning text-center' role='alert'> As palavras-passe não coincidem!</div>";
                    $result = false;
                }
            }

            # Query que irá verificar se o username já existe registado na base de dados
            $usernames_sql = "SELECT COUNT(username) AS username_num FROM users "; 
            $usernames_sql .= "WHERE username = :username";
            $stmt_usernames = $pdo->prepare($usernames_sql);
            $stmt_usernames->execute([":username" => $username]);

            # "Fetch" à base de dados de modo a retornar cada username
            $usernames = $stmt_usernames->fetch(PDO::FETCH_ASSOC);  

            # Query que irá verificar se o email já existe registado na base de dados
            $emails_sql = "SELECT COUNT(email) AS email_num FROM users WHERE email = :email";
            $stmt_emails = $pdo->prepare($emails_sql);
            $stmt_emails->execute([":email" => $email]);
            
            # "Fetch" à base de dados de modo a retornar cada email
            $emails = $stmt_emails->fetch(PDO::FETCH_ASSOC);  
            
            /* Se o username e email já existirem na base de dados, é mostrada 
            uma mensagem de erro */ 
            if ($usernames["username_num"] > 0 && $emails["email_num"] > 0) {
                $message_error_register = "<div class='alert alert-warning text-center' role='alert'> Esse utilizador nome de utilizador e email já se encontram registados!</div>";
                $result = false; 
            }  else if ($usernames["username_num"]) {
                $message_error_register = "<div class='alert alert-warning text-center' role='alert'> Esse nome de utilizador já se encontra registado!</div>";
                return false;  
            } else if ($emails["email_num"] > 0) {
                $message_error_register = "<div class='alert alert-warning text-center' role='alert'> Esse endereço de email já se encontra registado!</div>";
                $result = false;
            }

            /* Caso sejam passadas com sucesso as validações do processo de registo, 
            a variável de resultado retorna "true" */
            if ($result) {
                
                # Inserir campos na base de dados
                $sql = "INSERT INTO users(username, email, password) ";
                $sql .= "VALUES(:username, :email, :password)";
                $stmt = $pdo->prepare($sql);
            
                # Executar o statement
                $result = $stmt->execute([":username" => $username, ":email" => $email, 
                ":password" => $password_hash]);            
                
                # Se o registo foi bem sucedido, atribuir uma variável de sessão ao user 
                $_SESSION["client"] = $username;

                # Encaminhar o user para a sua área de cliente
                header("Location:area_cliente.php");

            }
                
        }

    }
    
?>