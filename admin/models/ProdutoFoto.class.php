<?php
class ProdutoFoto extends CModel
{ 	
	public $ID = null;
	public $IDProduto = null;
	public $IDFoto = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_produto_foto');
		$this->addWhere('Status > -1');
	}
	
	public function label($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDProduto'] = 'Cliente';
		$labels['IDFoto'] = 'Contato';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function type($key) {
		$types = array();
		$labels['IDProduto'] = 'integer';
		$labels['IDFoto'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function requestSave($request,$IDProduto){
		if($IDFoto = Foto::requestSave(array($request))):
			$model = new self();
			$model->IDProduto = $IDProduto;
			$model->IDFoto = $IDFoto;
			if(!($data = $model->save())) die('Não foi possivel executar ClienteContato::save()');
		endif;
		return true;
	}
	
	public static function hasFoto($IDP) {
			$model = new self();
			$model->IDProduto = $IDP;
			if($model->total() > 0) return true;
			else return false;
			
	}
	
}