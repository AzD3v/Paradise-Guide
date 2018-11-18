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

    # Obter ID do cliente em questão 
    $client = $_SESSION["client"];

     # Prepared statement que retorna o ID do admin em questão
    $client_id_sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
    $client_id_stmt = $pdo->prepare($client_id_sql);
    $client_id_stmt->execute([":username" => $client]);

    # Fetch à base de dados de modo a retornar o ID do utilizador
    $client_id_result = $client_id_stmt->fetch(PDO::FETCH_ASSOC);
    $idUserComSessao = $client_id_result["idUser"];

    # Aceder a todos os dados de cada atividade
    $activities = Activity::find_all_activities(); 

    # Aceder a todos os dados de cada comentário às atividades 
    $comments = Comment::find_all_comments();

    # Prepared statement que retorna todas as reservas do utilizador em questão
    $user_reservas_sql = "SELECT idAtividade FROM reservas WHERE idUser = :idUser";
    $user_reservas_stmt = $pdo->prepare($user_reservas_sql);
    $user_reservas_stmt->execute([":idUser" => $idUserComSessao]);

    # Fetch à base de dados de modo a retornar todas as reservadas do utilizador
    $user_reservas = $user_reservas_stmt->fetchAll();

    # Definir array que irá guardar as reservas do utilizador 
    $user_reservas_array = [];

    # Guardar as atividades do utilizador num array
    foreach ($user_reservas as $user_reserva) {
        $user_reservas_array = $user_reserva;
    }

    // Funcionalidade que possibilita reservar atividades
    # Processo de inserção de uma atividade na base de dados
    if (isset($_POST["reserve_btn"])) {
        
        # Obter dados dos campos do formulário de reserva 
        $cartaoCredito = $_POST["cartao_credito"];
        $expiracaoCartao = $_POST["data_expiracao"];
        $nomeCartao = $_POST["nome_cartao"];

        # Obter o ID do admin associado à atividade
        $idAdmin = $_POST["idAdmin"];

        # Obter o ID da atividade em questão
        $idAtividade = $_POST["idAtividade"];

        # Proteção contra XSS (Cross Site Scripting) - ID da atividade
        $idAtividade = htmlspecialchars($idAtividade, ENT_QUOTES, 'UTF-8');

        if (!empty($cartaoCredito) && !empty($expiracaoCartao) && !empty($nomeCartao)) {
            
            /* Eliminar todo o "whitespace" em branco do campo que contém o número 
            de cartão de crédito */
            $cartaoCredito = trim(preg_replace('/\s+/', '', $cartaoCredito));

            /* Eliminar o espaço em branco dos campos de expiração do cartão e nome presente no cartão */
            $expiracaoCartao = trim($expiracaoCartao);
            $nomeCartao = trim($nomeCartao);

            # Proteção contra XSS (Cross Site Scripting)
            $cartaoCredito = htmlspecialchars($cartaoCredito, ENT_QUOTES, 'UTF-8');
            $expiracaoCartao = htmlspecialchars($expiracaoCartao, ENT_QUOTES, 'UTF-8');
            $nomeCartao = htmlspecialchars($nomeCartao, ENT_QUOTES, 'UTF-8');

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
            
            # Caso exista uma duplicação de reservas, a reserva não é submetida
            if(in_array($idAtividade, $user_reservas_array)) {
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
                $sql = "INSERT INTO reservas (idAtividade, idUser, idAdmin, cartaoCredito, expiracaoCartao, nomeCartao, estadoReserva) ";
                $sql .= "VALUES(:idAtividade, :idUser, :idAdmin, :cartaoCredito, :expiracaoCartao, :nomeCartao, :estadoReserva)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([":idAtividade" => $idAtividade, ":idUser" => $idUserComSessao, ":idAdmin" => $idAdmin, ":cartaoCredito" => $cipherCartaoCredito, ":expiracaoCartao" => $expiracaoCartao, ":nomeCartao" => $nomeCartao, ":estadoReserva" => "Marcada"]);

                # Refrescar a página
                echo "<script> if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); } </script>";
                
            }
            
        }

    # Cancelamento de uma dada reserva
    if (isset($_POST["cancelar_reserva"])) {

        # Obter o ID da reserva que se deseja eliminar
        $idReserva = $_POST["idReserva"];

         # Proteção contra XSS (Cross Site Scripting)
        $idReserva = htmlspecialchars($idReserva, ENT_QUOTES, 'UTF-8');

        # Query que eliminará a reserva da base de dados 
        $sql = "DELETE FROM reservas WHERE idReserva = :idReserva";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":idReserva" => $idReserva]); 

        # Mensagem que aparecerá após uma reserva ser eliminada 
        $message_after_delete = "<div class='alert alert-danger text-center' role='alert'>Lamentamos o seu cancelamento da atividade! Esperemos que encontre uma do seu agrado na nossa vasta lista!</div>";

    }         
                

