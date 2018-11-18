<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="index.php"><img class="logo_index" src="img/logo.png"></a>
    
    <!-- Navbar collapse -->
    <div class="collapse navbar-collapse" id="navbarColor03">

        <ul class="navbar-nav mr-auto"></ul>

            <!-- Search form -->
            <form action="pesquisa_atividades.php" autocomplete="off" method="post" class="searchform cf">
                <select name="localizacao_geografica" class="form-control">
                    <option value="">Em toda a ilha</option>
                    <option value="Ponta Delgada">Ponta Delgada</option>
                    <option value="Lagoa">Lagoa</option>
                    <option value="Ribeira Grnade">Ribeira Grande</option>
                    <option value="Vila Franca do Campo">Vila Franca do Campo</option>
                    <option value="Lagoa">Lagoa</option>
                    <option value="Nordeste">Nordeste</option>
                </select>
                <input type="text" name="nome_atividade" placeholder="Pesquise aqui por atividades">
                <button type="submit" name="pesquisa_atividades">Pesquisar!</button>
            </form>
            
        </ul>

    </div>
</nav>
<!-- Navbar end -->