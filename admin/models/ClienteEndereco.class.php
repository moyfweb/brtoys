<?php
class ClienteEndereco extends CModel
{ 	
	public $ID = null;
	public $IDCliente = null;
	public $IDEndereco = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_cliente_endereco');
		$this->addWhere('Status > -1');
	}
	
	public function label($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDCliente'] = 'Cliente';
		$labels['IDEndereco'] = 'Endereço';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function type($key) {
		$types = array();
		$labels['IDCliente'] = 'integer';
		$labels['IDEndereco'] = 'integer';
		$types['IDTipo'] = 'string';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public static function saveList($post_key,$IDCliente){
		$enderecos = $_POST[$post_key];
		foreach($enderecos as $k=>$C):
			if($IDEndereco = Endereco::requestSave(array($post_key,$k))):
				$model = new ClienteEndereco();
				$model->IDEndereco = $IDEndereco;
				$model->IDCliente = $IDCliente;
				if(!($data = $model->save())) die('Não foi possivel executar ClienteEndereco::save()');
			endif;		
		endforeach;
	}
	
}