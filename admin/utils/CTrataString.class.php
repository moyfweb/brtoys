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
			$sql = trim($sql);//limpa espa�os vazio
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
		$var = preg_replace("[����]","a",$var);	
		$var = preg_replace("[���]","e",$var);	
		$var = preg_replace("[�����]","o",$var);	
		$var = preg_replace("[���]","u",$var);
		$var = preg_replace("[���]","i",$var);
		$var = str_replace("�","c",$var);
		return $var;
	} 
	/*
		transfroma acentos para html
	*/
	public static function tohtml($string)
	{
	  //Vogais com acento agudo
	  //$string = strtolower ($string);
	  $string = str_replace("�", "&aacute;", $string);//�
	  $string = str_replace("�", "&Aacute;", $string);//�        

	  $string = str_replace("�", "&eacute;", $string);//�
	  $string = str_replace("�", "&Eacute;", $string);//�
	  
	  $string = str_replace("�", "&iacute;", $string);//�
	  $string = str_replace("�", "&Iacute;", $string);//�
	  
	  $string = str_replace("�", "&oacute;", $string);//�
	  $string = str_replace("�", "&Oacute;", $string);//�
	  
	  $string = str_replace("�", "&uacute;", $string);//�
	  $string = str_replace("�", "&Uacute;", $string);//�

	  //Vagais com acento circunflexo
	  $string = str_replace("�", "&acirc;", $string);//�
	  $string = str_replace("�", "&Acirc;", $string);//�

	  $string = str_replace("e", "&ecirc;", $string);//�
	  $string = str_replace("E", "&Ecirc;", $string);//�
	  
	  $string = str_replace("�", "&icirc;", $string);//�
	  $string = str_replace("�", "&Icirc;", $string);//�
	  
	  $string = str_replace("�", "&ocirc;", $string);//�
	  $string = str_replace("�", "&Ocirc;", $string);//�

	  $string = str_replace("�", "&ucirc;", $string);//�
	  $string = str_replace("�", "&Ucirc;", $string);//�  

	  //Vogais com "tio"
	  $string = str_replace("a", "&atilde;", $string);//�
	  $string = str_replace("A", "&Atilde;", $string);//�
	  
	  $string = str_replace("o", "&otilde;", $string);//�
	  $string = str_replace("O", "&Otilde;", $string);//�

	  //Crase
	  $string = str_replace("a", "&agrave;", $string);//�
	  $string = str_replace("A", "&Agrave;", $string);//�
	  
	  //C�-cedilha
	  $string = str_replace("�", "&ccedil;", $string);//�
	  $string = str_replace("�", "&Ccedil;", $string);//�
	 
	  //Trema
	  $string = str_replace("�", "&uuml;", $string);//�
	  $string = str_replace("�", "&Uuml;", $string);//�

	  $string = str_replace("�", "&ouml;", $string);//�
	  $string = str_replace("�", "&Ouml;", $string);//�

	  return $string;
	}
}