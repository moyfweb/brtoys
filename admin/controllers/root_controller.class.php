<?php
class root_controller{

	#REDIRECIONA PARA UMA �REA PERMITIDA PELO USUARIO
	public static function index() {
		H::redirect('login','index');
	}
}