<?php   

    // Alteração do estado das reservas
    # Marcar reserva como "realizada"
    if (isset($_POST["marcar_reserva_realizada"])) {
        
        # Acesso ao ID da reserva marcada como "realizada" 
        $idReservaRealizada = $_POST["idReserva"];

        # Modificar estado da reserva para "realizada" 
        $sql = "UPDATE reservas SET estadoReserva = :estadoReserva ";
        $sql .= "WHERE idReserva = :idReserva";
        
        # Preparar o statement
        $stmt = $pdo->prepare($sql);

        # Executar o statement 
        $stmt->execute([":estadoReserva" => "Realizada", ":idReserva" => $idReservaRealizada]);

        # Refrescar a página com a reserva em questão atualizada
        echo "<script>alert('A reserva foi marcada como realizada!')</script>";
        echo "<script> if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); } </script>";

    }

    # Marcar reserva como "adiada"
    if (isset($_POST["adiar_reserva"])) {
        
        # Acesso ao ID da reserva marcada como "adiada" 
        $idReservaRealizada = $_POST["idReserva"];

        # Modificar estado da reserva para "adiada" 
        $sql = "UPDATE reservas SET estadoReserva = :estadoReserva ";
        $sql .= "WHERE idReserva = :idReserva";
        
        # Preparar o statement
        $stmt = $pdo->prepare($sql);

        # Executar o statement 
        $stmt->execute([":estadoReserva" => "Adiada", ":idReserva" => $idReservaRealizada]);

        # Refrescar a página com a reserva em questão atualizada
        echo "<script>alert('A reserva foi marcada como adiada!')</script>";
        echo "<script> if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); } </script>";

    }

    # Marcar atividade como "cancelada"
    if (isset($_POST["cancelar_reserva"])) {
        
        # Acesso ao ID da atividade a marcar como "cancelada" 
        $idReservaRealizada = $_POST["idReserva"];

        # Modificar estado da atividade para "cancelada" 
        $sql = "UPDATE reservas SET estadoReserva = :estadoReserva ";
        $sql .= "WHERE idReserva = :idReserva";
        
        # Preparar o statement
        $stmt = $pdo->prepare($sql);

        # Executar o statement 
        $stmt->execute([":estadoReserva" => "Cancelada", ":idReserva" => $idReservaRealizada]);

        # Refrescar a página com a reserva em questão atualizada
        echo "<script>alert('A reserva foi marcada como cancelada!')</script>";
        echo "<script> if ( window.history.replaceState ) { window.history.replaceState( null, null, window.location.href ); } </script>";

    }

    // Display das atividades reservadas associadas ao admin se estas existirem
    # Prepared statement que todas as reservas associadas ao admin em questão
    $admin_reservas_sql = "SELECT idAdmin, idAtividade FROM reservas WHERE idAdmin = :idAdmin";
    $admin_reservas_stmt = $pdo->prepare($admin_reservas_sql);
    $admin_reservas_stmt->execute([":idAdmin" => $idAdmin]);

    # Fetch à base de dados de modo a retornar todas as reservas associadas ao admin em questão
    $admin_reservas = $admin_reservas_stmt->fetchAll();
    
    if (!empty($admin_reservas)) {
        
    ?>
                            
    <!-- Reservas associadas ao admin -->
    <div id="user_activities">

        <!-- Tabela com todas as reservas associadas ao admin --> 
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Nome da atividade</th>
                        <th>Descrição da atividade</th>
                        <th>Zona</th>
                        <th>Duração média</th>
                        <th>Imagem</th>
                        <th>Preço</th>
                        <th>Estado da atividade</th>
                        <th>Atualizar atividade</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <?php 

                        # Obter da base de dados todas as reservas efetuadas pelo utilizador --> 
                        $reserves = Reserve::find_all_reserves();

                        /* Relacionar as tabelas "atividades" e "reservas", de modo a obter as reservas e atividades do utilizador em questão */
                        foreach ($reserves as $reserve) {

                            $idReserva = $reserve->idReserva;
                            $idAtividadeReserva = $reserve->idAtividade;
                            $estadoReserva = $reserve->estadoReserva;
                            $adminReserva = $reserve->idAdmin;

                            if ($adminReserva === $idAdmin) {

                                foreach($activities as $activity) {
                                    
                                    $idAtividade = $activity->idAtividade;
                                    
                                    if ($idAtividadeReserva === $idAtividade) {
                                        
                                        echo "<tr>";
                                        echo "<td>{$activity->nomeAtividade}</td>";
                                        echo "<td>{$activity->descricaoAtividade}</td>";
                                        echo "<td>{$activity->zonaAtividade}</td>";
                                        echo "<td>{$activity->duracaoAtividade}</td>";
                                        echo "<td><img src='img/imgs_atividades/{$activity->imagemAtividade}' class='img_reservas_cliente'></td>";
                                        echo "<td>{$activity->precoAtividade}€</td>";
                                        echo "<td>{$reserve->estadoReserva}</td>";
                                        
                                        # Marcar atividade como realizada, adiada ou cancelada
                                        echo "<td>
                                            
                                            <form action='' method='post' role='form'>
                                                
                                                <input type='hidden' name='idReserva' value='$idReserva'>

                                                <button type='submit' name='marcar_reserva_realizada' class='btn-success btn-block'>Realizada</button>

                                            </form>

                                            <form action='' method='post' role='form'>

                                                <input type='hidden' name='idReserva' value='$idReserva'>
                                                
                                                <button type='submit' name='adiar_reserva' class='btn-info btn-block'>Adiar</button>

                                            </form>

                                            <form action='' method='post' role='form'>

                                                <input type='hidden' name='idReserva' value='$idReserva'>
                                        
                                                <button type='submit' name='cancelar_reserva' class='btn-danger btn-block'>Cancelar</button>
                                        
                                            </form>
                                            
                                            </td>";
                                        
                                        echo "</tr>";
                                    
                                    }

                                }

                            }

                        }

                    ?>

                </tbody>
            
            </table>

        </div>

    </div> 

    <?php } else { ?>

        <!-- <div id="user_activities">
            
            <h1 class="alert alert-info text-center">Não possui atividades reservadas! Consulte a nossa <a class="check_all_activities" href="" onclick="return false;">vasta lista</a> e escolha uma que lhe agrade ou mais!</h1>
            
        </div> -->
    
    <?php } ?>