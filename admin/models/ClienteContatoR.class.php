<?php
class ClienteContatoR extends CModel
{ 	
	public $ID = null;
	public $IDCliente = null;
	public $IDContato = null;
	public $IDTipo = null;
	public $Cliente = null;
	public $Tipo = null;
	public $Valor = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_cliente_contato');
		$this->addWhere('Status > -1');
		$usr = H::cod();
		$this->IDCliente = $usr;
		
		$this->setFrom("
		FROM (
			SELECT  
			r.ID,
			r.IDCliente,
			r.IDContato,
			c.IDTipo,
			t.Tipo,
			Nome as Cliente,
			c.Valor,
			r.Status
			FROM ecom_cliente_contato as r
			LEFT JOIN ecom_cliente AS u ON u.IDCliente=r.IDCliente
			LEFT JOIN ecom_contato AS c ON c.IDContato=r.IDContato
			LEFT JOIN ecom_contato_tipo AS t ON c.IDTipo=t.IDTipo
			WHERE r.IDCliente=$usr
			GROUP BY r.ID
		) as t");
	}
	
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDCliente'] = 'ID do Cliente';
		$labels['IDContato'] = 'ID do Contato';
		$labels['IDTipo'] = 'ID do Tipo';
		$labels['Cliente'] = 'Nome do Cliente';
		$labels['Tipo'] = 'Tipo de Contato';
		$labels['Valor'] = 'Valor';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		#$types['ID'] = 'hidden';
		$types['IDCliente'] = 'integer';
		$types['IDContato'] = 'integer';
		$types['IDTipo'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function findAll() { if(!empty($this->IDCliente)) return parent::findAll(); else return array(new self(null));	}
}