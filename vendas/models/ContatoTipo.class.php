<?php
class ContatoTipo extends CModel
{ 	
	public $IDTipo = null;
	public $Tipo = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->setClass(get_class());
		$this->setPK('IDTipo');
		$this->setTable('ecom_contato_tipo');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDTipo'] = 'ID';
		$labels['Tipo'] = 'Tipo de Contato';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public static function getOptions(){
		$model = new self();
		$tipos = $model->findAll();
		$options = array();
		$options[] = array('','Selecione o Tipo');
		foreach($tipos as $t) $options[] = array($t->IDTipo,$t->Tipo);
		return $options;
	}
}