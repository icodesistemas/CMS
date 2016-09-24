<?php
	class ConstructMain{
		protected $rsParent;
		protected $rsChild;
		protected $dataChild;
		public function systemSideMenu(){
			$sql = "select cod_menu, name_menu, addr_menu , class_ico
					from tb_menu where cod_menu_parent = 0 and type_menu = 'L' and active = 1 order by cod_menu asc";			
			$this->rsParent = Apollo::$DB->getArray($sql);

			$sql = "select cod_menu, name_menu, addr_menu,cod_menu_parent ,class_ico
					from tb_menu where cod_menu_parent != 0 and type_menu = 'L' and active = 1";			
			$this->rsChild = Apollo::$DB->getArray($sql);

			$this->createSide();
		}
		private function createSide(){
			$m = '
			<ul class = "menu-side">
			';
			$rs = $this->rsParent;
			foreach ($rs as $value) {
				$child = $this->getOpcChildSie($value["cod_menu"]);
				$m .= '
						<li class="opt-main">
							<a href="#">'.$value["name_menu"].'</a>
							'.$child .'
						</li>
					';
			}
			echo $m."</ul>";
		}
		private function getOpcChildSie($idParent){
			$rs = $this->rsChild;
			$ss = '<ul>';
			foreach ($rs as $value) {
				if($value["cod_menu_parent"] == $idParent){
					$ss .= '
					<li>
						<a href = "'.$value["addr_menu"].'" title = "'.$value["name_menu"].'" id = "link-view">'.$value["name_menu"].'</a>
						<i class = "ico-black '.$value["class_ico"].'"></i>
					</li>
					';
				}
			}
			if($ss != '<ul>'){
				return $ss."</ul>";
			}else {
				return "";
			}
		}
		public function systemTopMenu(){
			$sql = "select cod_menu, name_menu, addr_menu from tb_menu where cod_menu_parent = 0 and type_menu = 'S'";			
			$this->rsParent = Apollo::$DB->getArray($sql);

			$sql = "select cod_menu, name_menu, addr_menu,cod_menu_parent from tb_menu where cod_menu_parent != 0 and type_menu = 'S'";			
			$this->rsChild = Apollo::$DB->getArray($sql);
			
			$this->createSystemTopMenu();
			
		}
		private function createSystemTopMenu(){
			$tool = '
				<ul class="nav menu-header">
			';	
			$rs = $this->rsParent;
			foreach ($rs as $value) {
				$child = $this->getOpcChild($value["cod_menu"]);
				
					$tool .= '
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$value["name_menu"].'<span class="caret"></span></a>
							'.$child .'
						</li>
					';
				
			}
			echo $tool.'<li><a class="menu-cpanel" href="/quit">Cerrar Sesión</a></li></ul>';
		}
		private function getOpcChild($idParent){
			$rs = $this->rsChild;
			$this->dataChild = "<ul class = 'dropdown-menu'>";
			foreach ($rs as $value) {
				if($value["cod_menu_parent"] == $idParent){
					$this->dataChild .= '
					<li>
						<a class="menu-config" href = "'.$value["addr_menu"].'">'.$value["name_menu"].'</a>
					</li>
					<li class="divider"><span></span></li>
					';
				}
			}
			if($this->dataChild == "<ul class = 'dropdown-menu'>"){
				return "";
			}else{
				return $this->dataChild .= "</ul>";	
			}
			
		}
	}