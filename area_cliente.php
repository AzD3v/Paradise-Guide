<!-- Header da área de cliente -->
<?php include_once("includes/area_cliente_header.php"); ?>

<body class="body_area_cliente">

    <!-- Navbar da área de cliente -->
    <?php include_once("includes/area_cliente_navbar.php"); ?>

    <!-- Listagem de todas as atividades disponíveis --> 
    <div id="all_activities">

        <?php 

            $activities = Activity::find_all_activities();

            foreach ($activities as $activity) {
                echo $activity->nomeAtividade;
                echo $activity->descricaoAtividade;
            }

        ?>

    </div>

    <!-- Footer do índex -->
    <?php include_once("includes/area_cliente_footer.php"); ?>

</body>
</html>