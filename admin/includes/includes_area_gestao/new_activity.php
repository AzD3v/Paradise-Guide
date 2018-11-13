<?php 
    
    # Verificação do formulário de inserção de uma nova atividade
    if(isset($_POST["submit_insert"])) {

        # Obter o id do admin para inserção na base de dados
        $admin = $_SESSION["admin"];
        $id_admin = Admin::find_id_by_username($admin);
        $idAdmin = $id_admin->idAdmin;

        # Aceder aos campos do formulário
        $nomeAtividade = $_POST["nome_atividade"];
        $descricaoAtividade = $_POST["descricao_atividade"];
        $zonaAtividade = $_POST["zona_atividade"];
        $duracaoAtividade = $_POST["duracao_atividade"];
        $precoAtividade = $_POST["preco_atividade"];

        # A atividade poderá ser grátis
        if ($precoAtividade === "") {
            $precoAtividade = "Atividade sem custos";
        }


        # Verificar que os campos não se encontram vazios
        if (!empty($nomeAtividade) && !empty($descricaoAtividade) && !empty($zonaAtividade) && !empty($duracaoAtividade) &&  !empty($precoAtividade)) { 

            # Eliminar o espaço em branco dos campos de inserção da nova atividade
            $nomeAtividade = trim($nomeAtividade);
            $descricaoAtividade = trim($descricaoAtividade);
            $zonaAtividade = trim($zonaAtividade);
            $duracaoAtividade = trim($duracaoAtividade);
            $precoAtividade = trim($precoAtividade);

            # Proteção contra XSS (Cross-Site Scripting)
            $nomeAtividade = htmlspecialchars($nomeAtividade, ENT_QUOTES, 'UTF-8');
            $descricaoAtividade = htmlspecialchars($descricaoAtividade, ENT_QUOTES, 'UTF-8');
            $zonaAtividade = htmlspecialchars($zonaAtividade, ENT_QUOTES, 'UTF-8');
            $duracaoAtividade = htmlspecialchars($duracaoAtividade, ENT_QUOTES, 'UTF-8');
            $precoAtividade = htmlspecialchars($precoAtividade, ENT_QUOTES, 'UTF-8');
            
            # Inserir campos na base de dados
            $sql = "INSERT INTO atividades (idAdmin, nomeAtividade, descricaoAtividade, zonaAtividade, duracaoAtividade, precoAtividade, imagemAtividade) VALUES(:idAdmin, :nomeAtividade, :descricaoAtividade, :zonaAtividade, :duracaoAtividade, :precoAtividade, :imagemAtividade)";
            $stmt = $pdo->prepare($sql);
        
            # Executar o statement
            $stmt->execute([":idAdmin" => $idAdmin, ":nomeAtividade" => $nomeAtividade, ":descricaoAtividade" => $descricaoAtividade, ":zonaAtividade" => $zonaAtividade, ":duracaoAtividade" => $duracaoAtividade, ":precoAtividade" => $precoAtividade, ":imagemAtividade" => 1]); 

            # Refrescar a página
            echo '<meta http-equiv="refresh" content="0">';

        }
                
    }
        
?>

<!-- Formulário de inserção de uma nova atividade -->
<div id="insert_activity_form">
    
    <form action="" method="post" autocomplete="off" role="form"> 
        
        <!-- Inserir o nome da atividade --> 
        <div class="form-group">
            <label for="nome_atividade">Nome da atividade</label>
            <div class="input-group nome_atividade">
                <ion-icon name="bonfire" class="nome_atividade_icon"></ion-icon>
                <input type="text" name="nome_atividade" placeholder="Digite aqui o nome da nova atividade" class="form-control nome_atividade" required>
            </div>
        </div>

        <!-- Inserir a descrição da atividade --> 
        <div class="form-group">
            <label for="new_user_email">Descrição da atividade</label>
            <div class="input-group descricao_atividade">
                <ion-icon name="book"></ion-icon>
                <textarea rows="5" name="descricao_atividade" placeholder="Descreva aqui de forma concisa e explicativa de que se trata a atividade em questão" class="form-control" required></textarea>
            </div>
        </div>

        <div class="inline_fields_labels">

            <!-- Inserir a zona da atividade --> 
            <label for="zona_atividade">Zona da atividade</label>

            <!-- Duração média da atividade --> 
            <label for="duracao_atividade">Duração média</label>

            <!-- Preço da atividade -->
            <label for="preco_atividade">Preço base da atividade</label>

        </div>

        <div class="form-inline">

            <!-- Inserir zona da atividade -->
            <div class="input-group zona_atividade">
                <ion-icon name="compass"></ion-icon>
                <input type="text" name="zona_atividade" placeholder="Ex: Sete Cidades" class="form-control" required>
            </div>
            
            <!-- Inserir duração da atividade -->
            <div class="input-group duracao_atividade">
                <ion-icon name="time"></ion-icon>
                <input type="text" name="duracao_atividade" placeholder="Ex: Aprox 2h" class="form-control" required>
            </div>

            <!-- Inserir preço da atividade -->
            <div class="input-group preco_atividade">
                <ion-icon name="cash"></ion-icon>
                <input type="text" name="preco_atividade" placeholder="Ex: Desde 30€" class="form-control">
            </div>

        </div>

        <!-- Upload da imagem de destaque da atividade --> 
        <div class="form-group upload_imagem_label">
            <label for="zona_atividade">Upload da imagem de destaque da atividade</label>
        </div>
        
        <!-- Botão de submissão -->
        <div style="text-align: center">
            <button type="submit" name="submit_insert" id="insert_button" 
            class="btn">Inserir nova atividade</button>
        </div>
    
    </form>

</div>