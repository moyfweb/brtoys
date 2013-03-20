<?php
class ProdutoFotoR extends CModel {

	public $ID = null;
	public $IDProduto = null;
	public $IDFoto = null;
	public $Arquivo = null;
	public $Tamanho = null;
	public $Nome = null;
	public $Descricao = null;
	public $Status = null;
	
	public function __construct()
	{
		parent::__construct();
		H::connect();
		$this->setClass(get_class());
		$this->setPK('ID');
		$this->setTable('ecom_produto_foto');
		$this->addWhere('Status > -1');
		
	}
	
	public function getLabel($key) {
		$labels = array();
		$labels['ID'] = 'PK';
		$labels['IDProduto'] = 'ID Produto';
		$labels['IDFoto'] = 'ID Foto';
		$labels['Arquivo'] = 'Arquivo';
		$labels['Tamanho'] = 'Tamanho';
		$labels['Nome'] = 'Nome';
		$labels['Descricao'] = 'Descrição';
		$labels['Status'] = 'Status';
		return $labels[$key];
	}
	
	public function getType($key) {
		$types = array();
		if(isset($types[$key])) return $types[$key];
		else return false;
	}
	
	public function findAll(){
		$IDP = empty($this->IDProduto) ? 'NULL' : $this->IDProduto;
		$this->setFrom("
		FROM (
			SELECT  
			r.ID,
			r.IDProduto,
			f.IDFoto,
			f.Arquivo,
			f.Nome,
			f.Descricao,
			f.Tamanho,
			r.Status
			FROM ecom_produto_foto as r
			INNER JOIN ecom_foto AS f ON f.IDFoto=r.IDFoto
			WHERE $IDP IS NOT NULL AND r.IDProduto=$IDP
		) as t");
		return parent::findAll();
	}
	
	
	public function SRC(){
		if(empty($this->Arquivo)) return null;
		else return H::root().'arquivos/upload/foto/'.$this->Arquivo;
	}

}