<div id='login'>
	<h1><?php echo $msg;?></h1>
	<?php
	#var_dump($errors);
	if(CLogin::id() > 0):
		echo '<h3> Você está logado com "'.CLogin::nome().'" !';
	else:
		$field = array('Login');
		$form = new form();
		echo $form->openForm('Login',URL::uri());
		$k = 'Email'; $v = $data->{$k}; $l = $data->getLabel($k); $t = $data->getType($k); $field[1] = $k; 
		echo $form->text($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

		$k = 'Senha'; $v = ''; $l = $data->getLabel($k); $t = $data->getType($k); $field[1] = $k; 
		echo $form->password($field,$l,$v,array('obrigatorio'=>1,'class'=>'', 'type'=>"$t",'p'=>"class='$k'", 'errors'=>$errors));

		echo "<input type='submit' name='login_button' value='Login'/>";
		echo $form->closeForm();
	endif;
	?>
</div>