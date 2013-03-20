<?php
class produto_controller{

	public static function INIT() { 
		#if(USR::type() != 2) H::redirect('central','site','index');
		H::path('/paginas/produto/');
		
		H::css(array(
			'index.css',
			'jquery.fancybox.css',
			'jquery.fancybox-buttons.css',
			'grid.css',
			'produto.css',
			'webcam.css',
			'smoothness/jquery-ui.css'));
		H::js(array(
			'jquery/jquery.fancybox.js',
			'jquery/jquery.fancybox.pack.js',
			'jquery/jquery.fancybox-buttons.js',
			'jquery/jquery.form.js',
			'jquery/jquery.validate.js',
			'jquery/jquery.metadata.js',
			'jquery/jquery.ui.core.js',
			'jquery/jquery.ui.widget.js',
			'jquery/jquery.ui.datepicker.js',
			'jquery/jquery.ui.datepicker-pt-BR.js',
			'jquery/jquery.mask.js',
			'jquery/jquery.maskMoney.js',
			'GridView.js',
			'index.js',
			'produto.js'
			));
		H::vars(array('menu_options'=>'menu.php'));
		return true;
	}
	
	public static function render() { 
		H::render('paginas/layout/index.php');
	}
	
	
	public static function index() { self::listing(); }
	
	public static function listing() {
		$vars = new stdClass();
		$model = new Produto();
		$model->request('Produto');
		$model->addWhere('Status=1');
		$model->setPagination(100);
		$model->setOrders(array('CodMitryus DESC'));
		$vars->produtos = $model->findAll();
		$vars->model = $model;
		H::vars($vars);
		H::config('listing.php','Produtos');
		self::render();
	}
	
	public static function create() { self::form('Novo Produto');}
	public static function edit() {	self::form('Editar Produto',H::cod());}
	private static function form($titulo,$id = null) {	
		$vars = new stdClass();
		$errors = array();
		$model = new Produto();
		$promo = new ProdutoPromo();
		if(isset($_POST['Produto'])):
			$model->request('Produto');
			if($id != null) $model->IDProduto = $id;
			$errors = Validate::model($model)->errors;
			
			#echo '<pre>';var_dump($errors);die;
			if($model->Status === null) $model->Status=0;
			
			if(count($errors) < 1):
				if(!$data = $model->save()) die('Não foi possivel salvar');
				else H::redirect('produto','view',$data->IDProduto);
			else:
			endif;
			$model->DataExpiracao = CData::setDateBr($model->DataExpiracao);
		else:
			if($id):
				$model->IDProduto = $id;
				$model = $model->findOne();
			endif;
		endif;
		$vars->tit = H::cod() == null ? $titulo : $titulo." : '".$model->Nome."'";
		$vars->model = $model;
		$vars->promo = $promo;
		$vars->errors = $errors;
		H::config('form.php',$vars->tit);
		H::vars($vars);
		self::render();

	}
	
	public static function view() {
		$vars = new stdClass();
		$model = new Produto();
		$model->IDProduto = H::cod();
		$vars->data = $model->findOne();
		H::config('view.php','Produto: '.$vars->data->Nome);
		H::vars($vars);
		self::render();
	}
	
	public static function delete() {
		$model = new Produto();
		$model->IDProduto = H::cod();
		if(!$model->remove()) die('Não foi possivel excluir');
		H::redirect('produto','index');
	}
	/*
	public static function foto_pop_up(){
		$model = new Foto();
		$model->IDFoto = URL::friend(3);
		if(!empty($model->IDFoto)) $model = $model->findOne();
		
		H::vars(array('data'=>$model));
		H::render('paginas/upload/form.php');
	}
	*/
	
	public static function foto() {
		$model = new ProdutoFotoR();
		$model->IDProduto = H::cod();
		$model->ID = URL::friend(3);
		$fotos = $model->findAll();
		$foto = $fotos[0];
		printf("
			<div class='voltar'>
			<a href='%s' target='#fotos' class='h_update' >VOLTAR</a>
			</div>
			<img src='%s' />
			",H::link('produto','fotos',H::cod()),
			$foto->SRC());
	}
	
	public static function fotos() {
		if(isset($_GET['POP_UP'])):
			printf("
			<div id='fotos'>
				<script type='text/javascript'>Produto.fotos(%s)</script>
			</div>
			",H::cod());
			die;
		endif;
		$vars = new stdClass();
		$model = new Produto();
		$model->IDProduto = H::cod();
		$vars->produto = $model->findOne();
		
		$model = new ProdutoFotoR();
		$model->IDProduto = H::cod();
		#$model->setPagination();
		$vars->fotos = $model->findAll();
		#$vars->model = $model;
		H::vars($vars);
		H::config('fotos.php','');
		H::render('paginas/produto/fotos.php');
	}
	
	public static function foto_rm(){
		$model = new ProdutoFoto();
		$model->ID = URL::friend(3);
		$pf = $model->findOne();
		$model_f = new Foto();
		$model_f->IDFoto = $pf->IDFoto;
		File::unlink_versions($model_f->findOne()->Arquivo);
		
		if(!$model->delete() || !$model_f->delete()) die('Não foi possivel excluir');
		H::redirect('produto','fotos',H::cod());
	}
	
	public static function camera() { 
		H::render('paginas/produto/camera.php');
	}
	
	public static function snapshot() { 
		H::render('paginas/produto/snapshot.php');
	}
	
	public static function upload() {
		if(ProdutoFoto::requestSave('foto',H::cod())) H::redirect('produto','fotos',H::cod());
		
	}
	
	public static function categorias() {
		$vars = new stdClass();
		$vars->errors = array();
		$model = new ProdutoCategoria();
		if(isset($_GET['Categoria'])) $model->request('Categoria');
		#$model->setPagination();
		$vars->categorias = $model->findAll();
		$vars->model = $model;
		H::vars($vars);
		if(isset($_GET['update'])):
			header ('Content-type: text/html; charset=ISO-8859-1');		
			H::render(H::path().'categorias.php');
		else:
			H::config('categorias.php','Categorias de Produtos');
			self::render();
		endif;
	}
	
	public static function categorias_form() {
		$vars = new stdClass();
		$vars->errors = array();
		$model = new ProdutoCategoria();
		$cod = H::cod();
		if(!empty($cod)):
			$model->IDCategoria = H::cod();
			$model = $model->findOne();
		endif;
		if(isset($_POST['ProdutoCategoria'])):
			$model->request('ProdutoCategoria');
			$vars->errors = Validate::model($model)->errors;
			if(count($vars->errors) > 0):  
			elseif(!$data = $model->save()): die('Não foi possivel salvar');
			else: return header("Location: ".H::link('produto','categorias').'?update=true');
			endif;
		endif;
		$vars->model = $model;
		H::vars($vars);
		header ('Content-type: text/html; charset=ISO-8859-1');
		H::render(H::path().'categorias_form.php');
	}
	
	public static function categorias_confirm() { 
		header ('Content-type: text/html; charset=ISO-8859-1');
		$model = new ProdutoCategoria();
		$model->IDCategoria = H::cod();
		$C = $model->findOne();
		H::vars(array('C'=>$C));
		H::render(H::path().'categorias_confirm.php');
	}
	
	
	public static function categorias_delete(){
		$model = new ProdutoCategoria();
		$model->IDCategoria = H::cod();
		if(!$model->remove()) die('Não foi possivel excluir');
		header("Location: ".H::link('produto','categorias').'?update=true');
	}
}