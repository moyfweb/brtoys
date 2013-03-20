<?php 
date_default_timezone_set("America/Sao_Paulo"); ## TIMEZONE
include('autoload.php');	## CARREGA CLASSES AUTOMATICAMENTE
$GLOBALS['AUTOLOAD'] = array(
	'utils',
	'models',
	'controllers'
	);
session_name('admin_br_toys');
session_start();
H::defaultConnection((object)array('DB'=>'brtoys', 'host'=>'localhost','user'=>'root','key'=>''));

H::root(URL::root());
H::site(URL::site());

list($modulo,$acao,$cod) = array(URL::friend(0),URL::friend(1),URL::friend(2));

if(!empty($modulo)) H::modulo($modulo); 
else root_controller::index();

if(!empty($acao)) H::acao($acao); 
else H::redirect($modulo,'index');

if(!empty($cod)) H::cod($cod); 

unset($modulo,$acao,$cod);

H::title('','E-Commerce','-');
H::css(array('index.css')); # adiciona CSS
H::js(array('jquery/jquery.js','H.js')); 	# adiciona JS
CLogin::getLogin();

if(method_exists(H::modulo()."_controller",H::acao())):	
	
	$unlock = array('login','logout','sites','site_selected');
	#if(CLogin::IDSite() < 1 && CLogin::id() > 0)
	#	if(H::modulo() !== 'login' && !in_array(H::acao(),$unlock))
	#		H::redirect('login','sites');
	
	unset($unlock);
	# CHAMA O METODO INIT SE EXISTIR
	$try = method_exists(H::modulo().'_controller','INIT') ? call_user_func(H::modulo().'_controller::INIT') : true;
	
	if($try): 
		call_user_func(H::modulo()."_controller::".H::acao());
	elseif(CLogin::id() > 0):
		login_controller::INIT();
		login_controller::denied();
	else: 
		login_controller::INIT();
		login_controller::index(true); 
	endif;
	unset($try);
else: 	
	#header("HTTP/1.0 404 Not Found");
	#header("Status: 404 Not Found");
	#header("Location: ".H::root().'404.html.php');
endif;
