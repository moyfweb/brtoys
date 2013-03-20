<?
printf('<h1 class="title">%1$s</h1>',$tit);
$form = new form();
echo $form->openForm('Usuario',URL::uri(),'form_usuario'," autocomplete='off' ");
$field = array('Usuario');

echo "<input type='hidden' value='$model->IDUsuario' id='IDUsuario' />";

$k = 'Nome'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

$k = 'Email'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

$k = 'Senha'; $v = ''; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->password($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

$options = Usuario::optionsTipos();
$k = 'IDTipo'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
echo $form->select($field,$l,$v,$options,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
# :: CONTATO ::
echo "<h4>Contato</h4>";
if(H::cod() > 0) $href = H::root()."usuario/contato_form/".H::cod();
else $href = H::root()."usuario/contato_form/";
echo "<div class='div_contato_fields' href='$href' target='.div_contato_fields'></div>";
echo "<div style='clear: both'></div>";
echo "<div><a class='add_field_contato' href='#'>Adicionar Contato</a></div>";

/*
# :: ENDERECO ::
echo "<div><h2>Endereco</h2></div>";
echo "<input type='hidden' name='unset[IDEndereco]' id='IDEndereco value='' />";
echo "<div class='div_endereco_form'></div>";
*/

# :: SUBMIT ::
echo "<div class='submit'> <input type='submit' value='".(H::acao() == 'create' ? 'Criar' : 'Salvar')."'/></div>";
$form->closeForm();
?>
	

