<?php
class CObjectArray
{
	public static function toObject($array)
	{
		$object = new stdClass();
		if (is_array($array) && count($array) > 0):
			foreach ($array as $name=>$value):
				
				$name = trim($name);
								
				if (!empty($name))
					$object->$name = $value;
				
			endforeach;
		endif;
		return $object;
	}


	public static function toArray($object)
	{
		$array = array();
		if (is_object($object))
			$array = get_object_vars($object);
		
		return $array;
	}
}