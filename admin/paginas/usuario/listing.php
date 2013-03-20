<?php printf('<h1 class="title">Lista de Usuários</h1>');?>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<form name='frm_busca' action='<?php echo URL::link(H::modulo(),H::acao());?>' method='get' > 
<tr class='busca'> 
	<th style='width: 30px;'><input type='text' name='Usuario[IDUsuario]' value='<?php echo $model->IDUsuario;?>' /></th>
	<th><input type='text' name='Usuario[Nome]' value='<?php echo $model->Nome;?>'/></th>
	<th><input type='text' name='Usuario[Email]' value='<?php echo $model->Email;?>' /></th>
	<th style='width: 80px;'><input type='submit' value='buscar' /></th>
</tr>
</form>
<tr class='legenda'> 
	<th>ID</th>
	<th>Nome</th>
	<th>E-mail</th>
	<th>Actions</th>
</tr>
<?php 
	foreach($usuarios as $U):
	$msg = "Tem certeza que deseja remover o usuario '".$U->Nome."'";
	echo "
	<tr class='grid'> 
		<td>$U->IDUsuario</td>
		<td>".substr($U->Nome,0,40)."</td>
		<td>".$U->Email."</td>
		<td class='actions'>
			".tag::a(H::link('usuario','view',$U->IDUsuario),'V','Visualizar',"class='vw'")."
			".tag::a(H::link('usuario','edit',$U->IDUsuario),'E','Editar',"class='ed'")."
			".tag::a(H::link('usuario','delete',$U->IDUsuario),'D','Remover',"class='h_confirm' msg=\"$msg\"")."
		</td>
	</tr>";
	endforeach; 
	echo "
	<tr> 
		<td class='pagination' colspan='4'>
		<ul>
		".$model->linkPrev()." 
		".$model->getCurrentPages()." 
		".$model->getNavigationGroupLinks()." 
		".$model->linkNext()." 
		</ul>
		</td>
	</tr>";
?>
</table>
