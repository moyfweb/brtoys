<?php
class CModel extends SQLB
{
	public function __construct()
	{
		parent::__construct();
	}	
	
	// PROCURA TODOS
	public function findAll()
	{
		$list = $this->sqlExeArray();
		$object_list = $this->array_to_self($list);
		return $object_list;
	}
	
	// PROCURA UM
	public function findOne()
	{
		$data = $this->sqlExeData();
		$object = $this->data_to_self($data);
		return $object;
	}
	
	public function save()
	{
		if($this->{$this->__pk} !== null):
			$this->update();
			return $this->findOne();
		else:
			$this->insert();
			$this->{$this->__pk} = SQLB::lastID();
			return $this->findOne();
		endif;
	}
	
	
	// CONVERTE TODOS OS RESULTADOS PARA OBJETOS slef(); 
	private function array_to_self($data_list)
	{
		$object_list = array();
		for($i=0;$i<count($data_list);$i++):
				$object_list[] = $this->data_to_self($data_list[$i]);
		endfor;
		return $object_list;
	}
	
	// CONVERTE TODOS OS RESULTADOS PARA OBJETOS slef(); 
	private function data_to_self($data)
	{
		//$class = get_called_class();
		$class = $this->getClass();
		
		$temp =  new $class();
		$temp_list = (array) $temp;
		foreach($temp_list as $k=>$v):
			if(isset($data[$k]))
				$temp->{$k} = $data[$k];
		endforeach;
		return $temp;
	}
	
	public function request($keys) {
		if(is_array($keys)):
			$crumb = implode("']['",$keys);
			$str_array = "\$_REQUEST['$crumb']";
			$busca = eval("if(isset($str_array)) return $str_array;");
			if($busca == null): unset($busca); endif;
			
		elseif(isset($_REQUEST[$keys])):
			$busca = $_REQUEST[$keys];
		endif;
		
		if(isset($busca)):
			foreach($busca as $k=>$v) if($v !== null): $this->{$k} = $v; endif;
		else:
			die('Erro no metodo CModel::request');
		endif;
	}
	
	public function valid($model) {
		return CValidation::valid($model);
	}
	
	public function remove() {
		if(!empty($this->{$this->__pk})):
			$this->Status = -1;
			$this->save();
			return true;
		else:
			return false;
		endif;
	}
			
	
	public function getPagination() 			{ return $this->__pag;}
	public function linkPrev()					{ return $this->__pag->linkPrev(); }
	public function linkNext()					{ return $this->__pag->linkNext(); }
	public function getCurrentPages()		 	{ return $this->__pag->getCurrentPages(); }
	public function getNavigationGroupLinks()	{ return $this->__pag->getNavigationGroupLinks();	}
	public function getListCurrentRecords()		{ return $this->__pag->getListCurrentRecords(); }
	
	/*
		comment = 
			$class = "Class".$str;
		$object = new $class();
	*/
}