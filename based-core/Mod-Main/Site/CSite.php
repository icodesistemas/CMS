<?php

	class CSite Extends CView{
		private static $msjUser;
		public static $titleOpcRun = '<div class="ico-white ico-dashboard"><span>Control Panel</span></div>';
		public function createUrl($string){
			$spacer = "-";
			$string = trim($string);
			$string = strtolower($string);
			$string = trim(ereg_replace("[^ A-Za-z0-9_]", " ", $string)); 

			$string = ereg_replace("[ \t\n\r]+", "-", $string);
			$string = str_replace(" ", $spacer, $string);
			$string = ereg_replace("[ -]+", "-", $string);
			return $string; 
		}
		public static function setMsjUser($msj){
			self::$msjUser = $msj;
		}
		public function getMsjUser(){

			return self::$msjUser;
		}
		public static function setTitleOpc($css, $title){

			self::$titleOpcRun = '
				<div class="ico-white '.$css.'">
					<span>'.$title.'</span>
				</div>
			';
		}
	}