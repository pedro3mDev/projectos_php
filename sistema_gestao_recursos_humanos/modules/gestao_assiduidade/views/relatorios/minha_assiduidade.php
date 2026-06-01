<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
   <br>
   <br>
   <br>
	 <h4>Minha Assiduidade</h4>

   <!--filtros-->
   <form action="" id="filtros_select" class="row"> 
                             

         <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
            <label for=""><?php echo _l('Funcionários'); ?></label>
            <select name="funcionarios_id" class="selectpicker"  id="funcionarios_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
               <option value="0">Nada selecionado</option> 
               <?php 
                  foreach ($opt_staff as $value) { ?>
                     <option value="<?php echo new_html_entity_decode($value['staffid']); ?>"><?php echo new_html_entity_decode($value['firstname'].' '.$value['lastname']); ?></option>
               <?php }?>          
            </select>	
         </div>

         <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
            <label for=""><?php echo _l('De'); ?></label>
             <input name="de" id="de" type="date" class="form-control">	
         </div>
         <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
            <label for=""><?php echo _l('Até'); ?></label>
             <input name="ate" id="ate" type="date" class="form-control">	
         </div>
         <div class="col-md-2" style="margin-top: 22px; margin-bottom: 22px">
             <button id="btn_pesquisar" type="button" class="btn btn-primary" style="margin-top: 25px;">Pesquisar</button>
         </div>



   </form>
        <!--end filtros-->
   <br>

   <div class="row">
         <div class="col-12" id="tabela">
              <?php echo $tabela; ?>
         </div>
   </div>

	     

</div>
</body> 
 
 <script>
 
     
   
 </script>

</html> 
