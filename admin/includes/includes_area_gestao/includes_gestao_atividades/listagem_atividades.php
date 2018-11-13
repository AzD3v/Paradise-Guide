<?php 

    # Obter o ID do admin que possui sessão iniciada
    $admin = $_SESSION["admin"];
    $id_admin = Admin::find_id_by_username($admin);
    $idAdmin = $id_admin->idAdmin;

    # Aceder a todos os dados de cada atividade
    $activities = Activity::find_all_activities(); 
    
    foreach($activities as $activity) {

        # Obter o ID do admin que está encarregado da atividade
        $adminAtividade = $activity->idAdmin;
        
        # Listar todas as atividades referentes a este administrador
        if ($adminAtividade === $idAdmin) {
        
        ?>
            
            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group">
                
                <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
                <!-- Título da atividade -->
                <h5 class="mb-3 text-center"><?php echo utf8_encode($activity->nomeAtividade); ?></h5>

                <!-- Imagem de destaque da atividade -->
                <p>IMAGEM DE DESTAQUE</p>
                
                <!-- Descrição da atividade --> 
                <p class="mb-3"><?php echo utf8_encode($activity->descricaoAtividade); ?></p>

                <!-- Zona da atividade --> 
                <p class="mb-2"><span class="subtitulo_listagem">Zona:</span> <?php echo utf8_encode($activity->zonaAtividade); ?></p>

                <!-- Duração média da atividade -->
                <p class="mb-2"><span class="subtitulo_listagem">Duração média:</span> <?php echo ($activity->duracaoAtividade); ?></p>  

                <!-- Preço da atividade -->
                <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $activity->precoAtividade; ?>€</p>

                <!-- Botão de edição -->
                <div style="text-align: center">
                    <button type="submit" id="edit_button" 
                    class="btn">Editar esta atividade</button>
                </div>
                
                </div>
            
            </div>

<?php } } ?>