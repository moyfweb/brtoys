<?php
class CData
{
	public static function str_to_format($format,$data_string)
	{
		$date = new DateTime($data_string);
		return $date->format($format);
	}
	
	public static function format($format,$data_string)
	{
		return self::str_to_format($format,$data_string);
	}
	
	public static function setDateTimeBr($string)
	{
		list($d, $m, $y , $h, $i, $s) = sscanf($string, '%02d/%02d/%04d %02d:%02d:%02d');
		return date('Y-m-d H:i:s',strtotime("$y-$m-$d $h:$i:$s"));
	}
	
	public static function setDateBr($string)
	{
		list($d, $m, $y) = sscanf($string, '%02d/%02d/%04d');
		return date('Y-m-d H:i:s',strtotime("$y-$m-$d 12:00:00"));
	}
	
	public static function setTimeBr($string)
	{
		list($h, $i, $s) = sscanf($string, '%02d:%02d:%02d');
		return date('Y-m-d H:i:s',strtotime("1999-12-12 $h:$i:$s"));
	}
	
	public static function semana_br($data_string)
	{
		$sem = array(
			'',
			'Segunda-Feira',
			'Terca-Feira',
			'Quarta-Feira',
			'Quinta-Feira',
			'Sexta-Feira',
			'Sábado',
			'Domingo'
			);
		return $sem[CData::str_to_format('N',$data_string)];
	}
	
	public static function mes_br($data_string)
	{
		$mesnome = array();
		$mesnome[1] = "Janeiro";
		$mesnome[2] = "Fevereiro";
		$mesnome[3] = "Mar&ccedil;o";
		$mesnome[4] = "Abril";
		$mesnome[5] = "Maio";
		$mesnome[6] = "Junho";
		$mesnome[7] = "Julho";
		$mesnome[8] = "Agosto";
		$mesnome[9] = "Setembro";
		$mesnome[10] = "Outubro";
		$mesnome[11] = "Novembro";
		$mesnome[12] = "Dezembro";	
		return $mesnome[CData::str_to_format('n',$data_string)];
	}
	
	
}
