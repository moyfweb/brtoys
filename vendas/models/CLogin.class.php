<?php
#Login::
class CLogin {

	private static $IDUsuario = null;
	private static $IDTipo = null;
	private static $Nome = null;
	private static $Email = null;
	
	public static function submit($post) {
		$errors = array();
		$model = new Usuario();
		$model->Email = $post['Email'];
		if($model->total() < 1) $errors['Email'] = 'Usuario não encontrado!';
		$model->Senha = md5(strtolower($post['Senha']));
		$model->Status = 1;
		$data = $model->findOne();
		if(!empty($data->IDUsuario)):
			#self::$HoraAcesso = date('Y-m-d H:i:s');
			$login = new stdClass();
			$keys = array('IDUsuario','IDTipo','Nome','Email');
			foreach($keys as $k) $login->{$k} = $data->{$k};
			$_SESSION['LOGIN'] = $login;
			self::getLogin();
		elseif(!isset($errors['Login'])): $errors['Senha'] = 'Senha inválida!';
		endif;
		return $errors;
	}
	
	public static function getLogin() {
		if(isset($_SESSION['LOGIN'])):
			$keys = array('IDUsuario','IDTipo','Nome','Email');
			foreach($keys as $k) self::$$k = $_SESSION['LOGIN']->{$k};
		endif;
	}
	/*
	public static function isNivel($N=0) {
		if(self::nivel() === null) return false;
		else if($N == 0) return true;
		else if(self::nivel() > $N) return false;
		else return true;
	}*/
	
	public static function id() { return self::$IDUsuario; }
	public static function nome() { return self::$Nome; }
	public static function email() { return self::$Email; }
	public static function tipo() { return self::$IDTipo; }

	
}