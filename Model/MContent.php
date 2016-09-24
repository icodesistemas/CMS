<?php
	class ContentModel{
		private $field_tb_article = array(
									"art_url" => "VARCHAR(250)",
									"art_title" => "VARCHAR(200)",
									"art_sub_title" => "VARCHAR(80)",
									"art_sumary" => "VARCHAR(400)",
									"art_content" => "TEXT",
								);
			private $field_tb_section = array(
									"name_section" => "VARCHAR(80)",
									"descrip_section" => "VARCHAR(200)",
									"section_url" => "VARCHAR(300)",
									"title_section" => "VARCHAR(80)",
									"cod_language" => "VARCHAR(3)",
								);
			private $field_tb_gallery = array(
									"gal_name" => "VARCHAR(80)",
								);
			private $field_tb_sliders = array(
									"slider_name" => "VARCHAR(80)",
								);
		public function __construct(){		
			

			if(isset($_REQUEST["action"])){
				switch ($_REQUEST["action"]) {
					case 'add-article':
						$this->makeArticle();
						break;
					case 'edit-article':
						$this->editArticle();
						break;
					case 'add-event':	
						$this->makeEvent();
						break;
					case 'edit-event':
						$this->makeEvent();
						break;
					case 'disabled-article':
						$this->disabedEnabledArticle();
						break;
					case 'enabled-article':
						$this->disabedEnabledArticle();
						break;	
					case 'delete-article':
						$this->deleteArticle();
						break;	
					case 'add-language':	
						$this->addLanguage();
						break;	
					case 'delete-language':
						$this->deleteLanguage();
						break;	
					default:
						# code...
						break;
				}
			}
			if(isset($_REQUEST["option"]) && $_SESSION["sid"] == $_REQUEST["sid"]){
				switch ($_REQUEST["option"]) {
					case 'data-article':
						$_REQUEST["action"] = "edit-section";
						$this->dataArticle();
						break;
					case 'data-category':
						break;
					case 'data-event':	
						
						$this->dataEevent();
						break;
					default:								
						break;
				}
			}else{
				switch ($_REQUEST["vista"]) {
					case 'create-article':
						$_REQUEST["action"] = "add-article";
						$_REQUEST["art_date_published"] = date("Y-m-d H:i:s");
						$_REQUEST["art_date_create"] = date("Y-m-d H:i:s");
						break;
					case 'create-event':
						$_REQUEST["action"] = "add-event";
						break;
					default:
						# code...
						break;
				}
				
			}
		}
		private function deleteLanguage(){

			$codeLanguage = $_GET["language-indx"];
			try{
				foreach ($this->field_tb_article as $key => $value) {
					$sql = "ALTER TABLE tb_article
							DROP COLUMN  ".$key."_".$codeLanguage." ";
					Apollo::$DB->exec($sql);

				}
				$sql = "delete from tb_idiomas where cod_language = ?";
				Apollo::$DB->exec($sql, array(strip_tags(addslashes($_GET["language-indx"])))  );
			}catch(PDOException $r){
				echo $r->getMessage();
			}
		}
		private function addLanguage(){
			
			$codeLanguage = $_POST["codigo_idioma"];
			try{
				foreach ($this->field_tb_article as $key => $value) {
					$sql = "ALTER TABLE tb_article
						ADD COLUMN  ".$key."_".$codeLanguage." ".$value." NULL COMMENT '' ";
					Apollo::$DB->exec($sql);

				}
				foreach ($this->field_tb_section as $key => $value) {
					$sql = "ALTER TABLE tb_section
						ADD COLUMN  ".$key."_".$codeLanguage." ".$value." NULL COMMENT '' ";
					Apollo::$DB->exec($sql);

				}
				foreach ($this->field_tb_gallery as $key => $value) {
					$sql = "ALTER TABLE tb_section
						ADD COLUMN  ".$key."_".$codeLanguage." ".$value." NULL COMMENT '' ";
					Apollo::$DB->exec($sql);

				}
				foreach ($this->field_tb_sliders as $key => $value) {
					$sql = "ALTER TABLE tb_sliders
						ADD COLUMN  ".$key."_".$codeLanguage." ".$value." NULL COMMENT '' ";
					Apollo::$DB->exec($sql);

				}
				
				$data = array(
							'language' => strip_tags(addslashes($_POST["idioma"])),
							'status' => strip_tags(addslashes($_POST["estauts"])),
							'cod_language' => strip_tags(addslashes($_POST["codigo_idioma"])),
							
						);
				Apollo::$DB->qqInsert('tb_idiomas', $data);
			}catch(PDOException $r){

			}
			
			
		}
		private function deleteArticle(){
			$sql = "delete from tb_article where art_cod = ? ";
			if(Apollo::$DB->exec($sql,array($_REQUEST["section-indx"]))>0){
				Apollo::setMsjUser('Artículo eleminado con exito');
			}
		}
		private function disabedEnabledArticle(){
			switch ($_REQUEST["action"]) {
				case 'disabled-article':
					$sql = "update tb_article set art_status = 0 where art_cod = ? ";
					break;
				case 'enabled-article':
					$sql = "update tb_article set art_status = 1 where art_cod = ? ";
					break;				
			}
			Apollo::$DB->exec($sql,array($_REQUEST["section-indx"]));
		}
		private function dataEevent(){
			$sql = "select event_cod, event_title, event_content, event_date, event_img_main as art_img_main, event_thumbnail as art_thumbnail
					from tb_event
					where 	event_cod = ?";
			$rs = Apollo::$DB->getRow($sql, array(strip_tags($_REQUEST["indx"])));
			unset($_REQUEST);
			$_REQUEST = $rs;
            
			$_REQUEST["action"] = "edit-event";					
		}
		private function dataArticle(){
			$sql = "select art_title_".$_SESSION["idioma"]." as art_title, art_sub_title_".$_SESSION["idioma"]." as art_sub_title ,art_cod, 
			               art_sumary_".$_SESSION["idioma"]." as art_sumary, art_content_".$_SESSION["idioma"]." as art_content, art_date_published,
			               c.cod_section ,art_img_main, 
			               art_date_create, art_metatag, art_status,art_show_index,
						   art_main, art_cod_gallery, art_thumbnail, c.cod_section, background
				   from tb_article a, tb_section c
				   where art_cod = ? and a.cod_section = c.cod_section and a.cod_language = '".$_SESSION["idioma"]."' ";
				   
			try{
				
				$rs = Apollo::$DB->getRow($sql, array(strip_tags($_REQUEST["indx"])));	  
				unset($_REQUEST);
				$_REQUEST = $rs;
				$_REQUEST["action"] = "edit-article";			
			}catch(Exception $e){
				Apollo::setMsjUser($e->getMessage());
			}
			

			
		}
		private function manageGallery(){
			$gallery = 0;
			if(isset($_REQUEST["file"]) && empty($_REQUEST["galeria-creadas"])){
				$gallery = $this->setGallery();
				if($gallery < 1){
					Apollo::$DB->setCommit(false);
					Apollo::setMsjUser("Operación cancelada al momento de asociar la galeria al artículo");
					return false;
				}
			}else if(!empty($_REQUEST["galeria-creadas"])){
				$gallery = $_REQUEST["galeria-creadas"];
			}
			return $gallery;
		}
		private function makeEvent(){
			Apollo::$DB->setBeginTrans();
			$commit = true;
			
			
			try{
				if(!Apollo::$CC->registerEvent($this->createThumbnail(), $this->manageGallery(),$_REQUEST["action"])){
					$commit = false;
					Apollo::setMsjUser("Imposible crear el evento");
				}else{
					Apollo::setMsjUser("Operación realizada con exito");
				}
				Apollo::$DB->setCommit($commit);
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());
			}
		}
		private function makeArticle(){
			Apollo::$DB->setBeginTrans();
			$commit = true;
			
			
			try{
				if(!Apollo::$CC->registerArticle($this->createThumbnail(), $this->manageGallery(),"add-article")){
					$commit = false;
					Apollo::setMsjUser("Imposible crear el artículo");
				}else{
					Apollo::setMsjUser("Artículo creado con exito");
				}
				Apollo::$DB->setCommit($commit);
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());
			}
			
		}
		
		private function editArticle(){
			
			Apollo::$DB->setBeginTrans();
			$commit = true;
			try{				
				if(!Apollo::$CC->registerArticle($this->createThumbnail(), $_REQUEST["galeria-creadas"],"edit-article")){
					$commit = false;
					Apollo::setMsjUser("Imposible Actualizar el artículo");
				}else{
					Apollo::setMsjUser("Artículo Actualizado con exito");
				}
				Apollo::$DB->setCommit($commit);
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());
			}
			

		}
		private function setGallery(){
			include_once $_SERVER["DOCUMENT_ROOT"]."/Controller/CMedia.php";
			return CMedia::createGallery();
		}
		private function createThumbnail(){			
			
			if(empty($_REQUEST["miniatura"])){
					return "";
			}
			$findme   = 'thumb_';
			$pos = strpos($_REQUEST["miniatura"], $findme);
			$thum = "";
			if ($pos === false) {
				$img = $_REQUEST["miniatura"];			
				$img = explode("/", $img);
				$i = 0;
				foreach ($img as $key => $value) {
					if($i >= count($img)-1){
						$thum .= "/thumb_".$value;
					}else  if($i>0){
						$thum .= "/".$value;
					}
					$i++;
				}
			}else{
				$thum = $_REQUEST["miniatura"];
			}
			
			return $thum;
		}

	}
?>