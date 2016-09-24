<?php
	class ContentController{
		public function getListSection($codEvent = 0){
			/*require_once "CMedia.php";
			$media = new CMedia();
			$media->getListSection();*/
			
			if($codEvent != 0){
				$sql = "select * from tb_event_assoc_section where event_cod = ".$codEvent;
				$event = Apollo::$DB->getArray($sql);
			}
			
			$sql = "select cod_section, name_section_".$_SESSION["idioma"]." as seccion
			        from tb_section";
			        
			$rs = Apollo::$DB->getArray($sql);
			foreach ($rs as $key => $value) {
				$checkbox = "";
				if($codEvent != 0){

					foreach ($event as $k => $val) {
						
						if($codEvent == $val["event_cod"] && $value["cod_section"] == $val["cod_section"]){
							$checkbox = "checked = 'checked'";
							break;
						}
					}
					echo '
					<tr>
						<td>
							<input type="checkbox" '.$checkbox.'  name="section[]" value="'.$value["cod_section"].'"><strong>'.$value["seccion"].'</strong>
						</td>
					</tr>';
				}
				
			}
		}
		
		public function registerArticle($Thumb, $gallery, $action){


			$metatag = $this->createMetaTag();			
			if($action == "add-article"){
				$data = array(
					'art_show_index' => strip_tags($_REQUEST["mostrar_index"]),
					'art_url_'.$_SESSION["idioma"] => Funciones::createUrl($_REQUEST["titulo"]),			
					'art_title_'.$_SESSION["idioma"] => strip_tags($_REQUEST["titulo"]),
					'art_sub_title_'.$_SESSION["idioma"] => strip_tags($_REQUEST["sub-titulo"]),
					'art_sumary_'.$_SESSION["idioma"] => strip_tags($_REQUEST["resumen"]),
					'art_content_'.$_SESSION["idioma"] => str_replace('../../Cluster', '/app/Cluster', $_REQUEST["content"]) ,
					'art_img_main' => strip_tags($_REQUEST["principal"]),
					'art_thumbnail' => $Thumb,
					'art_date_create' => date("d-m-Y H:m"),
					'art_date_published' => strip_tags($_REQUEST["fecha-publicacion"]),
					'art_metatag' => serialize($metatag),
					'art_status' => strip_tags($_REQUEST["status"]),
					'art_main' => strip_tags($_REQUEST["main"]),
					'art_cod_gallery' => $gallery,
					'cod_section' => strip_tags($_REQUEST["section"]),
					'art_creator' => Login::$datSession["id"],
					'cod_language' => $_SESSION["idioma"]
				);

				if(Apollo::$DB->qqInsert("tb_article",$data)>0){
					return true;
				}
			}else{
				$url = Funciones::createUrl($_REQUEST["titulo"]);
				
				$data = array(
					'art_cod' => $_REQUEST["indx"],
					'art_show_index' => strip_tags($_REQUEST["mostrar_index"]),
					'art_url_'.$_SESSION["idioma"] => $url,			
					'art_title_'.$_SESSION["idioma"] => strip_tags($_REQUEST["titulo"]),
					'art_sub_title_'.$_SESSION["idioma"] => strip_tags($_REQUEST["sub-titulo"]),
					'art_sumary_'.$_SESSION["idioma"] => strip_tags($_REQUEST["resumen"]),
					'art_content_'.$_SESSION["idioma"] => str_replace('../../Cluster', '/app/Cluster', $_REQUEST["content"]) ,
					'art_img_main' => strip_tags($_REQUEST["principal"]),
					'art_thumbnail' => $Thumb,					
					'art_date_published' => strip_tags($_REQUEST["fecha-publicacion"]),
					'art_metatag' => serialize($metatag),
					'art_status' => strip_tags($_REQUEST["status"]),
					'art_main' => strip_tags($_REQUEST["main"]),
					'art_cod_gallery' => $gallery,
					'cod_section' => strip_tags($_REQUEST["section"]),
					'cod_langauge' => $_SESSION["idioma"]
				);

				if(Apollo::$DB->qqUpdate("tb_article",$data)>0){
					return true;
				}
			}
			
			
			
		}	
		protected function createMetaTag(){			
			if(empty(trim($_REQUEST["meta-titulo"]))){
				$titulo = Funciones::createUrl($_REQUEST["titulo"]);
			}else{
				$titulo = Funciones::createUrl($_REQUEST["meta-titulo"]);
			}

			return array(				
				'description' => substr($_REQUEST["resumen"], 0, 158) ,
				'title' => $titulo
				);
		}
		
		private function replce($str){
            $str = str_replace(".","",$str);
            $str = str_replace(",","",$str);
            $str = str_replace("!","",$str);
            $str = str_replace("¡","",$str);
            $str = str_replace("¿","",$str);
            $str = str_replace("?","",$str);
            $str = str_replace("{","",$str);
            $str = str_replace("}","",$str);
            $str = str_replace("[","",$str);
            $str = str_replace("]","",$str);
            $str = str_replace("+","",$str);
            $str = str_replace("*","",$str);
            return $str;
        }
	}
?>