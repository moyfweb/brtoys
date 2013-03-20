<?php
class CTrataString
{
	/*
		limite de caracteres
	*/
	public static function limit($texto, $num)
	{
		$texto = strip_tags($texto);
		$texto = str_replace('&nbsp;','',$texto);
		if(strlen($texto) <= $num)
			$textoAux = $texto;
		else
		{
			$textoAux = substr($texto,0,$num+1);
			$pos = strrpos($textoAux," ");
			if($pos == "")
				$pos = $num-1;
			$textoAux = substr($texto,0,$pos) . "...";
		}
		return $textoAux;
	}

	/*
		sql anti injection
	*/
	public static function anti_injection($sql)
	{
			// remove palavras que contenham sintaxe sql
			$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
			$sql = trim($sql);//limpa espaзos vazio
			$sql = strip_tags($sql);//tira tags html e php
			$sql = addslashes($sql);//Adiciona barras invertidas a uma string
			return $sql;
	}
	
	/*
		remove acentos no texto
	*/
	public static function removeAcento($var)
	{
		$var = strtolower($var);
		$var = preg_replace("[бавгЄ]","a",$var);	
		$var = preg_replace("[йик]","e",$var);	
		$var = preg_replace("[утфхє]","o",$var);	
		$var = preg_replace("[ъщы]","u",$var);
		$var = preg_replace("[нмо]","i",$var);
		$var = str_replace("з","c",$var);
		return $var;
	} 
	/*
		transfroma acentos para html
	*/
	public static function tohtml($string)
	{
	  //Vogais com acento agudo
	  //$string = strtolower ($string);
	  $string = str_replace("б", "&aacute;", $string);//б
	  $string = str_replace("Б", "&Aacute;", $string);//Б        

	  $string = str_replace("й", "&eacute;", $string);//й
	  $string = str_replace("Й", "&Eacute;", $string);//Й
	  
	  $string = str_replace("н", "&iacute;", $string);//н
	  $string = str_replace("Н", "&Iacute;", $string);//Н
	  
	  $string = str_replace("у", "&oacute;", $string);//у
	  $string = str_replace("У", "&Oacute;", $string);//У
	  
	  $string = str_replace("ъ", "&uacute;", $string);//ъ
	  $string = str_replace("Ъ", "&Uacute;", $string);//Ъ

	  //Vagais com acento circunflexo
	  $string = str_replace("в", "&acirc;", $string);//в
	  $string = str_replace("В", "&Acirc;", $string);//В

	  $string = str_replace("e", "&ecirc;", $string);//к
	  $string = str_replace("E", "&Ecirc;", $string);//К
	  
	  $string = str_replace("о", "&icirc;", $string);//о
	  $string = str_replace("О", "&Icirc;", $string);//О
	  
	  $string = str_replace("ф", "&ocirc;", $string);//ф
	  $string = str_replace("Ф", "&Ocirc;", $string);//Ф

	  $string = str_replace("ы", "&ucirc;", $string);//ы
	  $string = str_replace("Ы", "&Ucirc;", $string);//Ы  

	  //Vogais com "tio"
	  $string = str_replace("a", "&atilde;", $string);//г
	  $string = str_replace("A", "&Atilde;", $string);//Г
	  
	  $string = str_replace("o", "&otilde;", $string);//х
	  $string = str_replace("O", "&Otilde;", $string);//Х

	  //Crase
	  $string = str_replace("a", "&agrave;", $string);//а
	  $string = str_replace("A", "&Agrave;", $string);//А
	  
	  //Cк-cedilha
	  $string = str_replace("з", "&ccedil;", $string);//з
	  $string = str_replace("З", "&Ccedil;", $string);//З
	 
	  //Trema
	  $string = str_replace("ь", "&uuml;", $string);//ь
	  $string = str_replace("Ь", "&Uuml;", $string);//Ь

	  $string = str_replace("ц", "&ouml;", $string);//ц
	  $string = str_replace("Ц", "&Ouml;", $string);//Ц

	  return $string;
	}
}