<?php
$form = new form();
$extra = " target='#categoria' autocomplete='off' fnc='Categoria.init()' ";
echo $form->openForm('ProdutoCategoria',H::link('produto','categorias_form').'?update=true','form_produto_c',$extra,null,null,'h_update');
$field = array('ProdutoCategoria');

$cod = H::cod();
if(!empty($cod)):
	echo "
	<input type='hidden' value='$cod' name='ProdutoCategoria[IDCategoria]'/>
	";
endif;
	
$k = 'Categoria'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

$k = 'Descricao'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->textarea($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

echo "
	<div class='submit'> <input type='submit' value='".(!empty($cod) ? 'Salvar' : 'Criar')."'/></div>";
$form->closeForm();
