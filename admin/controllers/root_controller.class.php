<?php
class root_controller{

	#REDIRECIONA PARA UMA ÁREA PERMITIDA PELO USUARIO
	public static function index() {
		H::redirect('login','index');
	}
}