<!-- Header da área de cliente -->
<?php include_once("includes/includes_area_cliente/area_cliente_header.php"); ?>

<?php 

    # Aceder a todos os dados de cada atividade
    $activities = Activity::find_all_activities(); 

    // Funcionalidade que possibilita reservar atividades
    # Obter o ID do utilizador que possui sessão iniciada
    $username = $_SESSION["client"];
    $user_id = User::find_id_by_username($username);
    $idUser = $user_id->idUser;

    # Obter o ID da atividade em questão
    if (isset($_GET["action"])) {$idAtividade = $_GET["id"];

        # Obter o número do cartão de crédito
        if (isset($_POST["reserve_btn"])) {$cartaoCredito = $_POST["credit_card"];}

            # Proceder à reserva
            $sql = "INSERT INTO reservas (idAtividade, idUser, cartaoCredito, estadoReserva) ";
            $sql .= "VALUES(:idAtividade, :idUser, :cartaoCredito, :estadoReserva)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":idAtividade" => $idAtividade, ":idUser" => $idUser, ":cartaoCredito" => $cartaoCredito, ":estadoReserva" => "Marcada"]);

            # Refrescar a página 
            header("Location:area_cliente.php");

        }

?>

<body class="body_area_cliente">

    <!-- Navbar da área de cliente -->
    <?php include_once("includes/includes_area_cliente/area_cliente_navbar.php"); ?>

    <!-- Listagem de todas as atividades disponíveis --> 
    <div id="all_activities">

        <h1>Aqui se encontram todas as atividades disponíveis</h1>

        <?php

        foreach($activities as $activity) {
        
        ?>

            <div class="list-group">
                <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-3"><?php echo $activity->nomeAtividade; ?></h5>
                <!-- <small>3 days ago</small> -->
            </div>

                <p class="mb-3"><?php echo utf8_encode($activity->descricaoAtividade); ?></p>
                <p class="mb-2"><span class="subtitulo_listagem">Zona da atividade:</span> <?php echo utf8_encode($activity->zonaAtividade); ?></p>
                <p class="mb-2"><span class="subtitulo_listagem">Preço da atividade:</span> <?php // echo utf8_encode($activity->zonaAtividade); ?></p>
                <p class="mb-2"><span class="subtitulo_listagem">Duração média da atividade:</span> <?php // echo utf8_encode($activity->zonaAtividade); ?></p>  
                
                <!-- Formulário de reserva -->
                <form action="area_cliente.php?action=reserve&id=<?php echo $activity->idAtividade; ?>" method="post" id="reserve_form">
                    <label for="credit_card">Digite aqui o número do seu cartão de crédito</label>
                    <input type="text" name="credit_card">
                    <input type="hidden" name="nome_atividade" value="<?php echo $activity->nomeAtividade; ?>">
                    <button type="submit" name="reserve_btn" id="reserve_button" class="btn">Reservar!</button>
                </form>

            </div>
        
        </div>

        <?php } ?>

    </div>

    <!-- Listagem das atividades escolhidas pelo utilizador -->
    <div id="user_activities">

    </div> 

    <!-- Footer do índex -->
    <?php include_once("includes/includes_area_cliente/area_cliente_footer.php"); ?>

</body>
</html>