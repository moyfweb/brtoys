<?php
class Produto extends CModel
{
	public $IDProduto = null;
	public $IDCategoria = null;
	public $Nome = null;
	public $Descricao = null;
	public $Validade = null;
	public $Preco = null;
	public $PrecoCaixa = null;
	public $ItensCaixa = null;
	public $Peso = null;
	public $Altura = null;
	public $Largura = null;
	public $Comprimento = null;
	public $Status = null;

	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDProduto');
		$this->setTable('ecom_produto');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDProduto'] = 'ID';
		$labels['IDCategoria'] = 'Categoria';
		$labels['Nome'] = 'Nome';
		$labels['Descricao'] = 'Descrição';
		$labels['Validade'] = 'Data de Validade';
		$labels['Preco'] = 'Preço';
		$labels['PrecoCaixa'] = 'Preço unitário na caixa';
		$labels['ItensCaixa'] = 'Itens por Caixa';
		$labels['Peso'] = 'Peso (Kg)';
		$labels['Altura'] = 'Altura (m)';
		$labels['Largura'] = 'Largura (m)';
		$labels['Comprimento'] = 'Comprimento (m)';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}

	public function getType($key) {
		$types = array();
		#	$types['IDCategoria'] = 'integer';
		$types['Nome'] = 'string';
		$types['Descricao'] = 'string';
		$types['Preco'] = 'float';
		$types['PrecoCaixa'] = 'float';
		$types['ItensCaixa'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function SRC() {
		$model = new ProdutoFotoR();
		$model->IDProduto = $this->IDProduto;
		return $model->findOne()->SRC();
		
	}
	
	public function request($key) {
		if(isset($_REQUEST[$key])):
			$busca = $_REQUEST[$key];
			foreach($busca as $k=>$v):
				if(!empty($v) && $this->getType($k) == 'date'): $this->{$k} = CData::setDateBr($v);
				elseif(!empty($v)): $this->{$k} = $v;
				endif;
			endforeach;
		endif;	
	}
	
	public static function getOne($ID) {
		$model = new self();
		$model->IDProduto = $ID;
		return $model->findOne();
	}
}
