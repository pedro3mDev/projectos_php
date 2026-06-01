

<script>
    //MINHA ASSIDUIDADE

$("#btn_pesquisar").click(function(){
    refresh_tabela_minha_assiduidade (); 
});



function refresh_tabela_minha_assiduidade (){
    if (validar()!=0) {
             $.ajax({
                    url: "<?php echo admin_url('gestao_assiduidade/get_minha_assiduidade_ajax'); ?>",
                    type: "GET",
                    data: $("#filtros_select").serialize(), 
                    success: function(response){
                         $("#tabela").html(response);
                    },
                    beforeSend: function(xhr, status, error){
                    },
                    error: function(xhr, status, error){
                    }
            });
    }else{
        console.log($('#funcionarios_id').val())
        console.log($("#de").val())
        console.log($("#ate").val())
        alert_float('danger', "Deve conter valor em todos os filtros");
        $("#tabela").html(' <h4 class="text-center">por favor, seleciona os filtros para apresentar a informação.</h4>');
    }
}



function validar(){
    var v1 = 1 ; var v2 = 1;var v3 = 1;
    if ($('#funcionarios_id').val()==0) {
        v1 = 0;
    }
    if ($("#de").val()=='') {
        v2 = 0;
    }
    if ($("#ate").val()=='') {
        v3 = 0;
    }
    if (v1 == 0 || v2 == 0 || v3 == 0) {
        return 0;
    }else{
        return 1;
    }
}
//ASSIDUIDADE POR DEPARTAMENTO

$("#btn_pesquisar_dpt").click(function(){
    refresh_tabela_assiduidade_dpt();
});



function refresh_tabela_assiduidade_dpt (){
    if (validar_dpt()!=0) {
        $("#filtros_select").submit();
    }else{
        alert_float('danger', "Deve conter valor em todos os filtros");
    }
}


function validar_dpt(){
    var v1 = 1 ; var v2 = 1;var v3 = 1;
    if ($('#department_id').val()==0) {
        v1 = 0;
    }
    if ($("#de").val()=='') {
        v2 = 0;
    }
    if ($("#ate").val()=='') {
        v3 = 0;
    }
    if (v1 == 0 || v2 == 0 || v3 == 0) {
        return 0;
    }else{
        return 1;
    }
}
</script>