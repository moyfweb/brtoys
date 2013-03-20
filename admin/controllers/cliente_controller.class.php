<?php
class cliente_controller{
	public static function INIT() { 
		# PASTA DOS ARQUIVOS DO MODULO
		H::path('/paginas/cliente/');
		
		# CSS GERAL DO MODULO
		H::css(array(
			'jquery.fancybox.css',
			'jquery.fancybox-buttons.css',
			'grid.css',
			'endereco.css',
			'contato.css'));
		
		# JS GERAL DO MODULO
		H::js(array(
			'jquery/jquery.fancybox.js',
			'jquery/jquery.fancybox.pack.js',
			'jquery/jquery.fancybox-buttons.js',
			'GridView.js',
			'index.js'));
		
		# SUBMENU GERAL DO MODULO
		H::submenu('menu.php');
		
		H::vars(array('menu_options'=>'menu.php'));
		return true;
	}

	
	public static function render() { H::render('paginas/layout/index.php'); }
	
	
	public static function index() { self::listing(); }
	
	public static function listing() {
		$vars = new stdClass();
		$model = new Cliente();
		if(isset($_GET['Cliente'])) $model->request('Cliente');
		
		$model->setPagination();
		$vars->clientes = $model->findAll();
		$vars->model = $model;
		H::vars($vars);
		H::config('listing.php','');
		self::render();
	}
	
	public static function create() { self::form('Novo Cliente');}
	public static function edit() {	self::form('Editar Cliente',H::cod());}
	private static function form($titulo,$id = null) {	
		$vars = new stdClass();
		$errors = array();
		$model = new Cliente();
		if(isset($_POST['Cliente'])):
			$model->request('Cliente');
			if($id != null) $model->IDCliente = $id;
			
			$errors = Validate::model($model)->errors;
			if(empty($model->Senha) && $id == null) $errors['Senha'] = 'O campo Senha e obrigatorio.';
			
			if(!empty($model->Senha)):
				if(strlen($model->Senha) < 6) $errors['Senha'] = 'O campo Senha deve conter mais que 6 caracteres.';
				else $model->Senha = md5($model->Senha);
			else: $model->Senha = null;	endif;
			
			if(count($errors) < 1):
				SQLB::begin();
				if(!($data = $model->save())): die('Erro ao salvar');
				else:
					if(isset($_POST['ClienteContato'])) 
						ClienteContato::saveList('ClienteContato',$data->IDCliente);
					if(isset($_POST['ClienteEndereco'])) 
						ClienteEndereco::saveList('ClienteEndereco',$data->IDCliente);
					
					SQLB::commit();
					
					# SEM ERROS E SALVO COM SUCESSO
					H::redirect('cliente','view',$data->IDCliente);
				endif;
			endif;
		else:
			if($id):
				$model->IDCliente = $id;
				$model = $model->findOne();
			endif;
		endif;
		foreach(array('model','errors') as $v) $vars->{$v} = $$v;
		$vars->tit = H::cod() == null ? $titulo : $titulo." : '".$model->Nome."'";
		H::config('form.php',$vars->tit);
		H::js(array('cliente.js'));
		H::vars($vars);
		self::render();
	}
	
	public static function view() {
		$vars = new stdClass();
		$model = new Cliente();
		$model->IDCliente = H::cod();
		$vars->data = $model->findOne();
		H::config('view.php','Usuário: '.$vars->data->Nome);
		H::vars($vars);
		self::render();
	}
	
	public static function delete() {
		$model = new Cliente();
		$model->IDCliente = H::cod();
		if(!$model->remove()) die('Não foi possivel excluir');
		H::redirect('cliente','index');
	}
	
	public static function form_contato(){  H::render('paginas/cliente/form_contato.php'); }
	public static function form_endereco(){  H::render('paginas/cliente/form_endereco.php'); }
	
	public static function rm_contato(){ 
		$model = new ClienteContato();
		$model->ID = URL::friend(3);
		if(!$model->remove()) die('Não foi possivel excluir');
		H::redirect('cliente','edit',URL::friend(2));
	}
	
	public static function rm_endereco(){ 
		$model = new ClienteEndereco();
		$model->ID = URL::friend(3);
		if(!$model->remove()) die('Não foi possivel excluir');
		H::redirect('cliente','edit',URL::friend(2));
	}
}