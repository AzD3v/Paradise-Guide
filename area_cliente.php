<!-- Header da área de cliente -->
<?php include_once("includes/includes_area_cliente/area_cliente_header.php"); ?>

<?php 

    # Aceder a todos os dados de cada atividade
    $activities = Activity::find_all_activities(); 

    // Funcionalidade que possibilita reservar atividades
    # Obter o ID do utilizador que possui sessão iniciada
    $username = $_SESSION["client"];
    $user_id = User::find_id_by_username($username);
    $user_id->idUser;

    # Obter o ID da atividade pretendida
    if (isset($_POST["reserve_activity"])) {
        $atividade_id = $_GET["id"];
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
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
            
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-3"><?php echo $activity->nomeAtividade; ?></h5>
                <!-- <small>3 days ago</small> -->
            </div>
                <p class="mb-3"><?php echo utf8_encode($activity->descricaoAtividade); ?></p>
                <p class="mb-2"><span class="subtitulo_listagem">Zona da atividade:</span> <?php echo utf8_encode($activity->zonaAtividade); ?></p>
                <p class="mb-2"><span class="subtitulo_listagem">Preço da atividade:</span> <?php // echo utf8_encode($activity->zonaAtividade); ?></p>
                <p class="mb-2"><span class="subtitulo_listagem">Duração média da atividade:</span> <?php // echo utf8_encode($activity->zonaAtividade); ?></p>    

                <!-- "Formulário" de reserva -->
                <form method="post" role="form" action="area_cliente.php?action=reserve&id=<?php echo $activity->idAtividade; ?>">       
                    <button type="submit" name="reserve_activity" class="btn">Reservar!</button>
                </form> 
            </a>

            </div>

        <?php } ?>

    </div>

    <!-- Footer do índex -->
    <?php include_once("includes/includes_area_cliente/area_cliente_footer.php"); ?>

</body>
</html>