<?php
class login_controller{

	public static function INIT() { 
		# PASTA DOS ARQUIVOS DO MODULO
		H::path('paginas/login/');
		
		# CSS GERAL DO MODULO
		H::css(array('login.css'));
		
		# JS GERAL DO MODULO
		H::js(array());
		H::submenu('menu.php');
				
		return true;
	}
	
	private static function render() { H::render('paginas/layout/index.php'); }
	
	public static function index($msg=false) {
		$vars = new stdClass();
		$vars->errors = array();
		$vars->msg = $msg ? "Acesso negado, você precisa estar Logado para acessar este setor!" : '';
		$vars->data = new Usuario();
		if(isset($_POST['Login'])):
			$vars->errors = CLogin::submit( $_POST['Login'] );
			$vars->data->Email = $_POST['Login']['Email'];
			if(CLogin::id() > 0): 
				H::redirect('usuario','index');
				#Log::record(CLogin::cliente(),"O usuário ".CLogin::nome()." se conectou.");
			endif;
		endif;
		H::vars($vars);
		H::config('index.php','Login');
		self::render();
	}
	
	public static function denied($msg=false) { H::config('denied.php','Acesso Negado'); self::render(); }
	public static function logout() { 
		#Log::record(CLogin::cliente(),"O usuário ".CLogin::nome()." se desconectou.");
		session_destroy(); H::redirect('login','index'); 
	}
	
}