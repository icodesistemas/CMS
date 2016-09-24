
<script type="text/javascript" src="/Component/tinymce/tinymce.min.js"></script>
<script>
	$(function(){
		$("#button-save").live("click",function(){

            if(validateFormFields("frm_article")){
                $("#frm_article").submit(); 
            }else{
                $(".loading").hide();
            }           
        });
	})
	tinymce.init({
        selector: "textarea#articulo",
        language : "es",
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
        relative_urls: true,        
        toolbar_items_size: "medium",
        schema: "html5",
        // Plugins
        plugins : "table link code charmap autolink lists importcss preview media textcolor ",
        // Toolbar
        toolbar1: "bold italic underline strikethrough | forecolor backcolor | aligncenter alignleft alignjustify | formatselect | bullist numlist",
        toolbar2: "outdent indent | undo redo | link unlink anchor video_template_callback code | hr table | subscript superscript | charmap | preview",
        height: "450"
    });
</script>

<input type="hidden" name="indx" value="<?= $_REQUEST["event_cod"] ?>">
<section style = "width:78%; float:left">
    <p class="inline">
        <label>Título</label>
        <input type="text" name="titulo" required = "required" value="<?= $_REQUEST["event_title"] ?>">         
    </p>
    
     <p class="inline">       
	   <textarea name="content" id = "articulo" style="width:100%"><?=$_REQUEST["event_content"]?></textarea>
    </p>
</section>
<section style = "width:20%; float:right">
	<p class = "inline">
		<label>Fecha del Evento</label>
		<input type = "date" name="fecha-evento" value="<?= $_REQUEST["event_date"] ?>" required = "required">
	</p>
	<p class = "inline">
		<label>Visible en las siguientes secciones:</label>
		<table class = "Grid"  style="margin-top:20px">
			<thead>
					<tr>
						<th>Secciones de la Página</th>
					</tr>	
			</thead>
		<?php


                Apollo::$CC->getListSection($_REQUEST["event_cod"]);
            

		?>
		</table>
    </p>
     <p>
    	<label>Activado</label>
    	<select name="status">
    		<option value="1">SI</option>	
    		<option value="O">NO</option>	
    	</select>
    </p>
     <center> <input type = "button" id = "container" value="INSERTAR MULTIMEDIA"> </center>
</section>	