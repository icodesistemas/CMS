<?php
	class ControllerSecurity{	
		protected $validar;
		public function __construct(){

			if(isset($_REQUEST["action"])){
				switch ($_REQUEST["action"]) {
					case 'delete-user':
						$this->deleteUser();
						break;
					case 'block-user':
						$this->blockUnlockUser("I");
						break;
					case 'unlock-user':
						$this->blockUnlockUser("A");
						break;	
					case 'delete-module':					
						$this->deleteOption();

						break;	
				}
			}
		}	
		public function deleteOption(){
			try{
				Apollo::$DB->setBeginTrans();
				$commit = true;
				
				$this->deleteSubModuel();
				$sql = "delete from tb_menu where cod_menu = ".$_REQUEST["module-indx"]." ";
				
				if(Apollo::$DB->exec($sql) < 1){
					$commit = falase;
				}
				
				if($commit){
					Apollo::setMsjUser("Opción de sistema eliminado con exito");
				}else{
					Apollo::setMsjUser("Error al momento de eliminar opción del sistema");
				}
				Apollo::$DB->setCommit($commit);		
			}catch(Exception $e){
				Apollo::setMsjUser($e->getMessage());
				Apollo::$DB->setCommit(false);
			}			
		}
		private function deleteSubModuel(){
			$sql = "delete from tb_menu where cod_menu_parent = ".$_REQUEST["module-indx"]." ";

			Apollo::$DB->exec($sql);
			
		}
		public function getProfiles($validarPerfil){
			
			$this->validar = $validarPerfil;
			$sql = "select cod_menu, name_menu,cod_menu_parent 
					from tb_menu where cod_menu_parent = 0";
			
			$rs1 = Apollo::$DB->getArray($sql);
			
			$i = 0;
			$v =  '<script>$(document).ready(function(){
	
					// first example
					$("#browser").treeview();
					
					
				
				});</script><ul id="browser" class="filetree">';	
			while(count($rs1) > $i){
				$v = $v.'
				<li>
				<span class="folder">'. ($rs1[$i]["name_menu"]).'</span>
					'. $this->buscarModuloHijo($rs1[$i]["cod_menu"]).'	
				</li>							
				';
				$i++;
			}
			echo $v.'</ul>';
		}
		protected function buscarModuloHijo($idMod,$r=""){
			if(empty($r)){
				$sql = "select cod_menu, name_menu,cod_menu_parent 
				        from tb_menu 
				        where cod_menu_parent = '{$idMod}'";
				$rs2 = Apollo::$DB->getArray($sql);
			}else{
				$rs2 = $r;
			}
			
			$j = 0;
			$h = '<ul>';
			while(count($rs2) > $j){
				$sql = "select cod_menu, name_menu,cod_menu_parent from tb_menu where cod_menu_parent = '{$rs2[$j]["cod_menu"]}'";
				$r2 = Apollo::$DB->getArray($sql);
				if(count($r2)>0){
					
					$h = $h.'<li class="closed">
								<span class="folder">
									<input type="checkbox" '.$this->validarPermiso($rs2[$j]["cod_menu"]).' name="perfil['.$rs2[$j]["cod_menu"].']" />
									'. ($rs2[$j]["name_menu"]).'
								</span>
									'. $this->buscarModuloHijo($rs2[$j]["cod_menu"]).'	
							</li>';
				}else{
					$h = $h. '<li class="last">
								<span class="file">
									<input type="checkbox" '.$this->validarPermiso($rs2[$j]["cod_menu"]).' name="perfil['.$rs2[$j]["cod_menu"].']" />
									'. ($rs2[$j]["name_menu"]).' '. $this->buscarModuloHijo($rs2[$j]["cod_menu"]).'
								</span></li>';
				}
				
					
				$j++;
			}
			return $h.'</ul>';
		}
		protected function validarPermiso($idMod){

			if($this->validar){
				$sql = "select cod_module,permission  
				        from tb_permission 
				        where cod_module = {$idMod} and cod_profile = ".$_REQUEST["perfil-indx"]." ";
			
				$rs = Apollo::$DB->getArray($sql);
				if(count($rs)<1){
					return;
				}
				if($rs[0]["permission"]==1){
					return "checked";	
				}else{
					return;
				}
			}
			
			
		}
		public function getDataProfiles(){
			$sql = "select cod_profile, name_profile from tb_profiles";
			$rs = Apollo::$DB->getArray($sql);
			if(count($rs)>0){
				return $rs;
			}else{
				return 0;
			}
		}
		public function addModule($data,$action){
			try{
				if($action == "edit-module"){
					$data = array_merge($data,array("cod_menu" => addslashes($_REQUEST["module-indx"])));
					
					$id = Apollo::$DB->qqUpdate("tb_menu",$data);
					$msj = "Módulo Actualizado con exito";
				}else{
					$id = Apollo::$DB->qqInsert("tb_menu",$data);
					$msj = "Modulo Registrado Con Exito";
				}
				

				if($id>0){
					Apollo::setMsjUser($msj);
				}else{
					Apollo::setMsjUser("Problemas para Registrar el Modulo");
				}	
			}catch(Exception $s){
				Apollo::setMsjUser($s->getMessage());
			}
			
			unset($_REQUEST);
		}
		
		public function deleteModule($id){
			global $app, $App_Default;			
			$sql = "delete from module where id_module = $id";
			$affected = Apollo::$DB->exec($sql);
			
			if($affected > 0){
				Apollo::setMsjUser("Modulo Eliminado Con Exito");
				
			}else{
				Apollo::setMsjUser("Error al Momento de Eliminar el Modulo");
			}
		}
		public function editModule($data){
			try{
	        	$id = Apollo::$DB->qqUpdate("module",$data);
				if($id>0){
					Apollo::setMsjUser("Modulo Actualizado Con Exito");
				}else{
					Apollo::setMsjUser("Problemas para Actualizar el Modulo");
				}
	        }catch(PDOException $e){
	        	Apollo::setMsjUser($e->getMessage());
	        }
			
		}
		private function blockUnlockUser($status){
			try{
				$data = array('coduser' => $_REQUEST["indx"],'status' => $status);
				Apollo::$DB->qqUpdate("tb_user",$data);
				Apollo::setMsjUser("Operación realizada con exito");
			}catch(PDOException $e){
				Apollo::setMsjUser($e->getMessage());
			}
		}
		public function addProfile($perf,$desPerf){
			try{
				Apollo::$DB->exec("insert into tb_profiles(name_profile)values('{$perf}')");
				$idPerfil = Apollo::$DB->getValue("select max(cod_profile) from tb_profiles");
				
				foreach ($desPerf as $id=>$checked){
				    if ($checked =='on'){
				        $sql ="insert into tb_permission(cod_profile,cod_module,permission)values({$idPerfil},{$id},1)";
						Apollo::$DB->exec($sql);
					}
				}
				Apollo::setMsjUser("Perfil creado con exito");
			}catch(PDOException $e){
				Apollo::setMsjUser($e->getMessage());
			}				
			
			
			
		}
		public function deletePerfil(){
			$idPerfil = $_REQUEST["perfil-indx"];
			
			$sql = "delete from tb_profiles where cod_profile = {$idPerfil}";
				
			$affected = Apollo::$DB->exec($sql);
			if($affected > 0){
				Apollo::setMsjUser("Perfil Eliminado Con Exito");
			}else{
				Apollo::setMsjUser("Imposible Eliminar el Perfil, tiene usuarios asignados");
			}
			
		}
		public function DataUser($id){					

			$sql = "select * from tb_user where coduser = ".$id." ";
			$rs = Apollo::$DB->getRow($sql);
			return $rs;
		}
		public function addUser($data){	
			try{
				$id = Apollo::$DB->qqInsert("tb_user",$data);
				if($id>0){
					Apollo::setMsjUser("Usuario Registrado Con Exito");
				}else{
					Apollo::setMsjUser("Problemas para Registrar al Usuario, El NRo de identificacion puedria estar registrado");
				}	
			}catch(Exception $e){
				Apollo::setMsjUser($e->getMessage());
			}				
		}
		public function editUser($data){
					
			try{
				$id = Apollo::$DB->qqUpdate("tb_user",$data);
				if($id>0){
					Apollo::setMsjUser("Usuario Actualizado Con Exito");
				}else{
					Apollo::setMsjUser("Problemas para Actualizado al Usuario");
				}
			}catch(Exception $e){
				Apollo::setMsjUser($e->getMessage());
			}	
		}
		public function deleteUser(){
					
			$sql = "delete from tb_user where coduser = ?";
			$affected = Apollo::$DB->exec($sql,array($_REQUEST["indx"]));
			if($affected > 0){
				Apollo::setMsjUser("Usuario Eliminado con Exito");
			}else{
				Apollo::setMsjUser("Problemas para Eliminar al Usuario");
			}
		}
		public function updateProfile(){
			try{
				Apollo::$DB->setBeginTrans();
				$si = true;
				$sql = "delete from tb_permission where cod_profile = ".$_REQUEST["iddProfile"]." ";
				Apollo::$DB->exec($sql);

				$desPerf = $_REQUEST["perfil"];
				foreach ($desPerf as $id=>$checked){
				    if ($checked =='on'){
				        $sql ="insert into tb_permission(cod_profile,cod_module,permission)values(".$_REQUEST["iddProfile"].",{$id},1)";
						
						if(Apollo::$DB->exec($sql)<1){
							$si = false;
						}
					}
				}
				if($si){
					Apollo::setMsjUser("Perfil Actualizado con Exito");
					Apollo::$DB->setCommit($si);
				}else{
					Apollo::setMsjUser("Imposible Actualizar el Perfil");
				}
				
			}catch(PDOException $e){
				Apollo::$DB->setCommit(false);
			}
		}
	}
?>