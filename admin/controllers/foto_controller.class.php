<?php
class foto_controller
{
	public static function INIT() { return true; 	}
	
	public static function index() { H::render('paginas/upload/form.php'); 	}
	
}