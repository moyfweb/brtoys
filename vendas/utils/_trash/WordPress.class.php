<?php
class WordPress
{
	public static function config($host,$db,$user,$key=null)
	{
		$host = !empty($host) ? $host : 'localhost';
		$key = !empty($key) ? $key : '24101977';
 		$blog = array('host'=>$host,'db'=>$db,'user'=>$user,'key'=>$key);
		$GLOBALS['BLOG_WP'] = (object)$blog;
	}
}