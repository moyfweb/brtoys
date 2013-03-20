<?php
class UsuarioContato extends CModel
{ 	
	public $ID = null;
	public $IDUsuario = null;
	public $IDContato = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_usuario_contato');
		$this->addWhere('Status > -1');
	}
	
	public function label($key) {
		$labels = array();
		$labels['ID'] = 'ID';
		$labels['IDUsuario'] = 'Usuario';
		$labels['IDContato'] = 'Contato';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function type($key) {
		$types = array();
		$labels['IDUsuario'] = 'integer';
		$labels['IDContato'] = 'integer';
		$types['IDTipo'] = 'string';
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function saveList($post_key,$IDUsuario){
		$contatos = $_POST[$post_key];
		foreach($contatos as $k=>$C):
			if($IDContato = Contato::requestSave(array($post_key,$k))):
				$model = new UsuarioContato();
				$model->IDContato = $IDContato;
				$model->IDUsuario = $IDUsuario;
				if(!($dataUC = $model->save())) die('Não foi possivel executar UsuarioContato::save()');
			endif;		
		endforeach;
	}
}