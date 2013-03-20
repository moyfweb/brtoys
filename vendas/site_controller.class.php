<?php
class site_controller {

	public static function INIT() { 
		#############################################################################
		##### QUANDO FIZER LOGIN - QUANDO FIZER LOGIN - QUANDO FIZER LOGIN ##########
		#############################################################################
		if(!isset($_SESSION['idsession'])) $_SESSION['idsession'] = uniqid();
		#############################################################################
		##### QUANDO FIZER LOGIN - QUANDO FIZER LOGIN - QUANDO FIZER LOGIN ##########
		#############################################################################
		
		# PASTA DOS ARQUIVOS DO MODULO
		H::path('paginas/');
		
		# JS GERAL DO MODULO
		H::js(array(
			'jquery/jquery.js',
			'jquery/jquery.fancybox.js',
			'jquery/jquery.fancybox-buttons.js',
			'H.js',
			'index.js'
			));
		
		# CSS GERAL DO MODULO
		H::css(array(
			'jquery.fancybox.css',
			'jquery.fancybox-buttons.css',
			'index.css'
		));
		
		H::submenu('menu.php');
		if(CLogin::id() !== null) return true;
		else return false;
	}
	
	private static function render() { H::render('paginas/layout/_index.php'); }
	
	#REDIRECIONA PARA UMA ÁREA PERMITIDA PELO USUARIO
	public static function index() { self::produtos();}
	
	public static function produtos() {
		H::config('produtos.php','Produtos');
		self::render();
	}
	
	public static function produto() {
		H::config('produto.php','Produto');
		self::render();
	}
	
	public static function login() {	
		$vars = new stdClass();
		$vars->errors = array();
		$vars->data = new Usuario();
		if(isset($_POST['Login'])):
			$vars->errors = CLogin::submit( $_POST['Login'] );
			$vars->data->Email = $_POST['Login']['Email'];
			if(CLogin::id() > 0): 
				H::redirect('produtos');
				#Log::record(CLogin::cliente(),"O usuário ".CLogin::nome()." se conectou.");
			endif;
		endif;
		H::vars($vars);
		H::config('login.php','Login');
		self::render();
	}
	
	public static function quantidade() { 
		$model = new Produto();
		$model->IDProduto = URL::friend(1);
		$produto = $model->findOne();
		H::vars(array('produto'=>$produto,'action'=>H::link('add').'/'.URL::friend(1).'/'.URL::friend(2).'/'));
		H::render('paginas/carrinho/quantidade.php');
	}
	
	public static function add() { 
		$caixa = URL::friend(2) == 'caixa' ? true : false;
		if(Carrinho::adicionar(URL::friend(1),$_POST['quantidade'],$caixa)) H::redirect('carrinho'); 
		else 'erro';
	}
	
	public static function carrinho() {
		$model = new CarrinhoItem();
		$itens = $model->findAll(); 
		H::vars(array('itens'=>$itens));
		H::render('paginas/carrinho/modal.php');
	}

	public static function selecionar_cliente() {
		$vars = new stdClass();
		$model = new Cliente();
		if(isset($_GET['busca'])):
			$b = '\'%'.mysql_real_escape_string($_GET['busca']).'%\'';
			$model->addWhere("( Nome LIKE $b OR Email LIKE $b )");
		endif;
		$vars->clientes = $model->findAll();
		H::vars($vars);
		
		H::config('carrinho/selecionar-cliente.php','Selecionar Cliente');
		self::render();
	}
	
	public static function carrinho_endereco() { 
		if(isset($_POST['ClienteEndereco'])):
			$model = new ClienteEndereco();
			ClienteEndereco::saveList('ClienteEndereco',URL::friend(1));
			H::redirect('carrinho_endereco',H::cod());
		endif;
		
		if(URL::friend(2) == 'novo'):
			header ('Content-type: text/html; charset=ISO-8859-1');
			H::render(H::path().'carrinho/carrinho_endereco.php');
		else:
			H::config('carrinho/carrinho_endereco.php','Selecionar Cliente');
			self::render();
		endif;
	}
	
	public static function finalzar() { 
		$vars = new stdClass();
		$model = new ClienteEnderecoR();
		$model->IDEndereco = URL::friend(2);
		$vars->endereco = $model->findOne();
		$model = new Cliente();
		$model->IDCliente = URL::friend(1);
		$vars->cliente = $model->findOne();
		$model = new CarrinhoItem();
		$vars->itens = $model->findAll(); 
		H::vars($vars);
		
		H::config('carrinho/finalizar.php','Selecionar Cliente');
		self::render();
		
		
	}
	
	public static function logout() { 
		session_destroy(); H::redirect('login'); 
	}
}


