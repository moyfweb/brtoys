<?php
class Files
{
	private static $url_painel = H::root().'painel/arquivo/resize';
	public static function resize($img,$width=null,$height=null,$crop=null)
	{
		$crop = $crop != null ? $crop : null;
		$query = array();
		if(!empty($img)) { $query['img'] = $img; }
		if(!empty($width)) { $query['w'] = $width; }
		if(!empty($height)) { $query['h'] = $height; }
		if(!empty($crop)) { $query['crop'] = $crop; }
		return self::$url_painel.'?'.http_build_query($query);
	}
	
}