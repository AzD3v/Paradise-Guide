<!-- Áreas administrativas -->
<div class="admin_wrapper">

    <!-- Listagem de todas as atividades do administrador -->
    <div id="all_activities_admin">
        
        <!-- Opção de logout -->
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>

        <!-- Título da área -->
        <h1>Listagem de todas as suas atividades</h1>

        <!-- Incluir a listagem das atividades -->
        <?php include_once("includes_gestao_atividades/listagem_atividades.php"); ?>

    </div>

    <!-- Criar uma nova atividade -->
    <div id="new_activity">

        <!-- Opção de logout -->
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>
        
        <!-- Título da área -->
        <h1>Área de criação de atividades</h1> 

        <!-- Incluir o formulário de criação de atividades -->
        <?php include_once("includes_gestao_atividades/new_activity.php"); ?>
         
    </div>

    <!-- Editar atividades -->
    <div id="edit_activities">
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>
        <h1>Área de edição de atividades</h1>

    </div>

    <!-- Listagem de todas as reservas do administrador -->
    <div id="all_reserves_admin">
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>
        <h1>Listagem de todas as reservas efetuadas</h1>
    </div>

    <!-- Editar reservas -->
    <div id="edit_reserves">
        <a href="includes/includes_area_gestao/admin_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>
        <h1>Área de edição de reservas</h1>
   
   </div>

</div>