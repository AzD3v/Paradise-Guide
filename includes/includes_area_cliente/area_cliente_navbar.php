<!-- Navbar --> 
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="area_cliente.php"><img class="logo_area_cliente" src="img/logo.png"></a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            
            <!-- Opção de vizualizar todas as atividades --> 
            <li class="nav-item" id="todas_atividades_tab">
                <a class="nav-link"><button class="btn-primary" id="todas_atividades_tab_button">Todas as atividades</button></a>
            </li>
            
            <!-- Opção de vizualizar as atividades associadas ao utilizador --> 
            <li class="nav-item" id="minhas_atividades_tab">
                <a class="nav-link"><button class="btn-primary" id="minhas_atividades_tab_button">Minhas atividades</button></a>
            </li>
        </ul>

        <!-- Pesquisa por atividades -->
        <form action="pesquisa_atividades.php" autocomplete="off" method="post" class="searchform cf log_search">
            <input type="text" name="nome_atividade" placeholder="Pesquise aqui por atividades">
            <button type="submit" name="pesquisa_atividades">Pesquisar!</button>
        </form>
        
        <!-- Opção de logout -->
        <a href="includes/includes_area_cliente/cliente_logout.php"><button class="btn btn-primary logout_button">Encerrar sessão<ion-icon class="navbar_logout_icon" name="power"></ion-icon></button></a>
        
    </div>
</nav>
<!-- Final da navbar -->