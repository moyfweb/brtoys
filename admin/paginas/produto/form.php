<div id='usuario'>
<h1><?php echo $tit;?></h1>
<?php
	$form = new form();
	echo $form->openForm('Produto',URL::uri(),'form_produto'," autocomplete='off' ");
	$field = array('Produto');
	
	$k = 'IDCategoria'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
	echo $form->select($field,$l,$v,ProdutoCategoria::getOptions(),array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
	
	$k = 'Nome'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
	echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
		
	$k = 'Preco'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
	echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors,'class'=>'decimal_2'));
	
	$k = 'Caixa'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
	echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors,'class'=>'integer'));
	
	$k = 'DataExpiracao'; $v = CData::format('d/m/Y',$model->{$k}); $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k; 
	echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
	/*
	// Status
	$options = array(array(1,'Sim'),array(0,'Não'));
	$k = 'Promocao'; $l = 'Promoção'; $t = 'integer'; $cfield = array('ativa_promocao');
	if($promo->{'Preco'} == 0) $v = 0;
	echo $form->radio($cfield,$l,$v,$options,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
	
	echo "<div class='fields_promocoes'>\n";
	$pfield = array('Promocao');
	$k = 'Preco'; $v = $promo->{$k}; $l = $promo->getLabel($k); $t = $promo->getType($k); $pfield[1] = $k; 
	echo $form->text($pfield,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors,'class'=>'decimal_2'));
		
	$k = 'DataInicio'; $v = $promo->{$k}; $l = $promo->getLabel($k); $t = $promo->getType($k); $pfield[1] = $k; 
	echo $form->text($pfield,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
	
	$k = 'DataFim'; $v = $promo->{$k}; $l = $promo->getLabel($k); $t = $promo->getType($k); $pfield[1] = $k; 
	echo $form->text($pfield,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
	echo "
		<div style='clear: both;'></div>
	</div>
	";
	*/
	// Status
	$options = array(array(1,'Ativo'),array(0,'Inativo'));
	$k = 'Status'; $v = $model->{$k}; $l = $model->getLabel($k); $t = $model->getType($k); $field[1] = $k;
	if($v == null) $v = 1;
	echo $form->radio($field,$l,$v,$options,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));
	
	echo "<div class='submit'> <input type='submit' value='Salvar'/></div>";
	$form->closeForm();
?>
	
<div class='clear:both;'></div>
</div>

