<script type="text/javascript" src="/Component/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    	$('.form_datetime').datetimepicker({
	        language:  'es', format:'yyyy-MM-dd hh:mm:ss',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1
	    });
        $("#button-save").live("click",function(){

            if(validateFormFields("frm_article")){
                $("#frm_article").submit(); 
            }else{
                $(".loading").hide();
            }           
        });
    	
    	
        <?php
            if(isset($_REQUEST["art_status"])){
                echo '$("#art_status option[value='.$_REQUEST["art_status"].']").attr("selected",true);  ';
            }
            if(isset($_REQUEST["art_show_index"])){
                echo '$("#mostrar_index option[value='.$_REQUEST["art_show_index"].']").attr("selected",true);  ';
            }
            if(isset($_REQUEST["art_main"])){
                echo '$("#select_destacado option[value='.$_REQUEST["art_main"].']").attr("selected",true);  ';
            }

            if(isset($_REQUEST["cod_section"])){
                echo '$("#section_art option[value='.$_REQUEST["cod_section"].']").attr("selected",true);  ';
            }
            
            if(isset($_REQUEST["art_cod_gallery"])){
                echo '$("#galeriaCreadas option[value='.$_REQUEST["art_cod_gallery"].']").attr("selected",true);  ';
            }
        ?>
    

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
        height: "650"
    });
</script>
<section id="toolBar" class = 'opc-menu'>
	<button id="button-save" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Aplicar</i>
	</button>
	<a href="/Content/Adm/general-article" class="button inactive">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>
	<a href="/Content/Adm/create-article" class="button inactive">
		<span class="ico-button ico-user-clear"></span>
		<i>Blanquear</i>
	</a>
</section><br><br><br>
<form method="post" action="/Content/Adm/create-article" id = "frm_article">
	<section class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tabs-1">Crear Artículo</a>
			</li>
			<li>
				<a data-toggle="tab" href="#tabs-2">Multimedia</a>
			</li>	
			<li>
				<a data-toggle="tab" href="#tabs-3">Metadatos</a>
			</li>		
		</ul>
		<section class="tab-content">
			<div id="tabs-1" class="tab-pane active">
				<?php
					require_once "article.php";
				?>
			</div>
			<div id="tabs-2" class="tab-pane">
				<?php
					require_once "multimedia.php";
				?>
			</div>
			<div id="tabs-3" class="tab-pane">
				<?php
					require_once 'metadatos.php';
				?>
			</div>
		</section>	
	</section>
	<input type = "hidden"	name = "action" value="<?= $_REQUEST["action"]?>">
	<input type = "hidden" name = "sid" value="<?= $_SESSION["sid"] ?>">
</form>


