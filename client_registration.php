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

            # Validações dos campos (número de caracteres) 
            if (strlen($username) < 5) {
                $message = "<div class='alertalert-warning' role='alert'>O nome de utilizador necessita ter pelo menos 5 caracteres!</div>";
            } else if (strlen($password) < 8) {
                $message = "<div class='alertalert-warning' role='alert'>A palavra-passe escolhida necessita ter pelo menos 8 caracteres!</div>";
            }

            # Comparação das passwords introduzidas 
            // if ($password !== $password_rewrite) {
            //     $message = "<div class='alertalert-warning' role='alert'>As palavras-passe não coincidem!</div>";
            // }

            # Verificar se o nome de utilizador já se encontra registado
            // $sql = "SELECT COUNT(username) AS username_num FROM users WHERE username = :username";
            // $stmt = $pdo->prepare($sql);
            // $stmt->bindValue(":username", $username);
            // $stmt->execute();
            
            # "Fetch" à base de dados de modo a retornar cada username
            // $usernames = $stmt->fetch(PDO::FETCH_ASSOC);  
            
            # Se o username já existir na base de dados, é mostrada uma mensagem de erro 
            // if ($usernames["username_num"] > 0) {
            //     $message = "Esse nome de utilizador já se encontra registado!";
            //     die();
            // } 

            # Verificar se o email já se encontra registado
            // $sql = "SELECT COUNT(email) AS email_num FROM users WHERE email = :email";
            // $stmt = $pdo->prepare($sql);
            // $stmt->bindValue(":email", $email);
            // $stmt->execute();
            
            # "Fetch" à base de dados de modo a retornar cada email
            // $emails = $stmt->fetch(PDO::FETCH_ASSOC);  
            
            # Se o username já existir na base de dados, é mostrada uma mensagem de erro 
            // if ($emails["email_num"] > 0) {
            //     $message = "Esse email já se encontra registado!";
            //     die();
            // }

            # Encriptação da palavra-passe 
            $password_hash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

            # Inserir campos na base de dados
            $sql = "INSERT INTO users(username, email, password) ";
            $sql .= "VALUES(:username, :email, :password)";
            $stmt = $pdo->prepare($sql);
            
            # Atribuição dos valores 
            $stmt->bindValue(":username", $username);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":password", $password_hash);
            
            # Executar o statement
            $result = $stmt->execute();

            # Verificar se o processo de registro foi bem-sucedido 
            if($result) {
                
                # Se o login foi bem sucedido, atribuir uma variável de sessão ao user 
                $_SESSION["client"] = $username;

                # Encaminhar o user para a sua área de cliente
                header("Location:area_cliente.php");
                
            }

        }

    }
    
?>