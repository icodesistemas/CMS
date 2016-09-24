<?php
/**
* Apollo CMS Framework: Incorpora librerias pre-construidas que agiliza el desarrollo de aplicaciones web
* Autor: Angel Bejarano	
* 2014 -02-15
* Vr 0.1 
*/

class Apollo extends CSite{
	public $Mail;
	static $DB;
	static $CC;
	public $MM;
	public $pF;
	
	public function __construct($presistentDB=false){
		//$this->validateHost();
		$fileConex =  (__DIR__)."/Library/.conf-conex.xml";
		if(!file_exists($fileConex)){
			die("Imposible Continuar falta error!!!");
		}
		require_once "Library/conexPdo.php";
		Apollo::$DB = new Conexion($presistentDB);
	
	}
	/* metodo para renderizar aplicaciones web */
	public function webApp($conf){
		
		require_once $_SERVER["DOCUMENT_ROOT"]."/Controller/CLogin.php";
		new Login;
		
		if(CView::contructView()){
			if(isset($conf["controller"])){				
				$obj = $this->renderController($conf["controller"]);
				if(!empty($obj)){
					Apollo::$CC = new $obj;	
				}
				
			}
			if(isset($conf["model"])){
				$obj = $this->renderModel($conf["model"]);
				if(!empty($obj)){
					$this->MM = new $obj;	
				}
				
			}	
		}
	}
	/* metodo para renderizar paginas web */
	public function pageWeb($conf){
		
	}
	private function renderController($controller){	

		$currentView = CView::getCurrentView();
		
		foreach ($controller as $key => $value) {
			foreach ($value as $k => $val) {
				if($currentView == $val){

					return $this->contructRouteFileInclude($key);
				}
			}
		}
	}
	protected function contructRouteFileInclude($file){		
		$routeFile = explode(".",$file);
		$route = "";
		for ($i = 0; $i < count($routeFile); $i++) { 
			if(count($routeFile) -1 > $i){
				$route .= "/".$routeFile[$i];
			}else{
				$instanObj = $routeFile[$i];
			}
		}
		$route = $_SERVER["DOCUMENT_ROOT"].$route.".php";
		
		if(file_exists($route)){
			require_once $route;
			return ($instanObj);
		}else{
			die("archivo a incluir no existe");
		}
	}
	protected function validateHost(){
		$_HOST = $_SERVER["SERVER_NAME"];
		
		switch ($_HOST) {
			case 'cpaneldna':
				return true;
				break;
			case 'dnapanel.dnaconections.com':
				return true;
				break;
			default:
				header("location: /Views/System/Page-Error/403.php");
				break;
		}
	}
	private function renderModel($model){
		$currentView = CView::getCurrentView();
		foreach ($model as $key => $value) {
			foreach ($value as $k => $val) {
				if($currentView == $val){

					return $this->contructRouteFileInclude($key);
				}
			}
		}
	}
	private function imporFIle($file){
		return require_once $file;
	}
	public function setMail($email,$content,$replay = ""){
		require_once "Library/serverMail.php";
		$this->Mail = new serverMail;
		$this->Mail->setMail($email,$content,$replay); 
	}
}
