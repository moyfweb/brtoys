<?php
class ProdutoPromo extends CModel
{
	public $ID = null;
	public $IDProduto = null;
	public $Preco = null;
	public $DataInicio = null;
	public $DataFim = null;
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_produto_promocao');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'PK';
		$labels['IDProduto'] = 'ID';
		$labels['Preco'] = 'Pre�o Promocional';
		$labels['DataInicio'] = 'In�cio da Promo��o';
		$labels['DataFim'] = 'Fim da Promo��o';
		return $labels[$key];
	}

	public function getType($key) {
		$types = array();
		$types['IDProduto'] = 'integer';
		$types['Preco'] = 'float';
		$types['DataInicio'] = 'date';
		$types['DataFim'] = 'date';
		if(isset($types[$key])) return $types[$key];
		else return false;
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
}