<?php
class UsuarioContatoR extends CModel
{ 	
	public $ID = null;
	public $IDUsuario = null;
	public $IDContato = null;
	public $IDTipo = null;
	public $Usuario = null;
	public $Tipo = null;
	public $Valor = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_usuario_contato');
		$this->addWhere('Status > -1');
		$usr = H::cod();
		$this->IDUsuario = $usr;
		
		$this->setFrom("
		FROM (
			SELECT  
			r.ID,
			r.IDUsuario,
			r.IDContato,
			c.IDTipo,
			t.Tipo,
			Nome as Usuario,
			c.Valor,
			r.Status
			FROM ecom_usuario_contato as r
			LEFT JOIN ecom_usuario AS u ON u.IDUsuario=r.IDUsuario
			LEFT JOIN ecom_contato AS c ON c.IDContato=r.IDContato
			LEFT JOIN ecom_contato_tipo AS t ON c.IDTipo=t.IDTipo
			WHERE r.IDUsuario=$usr
			GROUP BY r.ID
		) as t");
	}
	
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDUsuario'] = 'ID do Usuario';
		$labels['IDContato'] = 'ID do Contato';
		$labels['IDTipo'] = 'ID do Tipo';
		$labels['Usuario'] = 'Nome do Usuario';
		$labels['Tipo'] = 'Tipo de Contato';
		$labels['Valor'] = 'Valor';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		#$types['ID'] = 'hidden';
		$types['IDUsuario'] = 'integer';
		$types['IDContato'] = 'integer';
		$types['IDTipo'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function findAll() { if(!empty($this->IDUsuario)) return parent::findAll(); else return array(new self(null));	}
}