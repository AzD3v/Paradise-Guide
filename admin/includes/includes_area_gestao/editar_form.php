<?php 

    # Processo de edição de uma determinada atividade
    
        
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

?>