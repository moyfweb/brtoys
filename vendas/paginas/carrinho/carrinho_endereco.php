<?php 
global $FD, $id, $form;
$form = new form();
$FD = array('ClienteEndereco');
$model = new ClienteEnderecoR();
$model->setOrders('IDEndereco DESC');
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

if(URL::friend(2) == 'novo'):
	$id = uniqid();
	
	echo "
		<h1>NOVO ENDEREÇO</h1>
		<p>Salve o novo endereço para poder usá-lo como endereço de envio.</p>
		<div class='linha'>
			".$form->openForm('Cliente',URL::uri(),'form_cliente'," autocomplete='off' ")."
			".cliente_endereco_mk_field($model)."
			
			<div class='actions'> 
				<input type='submit' value='Salvar'/> 
				<a href='".H::link('carrinho_endereco',H::cod())."' class='voltar' > Voltar </a>
			<div style='clear: both'></div>
			</div>
			
			<div style='clear: both'></div>
			
			".$form->closeForm()."
		</div>
		";
else:
	echo "
	<div id='selecao_endereco'>
	<div><a class='h_update add_field_endereco' href='".H::link('carrinho_endereco',H::cod(),'novo')."' target='#selecao_endereco'>Adicionar Endereco</a></div>
	<h1>SELECIONAR ENDEREÇO</h1>
	";
	foreach($enderecos as $K=>$V):
		$id = uniqid();
		
		$rm_endereco = H::link('cliente','rm_endereco',$V->IDCliente,$V->ID);
		$rm = "<a href='$rm_endereco' onclick='return H.popup.confirm(this)' msg='Deseja mesmo remover este endereco?'>Remover</a>";
		echo "
		<div class='linha'>
			".$form->openForm('Cliente',URL::uri(),'form_cliente'," autocomplete='off' ")."
			".cliente_endereco_mk_field($V)."
			
			<div class='actions'> 
				<input type='submit' value='Salvar'/> 
				<a href='".H::link('finalzar',H::cod(),$V->IDEndereco)."' class='usar' > Usar </a>
				<a href='#' class='rm' > Excluir </a>
			<div style='clear: both'></div>
			</div>
			
			<div style='clear: both'></div>
			".$form->closeForm()."
		</div>
		";
	endforeach;
	echo "</div>";
endif;
?>