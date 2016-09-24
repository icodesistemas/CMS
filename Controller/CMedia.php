<?php
    /*5952016*/
	class CMedia{
		private $rsFile;
		private $infoContainer;

		public function createSlider(){
			
			$data = array(
				'slider_date_creation' => date('m-d-Y H:m'),
				'slider_status' => $_REQUEST["status"],
				'slider_name_'.$_SESSION["idioma"].'' => $_REQUEST["nombre"],
				'cod_language' =>$_SESSION['idioma']
			);
			$id = Apollo::$DB->qqInsert("tb_sliders",$data);

			if(self::fileSlider($id)){				
				return $id;
			}else{
				return 0;
			}
		}
		public function updateDataSlider(){
			$data = array(
				'slider_status' => $_REQUEST["status"],
				'slider_name' => $_REQUEST["nombre"],
				'slider_cod' => $_REQUEST["idSlider"]
			);
			try{
				Apollo::$DB->qqUpdate("tb_sliders",$data);
				return $this->updateFile();
			}catch(Exeption $e){
				return false;
			}	
		}
		public function getFileSlider(){
			$sql = "select slider_file_patch, slider_url, slider_file_descrip, slider_file_credito, cod
					from tb_slider_file
					where slider_parent = ?";
			$rs = Apollo::$DB->getArray($sql, array($_REQUEST["slider_cod"]));
			$file = '<tbody>';
			$i = 1;
			foreach ($rs as $key => $value) {
				$file .= '<tr id = "'.$i.'">
							<td>
								<img src = "'.$value["slider_file_patch"].'" alt = "" width="80px" height="60px" >
							</td>
							<td>
								<input type="text" data-preview="'.$i.'" readonly="readonly" id="search-file" name="file[]" value = "'.$value["slider_file_patch"].'">
							</td>
							<td>
								<input type="text" name="url[]" value = "'.$value["slider_url"].'">
							</td>
							<td>
								<input type="text" name="descripFile[]" value = "'.$value["slider_file_descrip"].'">
							</td>
							<td>
								<input type="text" name="creditoFile[]" value = "'.$value["slider_file_credito"].'">
							</td>
							<td>
								<center><img onclick="removeFile('.$i.')" src="/Template/img/delete.png"></center>	
								<input type = "hidden" name = "inxFile[]" value= "'.$value["cod"].'">
							</td>	
							
						</tr>';		
				$i++;		
			}
			return $file .= '</tbody>';
		}
		public function getFileGallery(){
			$sql = "select gal_detail_id, gal_file_patch, gal_url, gal_file_descrip, gal_file_credito
					from tb_gallery_file
					where gal_parent = ?";
			$rs = Apollo::$DB->getArray($sql, array($_REQUEST["gal_cod"]));
			$listFile = '<tbody>';
			$i = 1;
			foreach ($rs as $key => $value) {
				$rutaFile = $_REQUEST["gal_file_patch"];
				switch ($_REQUEST["gal_type"]) {
					case 'Word':
						$rutaFile = '/Template/img/word.png';
						$file = '<img src = "'.$rutaFile.'" >';	
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
						break;
					case 'Power Point':			
						$rutaFile = '/Template/img/power-point.jpg';
						$file = '<img src = "'.$rutaFile.'">';	
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
						break;
					case 'PDF':
						$rutaFile = '/Template/img/pdf.jpg';
						$file = '<img src = "'.$rutaFile.'">';	
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
						break;
					case 'Imagen':
						
						$file = '<img src = "'.$value["gal_file_patch"].'" width="80px" height="60px"  alt = "">';	
						$rutaFile = $value["fil_router"]."/".$value["fil_real_name"];
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
				$listFile .= '
					<tr id = "'.$i.'">
						<td>
						    '.$file.'
						</td>
						<td>
							<input type = "text" id = "search-file" data-preview = "'.$i.'" value = "'.$value["gal_file_patch"].'" name = "file[]" readonly="readonly">
						</td>
						<td>
							<input type="text" name="url[]" value = "'.$value["gal_url"].'">
						</td>
						<td>
							<input type="text" value="'.$value["gal_file_descrip"].'" name="descripFile[]">	
						</td>
						<td>
							<input type="text" value="'.$value["gal_file_credito"].'" name="creditoFile[]">	
						</td>
						<td>
							<center><img onclick="removeFile('.$i.')" src="/Template/img/delete.png"></center>	
							<input type = "hidden" name = "inxFile[]" value= "'.$value["gal_detail_id"].'">
						</td>	
					</tr>
				';
				$i++;
			}	
			echo $listFile .'</tbody>';
		}
		private function updateFile(){
			$indx = $_REQUEST["file"];
			$return = true;
			try{
				$sql = "delete from tb_slider_file where slider_parent = ".$_REQUEST["idSlider"];
				Apollo::$DB->exec($sql);

				foreach ($indx as $key => $value) {
					$sql = "insert into tb_slider_file(cod, slider_parent, slider_file_patch, slider_file_descrip, slider_url, slider_file_credito)values(
								?,?,?,?,?,?
						   )";
					$indxFile = $_REQUEST["inxFile"]["$key"];
					if(is_null($indxFile)){
						$indxFile = "DEFAULT";
					}
					
					$data = array(
						$indxFile,
						$_REQUEST["idSlider"],
						$indx[$key],
						$_REQUEST["descripFile"][$key],
						$_REQUEST["url"][$key],
						$_REQUEST["creditoFile"][$key]
					);	
					Apollo::$DB->exec($sql,$data);		
					
				}
			}catch(Exeption $e){
				$return = false;
				
			}	
			return $return;

		}

		private static function fileSlider($slider){
			$array = $_REQUEST["file"];
			foreach ($array as $key => $value) {
				$data = array(
					'slider_parent' => $slider,
					'slider_file_patch' => $value,
					'slider_url' => $_REQUEST["url"][$key],
					'slider_file_descrip' => $_REQUEST["descripFile"][$key],
					'slider_file_credito' => $_REQUEST["creditoFile"][$key]
					);
				if(Apollo::$DB->qqInsert("tb_slider_file",$data) < 1){
					return false;
				}
			}
			return true;
		}
		public function setAssocSliderSection($slider){

			$section = $_REQUEST["section"];
			try{
				foreach ($section as $key => $value) {
					$sql = "insert into tb_slider_assoc_section(slider_cod, cod_section) values(".$slider.",".$value.")";
					if(Apollo::$DB->exec($sql) < 1){
						return false;
					}

					
				}
				return true;
			}catch(Exeption $e){
				echo $e->getMessage();
			}
			
		}
		public function setUpdateAssocSliderSection(){
			try{
				$delete = "delete from tb_slider_assoc_section where slider_cod = ?";
				Apollo::$DB->exec($delete, array($_REQUEST["idSlider"]));
				$section = $_REQUEST["section"];
				foreach ($section as $key => $value) {
					$sql = "insert into tb_slider_assoc_section(slider_cod, cod_section) values(".$_REQUEST["idSlider"].",".$value.")";

					if(Apollo::$DB->exec($sql) < 1){
						return false;
					}

					
				}
				return true;
			}catch(Exeption $e){
				return false;
			}
		}
		public function updateGallery(){
			$data = array(
				'gal_cod' => $_REQUEST["idGallery"],
				'gal_name' => $_REQUEST["nombre-galeria"],
				'gal_status' => $_REQUEST["status-galeria"],
				'gal_type' => $_REQUEST["tipo_galeria"]
				);
			try{
				Apollo::$DB->qqUpdate("tb_gallery",$data);
				return $this->updateFileGallery();
			}catch(Exeption $e){
				return false;
			}
			
		}
		private function updateFileGallery(){
			try{
				$sql = "delete from tb_gallery_file where gal_parent = ?";
				Apollo::$DB->exec($sql, array($_REQUEST["idGallery"]));	
				$indx = $_REQUEST["file"];
				foreach ($indx as $key => $value) {
					$sql = "insert into tb_gallery_file(gal_detail_id, gal_parent, gal_file_patch, gal_file_descrip, gal_url, gal_file_credito)values(
								?,?,?,?,?,?
						   )";
					$indxFile = $_REQUEST["inxFile"]["$key"];
					if(is_null($indxFile)){
						$indxFile = "DEFAULT";
					}
					$data = array(
						$indxFile,
						$_REQUEST["idGallery"],
						$indx[$key],
						$_REQUEST["descripFile"][$key],
						$_REQUEST["url"][$key],
						$_REQUEST["creditoFile"][$key]
					);	
					Apollo::$DB->exec($sql,$data);	
				}
				return true;
			}catch(Exeption $e){
				return false;
			}
			
		}
		public static function createGallery(){
			if(!isset($_REQUEST["status"])){
				$status = 1;
			}else{
				$status = $_REQUEST["status"];
			}
			$data = array(
				'gal_date' => date('m-d-Y H:m'),
				'gal_type' => strip_tags($_REQUEST["tipo_galeria"]),
				'gal_status' => $status,
				'gal_name' => $_REQUEST["nombre-galeria"],
				'cod_language' => $_SESSION['idioma']
			);
			$id = Apollo::$DB->qqInsert("tb_gallery",$data);

			if(self::fileGallery($id)){
				return $id;
			}else{
				return 0;
			}
		}
		private static function fileGallery($cod){
			$array = $_REQUEST["file"];
			foreach ($array as $key => $value) {
				$data = array(
					'gal_parent' => $cod,
					'gal_file_patch' => $value,
					'gal_url' => $_REQUEST["url"][$key],
					'gal_file_descrip' => $_REQUEST["descripFile"][$key],
					'gal_file_credito' => $_REQUEST["creditoFile"][$key]
					);
				if(Apollo::$DB->qqInsert("tb_gallery_file",$data) < 1){
					return false;
				}
			}
			return true;	
		}
		public function pathContainer($idContainer){			
			$sql = "select cont_path, cont_real_name from tb_containers where cont_cod = ".$idContainer." ";
			$rs = Apollo::$DB->getRow($sql);			
			
			return $rs["cont_path"]."/".$rs["cont_real_name"];
		}	
		public function createContainer($path,$contenedor){
			//SELECT CONCAT(cont_path,'/',cont_real_name) FROM `tb_containers` WHERE 1
			$conParent = Apollo::$DB->getValue("select cont_cod from tb_containers where CONCAT(cont_path,'/',cont_real_name) = '".$_REQUEST["cluster"]."'");
			try{	
				$data = array(
						"cont_real_name" => $contenedor,
						"cont_name" => $_REQUEST["name-cluster"],
						"date_creation" => date("Y-m-d"),
						"cont_path" => $path,
						"cont_parent" => $conParent
					);
				$id = Apollo::$DB->qqInsert("tb_containers",$data);
	            return $id;
			}catch(Exeption $e){
				Apollo::$setMsjUser($e->getMessage());
			}
			
		}
		public function getInfContainer(){
			return $this->infoContainer;
		}
		public function getChildContent(){

			$id = $this->exists_content($_REQUEST["indx-content"]);
			
			if(count($id)  < 1){
				
				return 0;
			}
			$sql = "select cont_cod,cont_path, cont_real_name,cont_parent from tb_containers where cont_parent = ".$id["cont_cod"]." ";
			
			return Apollo::$DB->getArray($sql);
			
		}
		public function getListSection(){			
			$sql = "select cod_section, name_section_".$_SESSION["idioma"]." as seccion 
					from tb_section";			
			$rs = Apollo::$DB->getArray($sql);

			$sql = "select cod_section from tb_slider_assoc_section where slider_cod = ?";
			$rsSection = Apollo::$DB->getArray($sql, array($_REQUEST["slider_cod"]));
			foreach ($rs as $key => $value) {
				$checked  = "";
				if(isset($_REQUEST["slider_cod"])){					
					foreach ($rsSection as $k => $val) {
						if($value["cod_section"] == $val["cod_section"]){
							$checked  = "checked='checked'";	
							break;		
						}
					}
				}
				echo '
				<tr>
					<td>
						<input '.$checked.' type="checkbox" name="section[]" value="'.$value["cod_section"].'"><strong>'.$value["seccion"].'</strong>
					</td>
				</tr>';
			}
		}
		private function exists_content($name){
			$this->infoContainer = Apollo::$DB->getArray("select cont_cod,cont_path,cont_real_name from tb_containers where cont_real_name = ?",array($name));
			$this->infoContainer = $this->infoContainer[0];
			return $this->infoContainer;
		}
		public function getRsListContainers($where = 0){
			if($where == 0){
				$sql = "select * from tb_containers";
				$rs = Apollo::$DB->getArray($sql);	
			}else{
				$sql = "select * from tb_containers where cont_parent = ?";
				$rs = Apollo::$DB->getArray($sql,array($where));	
			}
			
			if(count($rs)>0){

				$sql = "select * from tb_files";
				$this->rsFile = Apollo::$DB->getArray($sql);

			}
			return $rs;
		}
		public function deleteFile($idFile){
			//Apollo::$DB->setBeginTrans();
			$rs = Apollo::$DB->getArray("select fil_router, fil_real_name from tb_files where fil_cod = ?",array($idFile));

			$r = $rs[0]["fil_router"];
			$route = $r."/".$rs[0]["fil_real_name"];
			$route_2 = $r."/thumb_".$rs[0]["fil_real_name"];
			
			
			
			$affet =  Apollo::$DB->exec("delete from tb_files where fil_cod = ?",array($idFile));
			//echo $affet;
			if($affet > 0){
				
				if(file_exists($_SERVER["DOCUMENT_ROOT"].$route)){
					unlink($_SERVER["DOCUMENT_ROOT"].$route);		
					unlink($_SERVER["DOCUMENT_ROOT"].$route_2);	
				}
				
				return true;
			}else{
				return false;
			}
			//Apollo::$DB->setCommit(false);
		}
		public function getNroFile($codigo){

			$rs = $this->rsFile;
			$cant = 0;
			foreach ($rs as $value) {
				if($value["cont_cod"] == $codigo){
					$cant++;
				}
			}
			return $cant;	
		}
		public function getFileContainer(){
			$codCluster = addslashes($_REQUEST["indx"]);
			$sql = "select *
			 		from tb_files
			 		where cont_cod = ?";
			 		
			return Apollo::$DB->getArray($sql, array($codCluster));
		}
		public function getDataContainerFather($indx){
			$idParent =  Apollo::$DB->getValue("select cont_parent from tb_containers where cont_cod = ".$indx." ");
			
			$rs = Apollo::$DB->getRow("select cont_cod, cont_name from tb_containers where cont_cod = ".$idParent." ");
			return $rs;
		}
	}
?>