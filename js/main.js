// Área de cliente - tabuladores (hightlight)
$('#area_cliente_tab').click(function () {
    $('#area_cliente_tab').addClass('active');
    $('#minhas_atividades_tab').removeClass('active');
    $('#todas_atividades_tab').removeClass('active');
});

$('#minhas_atividades_tab').click(function () {
    $('#minhas_atividades_tab').addClass('active');
    $('#area_cliente_tab').removeClass('active');
    $('#todas_atividades_tab').removeClass('active');
});

$('#todas_atividades_tab').click(function () {
    $('#todas_atividades_tab').addClass('active');
    $('#area_cliente_tab').removeClass('active');
    $('#minhas_atividades_tab').removeClass('active');
});

