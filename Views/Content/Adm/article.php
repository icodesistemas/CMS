
<input type="hidden" name="indx" value="<?= $_REQUEST["art_cod"] ?>">
<section style = "width:78%; float:left">
    <p class="inline">
        <label>Título</label>
        <input type="text" name="titulo" required = "required" value="<?= $_REQUEST["art_title"] ?>">         
    </p>
    <p class="inline">
        <label>Sub - Título</label>
        <input type="text" name="sub-titulo" value="<?= $_REQUEST["art_sub_title"] ?>">         
    </p>
    <p class="inline">
        <label>Resumen</label>
        <textarea name="resumen" style="width:98.5%" required = "required"><?=$_REQUEST["art_sumary"]?></textarea>         
    </p>
     <p class="inline">       
	   <textarea name="content" id = "articulo" style="width:100%"><?=$_REQUEST["art_content"]?></textarea>
    </p>
</section>
<section style = "width:20%; float:right">
	<p class = "inline">
		<label>Fecha Creación</label>
		<input type = "text" readonly="readonly" value="<?= $_REQUEST["art_date_create"] ?>">
	</p>
	<p class = "inline">
		<label>Fecha Publicación</label>
		<!--<input type = "text" name="fecha-publicacion" id = "fecha" value="<?= $_REQUEST["art_date_published"] ?>" required = "required">
        -->
        <div class="control-group">
                <div class="controls input-append date form_datetime" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input size="16" type="text" name="fecha-publicacion" value="<?= $_REQUEST["art_date_published"] ?>" readonly>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
            </div>
	</p>
	<p class = "inline">
		<label>Sección</label>
    	<select name="section" id = "section_art" required = "required">
    		<option></option>
    		<?php
    			echo Funciones::getComboSection();
    		?>	
    	</select>
    </p>	
    <p class = "inline">
		<label>¿Mostrar en el Index?</label>
    	<select name="mostrar_index" id = "mostrar_index" required = "required"> 
    		<option value="NO">NO</option>    
            <option value="SI">SI</option>    
    	</select>
    </p>
     <p>
        <label>Destacado</label>
        <select name="main" id = "select_destacado">
           <option value="NO">NO</option> 
           <option value="SI">SI</option>  
          
        </select>
    </p>
    <p>
    	<label>Publicar</label>
    	<select name="status" id = "art_status">
    		<option value="SI">SI</option> 
    		<option value="NO">NO</option>
    	</select>
    </p>
   <center> <input type = "button" id = "container" value="INSERTAR MULTIMEDIA"> </center>
</section>
<div class="clear"></div>
