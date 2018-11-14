$(document).ready(function () {

    // "Toggler" do menu administrativo
    // $('#menu_button').click(function (){


    // });

    // Esconder por predefinição todas as áreas excepto a de listagem completa de atividades
    $('#new_activity').hide();
    $('#edit_activities').hide();
    $('#all_reserves_admin').hide();
    $('#edit_reserves').hide();
    
    /* Mudança de área dentro da mesma página */
    // Mudança para a área de listagem de todas as atividades
    $('#all_activities_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#new_activity').hide();
        $('#edit_activities').hide();
        $('#all_reserves_admin').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#new_activity_admin_tab').removeClass('active');
        $('#edit_activities_admin_tab').removeClass('active');
        $('#all_reserves_admin_tab').removeClass('active');
        $('#edit_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#all_activities_admin_tab').addClass('active');
        $('#all_activities_admin').fadeIn('slow');
    });

    // Mudança para a área de criação de uma nova atividade
    $('#new_activity_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#all_activities_admin').hide();
        $('#edit_activities').hide();
        $('#all_reserves_admin').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#all_activities_admin_tab').removeClass('active');
        $('#edit_activities_admin_tab').removeClass('active');
        $('#all_reserves_admin_tab').removeClass('active');
        $('#edit_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#new_activity_admin_tab').addClass('active');
        $('#new_activity').fadeIn('slow');        
    });

    // Mudança para a área de edição de atividades
    $('#edit_activities_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#all_activities_admin').hide();
        $('#new_activity').hide();
        $('#all_reserves_admin').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#all_activities_admin_tab').removeClass('active');
        $('#new_activity_admin_tab').removeClass('active');
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
        $('#new_activity').hide();
        $('#edit_activities').hide();
        $('#edit_reserves').hide();

        // Remover a classe "active" dos links
        $('#all_activities_admin_tab').removeClass('active');
        $('#new_activity_admin_tab').removeClass('active');
        $('#edit_activities_admin_tab').removeClass('active');
        $('#edit_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#all_reserves_admin_tab').addClass('active');
        $('#all_reserves_admin').fadeIn('slow');

    });

    // Mudança para a área de edição de reservas
    $('#edit_reserves_admin_tab').click(function () {

        // Esconder divisões da página após o clique
        $('#all_activities_admin').hide();
        $('#new_activity').hide();
        $('#edit_activities').hide();
        $('#all_reserves_admin').hide();

        // Remover a classe "active" dos links
        $('#all_activities_admin_tab').removeClass('active');
        $('#new_activity_admin_tab').removeClass('active');
        $('#edit_activities_admin_tab').removeClass('active');
        $('#all_reserves_admin_tab').removeClass('active');

        // "Highlight" na aba e mudança para a área escolhida
        $('#edit_reserves_admin_tab').addClass('active');
        $('#edit_reserves').fadeIn('slow');

    });

});