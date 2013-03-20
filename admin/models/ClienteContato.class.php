<?php
class ClienteContato extends CModel
{ 	
	public $ID = null;
	public $IDCliente = null;
	public $IDContato = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_cliente_contato');
		$this->addWhere('Status > -1');
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDCliente'] = 'Cliente';
		$labels['IDContato'] = 'Contato';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		$labels['IDCliente'] = 'integer';
		$labels['IDContato'] = 'integer';
		$types['IDTipo'] = 'string';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function saveList($post_key,$IDCliente){
		$contatos = $_POST[$post_key];
		foreach($contatos as $k=>$C):
			if($IDContato = Contato::requestSave(array($post_key,$k))):
				$model = new ClienteContato();
				$model->IDContato = $IDContato;
				$model->IDCliente = $IDCliente;
				if(!($dataUC = $model->save())) die('Não foi possivel executar ClienteContato::save()');
			endif;		
		endforeach;
	}
	
}