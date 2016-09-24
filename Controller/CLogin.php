<?php

class Login extends Funciones{
	protected $Session;
	static public $datSession;
	static protected $guest =array("id"=>0,"nombre"=>"Invitado","perfil"=>0);

	public function __construct(){
		
		if(isset($_REQUEST["module"]) && $_REQUEST["module"] == "quit"){
			
			$this->makeLogout();
		}
		
		if(isset($_REQUEST["action"])){
			switch ($_REQUEST["action"]) {
				case 'makeLogin':
					$this->makeLogin();
					break;
				case 'quit':	
					$this->makeLogout();
					break;
				default:
					# code...
					break;
			}
		}
		if(!isset($_SESSION["id"])){
    		$_SESSION = self::$guest;				
    	}

    	$this->Session = $_SESSION;
    	$this->initialize();
	}
	protected function initialize(){
		self::$datSession["id"] = $this->decrypts($this->Session["id"]);
		self::$datSession["nombre"] = $this->decrypts($this->Session["nombre"]);
		self::$datSession["perfil"] = $this->decrypts($this->Session["perfil"]);
		
	}
	protected function decrypts($data){
		$semilla = "Vm0weGQxSXlSblJWV0d4WFlUSlNWVll3WkZOVU1WcHpXa2M1VjAxWGVEQmFWVll3Vm14YWMySkVUbGhoTVVwVVdWZHplRll5VGtkWGJGcFhUVEZHTTFkV1dsWmxSbVJJVm10V1VtSkdXbkJWYlRWRFpWWmtWMVp0UmxoaVZscElWMnRvUjFVeVNraFZhemxYWWxoU1lWcFhlR0ZXYkdSeVYyeENWMkV3Y0ZSV1ZWcFNaREZDVWxCVU1EMD0=";
		$decryptConstant = base64_decode($data);
        $decryptConstant = str_replace($semilla,"",$decryptConstant);            
        $decryptConstant = unserialize(str_rot13(base64_decode($decryptConstant)));
        //print_r( $decryptConstant);
        return $decryptConstant;
	}
	private function makeLogin(){
		$sql = "select coduser,nomuser,codperfil,passuser from tb_user where usersession = '".$_REQUEST["user"]."' ";
	
		$rs = Apollo::$DB->getRow($sql);		
		if($rs > 0){	
			if($rs["passuser"] == Funciones::encryption($_REQUEST["clave"])){
				$this->Session = array(
									"id" => Funciones::encryption($rs["coduser"]), 
									"nombre" => Funciones::encryption($rs["nomuser"]),
									"perfil" => Funciones::encryption($rs["codperfil"])
								);	
								
				$_SESSION = $this->Session;
				$_SESSION["sid"] = $this->createSID(Funciones::encryption($rs["nomuser"]));
				$_SESSION['idioma'] = $_POST["idioma_seleccionado"];
				$this->initialize();
			}else{
				Apollo::setMsjUser("Contraseña Incorrecta");	
			}
			

		}else{			
			Apollo::setMsjUser("Usuario No existe");
		}
		
	}

	private  function makeLogout(){
		$_SESSION = self::$guest;	
		$this->initialize();		
		header('Location: /');
	}

}