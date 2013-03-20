<?php 
date_default_timezone_set("America/Sao_Paulo"); ## TIMEZONE
include('autoload.php');	## CARREGA CLASSES AUTOMATICAMENTE
include('site_controller.class.php');	## CARREGA CLASSES AUTOMATICAMENTE
$GLOBALS['AUTOLOAD'] = array(
	'utils',
	'models'
	);
session_name('br_toys');
session_start();
H::defaultConnection((object)array('DB'=>'brtoys', 'host'=>'localhost','user'=>'root','key'=>''));
define('FILE_URL','http://localhost/brtoys/admin/');

H::root(URL::root());
H::site(URL::site());

list($acao,$cod) = array(URL::friend(0),URL::friend(1));



if(!empty($acao)) H::acao(str_replace('-','_',$acao)); 
else H::redirect('index');

if(!empty($cod)) H::cod($cod); 

unset($modulo,$acao,$cod);

H::title('','BR Toys','-');
H::css(array('index.css')); # adiciona CSS
H::js(array('jquery/jquery.js','H.js')); 	# adiciona JS
CLogin::getLogin();

if(method_exists("site_controller",H::acao())):	
	# CHAMA O METODO INIT SE EXISTIR
	$try = method_exists("site_controller",'INIT') ? call_user_func('site_controller::INIT') : true;
	if($try): call_user_func("site_controller::".H::acao());
	else: site_controller::login(); 
	endif;
	unset($try);
else: 	
	#header("HTTP/1.0 404 Not Found");
	#header("Status: 404 Not Found");
	#header("Location: ".H::root().'404.html.php');
endif;
