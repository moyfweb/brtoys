<?php
class WPConnect
{
	public static function connect()
	{
		$mysql = $GLOBALS['BLOG_WP'];
		$host = isset($mysql->host) ? $mysql->host : H::getSQL()->host;
		$user = isset($mysql->user) ? $mysql->user : H::getSQL()->user;
		$key = isset($mysql->key) ? $mysql->key : H::getSQL()->key;
		$db = isset($mysql->db) ? $mysql->db : null;
		if(empty($db)):
			echo 'NÃO FOI DEFINIDO O BANCO DE DADOS DO BLOG WORDPRESS';die;
		else:
			$conexao = mysql_connect($host, $user, $key);
			mysql_select_db($db, $conexao);
		endif;
	}
}
