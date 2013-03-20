<?php
class usuario_controller{
	public static function INIT() { 
		# PASTA DOS ARQUIVOS DO MODULO
		H::path('/paginas/usuario/');
		
		# CSS GERAL DO MODULO
		H::css(array(
			'jquery.fancybox.css',
			'jquery.fancybox-buttons.css',
			'grid.css',
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
		$model = new Usuario();
		if(isset($_GET['Usuario'])) $model->request('Usuario');
		$model->setPagination();
		$vars->usuarios = $model->findAll();
		$vars->model = $model;
		H::vars($vars);
		H::config('listing.php','');
		self::render();
	}
	
	
	public static function create() { self::form('Novo Usuario');}
	public static function edit() {	self::form('Editar Usuario',H::cod());}
	private static function form($titulo,$id = null) {	
		$vars = new stdClass();
		$errors = array();
		$model = new Usuario();
		if(isset($_POST['Usuario'])):
			$model->request('Usuario');
			if($id != null) $model->IDUsuario = $id;
			
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
					if(isset($_POST['UsuarioContato'])) 
						UsuarioContato::saveList('UsuarioContato',$data->IDUsuario);
						
					SQLB::commit();
					
					# SEM ERROS E SALVO COM SUCESSO
					H::redirect('usuario','view',$data->IDUsuario);
				endif;
				
			else:
				
			endif;
		else:
			if($id):
				$model->IDUsuario = $id;
				$model = $model->findOne();
			endif;
		endif;
		foreach(array('model','errors') as $v) $vars->{$v} = $$v;
		$vars->tit = H::cod() == null ? $titulo : $titulo." : '".$model->Nome."'";
		H::config('form.php',$vars->tit);
		H::css(array( 'endereco.form.css'));
		H::js(array('usuario.js'));
		H::vars($vars);
		self::render();
	}
	
	public static function view() {
		$vars = new stdClass();
		$model = new Usuario();
		$model->IDUsuario = H::cod();
		$vars->data = $model->findOne();
		H::config('view.php','Usuário: '.$vars->data->Nome);
		H::vars($vars);
		self::render();
	}
	
	public static function delete() {
		$model = new Usuario();
		$model->IDUsuario = H::cod();
		if(!$model->remove()) die('Não foi possivel excluir');
		H::redirect('usuario','index');
	}
	
	public static function form_contato(){  H::render('paginas/usuario/form_contato.php'); }
	
	public static function rm_contato(){ 
		$model = new UsuarioContato();
		$model->ID = URL::friend(3);
		if(!$model->remove()) die('Não foi possivel excluir');
		H::redirect('usuario','edit',URL::friend(2));
	}
}