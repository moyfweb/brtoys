<?php
class tag
{
	public static function a($url, $content, $title=null, $extra=null)
	{
		$title = $title === true ? $content : $title;
		$title = !empty($title) ? "title='$title'" : ''; 
		return "<a href='$url' $title $extra>$content</a>";
	}
	
	public static function fBox($src,$thumb,$title,$group='button')
	{
		$content = self::img($thumb, $title);
		return self::a($src,$content,$title,"class='fancybox-buttons' data-fancybox-group='$group'");
	}
	
	
	public static function fBoxR($src, $title, $w=null, $h=null, $c=null, $group='button')
	{
		$thumb = Ubis::resize($src,$w,$h,$c);
		$content = self::img($thumb, $title);
		return self::a($src,$content,$title,"class='fancybox-buttons' data-fancybox-group='$group'");
	}
	
	public static function img($src, $title, $alt=null, $extra=null)
	{
		$alt = $alt==null ? $title : $alt;
		return "<img src='$src' title='$title' alt='$alt' $extra/>";
	}
	
}