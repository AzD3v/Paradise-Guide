<?php

    # Processo de eliminação de uma dada atividade
    if (isset($_POST["eliminar_atividade"])) {

        # Obter o ID da atividade que se deseja eliminar
        $idAtividadeEliminar = $_POST["idAtividadeEliminar"];

         # Proteção contra XSS (Cross Site Scripting)
        $idAtividadeEliminar = htmlspecialchars($idAtividadeEliminar, ENT_QUOTES, 'UTF-8');

        # Query que eliminará a atividade da base de dados 
        $sql = "DELETE FROM atividades WHERE idAtividade = :idAtividade";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":idAtividade" => $idAtividadeEliminar]); 

        # Mensagem que aparecerá após uma atividade ser eliminada 
        
    } 