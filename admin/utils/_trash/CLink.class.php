<?php
class CLink
{
	public static function detalhe($modulo, $cod, $string)
	{
		$string = CLink::trataString($string);
		$string = str_replace(array(',','%','.','"','/'),'',$string);
		$string = urlencode($string);

		//substituir link por $url_server  
		$string = H::getUrl() . $modulo . "/" . $string . "-C" . "$cod" . ".html";
		// return the modified string
		return $string;
	}


	public static function noticia($modulo, $cod, $string, $ano, $mes)
	{
		$string = CLink::trataString($string);

		$string = str_replace(array(',','%','.','"','/'),'',$string);
		$string = urlencode($string);
		//substituir link por $url_server  
		$string = H::getUrl() . $modulo . "/" . "$ano". "/" . "$mes". "/"  . $string . "-C" . "$cod" . ".html";

		// return the modified string
		return $string;
	}



	public static function modulo($modulo )
	{  
			
		$string = H::getUrl() . $modulo . "/" ;		
		
		// return the modified string
		return $string;
	}
	
	public static function trataString($string)
	{	
	  // remove all characters that aren't a-z, 0-9, dash, underscore or space
	  $string = strtolower(trim( strip_tags($string) ));
	  
	  //$string = str_replace('?'a',$string);
	  $string = str_replace('?','',$string);  
	  $string = str_replace('-','_',$string);  
	  
	  $string = preg_replace("[^a-zA-Z0-9_]", "", strtr($string, "??e???aB¯EG???", "aaaaeeeiooouucaaaaeeeiooouuc_"));
	  //??e???aB¯EG??? 
	  //aaaaeeeiooouucaaaaeeeiooouuc_ 
	  
	  $NOT_acceptable_characters_regex = '#[^-a-zA-Z0-9_ ]#';
	  //$string = preg_replace($NOT_acceptable_characters_regex, '', $string );
	  $string = substr($string,0,100);
	  // remove all leading and trailing spaces  

	  // change all dashes, underscores and spaces to dashes
	  $string = preg_replace('#[-_ ]+#', '-', trim($string) );
	  return($string);
		
	}

}