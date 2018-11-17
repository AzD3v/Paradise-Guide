<!-- Áreas administrativas -->
<div class="admin_wrapper">

    <!-- Listagem de todas as atividades do administrador -->
    <div id="all_activities_admin">
        
        <!-- Opção de logout -->
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>

        <!-- Título da área -->
        <h1>Gestão de todas as suas atividades</h1>

        <!-- Incluir a listagem de todas as atividades associadas ao admin -->
        <?php include_once("listagem_atividades.php"); ?>

    </div>

    <!-- Editar atividades -->
    <div id="edit_activities">

        <!-- Opção de logout -->
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>

        <!-- Título da área -->
        <h1>Área de edição de atividades</h1>

        <!-- Incluir o formulário de edição de atividades -->
        <?php include_once("editar_atividades.php"); ?>

    </div>

    <!-- Listagem de todas as reservas do administrador -->
    <div id="all_reserves_admin">

        <!-- Opção de logout -->
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>

        <!-- Título da área -->
        <h1>Listagem de todas as reservas efetuadas</h1>

        <!-- Incluir a listagem de todas as reservas feitas pelos clientes -->
        <?php include_once("listagem_reservas.php"); ?>

    </div>

</div>