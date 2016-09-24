<script>
	$(document).ready(function(){
		$("#frm-upload").submit(function(){
			var valor = ""
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).val();
	            		
	            	}
	            }
	        });
	        
	        $("#upload-container").val(valor);
	        if(valor == ""){
	        	alert("Debe seleccionar un contenedor");
	        	return false;
	        }else{
	        	return true;
	        }
		})
		$("#button-add").live( "click", function() {
				location.href = '/Security/Module/view-module?frm=add-module'
			})
		$("#createCluster").live( "click", function() {	
			url = "<?= $_SERVER["REQUEST_URI"] ?>"	;
			if(/&/.test(url)){
				location.href = ""+url+"&frm=add-container";
			}else{
				location.href = ""+url+"?frm=add-container";
			}
			
			
		});
		$(".cluster").live("click",function(){
				var valor = $(this).attr("name-container");
				if(!$(this).is(':checked')){
					$(this).removeAttr('checked');
					return;
				}
				$(this).attr('checked', 'checked'); 

		        $('input[type=checkbox]').each( function() { 	        	
		            if($(this).is(':checked')){
		            	if($(this).attr("name-container") != valor){
		                	$(this).removeAttr('checked');
		            	}
		            }
		        }); 
			});
		$("#saveCluster").click(function(){
			var valor = ""
			$('input[type=checkbox]').each( function() { 	        	
	            if($(this).is(':checked')){
	            	if($(this).val() != 0){
	            		chck = true;
	            		valor = $(this).attr("name-container");
	            		
	            	}
	            }
	        });
	        if(valor != ""){
	        	$("#cluster-father").val(valor);	
	        	if($("#cluster-father").val() != ""){
	        		$("#frmCluseter").submit();	
	        	}else{
	        		alert("Error de Script");
	        	}
	        	
	        }else{
	        	$("#frmCluseter").submit();
	        }
			
			
		})
	})
	function fileSelected() {
		var file = document.getElementById('fileToUpload').files[0];
		if (file) {
		var fileSize = 0;
		if (file.size > 1024 * 1024)
		  fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		else
		  fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
		      
			document.getElementById('fileName').innerHTML = 'Nombre: ' + file.name;
			document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
			document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
			$("#type_file").val(file.type);
			
		}
	}
</script>
<section id="toolBar" class = 'opc-menu'>
	<?php
		if(!isset($_REQUEST["frm"]) || $_REQUEST["frm"] != "add-container"){
	?>
	<button id="createCluster" class="button">
		<span class="ico-button ico-user-add"></span>
		<i>Nuevo</i>
	</button>
	<?php } ?>
	<?php
		if(isset($_REQUEST["frm"]) && $_REQUEST["frm"] == "add-container"){
	?>
	<a href="#" id = "saveCluster" class="button">
		<span class="ico-button ico-user-save"></span>
		<i>Crear Contenedor</i>
	</a>
	<?php } ?>
	<a href="/Security/Module/view-module" class="button inactive">
		<span class="ico-button ico-user-edit"></span>
		<i>Editar</i>
	</a>	
	<a class="button inactive" href="/Multimedia/Container/view-content">
		<span class="ico-button ico-user-cancel"></span>
		<i>Cancelar</i>
	</a>	
	
</section>
<section style = "float:left; width:60%; margin-top:59px; margin-left:10px;">
	<section class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tabs-1">Contenedores</a>
			</li>		
		</ul>
		
		<section class="tab-content">			
			<div id="tabs-1" class="tab-pane active">
				<section id = "create-cluster">
					
				</section>
					
				<?= $app->MM->getDataContainers() ?>
				<div class="clear"></div>
			</div>
		</section>
	</section>		
	
</section>
<section style = "float:right; width:36%;margin-right: 20px; margin-top:10px; ">
	<?php
		if(!isset($_REQUEST["frm"])){
			require_once "upload-file.php";
		}else{
			require_once $_REQUEST["frm"].".php";
		}
	?>
</section>
