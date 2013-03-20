<?php
$__CFG_menu = new stdClass();
$__CFG_menu->msg = 'Tem certeza que deseja remover este cadastro?';
$__CFG_menu->option  = array();
$__CFG_menu->option[] = array(H::link(H::modulo(),'index'),'Listar','Listar','');
$__CFG_menu->option[] = array(H::link(H::modulo(),'create'),'Criar','Criar','');
$__CFG_menu->option[] = array(H::link(H::modulo(),'categorias'),'Categorias','Categorias','');
if(in_array(H::acao(),array('view','edit','fotos'))):
	$__CFG_menu->option[] = array(H::link(H::modulo(),'view',H::cod()),'Visualizar','Visualizar',"class='vw'");
	$__CFG_menu->option[] = array(H::link(H::modulo(),'edit',H::cod()),'Editar','Editar',"class='ed'");
	$__CFG_menu->option[] = array(H::link(H::modulo(),'fotos',H::cod()),'Fotos','Fotos',"class='ft'");
	$__CFG_menu->option[] = array(H::link(H::modulo(),'delete',H::cod()),'Remover','Remover',"class='h_confirm' msg=\"$__CFG_menu->msg\"");
endif;
?>
<ul class='submenu'>
<?php 
foreach($__CFG_menu->option as $k=>$v):
	if(substr_count($v[0],H::link(H::modulo(),H::acao()))):
		$L = H::acao() == 'categorias' ? $v[0] : '#';
		echo "\t\t <li class='current'>".tag::a($L,$v[1],$v[2],$v[3])."</li>\n"; 
	else:
		echo "\t\t <li>".tag::a($v[0],$v[1],$v[2],$v[3])."</li>\n"; 
	endif;
endforeach;
unset($__CFG_menu,$k,$v);
?>
</ul>
