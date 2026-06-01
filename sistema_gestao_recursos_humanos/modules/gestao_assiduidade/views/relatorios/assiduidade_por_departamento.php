<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
<br>
   <br>
   <br>
	 <h4>Assiduidade por Departamento</h4> 

   <!--filtros-->
   <?php
        if(!isset($filtros['department_id'])) {
           $filtros['department_id'] = 0;
        }
        if (!isset($filtros['de'])) {
           $filtros['de'] = '';
        }
        if(!isset($filtros['ate'])) {
           $filtros['ate'] = '';
        }
   ?>
   <form action="" id="filtros_select" class="row"> 
                             
         <input name="group" type="hidden" value = "assiduidade_por_departamento">	
         <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px"> 
            <label for=""><?php echo _l('Departamentos'); ?></label>
            <select name="department_id" class="selectpicker"  id="department_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
               <option value="0">Nada selecionado</option> 
               <?php 
                  foreach ($opt_departments as $value) { ?>
                     <option value="<?php echo new_html_entity_decode($value['departmentid']); ?>" <?php if($filtros['department_id']==$value['departmentid']){ echo "selected";} ?> > <?php echo new_html_entity_decode($value['name']); ?></option>
               <?php }?>          
            </select>	
         </div>

         <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
            <label for=""><?php echo _l('De'); ?></label>
             <input name="de" id="de" type="date" class="form-control" value= "<?php echo $filtros['de'];?>">	
         </div>
         <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
            <label for=""><?php echo _l('Até'); ?></label>
             <input name="ate" id="ate" type="date" class="form-control" value= "<?php echo $filtros['ate'];?>">	
         </div>
         <div class="col-md-2" style="margin-top: 22px; margin-bottom: 22px">
             <button id="btn_pesquisar_dpt" type="button" class="btn btn-primary" style="margin-top: 25px;">Pesquisar</button>
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
