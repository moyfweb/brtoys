<?php
//$GLOBALS['AUTOLOAD'] = array('required','utils','models');
function __autoload($classname)
{
	$pastas = $GLOBALS['AUTOLOAD'];
	$count_testes = 0;
	foreach($pastas as $p):
		$filename = $p."/". $classname .".class.php";
		// FILENAME EXITE
		if(file_exists($filename)):
			require $filename;
			break;
		endif;
		$count_testes++;
	endforeach;
	if($count_testes == count($pastas))
		echo "'$classname.class.php' N?encontrado <br>";
}