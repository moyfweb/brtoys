<?php
class CObject
{

	public static function toArray($object)
	{
		$array = array();
		$clean = array();
		if(is_object($object)) $array = get_object_vars($object);
		foreach($array as $k=>$v) if(substr($k,0,2) != '__') $clean[$k] = $v;
		return $clean;
	}

	public static function toStd($object) { return (object)self::toArray($object);	}

}