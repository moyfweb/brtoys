<?php 
$form = new form();
$FD = array('UsuarioContato');
$model = new UsuarioContatoR();
$contatos = $model->findAll();
if(H::cod() == null):
	$id = uniqid();
	$tipos = ContatoTipo::getOptions();
	
	$k = 'IDContato'; $v = ''; $l = $model->getLabel($k); $t = $model->getType($k); $FD[1] = $id; $FD[2] = $k; 
	$field_id = $form->hidden($FD,$l,$v);
	
	$k = 'IDTipo'; $v = ''; $l = $model->getLabel($k); $t = $model->getType($k); $FD[1] = $id; $FD[2] = $k;
	$DEF = array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'",'div_class'=>'div_c1');
	$field_tipo = $form->select($FD,$l,$v,$tipos,$DEF);
		
	$k = 'Valor'; $v = ''; $l = $model->getLabel($k); $t = $model->getType($k); $FD[1] = $id; $FD[2] = $k; 
	$DEF = array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'",'div_class'=>'div_c2');
	$field_nome = $form->text($FD,$l,$v,$DEF);

	$rm = "<a href='#' onclick='return USR.contato.retirar(this)'>Remover</a>";
	echo "
	<div class='linha'>
		$field_id
		$field_tipo
		$field_nome
		<p class='remover'>$rm</p>
		<div style='clear: both'></div>
	</div>";
else:
	foreach($contatos as $K=>$V):
		$id = uniqid();
		
		$k = 'IDContato'; $v = $V->{$k}; $l = $V->getLabel($k); $t = $model->getType($k); $FD[1] = $id; $FD[2] = $k; 
		$field_id = $form->hidden($FD,$l,$v);
		
		$tipos = ContatoTipo::getOptions();
		$k = 'IDTipo'; $v = $V->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $FD[1] = $id; $FD[2] = $k;
		$DEF = array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'",'div_class'=>'div_c1');
		$field_tipo = $form->select($FD,$l,$v,$tipos,$DEF);
			
		$k = 'Valor'; $v = $V->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $FD[1] = $id; $FD[2] = $k; 
		$DEF = array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'",'div_class'=>'div_c2');
		$field_nome = $form->text($FD,$l,$v,$DEF);
		$rm_contato = H::link('usuario','rm_contato',$V->IDUsuario,$V->ID);
		$rm = "<a href='$rm_contato' onclick='return H.popup.confirm(this)' msg='Deseja mesmo remover este contato?'>Remover</a>";
		echo "
		<div class='linha'>
			$field_id
			$field_tipo
			$field_nome
			<p class='remover'>$rm</p>
			<div style='clear: both'></div>
		</div>";
	endforeach;
endif;