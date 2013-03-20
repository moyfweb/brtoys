<?php
class UsuarioTipo extends CModel
{
	public $IDTipo = null;
	public $Tipo = null;
	public function __construct()
	{
		parent::__construct();
		$this->setClass(get_class());
		$this->setPK('IDTipo');
		$this->setTable('ecom_usuario_tipo');
	}
	
	public function label($key) {
		$labels = array();
		$labels['IDTipo'] = 'ID';
		$labels['Tipo'] = 'Tipo de Usuário';
		return $labels[$key];
	}
	
	public function type($key) {
		$types = array();
		$types['IDTipo'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
}