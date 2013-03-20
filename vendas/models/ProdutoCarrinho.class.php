<?php
class ProdutoCarrinho extends CModel
{
	public $ID = null;
	public $IDSCarrinho = null;
	public $IDProduto = null;
	public $QuantidadePacote = null;
	public $Unidades = null;
	public $PrecoPacote = null;
	public $Status = null;
	
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_carrinho_item');
		$this->addWhere('Status > -1');
		$this->IDSCarrinho = $_SESSION['idsession'];
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'PK';
		$labels['IDSCarrinho'] = 'Session';
		$labels['IDProduto'] = 'ID Usuario';
		$labels['QuantidadePacote'] = 'Quantidade por Pacote';
		$labels['Unidades'] = 'Unidades';
		$labels['Unidades'] = 'Unidades';
		$labels['PrecoPacote'] = 'Preço por Pacote';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['IDProduto'] = 'integer';
		$types['QuantidadePacote'] = 'integer';
		$types['Unidades'] = 'integer';
		$types['PrecoPacote'] = 'float';
		
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function save() {
		$this->IDSCarrinho = $_SESSION['idsession'];
		$carrinho = new self();
		$carrinho->IDSCarrinho = $this->IDSCarrinho;
		$carrinho->IDProduto = $this->IDProduto;
		$carrinho->QuantidadePacote = $this->QuantidadePacote;
		$this->ID = $carrinho->findOne()->ID;
		return parent::save();
	}
	
	public function SRC() {
		$model = new ProdutoFotoR();
		$model->IDProduto = $this->IDProduto;
		return $model->findOne()->SRC();
		
	}
	
	public function produto() {
		$model = new Produto();
		$model->IDProduto = $this->IDProduto;
		return $model->findOne();
	}
}