$(document).ready(function () {

    // "Toggler" do menu administrativo
    // $('#menu_button').click(function (){


    // });

    // Esconder por predefinição todas as áreas excepto a de listagem completa de atividades
    $('#edit_activities').hide();
    $('#all_reserves_admin').hide();
    $('#edit_reserves').hide();
    
    /* Mudança de área dentro da mesma página */
    // Mudança para a área de listagem de todas as atividades
    $('#all_activities_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#edit_activities').hide();
        $('#all_reserves_admin').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#edit_activities_admin_tab').removeClass('active');
        $('#all_reserves_admin_tab').removeClass('active');
        $('#edit_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#all_activities_admin_tab').addClass('active');
        $('#all_activities_admin').fadeIn('slow');
    });

    $('#new_activity_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#new_activity_admin_tab').addClass('active');
        
    });

    // Mudança para a área de edição de atividades
    $('#edit_activities_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#all_activities_admin').hide();
        $('#all_reserves_admin').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#all_activities_admin_tab').removeClass('active');
        $('#all_reserves_admin_tab').removeClass('active');
        $('#edit_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#edit_activities_admin_tab').addClass('active');
        $('#edit_activities').fadeIn('slow');

    });

    // Mudança para a área de listagem de todas as reservas
    $('#all_reserves_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#all_activities_admin').hide();
        $('#edit_activities').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#all_activities_admin_tab').removeClass('active');
        $('#edit_activities_admin_tab').removeClass('active');
        $('#edit_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#all_reserves_admin_tab').addClass('active');
        $('#all_reserves_admin').fadeIn('slow');

    });

    // Resultados de pesquisa (admin) 
    $('#listagem_edicao').hide();

    $('#edit_button_filter').click(function () {
        $('#resultados_filtro').fadeOut('slow');
        $('#listagem_edicao').show();
    });

});