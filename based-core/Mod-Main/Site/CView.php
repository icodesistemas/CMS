<?php
/**
* Clase para contruir la ruta a las diferentes vistas y validar si el usuario posee permisos
* para operar en dicha vista
*Autor: Angel Bejarano	
*2014-02-19
*/

	class CView extends ConstructMain{
		private static $routeView;
		private static $viewActive;
		private static $FileView;
		private static $patchVView = "";

		public static function getView(){
			return CView::$routeView;
		}
		public static function contructView(){
			if(empty(Login::$datSession["id"])){
				CView::$routeView = "Views/System/Default/login.php";
				CView::$viewActive = "login";
				return true;
			}else{

				CView::$routeView = "Views/System/Default/dashboard.php";
				return CView::searchView();
			}
		}
		private static function searchView(){
			if(isset($_SESSION["sid"])){
				
				if((isset($_REQUEST["sid"]) && $_REQUEST["sid"] != $_SESSION["sid"] || !isset($_REQUEST["sid"]))  && isset($_REQUEST["action"]) && $_REQUEST["action"] != "makeLogin"){
					header(":",true,403);
					header("location: /Views/System/Page-Error/403.php");
										
				}
			}
			if(isset($_REQUEST["module"])){
				$patch = $_REQUEST["module"];
			}
			if(isset($_REQUEST["submodule"])){
				$patch .= "/".$_REQUEST["submodule"];
			}
			if(isset($_REQUEST["vista"]) && $_REQUEST["vista"] != "dashboard"){
				$patch .= "/".$_REQUEST["vista"];
				CView::$viewActive = $_REQUEST["vista"];
			}else{
				CView::$FileView = "default.php";
				return false;
			}
			self::$patchVView = "/".$patch;
			if(isset($_REQUEST["action"])){
				$patch .= "/".$_REQUEST["action"];
			}
			$view = $_SERVER["DOCUMENT_ROOT"]."/Views/".self::$patchVView.".php";
			self::$patchVView = "/".$patch;
			if(file_exists($view)){
			
				if(self::checkUPermissions()){
					CView::$FileView = $view;
					return true;
				}else{
					header(":",true,403);
					header("location: /Views/System/Page-Error/403.php");
				}
				
			}else{
				header(":",true,404);
				header("location: /Views/System/Page-Error/404.php");
			}
		}
		public function getCurrentView(){
			return CView::$viewActive;
		}
		public function getFileView(){
			
			return self::$FileView;	
			
		}
		private static function checkUPermissions(){
			$sql = "select cod_menu,class_ico, title_menu from tb_menu where addr_menu = ? and active = 1 ";

			
			$rs = Apollo::$DB->getRow($sql,array(self::$patchVView));
			
			if($rs == 0){
				return false;
			}
			$codModule = $rs["cod_menu"];
			$css= trim($rs["class_ico"]);
			$title = $rs["title_menu"];
			$sql = "select permission from tb_permission where cod_module = $codModule and cod_profile = ".Login::$datSession["perfil"]." and permission = 1";
						
			if(Apollo::$DB->getValue($sql) != 0){
				Apollo::setTitleOpc($css, $title);
				return true;	
			}else{
				return false;	
			}			
		}
	}