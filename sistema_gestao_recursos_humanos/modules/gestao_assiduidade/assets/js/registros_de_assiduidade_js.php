<script>
const selectedItems = [];
$("#departmentid").change(function (){
    $.ajax({
            url: "<?php echo admin_url('gestao_assiduidade/get_func_by_dpt_ajax'); ?>",
            type: "GET",
            data: {id : $("#departmentid").val()},
            success: function(response){
                 $('#funcionarios_id').html('<option value="0">Nada selecionado</option>');  // Limpa as seleções
                 var arrayDados = JSON.parse(response);

                arrayDados.forEach(function(item){
                    var nome = item.firstname + ' ' + item.lastname;
                    var id   = item.staffid;
                    $('#funcionarios_id').append($('<option>', {
                        value: id,
                        text: nome
                    }));

                })
                $('#funcionarios_id').selectpicker('refresh');
                refresh_tabela ();
               
            },
            beforeSend: function(xhr, status, error){
                $('#funcionarios_id').html('<option value="0">Carregando...</option>');  // Limpa as seleções
                $('#funcionarios_id').selectpicker('refresh');
            },
            error: function(xhr, status, error){
                $('#funcionarios_id').html('<option value="0">Nada selecionado</option>');  // Limpa as seleções
                $('#funcionarios_id').selectpicker('refresh');
            }
    });
});
$("#funcionarios_id").change(function (){
    refresh_tabela ();
})

$("#meses_id").change(function (){
    refresh_tabela ();
})
function refresh_tabela (){
    if (validar()!=0) {
             $.ajax({
                    url: "<?php echo admin_url('gestao_assiduidade/get_marcacoes_ajax'); ?>",
                    type: "GET",
                    data: $("#filtros_select").serialize(), 
                    success: function(response){
                        console.log($("#filtros_select").serialize())
                         $("#tabela").html(response);
                    },
                    beforeSend: function(xhr, status, error){
                    },
                    error: function(xhr, status, error){
                    }
            });
    }else{
        $("#tabela").html(tbl_aviso());
    }
}
var id_mark;
function btnAddMark(id =''){
    id_mark = id;
    $.ajax({
                    url: "<?php echo admin_url('gestao_assiduidade/get_marcacoes_id_out_ajax'); ?>",
                    type: "GET",
                    data: {id: id}, 
                    success: function(response){
                        $('#item_marks').html('');
                        var arrayDados = JSON.parse(response);
                        arrayDados.forEach(function(item){
                            $('#item_marks').append(row_line(item.id,item.marc_in,item.marc_out));
                        })
                    },
                    beforeSend: function(xhr, status, error){
                        $('#item_marks').html('<h3  style="text-align: center;">Carregando...</h3>');
                    },
                    error: function(xhr, status, error){
                    }
    });
    $("#id_mark").val(id);
    $("#modalAddMark").modal('show');
}

var num_row = 0;
$('#itemSelect').click(function() {
        var id      = id_mark;
        var entrada = $("#d_entrada").val();
        var saida   = $("#d_saida").val();
        if (entrada == '' || saida == '') {
            $("#d_entrada").css({'border-color':'red'});
            $("#d_saida").css({'border-color':'red'});
            alert_float('danger', "Deve conter valor nas duas datas");
        }else{
            num_row ++;
            $("#d_entrada").css({'border-color':'green'});
            $("#d_saida").css({'border-color':'green'});
            $("#d_entrada").val('');
            $("#d_saida").val('');
            add_mark(id,entrada,saida);   
        }
       
 });

function itemSelect_rem(id){
    $.ajax({
                    url: "<?php echo admin_url('gestao_assiduidade/rem_marcacoes_id_out_ajax'); ?>",
                    type: "GET",
                    data: {id: id,id_mark: id_mark}, 
                    success: function(response){
                        $('#item_marks').html('');
                        var arrayDados = JSON.parse(response);
                        arrayDados.forEach(function(item){
                            $('#item_marks').append(row_line(item.id,item.marc_in,item.marc_out));
                        });
                         refresh_tabela ();
                         alert_float('success', "Removido com sucesso");
                    },
                    beforeSend: function(xhr, status, error){
                        $('#item_marks').html('<h3 style="text-align: center;">Carregando...</h3>');
                    },
                    error: function(xhr, status, error){
                    }
    });
}
function add_mark(id,entrada,saida){
    $.ajax({
                    url: "<?php echo admin_url('gestao_assiduidade/add_marcacoes_id_out_ajax'); ?>",
                    type: "GET",
                    data: {id: id, entrada : entrada, saida: saida}, 
                    success: function(response){
                        $('#item_marks').html('');
                        var arrayDados = JSON.parse(response);
                        arrayDados.forEach(function(item){
                            $('#item_marks').append(row_line(item.id,item.marc_in,item.marc_out));
                        })
                         refresh_tabela ();
                         alert_float('success', "Salvo com sucesso");
                    },
                    beforeSend: function(xhr, status, error){
                        $('#item_marks').html('<h3  style="text-align: center;">Carregando...</h3>');
                    },
                    error: function(xhr, status, error){
                    }
    });
}

function validar(){
    var v1 =1 ; var v2 = 1;
    if ($('#funcionarios_id').val()==0) {
        v1 = 0;
    }
    if ($("#meses_id").val()==0) {
        v2 = 0;
    }
    if (v1 == 0 || v2 == 0) {
        return 0;
    }else{
        return 1;
    }
}
function row_line(id,entrada,saida){
    var html = '';
    html +='<div class="row line_'+id+' " style="margin-top: 12px">';
    html +='    <div class="col-md-5">';
    html +='        <label for="" class="form-label">Entrada</label>';
    html +='        <input name="entrada[]" type="time" value="'+entrada+'" class="form-control" disabled>';
    html +='    </div>';
    html +='    <div class="col-md-5">';
    html +='        <label for="" class="form-label">Saída</label>';
    html +='        <input name="saida[]" type="time" value="'+saida+'" class="form-control" disabled>';
    html +='    </div>';
    html +='    <div class="col-md-2">';
    html +='        <button onclick="itemSelect_rem('+id+')"  type="button" class="btn btn-danger" style="margin-top: 22px"><i class="fa fa-close"></i></button>';
    html +='    </div>';
    html +='</div>';
    return html;
}

function tbl_aviso(){
    var html = '';
    html += '<table class="table table-bordered table-hover">';
    html += '	<thead class="thead-dark">';
    html += '		 <tr>';
    html += '			<th>Data</th>';
    html += '			<th>Entrada - Saida</th>';
    html += '			<th>Tipo</th>';
    html += '			<th>Assiduidade</th>';
    html += '			<th>Opções</th>';
    html += '		</tr>';
    html += '	</thead>';
    html += ' <tbody>';
    html += ' </tbody>';
    html += '		 <tr class="text-center" style="font-size: 1.2rem">';
    html += '		    <td colspan="5">por favor, seleciona os filtros para apresentar a informação</td>';
    html += '		</tr>';
    html += '</table>';
    return html;
}
</script>