<script>
    $(".btn_edit_periodo").click(function(){
        $("#id").val($(this).data("id"));
        $("#nome").val($(this).data("nome"));
        $("#data_inicial").val($(this).data("data_inicial"));
        $("#data_final").val($(this).data("data_final"));
        $("#intervalo").val($(this).data("intervalo"));

        $("#modal_editar").modal('show');
    });

    $(".btn_edit_feriados").click(function(){
        $("#id").val($(this).data("id"));
        $("#nome").val($(this).data("nome"));
        $("#data_inicial").val($(this).data("data_inicial"));
        $("#data_final").val($(this).data("data_final"));

        $("#modal_editar").modal('show');
    });
    $(".btn_edit_biometricos").click(function(){
        $("#id").val($(this).data("id"));
        $("#nome").val($(this).data("nome"));
        $("#codigo").val($(this).data("codigo"));
        $("#ip").val($(this).data("ip"));
        $("#porta").val($(this).data("porta"));
        $("#local").val($(this).data("local"));

        $("#modal_editar").modal('show');
    });
    
    
</script>

