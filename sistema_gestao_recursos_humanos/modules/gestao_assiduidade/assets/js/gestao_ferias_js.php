<script>
$("#btn_pesquisar").click(function(){
     $("#filtros_select").submit();
})  


$(document).ready(function() {
            var today = new Date().toISOString().split('T')[0];
            $('#de').attr('min', today);
            $('#ate').attr('min', today);

            $('#de').on('change', function() {
                var startDate = $('#de').val();
                $('#ate').attr('min', startDate);
            });

            $('#ate').on('change', function() {
                var endDate = $('#ate').val();
                $('#de').attr('max', endDate);
            });
});
 
</script>