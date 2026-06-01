<script>
           var array_d = [];
           var array_es = [];
          $(document).ready(function (){
               array_d['Sunday']     = '#e_checkbox_0';
               array_d['Monday']     = '#e_checkbox_1';
               array_d['Tuesday']    = '#e_checkbox_2';
               array_d['Wednesday']  = '#e_checkbox_3';
               array_d['Thursday']   = '#e_checkbox_4';
               array_d['Friday']     = '#e_checkbox_5';
               array_d['Saturday']   = '#e_checkbox_6';

               array_es = [0,1,2,3,4,5,6];

          });
     
     

        $(".btn_edit_turnos").click(function(){
           $.each(array_es,function(index,item){//desmarcar todos checkbox
             $('#e_checkbox_'+item).prop('checked',false);

        })

        $("#id").val($(this).data("id"));
        $("#nome").val($(this).data("nome"));
        $("#periodo_id").val($(this).data("periodo_id"));
        $("#freq_id").val($(this).data("freq_id"));

        var dias_trabalho = $(this).data("dias_trabalho");
        array_dias = dias_trabalho.split(',');

        $.each(array_dias,function(index,item){
             $(array_d[item]).prop('checked',true);
         
        })
       
      

        $("#modal_editar").modal('show');
    });
</script>