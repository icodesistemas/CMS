<?php

	class ModelSecurity{
		protected $dataUser;
		protected $profileSearch;
		public function __construct(){

			if(isset($_REQUEST["action"])){
				switch ($_REQUEST["action"]) {
					case 'add-user':
						$this->registerUser();
						break;
					case 'update-user':
						$this->updateDateUser();
						break;
					case 'edit-profile':
						
						Apollo::$CC->updateProfile();
						break;
					case 'add-profile':	
						if(!empty($_REQUEST["perf"])){
							$perf = $_REQUEST["perf"];
							Apollo::$CC->addProfile($perf, $_REQUEST['perfil']);
						}
						break;
					case 'add-module':
						$this->addModule();
						break;		
					case 'edit-module':						
						$this->addModule("edit-module");
						break;		
					default:
						# code...
						break;
				}
			}
			if(isset($_REQUEST["option"]) && $_SESSION["sid"] == $_REQUEST["sid"]){
				switch ($_REQUEST["option"]) {
					case 'edit-user':
						$this->prepareDataUser();
						break;
					case 'delete-profile':	
						Apollo::$CC->deletePerfil();
						break;	
					case 'data-edit-module':
						$this->getDataEditModule();	
						break;	
					default:
						# code...
						break;
				}
			}
		}
		private function getDataEditModule(){
			$sql = "select * from tb_menu where cod_menu = ?";

			$rs = Apollo::$DB->getRow($sql, array(addslashes($_REQUEST["module-indx"])));
			$_REQUEST["ico-css"] = $rs["class_ico"];
			$_REQUEST["titulo"] = $rs["title_menu"];
			$_REQUEST["ubicacion"] = $rs["type_menu"];
			
			$_REQUEST["modulo"] = $rs["name_menu"];

			$slag = explode("/", $rs["addr_menu"]);
			/*echo "<pre>";
			print_r($slag);
			echo "</pre>";*/
			$_REQUEST["direct"]  = $slag[1];
			if(isset($slag[2])){
				$_REQUEST["submodulo"] = $slag[2];
			}
			if(isset($slag[3])){
				$_REQUEST["view"] = $slag[3];
			}
			if(isset($slag[4])){
				$_REQUEST["accion"] = $slag[4];
			}

		}
		private function addModule($action = "add-module"){
			$slag = "/".$_REQUEST["direct"];
						
			if(!empty($_REQUEST["submodulo"])){
				$slag = $slag."/".$_REQUEST["submodulo"];
			}
			if(!empty($_REQUEST["view"])){
				$slag = $slag."/".$_REQUEST["view"];
			}
			if(!empty($_REQUEST["accion"])){
				$slag = $slag."/".$_REQUEST["accion"];
			}
			
			$data = array(
						 'name_menu' => $_REQUEST["modulo"],
						 'addr_menu' => $slag,	
						 'class_ico' => $_REQUEST["ico-css"],
						 'title_menu' => $_REQUEST["titulo"],
						 'type_menu' => $_REQUEST["ubicacion"],
						 'cod_menu_parent' => $_REQUEST["modduloPadre"],
						 'active' => 1
						 );
			Apollo::$CC->addModule($data,$action);
		}
		private function prepareDataUser(){

			$this->dataUser = Apollo::$CC->DataUser($_REQUEST["indx"]);
			$this->profileSearch = $this->dataUser["codperfil"];
		}
		public function getDataUser(){
			return $this->dataUser;
		}
		private function updateDateUser(){
			$data = array(
				'coduser' => $_REQUEST["ciUser"],
				'nomuser' => $_REQUEST["nameUser"],
				'usersession' => $_REQUEST["user"],
				'emailuser' => $_REQUEST["emailUser"],
				'codperfil' => $_REQUEST["perfil"],
				'status' => 'A'
				);
			
			Apollo::$CC->editUser($data);
		}
		public function registerUser(){
			$pass = Funciones::encryption($_REQUEST["passUser"]);
			$data = array(
				'coduser' => $_REQUEST["ciUser"],
				'nomuser' => $_REQUEST["nameUser"],
				'usersession' => $_REQUEST["user"],
				'emailuser' => $_REQUEST["emailUser"],
				'passuser' => $pass,
				'codperfil' => $_REQUEST["perfil"],
				'status' => 'A'
				);
			Apollo::$CC->addUser($data);
		}
		public function getProfiles(){
			
			$rs = ControllerSecurity::getDataProfiles();
			if($rs == 0){
				return "Perfiles de Usuario no han sido definidos";
			}
			$tab = '
				<table class="Grid" cellpadding="5" width="99.5%">
					<thead>
						<tr>	
							<th style = "width:5px;"></th>
							<th>Perfil de Usuario</th>
						</tr>
					</thead>
					<tbody>
			';
			$j = 0;
			foreach ($rs as $value) {
				if($j % 2 == 0){
                    $class = '';
                    
                }else{
                    $class = 'class= "alt"';
                }
                if($value["cod_profile"] == $this->profileSearch ){
                	$check = "checked= 'checked'";
                }else{
                	$check = "";
                }
				$tab .= '
					<tr '. $class.'>
						<td><input type = "checkbox" '.$check.' value= "'.$value["cod_profile"].'" class = "id-perfil" name = "perfil"></td>
						<td>'.$value["name_profile"].'</td>
					</tr>
				';
				$j++;
			}
			return $tab."</tbody></table>";
		}
	}