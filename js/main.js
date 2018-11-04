$(document).ready(function() {

    // Esconder por predefinição todas as atividades e o formulário de reserva
    $('#all_activities').hide();

    // Tabela que possui as atividades reservadas é o elemento que surge por predefinição
    $('#user_activities').fadeIn('slow');

    // Área de cliente - tabuladores (hightlight) e mostrar apenas o conteúdo pretendido
    $('#minhas_atividades_tab').click(function () {
        $('#user_activities').fadeIn('slow');
        $('#all_activities').hide();
    });

    $('#todas_atividades_tab').click(function () {
        $('#all_activities').fadeIn('slow');
        $('#user_activities').hide();
    });

});