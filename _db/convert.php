<html>
<header>
<style>
table { border: 1px solid gray; border-collapse: collapse;}
table td { border: 1px solid gray; padding: 2px 4px;}
</style>
</header>
<body>
<?php
$filename = "CADPRO_RED.csv";
$handle = fopen($filename, "rb");
$contents = fread($handle, filesize($filename));
fclose($handle);
$list = explode("\n",$contents);

$html = '';
$linhas = array();
foreach($list as $u):
	$u = sprintf('[%s]',str_replace("'",'"',$u));
	if($data = json_decode($u)):
		$linha = array();
		foreach($data as $k=>$v):
			if(in_array($k,array(3,4))): 
				$linha[$k] = (float)str_replace(',','.',$v);
			elseif(in_array($k,array(5,6))): 
				list($d, $m, $y , $h, $i, $s) = sscanf($v, '%02d/%02d/%04d %02d:%02d:%02d');
				$v = date('Y-m-d H:i:s',strtotime("$y-$m-$d $h:$i:$s"));
				$linha[$k] = "'$v'";
			elseif($k == 7):
				$linha[$k] = $v == 'N' ? 1 : 0;
			elseif($k == 2):
				$linha[$k] = sprintf("'%s'",trim(current(explode('REF:',$v))));
			else: 
				$linha[$k] = "'$v'";
			endif;
			$linha[] = 0;
		endforeach;
		$linhas[] = $linha;
	endif;
endforeach;

?>
<pre>
<?php
$inserts = array(); 
array_shift($linhas);
array_shift($linhas);
foreach($linhas as $linha):
	$inserts[] = implode(',',$linha);
endforeach;
printf("(%s)",implode("),\n(",$inserts));
?>
</pre>
</body>
</html>
