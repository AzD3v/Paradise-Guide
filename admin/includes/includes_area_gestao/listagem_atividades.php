<?php 

    # Obter o ID do admin que possui sessão iniciada
    $admin = $_SESSION["admin"];
    $id_admin = Admin::find_id_by_username($admin);
    $idAdmin = $id_admin->idAdmin;

    # Aceder a todos os dados de todas as atividades
    $activities = Activity::find_all_activities(); 
    
    foreach($activities as $activity) {

        # Obter o ID do admin que está encarregado da atividade
        $adminAtividade = $activity->idAdmin;
        
        # Listar todas as atividades referentes a este administrador
        if ($adminAtividade === $idAdmin) {

        ?>

            <!-- Grupo que contém os detalhes de cada atividade -->
            <div class="list-group" id="<?php echo $activity->idAtividade; ?>">
                
                <div class="list-group-item list-group-item-action flex-column align-items-start active">
            
                <!-- Título da atividade -->
                <h5 class="mb-3 text-center"><?php echo $activity->nomeAtividade; ?></h5>

                <!-- Imagem de destaque da atividade -->
                <img src=<?php echo "img/imgs_atividades/{$activity->imagemAtividade} class='img_listagem img-responsive';" ?>>
                
                <!-- Descrição da atividade --> 
                <p class="mb-3"><?php echo $activity->descricaoAtividade; ?></p>

                <!-- Zona da atividade --> 
                <p class="mb-2"><span class="subtitulo_listagem">Zona:</span> <?php echo $activity->zonaAtividade; ?></p>

                <!-- Duração média da atividade -->
                <p class="mb-2"><span class="subtitulo_listagem">Duração média:</span> <?php echo $activity->duracaoAtividade; ?></p>  

                <!-- Preço da atividade -->
                <?php 

                    # Mostrar o símbolo do euro apenas caso a atividade possuir um preço
                    if ($activity->precoAtividade !== "Atividade sem custos") {

                ?>

                <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $activity->precoAtividade; ?>€</p>

                <?php } else { ?>
                    
                <!-- Preço da atividade -->
                <p class="mb-2"><span class="subtitulo_listagem">Preço:</span> <?php echo $activity->precoAtividade; ?></p>

                <?php } ?>
                
                <!-- Manager buttons -->
                <div class="manager_buttons">   

                    <!-- Formulário e botão de edição -->
                    <div>
                        <form action="area_gestao.php?action=edit&id=<?php echo $activity->idAtividade; ?>" method="post" role="form">

                        <button type="submit" id="edit_button" class="btn">Editar esta atividade</button>
                        </form>
                    </div>

                    <!-- Botão que elimina uma atividade -->
                    <div>
                        <button type="submit" id="delete_button" 
                        class="btn">Eliminar atividade</button>
                    </div>
                </div>
                
                </div>
            
            </div>

<?php } } ?>