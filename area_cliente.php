<!-- Header da área de cliente -->
<?php include_once("includes/includes_area_cliente/area_cliente_header.php"); ?>

<?php 
    
    # Definir mensagens de sucesso e de erro - vazias inicialmente
    $error_message = "";
    $success_message = "";
    $repeat_reserve_message = "";
    $message_after_delete = "";
    
?>

<?php 

    # Aceder a todos os dados de cada atividade
    $activities = Activity::find_all_activities(); 

    // Funcionalidade que possibilita reservar atividades
    # Obter o ID do utilizador que possui sessão iniciada
    $username = $_SESSION["client"];
    $id_user = User::find_id_by_username($username);
    $idUser = $id_user->idUser;

    /* Definição do array que irá guardar os novos dados associados a uma reserva (ID do user e ID da atividade) */
    $new_reserve = [];

    // Processo de inserção na base de dados
    if (isset($_POST["reserve_btn"])) {
        
        # Obter o número do cartão de crédito
        $cartaoCredito = $_POST["credit_card"];
        $idAtividade = $_POST["idAtividade"];

        if (!empty($cartaoCredito)) {
            
            /* Eliminar todo o "whitespace" em branco do campo que contém o número 
            de cartão de crédito */
            $cartaoCredito = trim(preg_replace('/\s+/', '', $cartaoCredito));

            # Proteção contra XSS (Cross Site Scripting)
            $cartaoCredito = htmlspecialchars($cartaoCredito, ENT_QUOTES, 'UTF-8');

            # Encriptação do cartão de crédito
            $bytes = openssl_random_pseudo_bytes(8, $cstrong);
            $key = bin2hex($bytes);
            $plaintext = $cartaoCredito;
            $cipher = "aes-128-gcm";

            if (in_array($cipher, openssl_get_cipher_methods())) {
                $ivlen = openssl_cipher_iv_length($cipher);
                $iv = openssl_random_pseudo_bytes($ivlen);
                $cipherCartaoCredito = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
            }

            # Variável do resultado das validações definida como verdadeira inicialmente 
            $result = true;

            /* Inserindo o ID do user com sessão iniciada e o ID da atividade a ser reserva no
            array que contém os dados de uma nova reserva */
            array_push($new_reserve, $idUser);
            array_push($new_reserve, $idAtividade);

            # Obtenção de todas as reservas
            $all_reserves = Reserve::find_all_reserves();

            /* Inserir um array específico todas as atividades reservadas pelo utilizador com sessão iniciada */
            $user_reserves = [];
            foreach ($all_reserves as $the_reserve) {
                array_push($user_reserves, $the_reserve->idUser);
                array_push($user_reserves, $the_reserve->idAtividade);             
            }
            
            # Procura por reservas repetidas
            $repeated_reserves = !array_diff($new_reserve, $user_reserves);
            
            # Caso exista uma duplicação de reservas, a reserva não é submetida
            if($repeated_reserves) {
                $repeat_reserve_message = "<div class='alert alert-warning text-center' role='alert'>Já reservou esta atividade! Poderá verificar a reserva <a href='' onclick='return false;' class='check_reserves'>aqui</a>.</div>";
                $result = false;
            } 

        }   

            # Validação do número de cartão de crédito (número de caracteres) - sem encriptação
            if (strlen($cartaoCredito) !== 16) {
                $error_message = "<div class='alert alert-danger text-center' role='alert'>O número de cartão de crédito introduzido não é válido!</div>";
                $result = false;
            } 

            /* Caso a validação do número de cartão de crédito obtenha sucesso
            a variável de resultado retorna "true" */
            if ($result) {
                
                $success_message = "<div class='alert alert-success text-center' role='alert'>A atividade foi reservada com sucesso! Poderá verificar o estado da mesma na sua <a href='' onclick='return false;' class='check_reserves' id='check_success'>lista de atividades</a>.</div>";

                # Proceder à reserva de uma dada atividade
                $sql = "INSERT INTO reservas (idAtividade, idUser, cartaoCredito, estadoReserva) ";
                $sql .= "VALUES(:idAtividade, :idUser, :cartaoCredito, :estadoReserva)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([":idAtividade" => $idAtividade, ":idUser" => $idUser, ":cartaoCredito" => $cipherCartaoCredito, ":estadoReserva" => "Marcada"]);
                
            }
            
        }

    # Cancelamento de uma dada atividade 
    if (isset($_POST["cancelar_atividade"])) {

        # Obter o ID da atividade que se deseja eliminar
        $idReserva = $_POST["idReserva"];

         # Proteção contra XSS (Cross Site Scripting)
        $idReserva = htmlspecialchars($idReserva, ENT_QUOTES, 'UTF-8');

        # Query que eliminará a atividade da base de dados 
        $sql = "DELETE FROM reservas WHERE idReserva = :idReserva";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":idReserva" => $idReserva]); 

        # Mensagem que aparecerá após uma atividade ser eliminada 
        $message_after_delete = "<div class='alert alert-danger text-center' role='alert'>Lamentamos o seu cancelamento da atividade! Esperemos que encontre uma do seu agrado na nossa vasta lista!</div>";

    }         
                

