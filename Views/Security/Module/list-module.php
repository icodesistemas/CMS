<script>
	$(document).ready(function(){
		$("#button-add").live( "click", function() {
				location.href = '/Security/Module/view-module?frm=add-module'
			})
		$("#toolBar").Apollo({
			button:'add,edit,block,unlock,delete,filter'
		});
	})
</script>
<section id="toolBar" class = 'opc-menu'></section><br><br>
<form id="listado-usuarios" method="get" action="<?= $_SERVER["REQUEST_URI"] ?>"><br>
	<p style="width:20%">
		<label>Menu</label>
		<select name="ubicacion" id = "ubicacion" onchange="this.form.submit();">
			<option value="S">Menu Superior</option>	
			<option value="L">Menu Lateral</option>	
		</select>
	</p>
	<section class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tabs-1">Opciones del Sistema</a>
			</li>		
		</ul>
		
		<section class="tab-content">
			<div id="tabs-1" class="tab-pane active">
				<?php
						
					if(!isset($_REQUEST["ubicacion"])){
						$type = "S";
					}else{
						$type = $_REQUEST["ubicacion"];
					}
					
					$pag = array(
							"filter" => "nomuser",
							"header" => array("Código","Nombre de la Opción","URL","Opción Padre","Clase CSS", "Titulo","Status"),
							"DB"     => array("select" => "cod_menu, name_menu,addr_menu,(select b.name_menu from tb_menu b where a.cod_menu_parent = b.cod_menu) as padre,class_ico,title_menu,(case when active = 1 then 'Activado' when active = 0 then 'Bloqueado' end) as status",
								              "from" => "tb_menu a",
								              "where" => "type_menu = '".$type."' order by a.cod_menu_parent" ),
							"request" =>'/Security/Module/view-module?ubicacion='.$type.''
						);
					Component::paginacion($pag);
				?>
				
			</div>
		</section>
	</section>	
	
</form>
