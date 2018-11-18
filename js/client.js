$(document).ready(function() {

    // Tabela que possui as atividades reservadas é o elemento que surge por predefinição
    $('#all_activities').fadeIn('slow');

    // Área de cliente - tabuladores (hightlight) e mostrar apenas o conteúdo pretendido
    $('#minhas_atividades_tab').click(function () {
        $('#user_activities').fadeIn('slow');
        $('#all_activities').hide();
        $('#pesquisa_personalizada_tab').fadeOut();
    });

    $('#todas_atividades_tab').click(function () {
        $('#all_activities').fadeIn('slow');
        $('#user_activities').hide();
        $('#pesquisa_personalizada_tab').fadeIn();
    });    

    // Formulário de reserva - "Ajuda" no que toca a inserir número do cartão de crédito
    $('.cn').on('input', function () {
        this.value = this.value.replace(/ /g, "");
        this.value = this.value.replace(/\B(?=(\d{4})+(?!\d))/g, " ");
    });

    /* Âncoras das mensagens de erro ou de sucesso associadas às reservas (inexistência de reservas incluída) */ 
    $('.check_reserves').click(function () {
        $('#all_activities').fadeOut('slow');
        $('#user_activities').fadeIn('slow');
    });
    $('.check_all_activities').click(function () {
        $('#user_activities').fadeOut('slow');
        $('#all_activities').fadeIn('slow');
    });

});