?>

<body class="body_area_cliente">

    <!-- Navbar da área de cliente -->
    <?php include_once("includes/includes_area_cliente/area_cliente_navbar.php"); ?>

    <!-- Listagem de todas as atividades disponíveis --> 
    <div id="all_activities">

        <h1>Aqui se encontram todas as atividades disponíveis</h1>

        <!-- Display da mensagem de sucesso após uma reserva ser efetuada --> 
        <?php echo $success_message; ?>

        <!-- Display da mensagem de aviso após uma reserva ser efetuada em duplicado --> 
        <?php echo $repeat_reserve_message; ?>

        <!-- Display da mensagem pós-eliminação de uma atividade --> 
        <?php echo $message_after_delete; ?>

        <?php

        foreach($activities as $activity) {
        
        ?>
            
            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group">
            <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
            <!-- Título da atividade -->
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-3"><?php echo $activity->nomeAtividade; ?></h5>
            </div>
            
            <!-- Descrição da atividade --> 
            <p class="mb-3"><?php echo $activity->descricaoAtividade; ?></p>

            <!-- Zona da atividade --> 
            <p class="mb-2"><span class="subtitulo_listagem">Zona:</span> <?php echo $activity->zonaAtividade; ?></p>

            <!-- Duração média da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Duração média:</span> <?php echo $activity->duracaoAtividade; ?></p>  

             <?php 

                # Mostrar o símbolo do euro apenas caso a atividade possuir um preço
                if ($activity->precoAtividade !== "Atividade sem custos") {

            ?>

            <!-- Preço da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $activity->precoAtividade; ?>€</p>

            <?php } else { ?>

            <!-- Preço da atividade -->
            <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $activity->precoAtividade; ?></p>

            <?php } ?>

                <!-- Imagem de destaque da atividade -->
                <img src=<?php echo "img/imgs_atividades/{$activity->imagemAtividade} class='img_listagem img-responsive';" ?>>
                
                <!-- Separador --> 
                <hr class="hr_style">

                <!-- Formulário de reserva - através de cartão de crédito -->
                <h3 class="call_to_reserve">Deseja reservar esta atividade? Proceda ao preenchimento do formulário abaixo!</h3>

                <form action="" method="post" autocomplete="off" id="reserve_form" role="form">

                        <!-- Transmissão da mensagem de erro consoante a validação 
                        do cartão de crédito e confirmação do ID da atividade -->
                        <?php 
                                    
                            if (!empty($_POST["idAtividade"])) {
                                if($_POST["idAtividade"] === $activity->idAtividade) { 
                                    echo $error_message;
                                }
                            }
                                    
                        ?>

                        <!-- Número do cartão de crédito -->
                        <div class="form-group">
                            <label>Número do cartão de crédito</label>
                            <input type="text" name="credit_card" class="cn form-control" placeholder="" required>
                        </div>

                        <!-- Data de expiração do cartão de crédito -->
                        <div class="form-group">
                            <label>Data de expiração</label>
                            <input type="text" name="expiration_date" id="exp" placeholder="MM / AA" class="form-control" required>
                        </div>

                        <!-- Nome presente no cartão de crédito -->
                        <div class="form-group">
                        <label>Nome presente no cartão</label>
                        <input type="text" name="card_name" id="card_name" placeholder="Digite aqui o nome presente no cartão" class="form-control" required>
                        
                        <!-- Input type "hidden" - idAtividade -->
                        <input type="hidden" name="idAtividade" value="<?php echo $activity->idAtividade; ?>">

                     </div>

                    <!-- Botão de reserva -->
                    <div style="text-align: center">
                        <button type="submit" name="reserve_btn" id="reserve_button" 
                        class="btn">Reservar atividade!</button>
                    </div>

                </form>

            </div>
        
        </div>

        <?php } ?>

    </div>
                    
    <?php 

        # Display das atividades reservadas pelo utilizador se estas existirem
        $user_reserves = Reserve::find_user_reserves($idUser);
        
        if (!empty($user_reserves)) {
        
    ?>
                            
    <!-- Atividades escolhidas pelo utilizador -->
    <div id="user_activities">

        <h1>Pode consultar aqui todas as suas atividades reservadas</h1>
        
        <!-- Tabela com todas as atividades escolhidas pelo utilizador --> 
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Nome da atividade</th>
                        <th>Descrição da atividade</th>
                        <th>Zona</th>
                        <th>Duração média</th>
                        <th>Imagem</th>
                        <th>Preço</th>
                        <th>Estado</th>
                        <th>Desmarcar atividade</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <?php 

                    # Obter da base de dados todas as reservas efetuadas pelo utilizador --> 
                    $reserves = Reserve::find_all_reserves();

                    /* Relacionar as tabelas "atividades" e "reservas", de modo a obter as reservas e atividades do utilizador em questão */
                    foreach ($reserves as $reserve) {
                        $idReserva = $reserve->idReserva;
                        $idAtividadeReserva = $reserve->idAtividade;
                        $estadoReserva = $reserve->estadoReserva;
                        $userReserva = $reserve->idUser;

                        if ($userReserva === $idUser) {

                            foreach($activities as $activity) {
                                
                                $idAtividade = $activity->idAtividade;
                                
                                if ($idAtividadeReserva === $idAtividade) {
                                    
                                    echo "<tr>";
                                    echo "<td>{$activity->nomeAtividade}</td>";
                                    echo "<td>{$activity->descricaoAtividade}</td>";
                                    echo "<td>{$activity->zonaAtividade}</td>";
                                    echo "<td>{$activity->duracaoAtividade}</td>";
                                    echo "<td>{$activity->imagemAtividade}</td>";
                                    echo "<td>{$activity->precoAtividade}€</td>";
                                    echo "<td>{$reserve->estadoReserva}</td>";
                                    
                                    ?>

                                    <!-- Opção de cancelar a reserva --> 
                                    <form method="post">

                                        <!-- Campo hidden que contém o ID da atividade que se
                                        deseja eliminar -->
                                        <input type="hidden" name="idReserva" value="<?php echo $idReserva; ?>">
                                    
                                    <?php 

                                        # Botão que cancela uma dada atividade
                                        echo "<td><button type='submit' name='cancelar_atividade' class='btn-danger btn-block'>Cancelar</button></td>" ;
                                    
                                    ?>

                                    </form>

                                    <?php 
                                    
                                    echo "</tr>";

                                }

                            }

                        }

                    }

                    ?>

                </tbody>
            
            </table>

        </div>

    </div> 

    <?php } else { ?>

        <div id="user_activities">
            
            <h1 class="alert alert-info text-center">Não possui atividades reservadas! Consulte a nossa <a class="check_all_activities" href="" onclick="return false;">vasta lista</a> e escolha uma que lhe agrade ou mais!</h1>
            
        </div>
    
    <?php } ?>

    <!-- Footer do índex -->
    <?php include_once("includes/includes_area_cliente/area_cliente_footer.php"); ?>

</body>
</html>