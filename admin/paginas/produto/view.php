<div id='usuario'>
<h1>Visualizar Produto : <?php echo $data->Nome;?></h1>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<tr class='legenda'> 
	<th>Label</th>
	<th style='width: 80%;'>Valor</th>
</tr>
<?php 
	$params = CObject::toArray($data);
	foreach($params as $K=>$V):
		if(in_array($K,array('IDProduto'))) continue;
		if(in_array($K,array('IDCategoria'))) $V = ProdutoCategoria::getCategoria($V);
		if(!is_array($V) && !is_object($V)):
		if($K == 'Status') $V = $V == 1 ? 'Ativo' :  'Inativo';
		if(in_array($K,array('DataCadastro','DataExpiracao'))) $V = CData::format('d/m/Y',$V);
		echo "<tr class='grid'> 
			<td>".$data->getLabel($K)."</td>
			<td>".H::limit($V,200)."</td>
		</tr>";
		endif;
	endforeach; 
?>
</table>

</div>
