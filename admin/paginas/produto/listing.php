<div id='produtos'>
<h1>Lista de Produtos</h1>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<form name='frm_busca' action='<?php echo URL::link(H::modulo(),H::acao());?>' method='get' > 
<tr class='busca'> 
	<th></th>
	<th><input type='text' name='Produto[Nome]' value='<?php echo $model->Nome;?>'/></th>
	<th><input type='text' name='Produto[REF]' value='<?php echo $model->REF;?>' /></th>
	<th></th>
	<th style='width: 120px;'><input type='submit' value='buscar' /></th>
</tr>
</form>
<tr class='legenda'> 
	<th>Foto?</th>
	<th>Nome</th>
	<th>REF</th>
	<th>Categoria</th>
	<th>Actions</th>
</tr>
<?php 
	foreach($produtos as $P):
	$msg = "Tem certeza que deseja remover o produto '".$P->Nome."'";
	$foto = ProdutoFoto::hasFoto($P->IDProduto);
	echo "
	<tr class='grid'> 
		<td class='".($foto ? 'ftrue' : 'ffalse')."'>
		".($foto ? 'Sim' : 'Não')."
		</td>
		<td>".$P->Nome."</td>
		<td>". $P->REF."</td>
		<td>".ProdutoCategoria::getCategoria($P->IDCategoria)."</td>
		<td class='actions'>
			".tag::a(H::link('produto','view',$P->IDProduto),'V','Visualizar',"class='vw'")."
			".tag::a(H::link('produto','edit',$P->IDProduto),'E','Editar',"class='ed'")/*."
			".tag::a(H::link('produto','delete',$P->IDProduto),'D','Remover',"class='h_confirm' msg=\"$msg\"")*/."
			".tag::a(H::link('produto','fotos',$P->IDProduto,'?POP_UP=1'),'F','Foto',"class='h_popup_big' msg=\"$msg\"")."
		</td>
	</tr>";
	endforeach; 
	echo "
	<tr> 
		<td class='pagination' colspan='5'>
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


</div>
