<script>
    var id;
    $(".editar").click(function(){
        var id     = $(this).data('id');
        var name   = $(this).data('name');
        $("#id").val(id);
        $("#e_name").val(name);
        $("#modal_edit").modal('show');
    })  

    $(".eliminar").click(function(){
         id     = $(this).data('id');
        $("#modal_eliminar").modal('show');
    })
    $("#conf_eliminar").click(function(){
        url = "<?php echo admin_url('document_management/delete_seccoes/'); ?>"+id;
        window.location.href = url;   
    });
</script>