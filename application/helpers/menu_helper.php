<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('activate_menu')) {
  		function activate_menu($controller) {
    		// Getting CI class instance.
    		$CI = get_instance();
    		// Getting router class to active.
    		$class = $CI->router->fetch_class();
			$method = $CI->router->fetch_method();
			$active=$class;
			if($method!="index"){ $active.="/$method"; }
			//echo $active;
			return ($active == $controller) ? 'active' : '';
		}  
	}
	if(!function_exists('activate_dropdown')) {
		function activate_dropdown($controller){
			// Getting CI class instance.
    		$CI = get_instance();
    		// Getting router class to active.
    		$class = $CI->router->fetch_class();
			return ($class == $controller) ? 'active' : '';
		}
	}
?>