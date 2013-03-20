<?php
class ClienteEnderecoR extends CModel
{ 	
	public $ID = null;
	public $IDCliente = null;
	public $IDEndereco = null;
	public $Descricao = null;
	public $Pais = null;
	public $Estado = null;
	public $Cidade = null;
	public $Bairro = null;
	public $Logadouro = null;
	public $Numero = null;
	public $Complemento = null;
	public $CEP = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_cliente_endereco');
		$this->addWhere('Status > -1');
		$cli = H::cod();
		$this->IDCliente = $cli;
		
		$this->setFrom("
		FROM (
			SELECT  
			r.ID,
			r.IDCliente,
			r.IDEndereco,
			c.Nome as Cliente,
			e.Descricao,
			e.Pais,
			e.Estado,
			e.Cidade,
			e.Bairro,
			e.Logadouro,
			e.Numero,
			e.Complemento,
			e.CEP,
			r.Status
			FROM ecom_cliente_endereco as r
			LEFT JOIN ecom_cliente AS c ON c.IDCliente=r.IDCliente
			LEFT JOIN ecom_endereco AS e ON e.IDEndereco=r.IDEndereco
			WHERE r.IDCliente=$cli
			GROUP BY r.ID
		) as t");
	}
	
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDCliente'] = 'ID do Cliente';
		$labels['IDEndereco'] = 'ID do Endereço';
		$labels['Descricao'] = 'Descrição';
		$labels['Pais'] = 'País';
		$labels['Estado'] = 'Estado';
		$labels['Cidade'] = 'Cidade';
		$labels['Bairro'] = 'Bairro';
		$labels['Logadouro'] = 'Logadouro';
		$labels['Numero'] = 'Número';
		$labels['Complemento'] = 'Complemento';
		$labels['CEP'] = 'CEP';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		#$types['ID'] = 'hidden';
		$types['IDCliente'] = 'integer';
		$types['IDEndereco'] = 'integer';
		$types['IDTipo'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function findAll() { if(!empty($this->IDCliente)) return parent::findAll(); else return array(new self(null));	}
}