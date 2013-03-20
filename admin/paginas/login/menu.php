<?php
$__CFG_menu = new stdClass();
$__CFG_menu->msg = 'Tem certeza que deseja remover este cadastro?';
$__CFG_menu->option  = array();
$__CFG_menu->option[] = array(H::link(H::modulo(),'index'),'Login','Login','');
?>
<?php 
foreach($__CFG_menu->option as $k=>$v):
		
	if(substr_count($v[0],H::link(H::modulo(),H::acao()))):
		echo "\t\t <li class='current'>".tag::a('#',$v[1],$v[2],$v[3])."</li>\n"; 
	else:
		echo "\t\t <li>".tag::a($v[0],$v[1],$v[2],$v[3])."</li>\n"; 
	endif;
endforeach;
unset($__CFG_menu,$k,$v);
?>