?>

<body class="body_area_cliente">

    <!-- Navbar da área de cliente -->
    <?php include_once("includes/includes_area_cliente/area_cliente_navbar.php"); ?>

    <!-- Listagem de todas as atividades disponíveis --> 
    <div id="all_activities">

        <!-- Modal de pesquisa -->
        <div class="modal fade" id="search_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Efetue aqui a sua pesquisa</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Pesquisa por atividades -->
                        <form action="pesquisa_por_atividades.php" autocomplete="off" method="post">
                            <div class="form-group">    
                                <input type="text" name="nome_atividade" class="form-control" placeholder="Pesquise aqui por atividades">
                                <select name="localizacao_geografica" class="form-control">
                                    <option value="">Em toda a ilha</option>      
                                    <option value="Ponta Delgada">Ponta Delgada</option>
                                    <option value="Lagoa">Lagoa</option>
                                    <option value="Ribeira Grande">Ribeira Grande</option>
                                    <option value="Vila Franca do Campo">Vila Franca do Campo</option>
                                    <option value="Lagoa">Lagoa</option>
                                    <option value="Nordeste">Nordeste</option>
                                </select>
                            </div>  
                    </div>
                    <div class="modal-footer">
                        <button class="text-center" type="submit" name="pesquisa_por_atividades">Pesquisar!</button>   
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <h1>Aqui se encontram todas as atividades disponíveis</h1>

        <!-- Display da mensagem de sucesso após uma reserva ser efetuada --> 
        <?php echo $success_message; ?>

        <!-- Display da mensagem de aviso após uma reserva ser efetuada em duplicado --> 
        <?php echo $repeat_reserve_message; ?>

        <!-- Display da mensagem pós-eliminação de uma atividade --> 
        <?php echo $message_after_delete; ?>

        <?php

        # Display de todas as atividades
        foreach($activities as $activity) {
             
            # Acesso ao ID da atividade em questão
            $idAtividade = $activity->idAtividade;
        
        ?>
            
            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group">
            <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
            <!-- Título da atividade -->
            <div class="text-center">
                <h5 class="mb-3r"><?php echo $activity->nomeAtividade; ?></h5>
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
                <img src=<?php echo "admin/img/imgs_atividades/{$activity->imagemAtividade} class='img_listagem img-responsive';" ?>>
                
                <!-- Separador --> 
                <hr class="hr_style" id="<?php echo $idAtividade; ?>">
                
                <!-- Display dos comentários de acordo com o utilizador --> 
                <?php foreach ($comments as $comment) {$userComentario = $comment->idUser;}?>
                
                <!-- Comentários à atividade - caso esta já se encontre realizada -->
                <?php if ($activity->estadoAtividade === "1") {
                
                ?>
                
                <!-- Título da atividade -->
                <div class="text-center">
                    <h5 class="mb-3r">Comentários à atividade</h5>
                </div>
                
                <?php

                    foreach ($comments as $comment) {

                        $idAtividadeComentarios = $comment->idAtividade;
                        $idAtividadeRealizada = $activity->idAtividade;
                        $userComentario = $comment->idUser;

                        if ($idAtividadeComentarios === $idAtividadeRealizada) {

                            if ($idUserComSessao === $userComentario) {

                ?>

                <!-- Título do comentário --> 
                <p class="mb-3"><span class="subtitulo_listagem">Título do comentário:</span> <?php echo $comment->tituloComentario; ?></p>

                <!-- Texto do comentário --> 
                <p class="mb-2"><span class="subtitulo_listagem">Comentário:</span> <?php echo $comment->textoComentario; ?></p>

                <!-- Autor do comentário -->
                <p class="mb-2"><span class="subtitulo_listagem">Autor:</span> <?php echo $comment->autorComentario; ?></p>  

                <br>
                
                <hr class="hr_style">

                <?php } else {

                ?> 

                <!-- Título do comentário --> 
                <p class="mb-3"><span class="subtitulo_listagem">Título do comentário:</span> <?php echo $comment->tituloComentario; ?></p>

                <!-- Texto do comentário --> 
                <p class="mb-2"><span class="subtitulo_listagem">Comentário:</span> <?php echo $comment->textoComentario; ?></p>

                <!-- Autor do comentário -->
                <p class="mb-2"><span class="subtitulo_listagem">Autor:</span> <?php echo $comment->autorComentario; ?></p>  

                <br><br>

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
                            <input type="text" name="cartao_credito" class="cn form-control" placeholder="####-####-####-####" required>
                        </div>

                        <!-- Data de expiração do cartão de crédito -->
                        <div class="form-group">
                            <label>Data de expiração</label>
                            <input type="text" name="data_expiracao" id="exp" placeholder="MM / AA" class="form-control" required>
                        </div>

                        <!-- Nome presente no cartão de crédito -->
                        <div class="form-group">
                        <label>Nome presente no cartão</label>
                        <input type="text" name="nome_cartao" id="card_name" placeholder="Digite aqui o nome presente no cartão" class="form-control" required>

                        <!-- Input type "hidden" - idAdmin-->
                        <input type="hidden" name="idAdmin" value="<?php echo $activity->idAdmin; ?>">
                        
                        <!-- Input type "hidden" - idAtividade -->
                        <input type="hidden" name="idAtividade" value="<?php echo $activity->idAtividade; ?>">

                     </div>

                    <!-- Botão de reserva -->
                    <div style="text-align: center">
                        <button type="submit" name="reserve_btn" id="reserve_button" 
                        class="btn">Reservar atividade!</button>
                    </div>

                </form>

            <?php } } } } else { ?> 

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
                            <input type="text" name="cartao_credito" class="cn form-control" placeholder="" required>
                        </div>

                        <!-- Data de expiração do cartão de crédito -->
                        <div class="form-group">
                            <label>Data de expiração</label>
                            <input type="text" name="data_expiracao" id="exp" placeholder="MM / AA" class="form-control" required>
                        </div>

                        <!-- Nome presente no cartão de crédito -->
                        <div class="form-group">
                        <label>Nome presente no cartão</label>
                        <input type="text" name="nome_cartao" id="card_name" placeholder="Digite aqui o nome presente no cartão" class="form-control" required>

                        <!-- Input type "hidden" - idAdmin-->
                        <input type="hidden" name="idAdmin" value="<?php echo $activity->idAdmin; ?>">
                        
                        <!-- Input type "hidden" - idAtividade -->
                        <input type="hidden" name="idAtividade" value="<?php echo $activity->idAtividade; ?>">

                     </div>

                    <!-- Botão de reserva -->
                    <div style="text-align: center">
                        <button type="submit" name="reserve_btn" id="reserve_button" 
                        class="btn">Reservar atividade!</button>
                    </div>

                </form>

                <?php }  ?>

            </div>
        
        </div>

        <?php } ?>

    </div>
                    
    <?php 

        // Display das atividades reservadas pelo utilizador se estas existirem
        # Prepared statement que retorna todas as reservas do utilizador em questão
        $user_reservas_sql = "SELECT idUser, idAtividade FROM reservas WHERE idUser = :idUser";
        $user_reservas_stmt = $pdo->prepare($user_reservas_sql);
        $user_reservas_stmt->execute([":idUser" => $idUserComSessao]);

        # Fetch à base de dados de modo a retornar todas as reservadas do utilizador
        $user_reservas = $user_reservas_stmt->fetchAll();
                            
        if (!empty($user_reservas)) {
        
    ?>
                            
    <!-- Atividades escolhidas pelo utilizador -->
    <div id="user_activities">

        <h1>Pode consultar aqui todas as suas atividades reservadas/realizadas</h1>

        <?php 

            # Obter da base de dados todas as reservas efetuadas pelo utilizador --> 
            $reserves = Reserve::find_all_reserves();

            /* Relacionar as tabelas "atividades" e "reservas", de modo a obter as reservas e atividades do utilizador em questão */
            foreach ($reserves as $reserve) {

                $idReserva = $reserve->idReserva;
                $idAtividadeReserva = $reserve->idAtividade;
                $estadoReserva = $reserve->estadoReserva;
                $userReserva = $reserve->idUser;


        ?>

        <!-- Tabela com todas as atividades escolhidas pelo utilizador --> 
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">

                    <?php 
                    
                    if ($reserve->estadoReserva === "Realizada") {
                    
                        if ($userReserva === $idUserComSessao) {

                            foreach($activities as $activity) {
                                
                                # Obter ID da atividade
                                $idAtividade = $activity->idAtividade;
                                
                                if ($idAtividadeReserva === $idAtividade) {
                                    
                                    echo "<thead>";
                                    echo "<th>Nome da atividade</th>";
                                    echo "<th>Descrição da atividade</th>";
                                    echo "<th>Zona</th>";
                                    echo "<th>Duração média</th>";
                                    echo "<th>Imagem</th>";
                                    echo "<th>Preço</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Comentar atividade</th>";
                                    
                                    echo "<tr>";
                                    echo "<td>{$activity->nomeAtividade}</td>";
                                    echo "<td>{$activity->descricaoAtividade}</td>";
                                    echo "<td>{$activity->zonaAtividade}</td>";
                                    echo "<td>{$activity->duracaoAtividade}</td>";
                                    echo "<td><img src='admin/img/imgs_atividades/{$activity->imagemAtividade}' class='img_reservas_cliente'></td>";
                                    echo "<td>{$activity->precoAtividade}€</td>";
                                    echo "<td>{$reserve->estadoReserva}</td>";
                                     
                                    ?>

                                    <!-- Opção de comentar a atividade já realizada --> 
                                    <form action="comentario.php" method="post">

                                        <!-- Campo hidden que contém o ID da atividade que se
                                        deseja comentar -->
                                        <input type="hidden" name="idAtividade" value="<?php echo $idAtividade; ?>">
                                    
                                    <?php 

                                        echo "<td><button type='submit' name='comentar_reserva' class='btn-primary btn-block'>Comentar</button></td>";

                                    ?> 

                                    </form>
                                    
                                    <?php 
                                    
                                } 
        
                            }

                        }

                        } else {

                           if ($userReserva === $idUserComSessao) {

                            foreach($activities as $activity) {
                                
                                # Obter ID da atividade
                                $idAtividade = $activity->idAtividade;
                                
                                if ($idAtividadeReserva === $idAtividade) {
                                    
                                    echo "<thead>";
                                    echo "<th>Nome da atividade</th>";
                                    echo "<th>Descrição da atividade</th>";
                                    echo "<th>Zona</th>";
                                    echo "<th>Duração média</th>";
                                    echo "<th>Imagem</th>";
                                    echo "<th>Preço</th>";
                                    echo "<th>Estado</th>";
                                    echo "<th>Desmarcar atividade</th>";
                                    
                                    echo "<tr>";
                                    echo "<td>{$activity->nomeAtividade}</td>";
                                    echo "<td>{$activity->descricaoAtividade}</td>";
                                    echo "<td>{$activity->zonaAtividade}</td>";
                                    echo "<td>{$activity->duracaoAtividade}</td>";
                                    echo "<td><img src='admin/img/imgs_atividades/{$activity->imagemAtividade}' class='img_reservas_cliente'></td>";


                                    /* Mostrar o símbolo do euro apenas caso a atividade possuir um preço */
                                    if ($activity->precoAtividade !== "Atividade sem custos") {

                                        echo "<td>{$activity->precoAtividade}€</td>";

                                    } else {

                                        echo "<td>{$activity->precoAtividade}</td>";   

                                    }

                                    echo "<td>{$reserve->estadoReserva}</td>";

                                    ?>

                                    <!-- Opção de cancelar a reserva --> 
                                    <form method="post">

                                        <!-- Campo hidden que contém o ID da atividade que se
                                        deseja cancelar -->
                                        <input type="hidden" name="idReserva" value="<?php echo $idReserva; ?>">
                                    
                                    <?php 

                                        # Botão que cancela uma dada atividade
                                        echo "<td><button type='submit' name='cancelar_reserva' class='btn-danger btn-block'>Cancelar</button></td>" ;
                                    
                                    ?>

                                    </form>

                                    <?php

                                }
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