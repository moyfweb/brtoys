<?php printf('<h1 class="title">Lista de Clientes</h1>');?>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<form name='frm_busca' action='<?php echo URL::link(H::modulo(),H::acao());?>' method='get' > 
<tr class='busca'> 
	<th style='width: 30px;'><input type='text' name='Cliente[IDCliente]' value='<?php echo $model->IDCliente;?>' /></th>
	<th><input type='text' name='Cliente[Nome]' value='<?php echo $model->Nome;?>'/></th>
	<th><input type='text' name='Cliente[Email]' value='<?php echo $model->Email;?>' /></th>
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
	foreach($clientes as $C):
	$msg = "Tem certeza que deseja remover o usuario '".$C->Nome."'";
	echo "
	<tr class='grid'> 
		<td>$C->IDCliente</td>
		<td>".substr($C->Nome,0,40)."</td>
		<td>".$C->Email."</td>
		<td class='actions'>
			".tag::a(H::link(H::modulo(),'view',$C->IDCliente),'V','Visualizar',"class='vw'")."
			".tag::a(H::link(H::modulo(),'edit',$C->IDCliente),'E','Editar',"class='ed'")."
			".tag::a(H::link(H::modulo(),'delete',$C->IDCliente),'D','Remover',"class='h_confirm' msg=\"$msg\"")."
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