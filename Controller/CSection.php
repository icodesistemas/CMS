<?php
	class CSection{
		public function setCreateSection($action){
			if($_REQUEST["URL"] == ""){
				$URL = Funciones::createUrl($_REQUEST["seccion"]);
			}else{
				$URL = $_REQUEST["URL"];
				$pos = strpos($URL, 'http');
				if ($pos === false && $URL != '/' ) {
					$URL = $URL;
				}else{
					$URL = $URL;
				}
			}
			$data = array(
				'name_section_'.$_SESSION["idioma"] => strip_tags($_REQUEST["seccion"]),
				'descrip_section_'.$_SESSION["idioma"] => strip_tags($_REQUEST["descrip"]),
				'active_section' => strip_tags($_REQUEST["estado"]),
				'main_section' => strip_tags($_REQUEST["main"]),
				'section_url_'.$_SESSION["idioma"] => $URL,
				'title_section_'.$_SESSION["idioma"] => strip_tags($_REQUEST["titulo"]),
				'open_section' => strip_tags($_REQUEST["open-URL"]),
				'background' => strip_tags($_REQUEST["img-fondo"]),
				'cod_section_parent' => strip_tags($_REQUEST["idPadre"]),
				'cod_language' => $_SESSION["idioma"]
			);
			
			if($action == "edit-section"){
				$data = array_merge($data, array("cod_section" => $_REQUEST["section-indx"]));
				
				
				if( Apollo::$DB->qqUpdate("tb_section",$data)>0){
					return true;
				}else{
					return false;
				}
			}else{		
					
				return Apollo::$DB->qqInsert("tb_section",$data);
			}
			return 1;
		}
		
		
		public function deleteArea(){
			$sql = "delete from tb_section_area where cod_area = ? ";
			Apollo::$DB->exec($sql,array($_REQUEST["indx-area"]));
		}
		public function updateSection(){
			Apollo::$DB->setBeginTrans();
			try{
				$commit = true;		
				$this->setCreateSection('edit-section');
				$this->updateArea();
				
				Apollo::$DB->setCommit($commit);
				Apollo::setMsjUser("Sección Actualizada con exito");
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());
			}
		}
		
		public function enabledDisabled($var){
			try{
				if(Apollo::$DB->exec("update tb_section set active_section = ".$var." where cod_section = ?",array($_REQUEST["section-indx"]))>0){
					Apollo::setMsjUser("Sección actualizada");
					return true;
				}	
			}catch(Exception $e){
				Apollo::setMsjUser("Imposible actualizar la sección seleccionada");
				return false;
			}
		}
		public function enabledDisabledCategory($var){

			try{
				if(Apollo::$DB->exec("update tb_category set category_active = ".$var." where category_cod = ?",array($_REQUEST["indx-category"]))>0){
					Apollo::setMsjUser("Categoría actualizada");
					return true;
				}	
			}catch(Exception $e){
				Apollo::setMsjUser("Imposible actualizar la categoría seleccionada");
				return false;
			}
		}
		public function deleteSection(){
			try{
				if(Apollo::$DB->exec("delete from tb_section where cod_section = ?",array($_REQUEST["section-indx"]))){
					Apollo::setMsjUser("Sección eliminada con exito");
					return true;
				}	
			}catch(Exception $e){
				Apollo::setMsjUser("Imposible Eliminar la sección seleccionada");
				return false;
			}
		}
		private function updateArea(){
			$sql = "delete from tb_section_area where cod_section = ?";
			Apollo::$DB->exec($sql,array($_REQUEST["section-indx"]));
			return $this->setAreaForSection($_REQUEST["section-indx"]);
			
			
		}
		public function setAreaForSection($idSection){
			$areas = $_REQUEST["area"];	
			$return = true;	
			foreach ($areas as $key => $value) {
				
				$data = array(
					'cod_section' => $idSection,
					'name_area' => $value,
					'width_area' => $_REQUEST["ancho"][$key],
					'cod_type_content' => $_REQUEST["tipo_contenido"][$key],
					"css_area" => $_REQUEST["style"][$key]
					);
				
				$id = Apollo::$DB->qqInsert("tb_section_area",$data);
				
				if($id < 1){

					$return = false;
				}
			}
			return $return;
		}
	}
?>