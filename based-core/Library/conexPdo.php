<?php

/**
*   14/02/2014
*   autor: Angel Bejarano
*   Driver para conexiones de base de datos mysql y postgres
*/
class Conexion extends PDO{
	protected $conf;
	protected $fieldPK = "";
	
	public function __construct($persistent = false){
		if($this->leerConf()){

			$driver = $this->conf->driver;
			$db = $this->conf->database;
	        $host = $this->conf->srv;
			$dsn = "$driver:dbname=$db;host=$host";

			$nombre_usuario =  $this->conf->userdb;
			$contraseña = $this->conf->passdb;
			if($driver == "mysql"){
					$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							 PDO::ATTR_PERSISTENT => $persistent,
							 PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
							 );
			}else{
				$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							 PDO::ATTR_PERSISTENT => $persistent
							 );
			}
			
	        try{
	        	parent::__construct($dsn, $nombre_usuario, $contraseña,$options);
	        }catch(PDOException $e){
	        	die($e->getMessage());
	        }	
		}
		
		
	}
	protected function leerConf(){
		$fileConex =  (__DIR__)."/.conf-conex.xml";
		/*if(!file_exists($fileConex)){			
			$install = 	"/based-core/Mod-Install/";			
			header("location: $install");
		}*/
		//echo $fileConex;
		$file = file_get_contents($fileConex);
		$file = str_replace("\v", "", $file);
		$xml = new SimpleXMLElement($file);
		
		$this->conf = $xml;
		return true;
	}
	public function getArray($sql, $data = ""){			
		try{
			$stmt =parent::prepare($sql); 

			if(empty($data)){
				$stmt->execute();		
			}else{
				$stmt->execute($data);		
			}
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $data;
		}catch (PDOException $e) { 
			echo $e->getMessage();
		}
	}
	public function getValue($sql, $data = ""){
		try{
			$stmt =parent::prepare($sql); 

			if(empty($data)){

				$stmt->execute();		
			}else{
				$stmt->execute($data);		
			}
			
			$rs = $stmt->fetchAll(PDO::FETCH_BOTH);
			$stmt->closeCursor();
			if(count($rs) > 0){
				return $rs[0][0];	
			}else{
				return 0;
			}
			
		}catch (PDOException $e) { 
			echo $e->getMessage();
		}
	}
	public function getRow($sql, $data=""){
		$rs = $this->getArray($sql,$data);
		if(count($rs)>0){
			return $rs[0];	
		}else{
			return 0;
		}
		
	}
	public function qqUpdate($table,$data){
    	$table_data = $this->pairsColumnWithData($data, $table);
    	
    	$update = "update $table set ";
    	$where = " where ";
    	$i = 1;
    	$arrayValue = "";
    	$field  = "";
    	if(!isset($table_data["PK"])){
    		throw new Exception("No se puede actualizar el registro por que no se halla definida la clave primaria");
            return false;
    	}else{
    		$where .= $table_data["PK"][0]. " = ?";
    	}

    	foreach ($table_data as $key => $val) {
    		
    		if($key  != "PK"){
    			if(count($table_data) > $i){
					
					$field .= $val[0]." = ?,";						
					$arrayValue .= $val[2]."***";
				}else{
					$field .= $val[0]." = ? ";												
					$arrayValue .= $val[2];
				}
    		}	
			
			$i++;
			
		}	
		$arrayValue .= "***".$table_data["PK"][2];
		$sql = $update.$field.$where;
		

		return $this->exec($sql,explode("***",$arrayValue));
    }
	public function qqInsert($table, $data){
		$table_data = $this->pairsColumnWithData($data, $table);

		$insert = "insert into $table ";
	    $field = "(";
		$value = "values(";
		$arrayValue= "";	
	    $i = 1;
	    
    	foreach ($table_data as $key => $val) {
			if(count($table_data) > $i){
				if($i == 1){
					$value .= "?";	
				}else{
					$value .= ",?";
				}
				$field .= $val[0].",";						
				$arrayValue .= $val[2]."***";
			}else{
				if(count($table_data)>1){
					$field .= $val[0].")";
					$value .= ",?)";
					$arrayValue .= $val[2];	
				}else{
					$field .= $val[0].")";
					$value .= "?)";
					$arrayValue .= $val[2];	
				}
				
			}
			$i++;
			
		}	
			
		$sql = $insert.$field." ".$value;
		
		return $this->exec($sql,explode("***",$arrayValue),"qqInsert", $table);
		
	}
	public function exec($sql, $data="", $action = "otro", $table = ""){		
		/*echo $sql;
		echo" <pre>";
		print_r($data);
		echo" <pre>";
		*/
			if(empty($data)){
				return parent::exec($sql);
			}else{
				$stmt =parent::prepare($sql); 
				try{
					$stmt->execute($data);
					
					if($action == "qqInsert"){
						if(!empty($this->fieldPK)){
							$sql = "select max(".$this->fieldPK.") from $table";
							return $this->getValue($sql);	
						}else{
							$stmt->closeCursor();
							$rowCount = $stmt->rowCount();
							return $rowCount;		
						}
						
					}else{
						$stmt->closeCursor();
						$rowCount = $stmt->rowCount();
						return $rowCount;	
					}
				}catch(PDOException $e){
					$error =  $e->getMessage();
					
					throw new Exception($error);
				}

				
			}
	}
	private function getFields($table){
    	/* Obtener Conjunto de Campos de la Tabla */
    	$COL = array();    	
    	switch ($this->conf->driver) {
    		case 'pgsql':
    			/*$sql = "select a.column_name as field,data_type as type, constraint_name as key
						from information_schema.columns a left JOIN information_schema.key_column_usage b on a.COLUMN_NAME = b.column_name
						where a.table_name = '".$table."'";*/
				$sql = "select a.column_name as Field,data_type as Type, constraint_name  as Key
						from information_schema.columns a LEFT JOIN information_schema.key_column_usage b on a.table_name = b.table_name and a.column_name = b.column_name
						where a.table_name = '".$table."'";
    			break;
    		case 'mysql':
    			$sql = "SHOW COLUMNS FROM " . $table;
    		default:
    			# code...
    			break;
    	}
    	
    	$rsCol = parent::query($sql);  
    	 
    	foreach ($rsCol as $i => $row) {
    		$string = $row['Key'];    			
			$var  = strpos($string,"pk");
			$var2 = strpos($string,"PRI");
			if($var !== false || $var2 !== false){
				$COL = array_merge($COL, array("PK" => array($row['Field'],$row['Type'])));	
			}else{
				$var  = strpos($string,"fk");
    			if($var !== false){	    				
    				$COL = array_merge($COL, array("FK" => array($row['Field'],$row['Type'])));
    			}else{
    				$COL = array_merge($COL, array("Field_".$i => array($row['Field'],$row['Type'])));
    			}
			}
    		/*if(isset($row['Key']) || !is_null($row['Key'])){
    			
    			$string = $row['Key'];    			
    			$var  = strpos($string,"pk");
    			$var2 = strpos($string,"PRI");
    			if($var !== false || $var2 !== false){
    				$COL = array_merge($COL, array("PK" => array($row['Field'],$row['Type'])));	
    			}else{
    				$var  = strpos($string,"fk");
	    			if($var !== false){	    				
	    				$COL = array_merge($COL, array("FK" => array($row['Field'],$row['Type'])));
	    			}
    			}
    		}else{

    			$COL = array_merge($COL, array("Field_".$i => array($row['Field'],$row['Type'])));
    		}*/   		
	    }
	    return $COL;

    }
    private function pairsColumnWithData($data,$table){

    	if(!$table) {
            throw new Exception("No se puede verificar los campos por que tabla no esta configurada");
            return false;
        }
        if(!is_array($data)) {
            throw new Exception("La variable data debe ser una matriz asociativa");
            return false;
        }	
        $structTable = $this->getFields($table);

       	$arrayAssocc = array();
        
        /* checar si los campos pasados en el array $data existen en la estructura de la tabla y si existen asociar a esos campos su valor correspondiente */
        foreach ($structTable as $i => $val) {
        	if($i == "PK"){
        		$this->fieldPK = $val[0];
        	}
        	foreach ($data as $j => $value) {
				if($val[0] == $j){
        			$arrayAssocc = array_merge($arrayAssocc, array($i => array($val[0],$val[1],$value)));
				}            		
        	}
        }        
        return ($arrayAssocc);
    }
    /** manejo de transacciones **/
    public function setBeginTrans(){
    	parent::beginTransaction();
    }
    public function setCommit($commit){
    	if($commit){
    		parent::commit();
    	}else{
    		parent::rollBack();
    	}
    }
}

?>