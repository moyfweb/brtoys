<?php
class Contato extends CModel
{ 	
	public $IDContato = null;
	public $IDTipo = null;
	public $Valor = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('IDContato');
		$this->setTable('ecom_contato');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDContato'] = 'ID';
		$labels['IDTipo'] = 'Tipo de Contato';
		$labels['Valor'] = 'Valor';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$types['IDTipo'] = 'integer';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public static function requestSave($request) {
		$model = new self();
		$model->request($request);
		if(empty($model->IDContato)) $model->IDContato = null;
		if(!empty($model->IDTipo) && !empty($model->Valor)):
			$new = $model->IDContato == null ? true : false;
			if(!$dataC = $model->save()) die('Não foi possivel executar Contato::save()');
			else return (!$new ? false : $dataC->IDContato);
		endif;
	}
	
}