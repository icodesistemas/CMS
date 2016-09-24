<?php
	require_once 'Email/PHPMailerAutoload.php';
	class serverMail extends PHPMailer{
		private $mail;
		private $EmailFrom;
		private $From_Name;

		public function __construct(){

			parent::__construct(true);
			$this->conf();
		}
		private function conf(){
			$fileXML =  (__DIR__)."/.conf-mail.xml";
			if(!file_exists($fileXML)){
				die("Configuración del Servidor de Correo no Existe");
			}

			$fileXML = file_get_contents($fileXML);
			$xml = new SimpleXMLElement($fileXML);			

			if(strtoupper($xml->smpt) == "SI"){
				$this->IsSMTP();
				$this->SMTPAuth   = true;    
			}else{
				$this->IsSendmail(); 
			}
			                          
			              
			$this->Port       = $xml->puerto;                    
			$this->Host       = $xml->host; 
			$this->Username   = $xml->user;  
			$this->Password   = $xml->pass; 
			//$this->Subject    = $xml->Subject;
			
			$this->IsHTML(true);

			$this->EmailFrom = $xml->send->mail;
			$this->From_Name  = $xml->send->name;

		}
		public function datosEmail($nombre, $correo){
			$this->EmailFrom = $correo;
			$this->From_Name  = $nombre;
		}
		public function sendEmail($email,$content,$Subject,$replay = "", $file = array()){
			//parent::mailReply = $replay;

			 try {
				$this->Subject    = $Subject;
				$body = $content;
				$this->From       = $this->EmailFrom;
				$this->FromName   = $this->From_Name;
				$this->AddAddress($email);
				
				if(count($file)>0){
					$this->AddAttachment($file[0],$file[1]);
				}

				$this->AltBody    = "Para ver el mensaje, por favor, utilice un visor de correo electrónico compatible con HTML!"; // optional, comment out and test
				$this->WordWrap   = 80; // set word wrap
				$this->MsgHTML($body);

				$this->Send();
				
			} catch (phpmailerException $e) {
				//echo $e->errorMessage();
			}
		}
	}



?>
