<?php
	class Funciones{
		private static $semilla = "Vm0weGQxSXlSblJWV0d4WFlUSlNWVll3WkZOVU1WcHpXa2M1VjAxWGVEQmFWVll3Vm14YWMySkVUbGhoTVVwVVdWZHplRll5VGtkWGJGcFhUVEZHTTFkV1dsWmxSbVJJVm10V1VtSkdXbkJWYlRWRFpWWmtWMVp0UmxoaVZscElWMnRvUjFVeVNraFZhemxYWWxoU1lWcFhlR0ZXYkdSeVYyeENWMkV3Y0ZSV1ZWcFNaREZDVWxCVU1EMD0=";
		private static $rsChild;
        public static function encryption($data){
			 $a = base64_encode(self::$semilla . base64_encode(str_rot13(serialize($data))));
			 return $a;
		}
		public static function createUrl($url){
            return self::strtourl(strtolower($url));

        }
        private static function strtourl($str){
            $str = trim(strip_tags($str));
            $str = str_replace("-","_",$str);
            $str = str_replace(" ","-",$str);
            $str = str_replace("/","",$str);
            $str = str_replace("&","",$str);
            $str = str_replace("¬","",$str);            
            $str = str_replace("$","",$str);            
            $str = str_replace("#","",$str);            
            $str = str_replace("¡","",$str);            
            $str = str_replace("<","",$str);            
            $str = str_replace(">","",$str);            
            $str = str_replace("=","",$str);            
            $str = str_replace("*","",$str);            
            $str = str_replace("%","",$str);            
            $str = str_replace('"',"",$str);            
            $str = str_replace("'","",$str);            
            $str = str_replace("+","",$str);    
            $str = str_replace(".","",$str);                    
            $str = str_replace(",","",$str);            
            $str = str_replace(";","",$str);            
            $str = str_replace(":","",$str);            
            $str = str_replace("ç","",$str);
            $str = str_replace("ñ","n",$str);
            $str = str_replace("á","a",$str);
            $str = str_replace("é","e",$str);
            $str = str_replace("í","i",$str);
            $str = str_replace("ó","o",$str);
            $str = str_replace("ú","u",$str);
            $str = str_replace("[","",$str);
            $str = str_replace("[","",$str);
            $str = str_replace("{","",$str);
            $str = str_replace("}","",$str);
            $str = str_replace("!","",$str);
            $str = str_replace("?","",$str);
            $str = str_replace("¿","",$str);
            $str = str_replace("|","",$str);            
            $str = str_replace("\\","",$str);
            $str = str_replace("--","-",$str);
            return $str;
        }
		public function encryption_session($data){
			$a = base64_encode($this->semilla . base64_encode(sha1(str_rot13(serialize($data)))));
			 return $a;	
		}
		public function createSID($data){
			$ip = $this->getRealIpAddr();

			return sha1($ip. md5(chr(rand(ord('a'), ord('Z')))).md5((rand(1,15))).base64_encode(self::$semilla . base64_encode(sha1(str_rot13(serialize($data))))));
		}
		public function getRealIpAddr(){			
            if (!empty($_SERVER['HTTP_CLIENT_IP'])){
              $ip=$_SERVER['HTTP_CLIENT_IP'];
            }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
              $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }else{
              $ip=$_SERVER['REMOTE_ADDR'];
            }
            return $ip;
		}
        public static function getComboModule($type = "S"){
            $sql = "select * from tb_menu where cod_menu_parent = 0 and type_menu = '".$type."' ";
            
            $rsParent = Apollo::$DB->getArray($sql);

            $sql = "select * from tb_menu where cod_menu_parent != 0 and type_menu = '".$type."'";
            self::$rsChild = Apollo::$DB->getArray($sql);
            $cb = '';
            foreach ($rsParent as $value) {
                $child = self::ComboSubModule($value["cod_menu"],"-");
                
                $cb .= '<option value="'.$value["cod_menu"].'">'.$value["name_menu"].'</option>'.$child.'';
            }
            return $cb;
        }
        private static function ComboSubModule($idParent,$sep = ""){
            $rs = self::$rsChild;
            
            $separado = $sep.'--';
            $comb = ''; 
            foreach ($rs as $value) {
                if($value["cod_menu_parent"] == $idParent){
                    $child = self::ComboSubModule($value["cod_menu"],$separado);
                    if(!empty($child)){
                        $style = "style = 'font-family:FontBold !important;'";
                    }else{
                        $style = '';
                    }
                    $comb .= '<option '.$style.' value="'.$value["cod_menu"].'">'.$separado .$value["name_menu"].'</option>'.$child.'';

                }
                
            }
            return $comb;
        }
        public function getComboSection(){
            if(isset($_REQUEST["indx-category"])){
                $sql = "select cod_section,cod_section_parent,name_section_".$_SESSION["idioma"]." 
                        from tb_section where cod_section_parent = 0 and cod_section != ".$_REQUEST["section-indx"]." and cod_language = '".$_SESSION["idioma"]."' ";    
            }else{
                $sql = "select cod_section,cod_section_parent,name_section_".$_SESSION["idioma"]." 
                        from tb_section where cod_section_parent = 0 and cod_language = '".$_SESSION["idioma"]."' ";
            }  
                    
            $rsParent = Apollo::$DB->getArray($sql);
            if(isset($_REQUEST["indx-category"])){
                $sql = "select cod_section,cod_section_parent,name_section_".$_SESSION["idioma"]." 
                        from tb_section where cod_section_parent != 0 and cod_section != ".$_REQUEST["section-indx"]." and cod_language = '".$_SESSION["idioma"]."' ";    
            }else{
                $sql = "select cod_section,cod_section_parent,name_section_".$_SESSION["idioma"]." 
                        from tb_section where cod_section_parent != 0 and cod_language = '".$_SESSION["idioma"]."'";
            }
            
            self::$rsChild = Apollo::$DB->getArray($sql);
            $cb = '';
            foreach ($rsParent as $value) {
                $child = self::ComboSubSection($value["cod_section"],"-");
                
                $cb .= '<option value="'.$value["cod_section"].'">'.$value["name_section_".$_SESSION["idioma"]].'</option>'.$child.'';
            }
            return $cb;
        }
        private static function ComboSubSection($idParent,$sep = ""){
            $rs = self::$rsChild;
            
            $separado = $sep.'--';
            $comb = ''; 
            foreach ($rs as $value) {
                if($value["cod_section_parent"] == $idParent){
                    $child = self::ComboSubModule($value["cod_section"],$separado);
                    if(!empty($child)){
                        $style = "style = 'font-family:FontBold !important;'";
                    }else{
                        $style = '';
                    }
                    $comb .= '<option '.$style.' value="'.$value["cod_section"].'">'.$separado .$value["name_section_".$_SESSION["idioma"]].'</option>'.$child.'';

                }
                
            }
            return $comb;
        }
        public function getComboCategory(){
            if(isset($_REQUEST["indx-category"])){
                $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent = 0 and category_cod != ".$_REQUEST["indx-category"]." ";    
            }else{
                $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent = 0 ";
            }                
            $rsParent = Apollo::$DB->getArray($sql);
            if(isset($_REQUEST["indx-category"])){
                $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent != 0 and category_cod != ".$_REQUEST["indx-category"]." ";    
            }else{
                $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent != 0";
            }
            
            self::$rsChild = Apollo::$DB->getArray($sql);
            $cb = '';
            foreach ($rsParent as $value) {
                $child = self::ComboSubCategory($value["category_cod"],"-");
                
                $cb .= '<option value="'.$value["category_cod"].'">'.$value["category_name"].'</option>'.$child.'';
            }
            return $cb;
        }
        private static function ComboSubCategory($idParent,$sep = ""){
            $rs = self::$rsChild;
            
            $separado = $sep.'--';
            $comb = ''; 
            foreach ($rs as $value) {
                if($value["cod_category_parent"] == $idParent){
                    $child = self::ComboSubModule($value["category_cod"],$separado);
                    if(!empty($child)){
                        $style = "style = 'font-family:FontBold !important;'";
                    }else{
                        $style = '';
                    }
                    $comb .= '<option '.$style.' value="'.$value["category_cod"].'">'.$separado .$value["category_name"].'</option>'.$child.'';

                }
                
            }
            return $comb;
        }
		public static function getCombo($tabla,$campos,$condicion = ""){
			if(empty($condicion)){
                $sql = "select $campos from $tabla";
            }else{
                $sql = "select $campos from $tabla where $condicion";
            }
           
            $arrayCampo = explode(",",$campos);
            $campos1 = explode(" ",$arrayCampo[0]);
            $campos2 = explode(" ",$arrayCampo[1]);

            if(count($campos1) > 1){
                $campos1 = $campos1[count($campos1)-1];
            }else{
                 $campos1 = $campos1[0];
            }
          //  echo $campos1;
            if(count($campos2) > 1){
                $campos2 = $campos2[count($campos2)-1];
            }else{
                 $campos2 = $campos2[0];
            }
           
            $cb="";
            $rs = Apollo::$DB->getArray($sql);
            $i = 0;
            if(count($rs)<1){
            	return "<option>No hay Datos</optin>";
            	
            }else{
            	while($i < count($rs)){
	                $cb = $cb.'<option value='.$rs[$i][$campos1].'>'.$rs[$i][$campos2].'</option>';
	                $i++;
	            }
	            return $cb;
            }
		}
	}