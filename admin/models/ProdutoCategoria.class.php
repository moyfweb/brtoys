<?php
class ProdutoCategoria extends CModel
{ 	
	public $IDCategoria = null;
	public $Categoria = null;
	public $Descricao = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDCategoria');
		$this->setTable('ecom_produto_categoria');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDCategoria'] = 'ID';
		$labels['Categoria'] = 'Categoria';
		$labels['Descricao'] = 'Descrição';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['Categoria'] = 'string';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}

	public static function getOptions(){
		$option = array(array(0,'Selecione uma categoria'));
		$model = new self();
		$model->Status = 1;
		$lista = $model->findAll();
		foreach($lista as $v) $option[] = array($v->IDCategoria,$v->Categoria);
		return $option;
	}
	
	public static function getCategoria($ID){
		$model = new self();
		$model->IDCategoria = $ID;
		$res = $model->findOne()->Categoria;
		if(!empty($res)) return $res;
		else return 'sem categoria';
	}
}