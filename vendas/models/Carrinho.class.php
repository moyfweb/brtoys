<?php
class Carrinho extends CModel
{
	public $IDCarrinho = null;
	public $IDSCarrinho = null;
	public $IDUsuario = null;
	public $IDCliente = null;
	public $DataCadastro = null;
	public $SituacaoVenda = null;
	public $SituacaoEntrega = null;
	public $FormaPagamento = null;
	public $DataEntrega = null;
	public $HoraEntrega = null;
	public $EnderecoEntrega = null;
	public $EmailCobranca = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDCarrinho');
		$this->setTable('ecom_carrinho');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDCarrinho'] = 'PK';
		$labels['IDSCarrinho'] = 'Session';
		$labels['IDUsuario'] = 'ID Usuario';
		$labels['IDCliente'] = 'ID Cliente';
		$labels['DataCadastro'] = 'Data do Cadastro';
		$labels['SituacaoVenda'] = 'Situação da Venda';
		$labels['SituacaoEntrega'] = 'Situação da Entrega';
		$labels['FormaPagamento'] = 'Forma de Pagamento';
		$labels['DataEntrega'] = 'Data da Pagamento';
		$labels['HoraEntrega'] = 'Hora da Entrega';
		$labels['EnderecoEntrega'] = 'Endereço de Entrega';
		$labels['EmailCobranca'] = 'Email de Cobrança';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['IDSCarrinho'] = 'string';
		$types['IDUsuario'] = 'integer';
		$types['IDCliente'] = 'integer';
		$types['DataCadastro'] = 'date';
		$types['SituacaoVenda'] = 'integer';
		$types['SituacaoEntrega'] = 'integer';
		$types['FormaPagamento'] = 'integer';
		$types['DataEntrega'] = 'date';
		$types['HoraEntrega'] = 'time';
		$types['EnderecoEntrega'] = 'integer';
		$types['EmailCobranca'] = 'email';
		
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function adicionar($IDProduto,$Unidades,$caixa) {
		$carrinho = new CarrinhoItem();
		
		$produto = Produto::getOne($IDProduto);
		$carrinho->QuantidadePacote = !$caixa ? 1 : $produto->ItensCaixa;
		$carrinho->PrecoPacote = !$caixa ? $produto->Preco : $produto->PrecoCaixa*$produto->ItensCaixa;
		
		$carrinho->IDProduto = $IDProduto;
		$carrinho->Unidades = $Unidades;
		return $carrinho->save();
		
	}
	
}