<?php
class Produto extends CModel
{
	public $IDProduto = null;
	public $IDCategoria = null;
	public $CodMitryus = null;
	public $REF = null;
	public $Nome = null;
	public $Preco = null;
	public $Caixa = null;
	public $DataCadastro = null;
	public $DataExpiracao = null;
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
		$labels['CodMitryus'] = 'Cod Mitryus';
		$labels['REF'] = 'REF';
		$labels['Nome'] = 'Nome';
		$labels['Preco'] = 'Preço';
		$labels['Caixa'] = 'Itens por Caixa';
		$labels['DataCadastro'] = 'Data de Cadastro';
		$labels['DataExpiracao'] = 'Data de Expiração';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}

	public function getType($key) {
		$types = array();
		#	$types['IDCategoria'] = 'integer';
		$types['Nome'] = 'string';
		$types['Descricao'] = 'string';
		$types['Preco'] = 'float';
		$types['Caixa'] = 'integer';
		$types['DataExpiracao'] = 'date';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function save() {
		$this->DataExpiracao = CData::setDateBr($this->DataExpiracao);
		return parent::save();
	}
	public function request($key) {
		if(isset($_REQUEST[$key])):
			$busca = $_REQUEST[$key];
			foreach($busca as $k=>$v):
				if(!empty($v)): $this->{$k} = $v;endif;
			endforeach;
		endif;	
	}
}