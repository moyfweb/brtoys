<?php
class SQLB
{
	public $__pk = null;
	public $__pag 	= "";
	private $__class = null;
	private $__select = "SELECT * ";
	private $__from	= "";
	private $__join	= "";
	private $__where	= "";
	private $__group	= "";
	private $__order	= "";
	private $__limit	= "";
	private $__wheres = null;
	private $__table = null;
	
	public function __construct() {
		$this->__wheres = array();
	}
	
	public function setClass($class) { $this->__class = $class; }
	public function getClass() { return $this->__class; }
	
	public function setTable($table) { $this->__table = $table; }
	
	public function setPK($pk) { $this->__pk = $pk; }
	

	public function sqlBuilder() {
		$this->__select = empty($this->__select) ? "SELECT *" : $this->__select;
		$this->__from = empty($this->__from) ? "FROM ".$this->__table." AS t" : $this->__from;
		$this->build_where();
		return "
		".$this->__select."
		".$this->__from."
		".$this->__join."
		".$this->__where."
		".$this->__group."
		".$this->__order."
		".$this->__limit;
	}
	
	public function setSelect($select) { $this->__select = $select; }
	public function setFrom($from) { $this->__from = $from; }
	public function setJoin($join) { $this->__join = $join."\n"; }
	public function addJoin($join) { $this->__join .= $join."\n"; }
	
	// DEFINE LIMITES DE PESQUISA
	public function setLimit($limit,$start=0)	{ $this->__limit = "LIMIT $start,$limit"; }
	
	// DEFINE OS PARAMETROS WHERE
	public function setWheres($wheres)			{ $this->__wheres = $wheres; }
	
	// ADICIONA UM PARAMETRO WHERE
	public function addWhere($where)			{ $this->__wheres[] = $where; }
	
	
	// DEFINE O GROUPS
	public function setGroups($groups) {
		if(is_array($groups)) $this->__group = "GROUP BY ".implode(',',$groups);
		else $this->__group = "GROUP BY ".$groups;
	}
		
	// DEFINE O ORDERS
	public function setOrders($orders) {
		if(is_array($orders)) $this->__order = "ORDER BY ".implode(',',$orders);
		else $this->__order = "ORDER BY ".$orders;
		
	}
	
	// EXECUTA O MYSQL
	public function sqlExecute() {
		$results = mysql_query($this->sqlBuilder()) or die(mysql_error());
		return $results;
		
	}
		
	public function resultsToArray($r) {
		$lista = array();
		while($data = mysql_fetch_array($r))
			$lista[] = $data;
		return $lista;
	}
			
	public function sqlExeArray() {
		$r = $this->sqlExecute();
		return $this->resultsToArray($r);
	}
			
	public function sqlExeData() {
		$r = $this->sqlExecute();
		$data = mysql_fetch_array($r);
		return $data;
	}
	
	public function build_where() {
		$lista = CObject::toArray($this);
		$filters = array();
		foreach($lista as $k=>$v):
			if($v !== null):
				if(is_object($v) || is_array($v)):
				elseif(is_numeric($v)):
					$filters[] = " $k=$v ";
				else:
					$filters[] = " $k LIKE '%".mysql_real_escape_string($v)."%' ";
				endif;
			endif;
		endforeach;
		$filters = array_merge($filters,$this->__wheres);
		$this->__where = count($filters) > 0 ? "WHERE \n".implode(" AND \n", $filters) : "";
	}
	
	public function total() {
		$this->sqlBuilder();
		$break = explode('GROUP BY',$this->__group);
		$count = count($break) > 1 ? ' COUNT(DISTINCT '.$break[1].') ' : ' COUNT(*) ';
		$sql_total = "
		SELECT $count AS Total 
		".$this->__from."
		".$this->__join."
		".$this->__where;
		$resultado = mysql_query($sql_total) or die(mysql_error());
		if($linha = mysql_fetch_array($resultado)):
			return $linha["Total"];
		else:
			return 0;
		endif;
	}
	
	public function setPagination($recordByPage=10) {	$this->__pag = new Paginacao($this,$recordByPage);	}
		
	// INSERT
	public function insert() {
		if($this->__pk == null) return false;
		if($this->{$this->__pk} != null) return false;
		$lista = CObject::toArray($this);
		$fields = array();
		$values = array();
		foreach($lista as $k=>$v):
			if($v !== null):
				if(is_object($v) || is_array($v) && $k == $this->__pk):
				elseif(is_numeric($v)): $fields[] = $k;	$values[] = "'$v'";
				elseif($v == 'NOW()'): 	$fields[] = $k;	$values[] = "NOW()";
				else: 					$fields[] = $k; $values[] = "'".SQLB::escape($v)."'";
				endif;
			endif;
		endforeach;
		$insert = "INSERT INTO $this->__table (`".implode('`,`',$fields)."`) VALUES (".implode(',',$values).")";
		return mysql_query($insert) or die(mysql_error());
	}
	
	// UPDATE
	public function update() {
		if($this->__pk == null) return false;
		if($this->{$this->__pk} == null) return false;
		$lista = CObject::toArray($this);
		$filters = array();
		foreach($lista as $k=>$v):
			if($v !== null):
				if(is_object($v) || is_array($v)):
				elseif(strlen($v) == 0): $filters[] = " `$k`=NULL ";
				elseif(is_numeric($v)): $filters[] = " `$k`=$v ";
				elseif($v == 'NOW()'):  $filters[] = " `$k`=NOW()";
				else: $filters[] = " `$k` = '".SQLB::escape($v)."' ";
				endif;
			endif;
		endforeach;
		$update = "UPDATE ".$this->__table."
					SET
					".implode(",\n", $filters)."
				WHERE `".$this->__pk."`='".$this->{$this->__pk}."'";
					
		return mysql_query($update) or die(mysql_error());
	}
	
	// DELETE
	public function delete()
	{
		if($this->__pk === null) return false;
		else if($this->{$this->__pk} === null) return false; 
		
		$delete = "DELETE FROM ".$this->__table." WHERE `".$this->__pk."`='".$this->{$this->__pk}."'";
		return mysql_query($delete) or die(mysql_error());
	}
	
	public static function lastID() {	
		$query = "SELECT LAST_INSERT_ID() AS ID";
		$res = mysql_query($query) or die (mysql_error());
		return mysql_fetch_object($res)->ID;
	}
	
	public static function begin() { return mysql_query("BEGIN") or die (mysql_error()); }
	
	public static function commit() { return mysql_query("COMMIT") or die (mysql_error()); }
	
	public static function escape($value) {
		$value = mysql_real_escape_string($value);
		$value = str_replace('\n',"\n",$value);
		$value = str_replace('\r',"\r",$value);
		return $value;
	}
	
	
}