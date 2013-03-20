<?php 
global $FD, $id, $form;
$form = new form();
$FD = array('ClienteEndereco');
$model = new ClienteEnderecoR();
$enderecos = $model->findAll();

function cliente_endereco_mk_field($C) {
	global $FD, $id, $form;
	
	$k = 'IDEndereco'; $v = $C->{$k}; $l = $C->getLabel($k); $t = $C->getType($k); $FD[1] = $id; $FD[2] = $k; 
	$conteudo = "\n\n".$form->hidden($FD,$l,$v);
		
	$fields = array('Descricao','Pais','Estado','Cidade','Bairro','Logadouro','Numero','Complemento','CEP');
	foreach($fields as $k):
		$v = $C->{$k}; $l = $C->getLabel($k); $t = $C->getType($k); $FD[1] = $id; $FD[2] = $k; 
		$DEF = array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'");
		$conteudo .= "\n\n".$form->text($FD,$l,$v,$DEF);
	endforeach;
	return $conteudo;
}

if(H::cod() == null):
	$id = uniqid();
	
	$rm = "<a href='#' onclick='return CLI.endereco.retirar(this)'>Remover</a>";
	echo "
	<div class='linha'>
		".cliente_endereco_mk_field($model)."
		<p class='remover'>$rm</p>
		<div style='clear: both'></div>
	</div>";
else:
	foreach($enderecos as $K=>$V):
		$id = uniqid();
		
		$rm_endereco = H::link('cliente','rm_endereco',$V->IDCliente,$V->ID);
		$rm = "<a href='$rm_endereco' onclick='return H.popup.confirm(this)' msg='Deseja mesmo remover este endereco?'>Remover</a>";
		echo "
		<div class='linha'>
			".cliente_endereco_mk_field($V)."
			<p class='remover'>$rm</p>
			<div style='clear: both'></div>
		</div>";
	endforeach;
endif;