<?php

    # Processo de edição de uma determinada atividade
    if (isset($_POST["edit_button"])) {
        
        # Obter o ID da atividade em questão
        $idAtividade = $_POST["idAtividade"];

        # Acesso aos dados do formulário 
        $novoNomeatividade = $_POST["novo_nome_atividade"];
        $novaDescricaoAtividade = $_POST["nova_descricao_atividade"];
        $novaZonaAtividade = $_POST["nova_zona_atividade"];
        $novaDuracaoAtividade = $_POST["nova_duracao_atividade"];
        $novoCustoAtividade = $_POST["novo_custo_atividade"];

        # Permitir que haja a possibilidade da atividade ser grátis
        if ($novoCustoAtividade === "") {$novoCustoAtividade = "Atividade sem custos";}

        # Obter a referência à antiga imagem
        $antigaImagem = $_POST["antiga_imagem"]; 

        # Aceder ao ficheiro da imagem para upload
        $novaImagemAtividade = $_FILES['novo_ficheiro_imagem']['name'];
        $novaImagemAtividadeTemp = $_FILES['novo_ficheiro_imagem']['tmp_name'];

        # Eliminar os espaços dos campos do formulário
        $novoNomeatividade = trim($novoNomeatividade);
        $novaImagemAtividade = trim($novaImagemAtividade);
        $novaImagemAtividadeTemp = trim($novaImagemAtividadeTemp);
        $novaDescricaoAtividade = trim($novaDescricaoAtividade);
        $novaZonaAtividade = trim($novaZonaAtividade);
        $novaDuracaoAtividade = trim($novaDuracaoAtividade);
        $novoCustoAtividade = trim($novoCustoAtividade);

        # Proteção contra XSS (Cross Site Scripting) - dados do formulário
        $novoNomeatividade = htmlspecialchars($novoNomeatividade, ENT_QUOTES, 'UTF-8');
        $novaImagemAtividade = htmlspecialchars($novaImagemAtividade, ENT_QUOTES, 'UTF-8');
        $novaImagemAtividadeTemp = htmlspecialchars($novaImagemAtividadeTemp, ENT_QUOTES, 'UTF-8');
        $novaDescricaoAtividade = htmlspecialchars($novaDescricaoAtividade, ENT_QUOTES, 'UTF-8');
        $novaZonaAtividade = htmlspecialchars($novaZonaAtividade, ENT_QUOTES, 'UTF-8');
        $novaDuracaoAtividade = htmlspecialchars($novaDuracaoAtividade, ENT_QUOTES, 'UTF-8');
        $novoCustoAtividade = htmlspecialchars($novoCustoAtividade, ENT_QUOTES, 'UTF-8');

        # Não permitir que exista uma atualização sem alterações aos dados
        if (empty($novoNomeatividade) && empty($novaDescricaoAtividade) && empty($novaDuracaoAtividade) && empty($novaZonaAtividade) && empty($novoCustoAtividade)) {

            echo "<script>alert('Não procedeu a qualquer tipo de alteração à atividade!')</script>";

        }

        # Mover a imagem carregada para a pasta respetiva
        move_uploaded_file($novaImagemAtividadeTemp, "img/imgs_atividades/{$novaImagemAtividade}");

        # Certificação de que existe sempre uma imagem de destaque na atividade
        if(empty($novaImagemAtividade)) { $novaImagemAtividade = $antigaImagem; }

        # Atualizar campos da base de dados 
        $sql = "UPDATE atividades SET ";
        $sql .= "nomeAtividade = :novoNomeAtividade, ";
        $sql .= "descricaoAtividade = :novaDescricaoAtividade, ";
        $sql .= "zonaAtividade = :novaZonaAtividade, ";
        $sql .= "duracaoAtividade = :novaDuracaoAtividade, ";
        $sql .= "precoAtividade = :novoPrecoAtividade, ";
        $sql .= "imagemAtividade = :novaImagemAtividade ";
        $sql .= "WHERE idAtividade = :idAtividade ";

        # Preparar o statement
        $stmt = $pdo->prepare($sql);

        # Executar o statement
        $stmt->execute([":novoNomeAtividade" => $novoNomeatividade, ":novaDescricaoAtividade" => $novaDescricaoAtividade, ":novaZonaAtividade" => $novaZonaAtividade, ":novaDuracaoAtividade" => $novaDuracaoAtividade, ":novoPrecoAtividade" => $novoCustoAtividade, ":novaImagemAtividade" => $novaImagemAtividade, ":idAtividade" => $idAtividade]);

        # Refrescar a página com a atividade em questão atualizada
        echo "<script>alert('A atividade foi atualizada com sucesso!')</script>";
        echo "<script> if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); } </script>";
        echo "<script>location.reload();</script>"; 

    }

    # Aceder a todos os dados de todas as atividades
    $activities = Activity::find_all_activities(); 

    # Obter o ID do admin que possui sessão iniciada
    $admin = $_SESSION["admin"];
    $id_admin = Admin::find_id_by_username($admin);
    $idAdmin = $id_admin->idAdmin;

    # Display de todas as atividades
    foreach($activities as $activity) {

        # Obter o ID do admin que está encarregado da atividade
        $adminAtividade = $activity->idAdmin;
        
        # Listar todas as atividades referentes a este administrador
        if ($adminAtividade === $idAdmin) {

        ?>

            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group" id="<?php echo $activity->idAtividade; ?>">
                
                <div class="list-group-item list-group-item-action flex-column align-items-start active">

                <form action="" method="post" enctype="multipart/form-data">
            
                    <!-- Título da atividade -->
                    <label class="new_name_label" for="novo_ficheiro_atividade">Insira aqui um novo título para a atividade</label>
                    <h5 class="mb-3"><input type="text" class="form-control" name="novo_nome_atividade" value="<?php echo $activity->nomeAtividade; ?>"></h5>
                    
                    <!-- Imagem de destaque da atividade -->
                    <label for="nova_imagem">Substituir imagem de destaque</label>
                    <br><br>
                    <img src=<?php echo "img/imgs_atividades/{$activity->imagemAtividade} class='img-responsive edit_img';" ?>>
                    <br>
                    
                    <!-- Opção de substituir a imagem de destaque --> 
                    <input class="new_image" type="file" name="novo_ficheiro_imagem" accept="*/image">
                    <br>

                    <!-- Input type "hidden" - idAtividade -->
                    <input type="hidden" name="antiga_imagem" value="<?php echo $activity->imagemAtividade; ?>">
                    
                    <!-- Descrição da atividade --> 
                    <label class="new_description_label" for="nova_descricao_atividade">Insira aqui uma nova descrição para a atividade</label>
                    <textarea rows="5" name="nova_descricao_atividade" class="form-control"><?php echo $activity->descricaoAtividade; ?></textarea>

                    <!-- Zona da atividade --> 
                    <p class="mb-2"><span class="subtitulo_listagem">Modifique a zona da atividade:</span> <input type="text" name="nova_zona_atividade" class="form-control" value="<?php echo $activity->zonaAtividade; ?>"></p>

                    <!-- Duração média da atividade -->
                    <p class="mb-2"><span class="subtitulo_listagem">Modifique a duração da atividade:</span><input class="form-control" type="text" name="nova_duracao_atividade" value="<?php echo $activity->duracaoAtividade; ?>"></p>  

                    <!-- Preço da atividade -->
                    <p class="mb-2"><span class="subtitulo_listagem">Modifique o preço da atividade:</span> <input type="text" name="novo_custo_atividade" value="<?php echo $activity->precoAtividade; ?>" class="form-control"></p>

                    <!-- Input type "hidden" - idAtividade -->
                    <input type="hidden" name="idAtividade" value="<?php echo $activity->idAtividade; ?>">

                    <!-- Botão de confirmação da edição -->
                    <button type="submit" name="edit_button" id="edit_button_confirm" class="btn">Concluir edição da atividade</button>

                </form>
                
            </div>
            
        </div>

<?php } } ?>