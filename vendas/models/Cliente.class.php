<?php
class Cliente extends CModel
{
	public $IDCliente = null;
	public $Nome = null;
	public $Senha = null;
	public $Email = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDCliente');
		$this->setTable('ecom_cliente');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDCliente'] = 'ID';
		$labels['Nome'] = 'Nome';
		$labels['Senha'] = 'Senha';
		$labels['Email'] = 'Email';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['Nome'] = 'string';
		#$types['Senha'] = 'key';
		$types['Email'] = 'email';
		
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
}