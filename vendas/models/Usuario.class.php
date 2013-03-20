<?php
class Usuario extends CModel
{
	public $IDUsuario = null;
	public $IDTipo = null;
	public $Nome = null;
	public $Senha = null;
	public $Email = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDUsuario');
		$this->setTable('ecom_usuario');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDUsuario'] = 'ID';
		$labels['IDTipo'] = 'Tipo de Usuário';
		$labels['Nome'] = 'Nome';
		$labels['Senha'] = 'Senha';
		$labels['Email'] = 'Email';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['Nome'] = 'string';
		$types['IDTipo'] = 'integer';
		#$types['Senha'] = 'key';
		$types['Email'] = 'email';
		
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public static function optionsTipos(){
		$model = new UsuarioTipo();
		$tipos = $model->findAll();
		$options = array();
		$options[] = array('','Selecione um tipo de Usuário');
		foreach($tipos as $t) $options[] = array($t->IDTipo,$t->Tipo);
		return $options;
	}
}