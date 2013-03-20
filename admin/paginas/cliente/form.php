<?
printf('<h1 class="title">%1$s</h1>',$tit);
$form = new form();
echo $form->openForm('Cliente',URL::uri(),'form_cliente'," autocomplete='off' ");
$field = array('Cliente');

echo "<input type='hidden' value='$model->IDCliente' id='IDCliente' />";

$k = 'Nome'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

$k = 'Email'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

$k = 'Senha'; $v = ''; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->password($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

# :: CONTATO ::
echo "<h4>Contato</h4>";
if(H::cod() > 0) $href = H::root()."cliente/contato_form/".H::cod();
else $href = H::root()."cliente/contato_form/";
echo "<div class='div_contato_fields' href='$href' target='.div_contato_fields'></div>";
echo "<div style='clear: both'></div>";
echo "<div><a class='add_field_contato' href='#'>Adicionar Contato</a></div>";
echo "<div style='clear: both'></div><hr/>";


# :: ENDERECO ::
echo "<h4>Endereco</h4>";
echo "<div class='div_endereco_fields'></div>";
echo "<div><a class='add_field_endereco' href='#'>Adicionar Endereco</a></div>";
echo "<div style='clear: both'></div><hr/>";


# :: SUBMIT ::
echo "<div class='submit'> <input type='submit' value='".(H::acao() == 'create' ? 'Criar' : 'Salvar')."'/></div>";
echo $form->closeForm();
?>
	

