<?php
	ini_set('post_max_size','300M');
	ini_set('upload_max_filesize','300M');
	ini_set('max_execution_time','3000');
	ini_set('max_input_time','3000');
	require_once "Thumbnails/ThumbLib.inc.php";
	class Multimedia{
		private static $dataCluster;
		public function __construct(){
//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";
			if(isset($_REQUEST["action"])){
				switch($_REQUEST["action"]){
					case 'create-cluster':
						$this->createCluster();	
						self::ListCluster();
						break;
					case 'upload-file':	
						if($this->uploadFile()){
							//self::ListCluster();	
						}
						break;
					case 'delete-container':
						if($this->deleteContainer()){
							self::ListCluster();	
						}						
						break;		
					case 'delete-file':	
						$this->deleteFile($_REQUEST["file-indx"]);
						break;		
					case 'edit-slider':	
						$this->updateSlider();
						break;		
					case 'add-slider':	
						$this->setCreateSlider();					
						break;		
					case 'edit-gallery':
						$this->updateGallery();
						break;
					case 'delete-gallery':	
						$this->deleteGallery();
						break;
					case 'add-gallery':
						//$this->saveGallery();
						CMedia::createGallery();;	
						break;							
				}
			}

			if(isset($_REQUEST["option"])){
				switch ($_REQUEST["option"]) {
					case 'data-container':
						$this->dataCluster();
						break;
					case 'data-slider':
						$this->setDataSlider();
						break;
					case 'data-gallery':
						$this->dataGallery();
						break;
					default:
						
						break;
				}
			}elseif(!isset($_REQUEST["option"]) && !isset($_REQUEST["action"])){
				
				self::ListCluster();
			}
			
		}
		private function deleteGallery(){
			try{
				$sql = 'delete from tb_gallery where gal_cod = ?';
				Apollo::$DB->exec($sql, array(addslashes($_REQUEST['indx'])));
			}catch(Exception $e){
				Apollo::setMsjUser($e->getMessage());	
			}
		}
		private function updateGallery(){
			try{
				Apollo::$DB->setBeginTrans();
				if(Apollo::$CC->updateGallery()){
					Apollo::$DB->setCommit(true);	
				}else{
					Apollo::$DB->setCommit(false);
					Apollo::setMsjUser("Imposible Actualizar la galeria");
				}
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());	
			}
			
		}
		private function dataGallery(){			
			$sql = "select gal_cod, gal_name, gal_type, gal_status	
					from tb_gallery
					where gal_cod = ? ";
			$rs = Apollo::$DB->getRow($sql,array($_REQUEST["indx"]));

			unset($_REQUEST);
			$_REQUEST  = $rs;
			$_REQUEST["frm"] = "create-gallery";
			$_REQUEST["action"] = "edit-gallery";
		}
		private function setDataSlider(){
			$sql = "select slider_cod, slider_name_".$_SESSION["idioma"]." as slider_name, slider_status
			        from tb_sliders
			        where slider_cod = ?";
			$rs = Apollo::$DB->getRow($sql,array($_REQUEST["indx"]));
			unset($_REQUEST);
			$_REQUEST  = $rs;
			$_REQUEST["option"] = "data-slider";
			$_REQUEST["action"] = "edit-slider";
			
		}
		
		private function setCreateSlider(){
			Apollo::$DB->setBeginTrans();
			
			try{	
				$codSlider = Apollo::$CC->createSlider();			
				if($codSlider < 1){

					Apollo::$DB->setCommit(false);	
					Apollo::setMsjUser("Imposible crear el slider");	
					return false;
				}
				if(Apollo::$CC->setAssocSliderSection($codSlider)){
					Apollo::setMsjUser("Slider creado con exito");	
					Apollo::$DB->setCommit(true);	
				}else{
					Apollo::setMsjUser("Operación cancelada, no se logró asociar el slider con las secciones");	
					Apollo::$DB->setCommit(false);	
				}
				
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());
			}
			
		}
		private function updateSlider(){
			try{
				$commit = false;
				Apollo::$DB->setBeginTrans();
				if(!Apollo::$CC->updateDataSlider()){
					Apollo::$DB->setCommit(false);	
					Apollo::setMsjUser("Imposible actualizar el slider");	
					return false;
				}if(Apollo::$CC->setUpdateAssocSliderSection()){
					Apollo::$DB->setCommit(true);	
				}else{
					Apollo::$DB->setCommit(false);	
					Apollo::setMsjUser("Operación cancelada, no se logró asociar el slider con las secciones");	
				}
			}catch(Exception $e){
				Apollo::$DB->setCommit(false);
				Apollo::setMsjUser($e->getMessage());
			}
			
		}
		private function deleteContainer(){
			
			
			$array = Apollo::$CC->getChildContent();
			$infoContainer = Apollo::$CC->getInfContainer();
			foreach ($array as $container) {				
				try{
					$path = $_SERVER["DOCUMENT_ROOT"].$container["cont_path"]."/".$container["cont_real_name"];	
					if(file_exists($path)){
						$sql = "delete from tb_containers where cont_cod = ".$container["cont_cod"]." ";	
						Apollo::$DB->exec($sql);		
						rmdir($path);

						 $aux = explode("/", $container["cont_path"]);
						 $aux = $aux[0]."/".$aux[1]."/thumb_".$aux[2]."/".$container["cont_real_name"];

						 
						// echo $aux;
						 
						 
						 
						$p = $_SERVER["DOCUMENT_ROOT"].$aux;	
						
						rmdir($p);
					}										
				}catch(PDOException $e){
					
					Apollo::setMsjUser("Imposible Eliminar el contenedor, tiene archivos que estan siendo usados");
					
				}
			}
			try{
				
				$path = $_SERVER["DOCUMENT_ROOT"].$infoContainer["cont_path"]."/".$infoContainer["cont_real_name"];	
				
				if(file_exists($path)){
					$sql = "delete from tb_containers where cont_cod = ".$infoContainer["cont_cod"]." ";	
					
					Apollo::$DB->exec($sql);		
					rmdir($path);

					$aux = explode("/",$infoContainer["cont_path"]);
					$aux = $_SERVER["DOCUMENT_ROOT"]."/".$aux[1]."/thumb_".$infoContainer["cont_real_name"];
					rmdir($aux);					
				}
			}catch(PDOException $e){
				Apollo::setMsjUser("Imposible Eliminar el contenedor, tiene archivos que estan siendo usados");
				
			}
			return true;
		}
		private function deleteFile($idFile){
			try{
				if(Apollo::$CC->deleteFile($idFile)){
					Apollo::setMsjUser("Archivo Eliminado Con exito");
				}else{
					Apollo::setMsjUser("El archivo no existe");
				}
			}catch(Exception $e){
					Apollo::setMsjUser("El archivo no puede ser eliminado esta en uso");
			}
			
		}
		private function validateExtFile($typeFile, $File){
			
			if(empty($File["archivo"]["type"])){
				$File["archivo"]["type"] = $_REQUEST["type_file"];
			}
			
			switch ($typeFile) {
				case 'Word':
					$Extensions = array("application/vnd.openxmlformats-officedocument.wordprocessingml.document",
										"application/msword",
										"application/vnd.oasis.opendocument.text"
										);
					break;
				case 'Excel':
					$Extensions = array("application/vnd.oasis.opendocument.spreadsheet",
										"pplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
										"application/vnd.ms-excel"
										);
					break;
				case 'PowerPoint':	
					$Extensions = array("application/vnd.oasis.opendocument.presentation",
										"application/vnd.ms-powerpoint",
										"application/vnd.openxmlformats-officedocument.presentationml.presentation"
										);
					break;
				case 'PDF':	
					$Extensions = array("application/pdf");
					break;
				case 'Imagen':

					$Extensions = array("image/png",
										"image/gif",
										"image/jpeg"
										);	
													
					break;
				case 'Audio':	
					$Extensions = array("audio/mpeg",
										"audio/x-ms-wma",
										"audio/mp3",
										"audio/x-wav");					
					break;
				case 'Videos':	
					$Extensions = array("video/ogg",
										"video/mp4",
										"video/3gpp");					
					break;	
				default:
					Apollo::setMsjUser("Error en la extensión del archivo");
					break;
			}
			foreach ($Extensions as $key => $value) {
				if($value ==  $File["archivo"]["type"]) {

					return true;
				}
			}
			echo Apollo::setMsjUser("Formato del archivo es desconocido, o intenta subir un archivo que no es del tipo seleccionado");
			return false;
			
		}
		private function optimizeImages($img,$patchFile){

			$info = getimagesize($img);
			$thumb = PhpThumbFactory::create($img);			
			$thumb->resize(1100, 760); 
			$thumb->save($img);

			$this->createThumbnail($patchFile);

		}
		private function createThumbnail($img){
			$Thumb = explode("/", $img);
			
			$Thumbnail = "";
			$i = 0;
			foreach ($Thumb as $key => $value) {
				
				if($i >= count($Thumb) -1 ) {
					$Thumbnail .= "/thumb_".$value;
				}elseif($i>0){
					$Thumbnail .= "/".$value;	
				}
				
				$i++;
			}
			
		    
			$Thumbnail = $_SERVER["DOCUMENT_ROOT"].$Thumbnail;								
										
			$thumb = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"].$img);			
			$thumb->resize(282, 243); 
			$thumb->save($Thumbnail);
		}
		private function uploadFile(){
			
			if($this->validateExtFile($_REQUEST["tipo_archivo"], $_FILES)){
				
				//$ext = explode("/",$_FILES['archivo']['type']);
				$ext = explode(".",$_FILES['archivo']['name']);
				$archivo = sha1($_FILES['archivo']['name'].date('Y-m-d H:i:s')).".".$ext[1];
				$ruta =  Apollo::$CC->pathContainer($_REQUEST["container"]);
				$file = $_SERVER["DOCUMENT_ROOT"].$ruta."/".$archivo;
				$tmp = $file;
				
				if(file_exists($file)){
					Apollo::setMsjUser("El archivo existe en el contenedor");
				}else{
					if(move_uploaded_file($_FILES['archivo']['tmp_name'], $file)){
						if($_REQUEST["tipo_archivo"] == "Imagen"){
							$this->optimizeImages($tmp,$ruta."/".$archivo);
						}
						
						$data = array(
							"fil_name" => $_REQUEST["descripcion"],
		                    "fil_real_name" => $archivo,
		                    "fil_router" => $ruta,
		                    "fil_type" => $_REQUEST["tipo_archivo"],
		                    "cont_cod" => $_REQUEST["container"],
		                    "fil_date_upload" => date("Y-m-d")
		                );
		               
		                try{
		                	$id = Apollo::$DB->qqInsert("tb_files", $data);	
			               if($id>0){
			               		unset($_REQUEST["action"]);
			               		unset($_REQUEST["container"]);
			               		unset($_REQUEST["sid"]);
			               		Apollo::setMsjUser("Archivo fue agregado con éxito");
			               }else{
			               		unlink($tmp);
			               		Apollo::setMsjUser("Error inesperado al subir el archivo la servidor");
			               }
		                }catch(Exception $e){

		                	unlink($tmp);
		                	Apollo::setMsjUser($e->getMessage());
		                }
		               
					}else{
						Apollo::setMsjUser("Imposible subir el archivo la servidor");
					}
				}
				
				
				
			}else{
				Apollo::setMsjUser("Tipo de archivo no valido");
			}
			return true;
		}
		
		private function ListCluster(){

			$rs = Apollo::$CC->getRsListContainers();

			foreach ($rs as $value) {
				$nroFile = Apollo::$CC->getNroFile($value["cont_cod"]);
				if($nroFile < 1){
					$style = "class = 'folder-container folder-empty'";
				}else{
					$style = "class = 'folder-container folder-file'";
				}
				$folder = explode("/",$value["cont_path"]);
				if(count($folder)<3){
					$path = $value["cont_path"]."/".$value["cont_real_name"];
					self::$dataCluster .= '
						<div class = "conteiners">
							<p>
								<input type = "checkbox" class= "cluster" value = "'.$value["cont_cod"].'" name-container = "'.$path.'"> '.$nroFile.'
								<a title="Eliminar Contenedor" href="/Multimedia/Container/view-content?indx-content='.$value["cont_real_name"].'&sid='.$_SESSION["sid"].'&action=delete-container" target="_top" class="close delete-item">×</a>
							</p>
							<a href = "/Multimedia/Container/view-content?option=data-container&indx='.$value["cont_cod"].'">
								<span '.$style.'></span>
							
								<p class = "name-container">
									'.$value["cont_name"].'
								</p>
							</a>
						</div>
					';		
				}
				
			}
		}
		public function getDataContainers(){
			return self::$dataCluster;
		}
		private function dataCluster(){

			$rsFolder = Apollo::$CC->getRsListContainers(addslashes($_REQUEST["indx"]));
			$rsFile = Apollo::$CC->getFileContainer();	

			$dataParent = Apollo::$CC->getDataContainerFather(addslashes($_REQUEST["indx"]));
			if(empty($dataParent)){
				$url = '/Multimedia/Container/view-content';
			}else{
				$url = '/Multimedia/Container/view-content?option=data-container&indx='.$dataParent["cont_cod"].'';
			}
			self::$dataCluster .= '
			<div style = "margin-top:-5px">
				<a href = "'.$url.'">
					Ir Atras
				</a>
			</div>
			';
			foreach ($rsFolder as $value) {
				$nroFile = Apollo::$CC->getNroFile($value["cont_cod"]);
				if($nroFile < 1){
					$style = "class = 'folder-container folder-empty'";
				}else{
					$style = "class = 'folder-container folder-file'";
				}
				$folder = explode("/",$value["cont_path"]);
				$path = $value["cont_path"]."/".$value["cont_real_name"];
				self::$dataCluster .= '
						<div class = "conteiners">
							<p>
								<input type = "checkbox" class= "cluster" name-container = "'.$path.'" select-container[] value = "'.$value["cont_cod"].'"> '.$nroFile.'
								<a title="Eliminar Contenedor" rel="banners :: 5" href="/Multimedia/Container/view-content?sid='.$_SESSION["sid"].'&indx-content='.$value["cont_real_name"].'&action=delete-container" target="_top" class="close delete-item">×</a>
							</p>
							<a href = "/Multimedia/Container/view-content?option=data-container&indx='.$value["cont_cod"].'">
								<span '.$style.'></span>							
								<p class = "name-container">
									'.$value["cont_name"].'
								</p>
							</a>
						</div>
					';	
			}
			foreach ($rsFile as $value) {
				switch ($value["fil_type"]) {
					case 'Word':
						$rutaFile = '/Template/img/word.png';
						$file = '<img src = "'.$rutaFile.'" >';	
						break;
					case 'Power Point':
						$rutaFile = '/Template/img/power-point.jpg';
						$file = '<img src = "'.$rutaFile.'">';	
						break;
					case 'PDF':
						$rutaFile = '/Template/img/pdf.jpg';
						$file = '<img src = "'.$rutaFile.'">';	
						break;
					case 'Imagen':
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
						$file = '<img src = "'.$rutaFile.'" >';	
						break;
					case 'Videos':
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
						$file = '<video controls>
								    <source src="'.$rutaFile .'" type="video/mp4">
								    <source src="'.$rutaFile .'" type="video/ogg">
								    <source src="'.$rutaFile .'" type="video/WebM">
								    <embed src="'.$rutaFile .'" type="application/x-shockwave-flash" width="1024" height="798" allowscriptaccess="always" allowfullscreen="true"></embed>
								</video>';	
						break;
					case 'Audio':
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
						$file = '<audio controls>
								    <source src="'.$rutaFile .'">								    
								</audio>';	
						break;	
					default:
						$file = "";
						$rutaFile = "";
						break;
				}
				
				self::$dataCluster .= '
					<div class = "conteiners">
						<p>
							<a title="Eliminar Archivo" rel="banners :: 5" href="/Multimedia/Container/view-content?option=data-container&indx='.$_REQUEST["indx"].'&sid='.$_SESSION["sid"].'&action=delete-file&file-indx='.$value["fil_cod"].'" target="_top" class="close delete-item">×</a>
						</p>
						<div class = "file-container">
							'.$file.'
						</div>
						
						<p class = "name-container">
							'.$value["fil_name"].'
						</p>
					</div>
				';
			}
		}
		private function createCluster(){
			$contenedor = sha1($_REQUEST["name-cluster"]);	
			$pathname = "";
			$conteiners_thumb = "";
			
			if(empty($_REQUEST["cluster"])){
				$pathname = $_SERVER["DOCUMENT_ROOT"]."/Cluster/".$contenedor;				
				$path = "/Cluster";
			}else{
				$pathname = $_SERVER["DOCUMENT_ROOT"].$_REQUEST["cluster"]."/".$contenedor;				
				$path = $_REQUEST["cluster"];
			}
				
			if(file_exists($pathname)){
				echo Apollo::setMsjUser("El Contenedor No Fue Creado Porque Ya Existe");
			}else{
				if(Apollo::$CC->createContainer($path,$contenedor) > 0){
					echo Apollo::setMsjUser("Contenedor Creado con Exito");
					mkdir($pathname);
					

					//	mkdir($conteiners_thumb);
					
				}else{
					echo Apollo::setMsjUser("Error Desconocido, Contenedor no Fue Registrado");
				}
				
			}
		}
		
	}
?>
