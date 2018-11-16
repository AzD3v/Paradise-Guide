<?php 

        # Display das atividades reservadas pelo utilizador se estas existirem
        $user_reserves = Reserve::find_admin_reserves($idAdmin);
        
        if (!empty($user_reserves)) {
        
    ?>
                            
    <!-- Atividades escolhidas pelo utilizador -->
    <div id="user_activities">

        <!-- Tabela com todas as atividades escolhidas pelo utilizador --> 
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
                                    
                                    ?>

                                    <!-- Opção de cancelar a reserva --> 
                                    <form method="post">

                                        <!-- Campo hidden que contém o ID da atividade que se
                                        deseja eliminar -->
                                        <input type="hidden" name="idReserva" value="<?php echo $idReserva; ?>">
                                    
                                    <?php 

                                        # Botão que cancela uma dada atividade
                                        echo "<td><button type='submit' name='cancelar_reserva' class='btn-danger btn-block'>Realizada</button>
                                        <button type='submit' name='cancelar_reserva' class='btn-danger btn-block'>Adiar</button>
                                        <button type='submit' name='cancelar_reserva' class='btn-danger btn-block'>Cancelar</button></td>";
                                    
                                    ?>

                                    </form>

                                    <?php 
                                    
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