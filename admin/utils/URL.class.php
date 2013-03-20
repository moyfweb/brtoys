<?php
class URL
{
	private static $root;
	private static $site;
	private static $urls;
	private static $vars;
	
	public static function init()
	{
		self::$root = str_replace('index.php','',$_SERVER['PHP_SELF']);
		self::$site = 'http://'.$_SERVER['SERVER_NAME'].self::$root;
		
		$break = explode(self::$root,$_SERVER['REQUEST_URI']);
		if(empty($break[0])) unset($break[0]);
		$url = implode(self::$root,$break);
		
		$url = current(explode('?',$url));
		self::$urls = array();
		$urls = explode('/', $url);
		foreach($urls as $v):
			if(!empty($v) && count(explode(':',$v)) == 1) self::$urls[] = $v;
		endforeach;
		self::$vars = new stdClass();
		foreach($urls as $k=>$v):
			$brk = explode(':',$v);
			$key = array_shift($brk);
			$val = implode(':',$brk);
			if($k > 1 && count(explode(':',$v)) > 1) self::$vars->{$key} = $val;
		endforeach;
	}
	public static function atual() { return 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];}
	
	public static function root() { return self::$root;}
	
	public static function site() { return self::$site;}
	
	public static function uri() { return $_SERVER['REQUEST_URI'];}
	
	public static function urls() { return self::$urls;}
	
	public static function vars() { return self::$vars;}
	
	public static function getVar($v) { if(isset(self::$vars->{$v})) return self::$vars->{$v}; else return null;}
	
	public static function friend($k) { 
		if(isset(self::$urls[$k]))	return self::$urls[$k];
		else return null;
	}
	
	public static function link($l1,$l2=null,$l3=null,$l4=null,$l5=null,$l6=null) {
		if($l1 == null) $l1 = self::urls();
		if(!is_array($l1)):
			$seq = array();
			$vars=new stdClass();
			for($i=1;$i<=6;$i++)
			if(${"l$i"} !== null) $seq[] = ${"l$i"};	else break;
		else:	
			$seq = $l1;
			if(!is_object($l2)):
				$vars=new stdClass();
			else:
				$vars=new stdClass();
				foreach(self::$vars as $k=>$v) $vars->{$k} = $v;
				foreach($l2 as $k=>$v) $vars->{$k} = $v;
			endif;
		endif;
		foreach($vars as $k=>$v) $seq[] = "$k:$v";

		return self::root().implode('/',$seq);
	}
}
URL::init();