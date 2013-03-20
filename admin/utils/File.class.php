<?php
File::init();
class File
{
	private static $url_painel = null;
	private static $prefix = null;
	
	public static function init() {
		 self::$url_painel = H::root().'arquivo/resize/';
		 self::$prefix = H::root().'arquivos/upload/';
	}
	
	public static function resize($img,$width=null,$height=null,$crop=null)
	{
		$crop = $crop != null ? $crop : null;
		$img = str_replace(self::$prefix,'',$img);
		$query = array();
		if(!empty($img)) { $query['img'] = $img; }
		if(!empty($width)) { $query['w'] = $width; }
		if(!empty($height)) { $query['h'] = $height; }
		if(!empty($crop)) { $query['crop'] = $crop; }
		return self::$url_painel.'?'.http_build_query($query);
	}
	
	public static function unlink_versions($arquivo)
	{
		if(strlen($arquivo) > 3):
			$break = explode('.',$arquivo);
			array_pop($break);
			$fname = implode('.',$break);
			$mask = './arquivos/upload/foto/'.$fname."*";
			array_map( "unlink", glob( $mask ));
			$mask = './arquivos/upload/thumb/'.$fname."*";
			array_map( "unlink", glob( $mask ));
		endif;
	}
}