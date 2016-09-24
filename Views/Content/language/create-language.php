<script>
	$(function(){
		$("#button-save").live("click",function(){

            if(validateFormFields("frm_idioma")){
                $("#frm_idioma").submit(); 
            }else{
                $(".loading").hide();
            }           
        });
	})
</script>
<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Content/language/list-language" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Content/language/create-language" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>

<form method="post" action="/Content/language/create-language" id = "frm_idioma">
	<p>
		<label>Nombre del idioma</label>
		<input type="text" name="idioma" placeholder = "Nombre descriptivo del idioma" required = "required">
	</p>
	<div style="width:250px">
		<p>
			<label>Nombre abreviado</label>
			<input type="text" name="codigo_idioma" placeholder = "" required = "required" maxlength="3">
		</p>
		<p>
			<label>Estatus</label>
			<select name="estauts">
				<option value = "A">Activo</option>
				<option value = "I">Inactivo</option>
			</select>
		</p>
	</div>
	
	<input type="hidden" name="action" value="add-language">
	<input type = "hidden" name = "sid" value="<?= $_SESSION["sid"] ?>">
</form>