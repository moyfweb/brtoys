<?php
/**
* Helper class
* 
* @author Moysés Filipe Lopes Peixoto de Oliveira <moyfweb@gmail.com>
* @version 1.0
* @access public
* @modification 2012-04-24
*/

class H
{
	/**
	* Pasta raiz onde se encontra o farmework
	*
	* @var integer
	* @access public
	* @see URL::root();
	* @see H::root();
	*/
	private static $root = '';
	
	
	/**
	* Pasta raiz onde se encontra o farmework
	*
	* @var integer
	* @access public
	* @see URL::site();
	* @see H::site();
	*/
	private static $site = '';
	
	private static $pasta_arquivos = '';
	private static $sql = null;
	private static $IDCliente = '';
	private static $furls = null;
	
	private static $submenu = null;
	private static $modulo = null;
	private static $tituloModulo = null;
	private static $acao = null;
	private static $cod = null;
	
	## VIEWS CONFIG
	private static $path = null;
	private static $file = null;
	
	## VIEWS CONFIG
	private static $title= null;
	private static $contato = null;
	private static $erro = 'Arquivo não encontrado.';
	private static $css = array();
	private static $js = array();
	private static $conexao_config = null;
	private static $vars = array();
	private static $sessao = 'padrao';
		
	public static function redirect($l1,$l2=null,$l3=null,$l4=null,$l5=null,$l6=null) {
		header('Location: '.self::link($l1,$l2,$l3,$l4,$l5,$l6));die; 
	}
	
	public static function getSQL() { return self::$sql; }
	
	public static function root($root = false) { 
		if($root !== false) self::$root = strtolower($root);
		return strtolower(self::$root); 
	}
		
	public static function site($site = false) { 
		if($site !== false) self::$site = strtolower($site);
		return strtolower(self::$site); 
	}
	
	public static function submenu($submenu = false) { 
		if($submenu !== false) self::$submenu = $submenu;
		return self::$submenu; 
	}
	
	public static function modulo($modulo = false) { 
		if($modulo !== false) self::$modulo = strtolower($modulo);
		return strtolower(self::$modulo); 
	}
	
	public static function acao($acao = false) { 
		if($acao !== false) self::$acao = strtolower($acao);
		return strtolower(self::$acao); 
	}
	
	public static function cod($cod = false) { 
		if($cod !== false) self::$cod = $cod;
		return self::$cod; 
	}
	
	# Pasta das VIEWS 
	public static function path($path = false) { 
		if($path !== false) self::$path = $path;
		return self::$path;
	}
	
	# Arquivo da View
	public static function file($file = false) { 
		if($file !== false) self::$file = $file;
		return self::$file;
	}
	
	# Título da Página
	public static function title($page=false,$site=false,$separator=false)	{ 
		if(!is_object(self::$title)) self::$title = (object)array('page'=>'','site'=>'','separator'=>'');
		if($page !== false) self::$title->page = $page;
		if($site !== false) self::$title->site = $site;
		if($separator !== false) self::$title->separator = $separator;
		list($b,$s,$a) = array(self::$title->page,self::$title->separator,self::$title->site);
		if(!empty($b)) return "$b $s $a";
		else return "$a";
	}
	
	# Get Título da Página
	public static function getTitle() { return self::$title->page; }
	
	
	# Erro de Página
	public static function erro($erro = false) { 
		if($erro !== false) self::$erro = $erro;
		return self::$erro;
	}
	
	# CSS
	public static function css($css = false,$clean = false) { 
		if($css !== false):
			if(is_array($css) && !$clean) self::$css = array_merge(self::$css,$css);
			else if(is_array($css) && $clean) self::$css = $css;
			else if(is_string($css)) self::$css[] = $css;
		endif;
		
		return self::$css;
	}
	
	# JS
	public static function js($js = false,$clean = false) { 
		if($js !== false):
			if(is_array($js) && !$clean) self::$js = array_merge(self::$js,$js);
			else if(is_array($js) && $clean) self::$js = $js;
			else if(is_string($js)) self::$js[] = $js;
		endif;
		
		return self::$js;
	}
	
	# VARS
	public static function vars($vars = false,$clean = false) { 
		if($vars !== false):
			if(is_object($vars) && !$clean): self::$vars = array_merge(self::$vars,(array)$vars);
			elseif(is_object($vars) && $clean): self::$vars = (array)$vars;
			elseif(is_array($vars) && !$clean): self::$vars = array_merge(self::$vars,$vars);
			elseif(is_array($vars) && $clean): self::$vars = $vars;
			endif;
		endif;
		
		return self::$vars;
	}
	
	# Sessao de Página
	public static function sessao($sessao = false) {
		if($sessao !== false) sessao::$sessao = $sessao;
		return self::$sessao;
	}
	
	public static function config($file, $pageTitle=null) { 
		self::$file = $file;
		self::$title->page = !empty($pageTitle) ? $pageTitle : '';
	}
	
	public static function defaultConnection($sql=null)	{ if(!empty($sql)) self::$sql = $sql; return self::$sql; }
	
	public static function connect($_db=null,$_host=null,$_user=null,$_key=null)	{
		$db = $_db != null ? $_db : self::$sql->DB;
		$host = $_host != null ? $_host : self::$sql->host;
		$user =  $_user != null ? $_user : self::$sql->user;
		$key = $_key != null ? $_key : self::$sql->key;
		self::$conexao_config = mysql_connect($host, $user, $key);
		mysql_select_db($db, self::$conexao_config);
	}
	
	public static function limit($texto, $num) { return CTrataString::limit($texto, $num);	}
	
	
	public static function link($l1,$l2=null,$l3=null,$l4=null,$l5=null,$l6=null) { return URL::link($l1,$l2,$l3,$l4,$l5,$l6); }
	
	public static function write($file) { include($file); }
	
	public static function render($file) {
		$_data_ = self::vars();
		if(is_array($_data_)) extract($_data_,EXTR_PREFIX_SAME,'data');
		else $data=$_data_;
		require($file);
	}
}