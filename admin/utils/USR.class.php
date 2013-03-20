<?php
class USR {
	private static $connected = false;
	private static $id = null;
	private static $type = null;
	
	public static function on($connected = null){
		if($connected !== null) self::$connected = $connected;
		else return self::$connected;
	}
	
	public static function id($id = null){
		if($id !== null) self::$id = $id;
		else return self::$id;
	}
	
	public static function type($type = null){
		if($type !== null) self::$type = $type;
		else return self::$type;
	}
}