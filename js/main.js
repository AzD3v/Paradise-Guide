$(document).ready(function() {

    // Esconder por predefinição todas as atividades e o formulário de reserva
    $('#all_activities').hide();

    // Tabela que possui as atividades reservadas é o elemento que surge por predefinição
    $('#user_activities').fadeIn('slow');

    // Área de cliente - tabuladores (hightlight) e mostrar apenas o conteúdo pretendido
    $('#minhas_atividades_tab').click(function () {
        $('#minhas_atividades_tab').addClass('active');
        $('#todas_atividades_tab').removeClass('active');
        $('#user_activities').fadeIn('slow');
        $('#all_activities').hide();
    });

    $('#todas_atividades_tab').click(function () {
        $('#todas_atividades_tab').addClass('active');
        $('#minhas_atividades_tab').removeClass('active');
        $('#all_activities').fadeIn('slow');
        $('#user_activities').hide();
    });

});