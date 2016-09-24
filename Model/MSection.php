<?php
	class Section{
		private $areasTemplate = "";
		public function __construct(){
			
			if(isset($_REQUEST["action"])){
				switch($_REQUEST["action"]){
					case 'add-section':
						$this->createSection();	
						break;
					case 'delete-section':
						Apollo::$CC->deleteSection();
						break;	
					case 'disabled-section':					
						Apollo::$CC->enabledDisabled(0);
						break;	
					case 'enabled-section':					
						Apollo::$CC->enabledDisabled(1);
						break;		
					case 'edit-section':
						Apollo::$CC->updateSection();
						break;	
					case 'delete-area':	
						Apollo::$CC->deleteArea();
						break;	
					case 'add-new-category':
						Apollo::$CC->addCategory();
						break;
					case 'edit-category':	
						Apollo::$CC->addCategory('edit-category');
						break;		
					case 'enabled-category':	
						Apollo::$CC->enabledDisabledCategory(1);
						break;
					case 'disabled-category':	
						Apollo::$CC->enabledDisabledCategory(0);
						break;	
					case 'delete-category':	
						Apollo::$CC->deteleCategory();					
						break;		

				}
			}
			if(isset($_REQUEST["option"]) && $_SESSION["sid"] == $_REQUEST["sid"]){
				switch ($_REQUEST["option"]) {
					case 'data-edit-section':
						$_REQUEST["action"] = "edit-section";
						$this->dataEditSection();
						break;
					case 'data-category':
						$_REQUEST["action"]	 = "edit-category";
						$this->dataCategory();
					default:								
						break;
				}
			}else{
				if(isset($_REQUEST["frm"])){
					switch ($_REQUEST["frm"]) {
						case 'create-section':
							$_REQUEST["action"] = "add-section";		
							break;
						case 'create-category':
							$_REQUEST["action"] = "add-new-category";		
							break;
					}	
				}
				
					
			}
		}
		private function dataCategory(){
			$sql = "select * from tb_category where category_cod = ?";
			$rs = Apollo::$DB->getRow($sql, array($_REQUEST["indx-category"]));
		
			foreach ($rs as $key => $value) {
				$_REQUEST[$key] = $rs[$key];
			}
			
		}
		private function dataEditSection(){

			$sql = "select * from tb_section where cod_section = ? ";
			$rs = Apollo::$DB->getRow($sql,array($_REQUEST["section-indx"]));
			
			$_REQUEST["seccion"] = $rs["name_section_".$_SESSION["idioma"]];
			$_REQUEST["descrip"] = $rs["descrip_section_".$_SESSION["idioma"]];
			$_REQUEST["main"] = $rs["main_section"];
			$_REQUEST["titulo"] = $rs["title_section_".$_SESSION["idioma"]];
			$_REQUEST["section_url"] = $rs["section_url_".$_SESSION["idioma"]];
			$_REQUEST["estado"] = $rs["active_section"];
			$_REQUEST["background"] = $rs["background"];
			$_REQUEST["cod_section_parent"] = $rs["cod_section_parent"];

			$sql = "select type_content,  name_area,width_area, cod_area,css_area
					from tb_section_area a, tb_type_content b 
					where cod_section = ? and a.cod_type_content = b.cod_type_content
					order by orden asc";
			$rs = Apollo::$DB->getArray($sql,array($_REQUEST["section-indx"]));


			$sql = "select cod_type_content, type_content from tb_type_content";
			$content = Apollo::$DB->getArray($sql);

			$area = "";
			foreach ($rs as $value) {
				$area .= '
					<tr id = "'.$value["cod_area"].'">
						<td>
							<input type = "text" name = "area[]" value = "'.$value["name_area"].'">
						</td>
						<td>
							<input type = "number" name = "ancho[]" value = "'.$value["width_area"].'">
						</td>	
						<td>
							<select name = "tipo_contenido[]">
								'.$this->comboTypeContent($content, $value["type_content"]).'">
							</select>
						</td>
						<td>
						    <input type = "text" name = "style[]" value = "'.$value["css_area"].'" >
						</td>
						<td>
							<center>
								<img style = "cursor:pointer" src = "/Template/img/delete.png" onclick="deleteArea('.$_REQUEST["section-indx"].','.$value["cod_area"].')">
							</center>
							
						</td>
						<input type = "hidden" name = "indx-area" value = "'.$value["cod_area"].'">
					</tr>
				';
			}
			$this->areasTemplate = $area;
		}
		private function comboTypeContent($rs,$name){
			$cb = "";
			foreach ($rs as $value) {
				if($value["type_content"] == $name){
					$cb .= '
					<option value = "'.$value["cod_type_content"].'" selected = "selected">'.$value["type_content"].'</option>
					';	
				}else{
					$cb .= '
					<option value = "'.$value["cod_type_content"].'">'.$value["type_content"].'</option>
					';	
				}
				
			}
			return $cb;
		}
		public function getAreas(){
			return $this->areasTemplate;
		}
		private function createSection(){
			$commit = false;
			try{
				Apollo::$DB->setBeginTrans();
				
				$id = Apollo::$CC->setCreateSection($_REQUEST["action"]);

				if($id > 1){
					
					if(isset($_REQUEST["area"])){
						if(Apollo::$CC->setAreaForSection($id)){							
							$commit = true;
						}else{
							Apollo::setMsjUser("Imposible Crear las área de la sección");
						}
					}else{
						$commit = true;
					}
					if($commit){
						Apollo::setMsjUser("Sección creada con exito");
					}
					Apollo::$DB->setCommit($commit);
				}else{
					Apollo::setMsjUser("Imposible Crear la sección");
				}
				
			}catch(Exception $e){
				Apollo::$DB->setCommit($commit);
				Apollo::setMsjUser($e->getMessage());
			}
		}
	}