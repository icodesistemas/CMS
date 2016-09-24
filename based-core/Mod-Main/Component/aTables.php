<?php
/**
*   14/11/2013
* Autor: Angel Bejarano
*   Version 1.0 Mejora en crear el SQL automaticamente con campos que tienen alias
*   14/11/2013 mantener los filtros cuando se pasa de pagina
*/
	class aTables{
		private static $table =  '<table class="Grid" cellpadding = "5">';
        private static $filter;

        private static $rowPage;
        private static $page = 1;
        private static $totalReg;
        private static $totalPage;
        private static $desde;
        private static $url;

        private static $sql = "";
        private static $fieldDB;

        private static $jquery;
        
        
        public static function paginacion($_table="",$RowPage = 10){
            self::$rowPage = $RowPage;
            if(is_array($_table)){
                if(isset($_REQUEST["page"])){
                    self::$page = $_REQUEST["page"];
                }
                if(isset($_table["request"])){
                    self::$url = $_table["request"];

                   // echo self::$url;
                }
                foreach ($_table as $key => $value) {
                    if($key == "filter"){
                        self::crearFilter($_table[$key]);
                    }
                    if($key == "header"){
                        self::createHedar($_table[$key]);
                    }
                    
                    if($key == "DB"){
                        self::createSQL($_table[$key]);
                    }
                    
                }
                self::createBody();
                self::createFooter();
                echo self::$table;
            }else{
                echo "PARAMETROS INCORRECTOS";
            }
            
        }
        private static function crearFilter($filter){

            if(isset($_REQUEST["filter"]) && ! empty($filter)){
                $where = " ".$filter." like '%".$_REQUEST["filter"]."%' ";
                if(!empty($where)){
                    self::$filter = " where ".$where;    
                }
            }

        }
        private static function createFooter(){
            $desd = self::$desde;
            if($desd == 0){
                $desd = 1;
            }
            $hasta = $desd + self::$rowPage;

            if($hasta > self::$totalReg){
                $hasta = self::$totalReg;
                 if($hasta == 0){
                    $hasta = 1;
                }
            }
            if(self::$totalPage==0){
                self::$totalPage = 1;
            }
            if((self::$page + 1) <= self::$totalPage){
                $sig = self::$page + 1; 
            }else{
                $sig = self::$page;
            }
            if((self::$page - 1)>0){
                $ant = self::$page -1;
            }else{
                $ant = self::$page;
            }
            if(self::$totalReg==0){
                $desd = 0;
                $hasta = 0;
            }
            self::$table .= '
                <section class="Grid-footer">
                    <section style="float:right;width:25%;text-align:right;font-weight: bold;">
                        Mostrando '.$desd.'-'.$hasta.' de '.self::$totalReg.'
                    </section>
                   
                    <section class="float:left;width:70%">

                        ';

                        if(self::$page < 5){
                            $min = 1;
                            $max = self::$rowPage;
                            

                        }else{
                            
                            $min = self::$page;
                            $max = self::$page + $min;
                        } 
                       // echo $max;
                        if($max > self::$totalPage){

                            $max = self::$totalPage;
                        }
                        
                        if(strpos(self::$url, "?")){
                            $simbolo = self::$url."&";    
                        }else{
                            $simbolo = self::$url."?";    
                        }
                        self::$table .='<a class="button btn-footer" href="'.$simbolo.'page='.($ant).'">&laquo; Ant</a>';
                        $control = 0;
                        $init = 0;
                        

                        for($i = $min-5; $i <= $max; $i++){
                            if($i>0){
                                if($control == 0){
                                    $init  = $i;
                                }
                                if($control>10){
                                    break;
                                }
                                if($i == self::$page){
                                    
                                    self::$table .= '<a class="button btn-footer button-active" href="'.$simbolo.'page='.($i).'">'.$i.'</a>';
                                }else{
                                    self::$table .= '<a class="button btn-footer" href="'.$simbolo.'page='.($i).'">'.$i.'</a>';    
                                }
                                $control++;
                            }
                            
                        }
                        $xx = '
                            <a class="button btn-footer" href="'.$simbolo.'page='.(self::$totalPage).'">'.self::$totalPage.'</a>
                        ';   
                        
                        self::$table .='    <a class="button btn-footer" href="#">...</a>
                        '.$xx.'
                            <a class="button btn-footer" href="'.$simbolo.'page='.($sig).'">Sig »</a>

                        '; 

           self::$table .='</section>
                   <div class="clear"></div>
            </section>
            ';
        }
        private static function createBody(){
            self::$table .= "<tbody>";
            $rs = Apollo::$DB->getArray(self::$sql);
             $i = 0;
            $j = 0;
            foreach ($rs as $key => $value) {
                if($i % 2 == 0){
                    $class = '';
                    
                }else{
                    $class = 'class= "alt"';
                }
                self::$table .= "
                                <tr ".$class." id=".$rs[$i][trim(self::$fieldDB[0])].">
                                <td><input type='checkbox' value='".$rs[$i][trim(self::$fieldDB[0])]."' name='select-all[]' class = 'iTem' ></td>
                                ";
                $j = 0;                    
                foreach (self::$fieldDB as $k => $v) {
                    if($j == 0){
                        $display = "style='display:none'";
                    }else{
                        $display = "";
                    }

                    self::$table .="<td ".$display.">".$rs[$i][trim($v)]."</td>";                    
                    $j++;
                }    
                
                                    
                $i++;                
            }
            self::$table .= "</tbody></table>";
        }
        private static function createSQL($aSQL){
            $sql = "";
            $fieldSQL = ""; 
            $i = 0;
            /* extraer campos del arraySQL */

            $aField = explode(",",$aSQL["select"]);      
            

            // determinar los alias
            foreach ($aField as $key => $value) {
                
                $x = explode(" as ", $value);
                if(count($x) == 1){
                    $x = $x[0];
                }else{
                    $x = $x[1];
                }
                if(count($aField)-1 > $i){

                    $fieldSQL .= $x.",";
                }else{
                    $fieldSQL .= $x;
                }
                $i++;
            }
            self::$fieldDB = explode(",",$fieldSQL);
            /* ********************************** */

            /* creamos el sql  */
            foreach ($aSQL as $key => $value) {
            
                if($key == "from"){
                    $sql .= " ".$key."  ".$value;        
                    $sql .= " ".self::$filter;
                }else if($key == "where"){
                    if(!empty(self::$filter)){
                        $sql .= " and ".$value;        
                    }else{
                        $sql .= " ".$key."  ".$value;        
                    }
                    
                }else{
                    $sql .= " ".$key."  ".$value;        
                }            
            }

            self::$totalReg = count(Apollo::$DB->getArray($sql));
            self::$totalPage = ceil(self::$totalReg  / self::$rowPage);            
            self::$desde = (self::$page - 1) * self::$rowPage; 
            $limit = "LIMIT ".self::$rowPage." offset ".self::$desde."";
            self::$sql = $sql." ".$limit;
            
            
        }
        private static function createHedar($header){
            self::$table .= '<thead>
                                <tr>
                                    <th style="width:5px"><input type="checkbox" value ="0" id= "select-all" ></th>';
            $j = 0;
            foreach ($header as $key => $value) {        
                if($j == 0){
                    $display = "style='display:none'";
                }else{
                    $display = "";
                }                    
                self::$table .='                    
                        <th '. $display.'>'.$value.'</th>                 
                ';
                $j++;
            }
            self::$table .= '</tr></thead>';
        }
    }