<?php
	$rsFile;
	function getRsListContainers($where = 0){
		global $db, $rsFile;
		if($where == 0){
			$sql = "select * from tb_containers";
			$rs = $db->getArray($sql);	
		}else{
			$sql = "select * from tb_containers where cont_parent = ?";
			$rs = $db->getArray($sql,array($where));	
		}
		
		if(count($rs)>0){

			$sql = "select * from tb_files";
			$rsFile = $db->getArray($sql);

		}

		return $rs;
	}
	function getFileContainer(){
		global $db;
		$codCluster = addslashes($_REQUEST["indx"]);
		if($_REQUEST["formato"] == ""){
			$sql = "select fil_real_name, fil_name, fil_type, fil_router,cont_name
		 			from tb_files a, tb_containers b
		 			where b.cont_cod = ? and a.cont_cod = b.cont_cod";
		}else{
			if($_REQUEST["formato"] == 'Descargables'){
				$type = " in ('Word','Excel','PowerPoint','PDF')";
			}else{
				$type = " = '".$_REQUEST["formato"]."'";
			}
			$sql = "select fil_real_name, fil_name, fil_type, fil_router,cont_name
		 			from tb_files a, tb_containers b
		 			where b.cont_cod = ? and a.cont_cod = b.cont_cod and fil_type $type  ";
		}		
		return $db->getArray($sql, array($codCluster));
	}
	/*function getNroFile($codigo){
		global $rsFile;
		$rs = $rsFile;
		$cant = 0;
		foreach ($rs as $value) {
			if($value["cont_cod"] == $codigo){
				$cant++;
			}
		}
		return $cant;	
	}*/
	/*function getDataContainerFather($indx){
		global $db;
		$idParent =  $db->getValue("select cont_parent from tb_containers where cont_cod = ".$indx." ");
		
		$rs = $db->getRow("select cont_cod, cont_name from tb_containers where cont_cod = ".$idParent." ");

		return $rs;
	}*/
	function ListCluster($parent){
		$rs = getRsListContainers();
		if($parent == 0){
			$Cluster = '<section style = "float:left; width:28%"><ul>';	
		}else{
			$Cluster = "<ul id = 'explorer'>";
		}
		
		foreach ($rs as $value) {
			if($value["cont_parent"] == $parent){
				$child = ListCluster($value["cont_cod"]);
				if($child != "<ul id = 'explorer'></ul>"){
					$style = "class = 'folder-container folder-file'";
					$onclick = 'onclick="explorerFile('.$value["cont_cod"].')"';
				}else{
					$style = "class = 'folder-container folder-empty'";
					$onclick = 'onclick="explorerFile('.$value["cont_cod"].')"';
				}
				
				$Cluster .= '<li>
								<span '.$style.'></span>
								<i '.$onclick.'>'.$value["cont_name"].'</i>
								'.$child.'
							</li>';
			}
			
		}
		if($parent == 0){
			return $Cluster."</ul></section>";
		}else{
			return $Cluster."</ul>";
		}
		
	}
	function navegacionArchivos(){
		
		if($_REQUEST["indx"] == 0 ){
			echo ListCluster(0);
			return true;
		}
		$rsFile = getFileContainer();	
		$dataCluster = ListCluster(0);
		$dataCluster .= "<section style = 'float:left; width:70%'>
							<h3 style = 'margin-top:0'>Contenedor: ".$rsFile[0]["cont_name"]."</h3>";
		foreach ($rsFile as $value) {
			switch ($value["fil_type"]) {
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
					$thum = $value["fil_router"]."/thumb_".$value["fil_real_name"];
					$file = '<img src = "'.$thum.'" >';	
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
			
			$dataCluster .= '
				<div class = "conteiners" onclick= "imgSelect(\''.$rutaFile .'\',\''.$value["fil_type"].'\')">
					<div class = "file-container">
						'.$file.'
					</div>					
					<p class = "name-container">
						'.$value["fil_name"].'
					</p>
				</div>
			';
		}
		
		echo $dataCluster."</section>";
	}

?>