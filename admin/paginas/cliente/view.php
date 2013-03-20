<?php printf('<h1 class="title">Visualizar Cliente : %1$s</h1>',$data->Nome);?>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<tr class='legenda'> 
	<th>Label</th>
	<th style='width: 80%;'>Valor</th>
</tr>
<?php 
	$params = CObject::toArray($data);
	foreach($params as $K=>$V):
		if(in_array($K,array('IDCliente','Senha'))) continue;
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
	$model = new ClienteContatoR();
	$contatos = $model->findAll();
	foreach($contatos as $V):
		echo "<tr class='grid'> 
			<td>".$V->Tipo."</td>
			<td>".$V->Valor."</td>
		</tr>";
	endforeach;
?>
</table>
<br/>
<?php 
	$model = new ClienteEnderecoR();
	$enderecos = $model->findAll();
	foreach($enderecos as $V):
		printf('<div class="endereco"> 
			<h4><span>Endereço: </span> \'%s\'</h4>
			<p><span>País: </span>%s</p>
			<p><span>Estado: </span>%s</p>
			<p><span>Cidade: </span>%s</p>
			<p class="bairro"><span>Bairro: </span>%s</p>
			<p class="logadouro"><span>Logadouro: </span>%s</p>
			<p><span>Número: </span>%s</p>
			<p><span>Complemento: </span>%s</p>
			<p><span>CEP: </span>%s</p>
			<div style="clear: both"></div>
		</div>', $V->Descricao, $V->Pais, $V->Estado, $V->Cidade, 
		$V->Bairro, $V->Logadouro, $V->Numero, $V->Complemento, $V->CEP);
	endforeach;
?>