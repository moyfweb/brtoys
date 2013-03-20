<?php
class BlogImg
{
	public static function resize($url_php,$img,$width=null,$height=null,$crop=null)
	{
		if(!empty($img)):
		$crop = $crop != null ? $crop : null;
			$query = array();
			if(!empty($img)) { $query['img'] = $img; }
			if(!empty($width)) { $query['w'] = $width; }
			if(!empty($height)) { $query['h'] = $height; }
			if(!empty($crop)) { $query['crop'] = $crop; }
			return $url_php.'?'.http_build_query($query);
		endif;
		return null;
	}
	
}