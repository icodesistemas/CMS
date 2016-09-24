<?php
	session_start();
    ini_set("display_errors", 0);
	require_once $_SERVER["DOCUMENT_ROOT"]."/based-core/Library/conexPdo.php";
	$db = new Conexion(true);
	
	switch ($_REQUEST["action"]) {
		case 'galeria':
			include_once "files.php";
			navegacionArchivos();
			break;
		case 'cbcategorias':
			getComboCategory();
			break;
		default:
			# code...
			break;
	}
	$rsParent = "";
	$rsChild = "";
	function getComboCategory(){
		global $db,$rsParent,$rsChild;
        if(isset($_REQUEST["indx-category"])){
            $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_section = ".$_REQUEST["section"]." and cod_category_parent = 0 and category_cod != ".$_REQUEST["indx-category"]." ";    
        }else{
            $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent = 0 and cod_section = ".$_REQUEST["section"]."";
        }                
        $rsParent = $db->getArray($sql);
        if(isset($_REQUEST["indx-category"])){
            $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent != 0 and category_cod != ".$_REQUEST["indx-category"]." and cod_section = ".$_REQUEST["section"]." ";    
        }else{
            $sql = "select category_cod,cod_category_parent,category_name from tb_category where cod_category_parent != 0 and cod_section = ".$_REQUEST["section"]."";
        }
        
        $rsChild = $db->getArray($sql);
        $cb = '<option value = "">-- SELECCIONE UNA CATEGORIA --</option>';
        foreach ($rsParent as $value) {
            $child = ComboSubCategory($value["category_cod"],"-");
            
            $cb .= '<option value="'.$value["category_cod"].'">'.$value["category_name"].'</option>'.$child.'';
        }
        echo $cb;
    }
    function ComboSubCategory($idParent,$sep = ""){
    	global $rsChild;
        $rs = $rsChild;
        
        $separado = $sep.'--';
        $comb = ''; 
        foreach ($rs as $value) {
            if($value["cod_category_parent"] == $idParent){
                $child = ComboSubCategory($value["category_cod"],$separado);
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

?>