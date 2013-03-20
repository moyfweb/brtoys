<?php
class Endereco extends CModel
{
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
	
	public function __construct()
	{
		parent::__construct();
		$this->setClass(get_class());
		$this->setPK('IDEndereco');
		$this->setTable('ecom_endereco');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['IDEndereco'] = 'ID';
		$labels['Descricao'] = 'Descrição';
		$labels['Pais'] = 'País';
		$labels['Estado'] = 'Estado';
		$labels['Cidade'] = 'Cidade';
		$labels['Bairro'] = 'Bairro';
		$labels['Logadouro'] = 'Logadouro';
		$labels['Numero'] = 'Número';
		$labels['Complemento'] = 'Complemento';
		$labels['CEP'] = 'CEP';
		return $labels[$key];
	}
	
	public function getType($key) { return false; }
	
	
	public static function requestSave($request) {
		$model = new self();
		$model->request($request);
		if(empty($model->IDEndereco)) $model->IDEndereco = null;
		if(!empty($model->Descricao)):
			$new = $model->IDEndereco == null ? true : false;
			if(!$data = $model->save()) die('Não foi possivel executar Contato::save()');
			else return (!$new ? false : $data->IDEndereco);
		endif;
	}
}