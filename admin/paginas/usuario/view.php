<?php printf('<h1 class="title">Visualizar Usuário : %1$s</h1>',$data->Nome);?>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<tr class='legenda'> 
	<th>Label</th>
	<th style='width: 80%;'>Valor</th>
</tr>
<?php 
	$params = CObject::toArray($data);
	foreach($params as $K=>$V):
		if(in_array($K,array('IDUsuario','Senha'))) continue;
		if(!is_array($V) && !is_object($V)):
		if($K == 'Status') $V = $V == 1 ? 'Ativo' :  'Inativo';
		echo "<tr class='grid'> 
			<td>".$data->getLabel($K)."</td>
			<td>".H::limit($V,200)."</td>
		</tr>";
		endif;
	endforeach; 
?>
</table>

<h4>Contato</h4>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<tr class='legenda'> 
	<th>Tipo</th>
	<th style='width: 80%;'>Valor</th>
</tr>
<?php 
	$model = new UsuarioContatoR();
	$contatos = $model->findAll();
	foreach($contatos as $V):
		echo "<tr class='grid'> 
			<td>".$V->Tipo."</td>
			<td>".$V->Valor."</td>
		</tr>";
	endforeach;
?>
</table>

