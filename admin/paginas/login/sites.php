<div id='site'>
<h1>Selecione um site para administrar.</h1>
<table class='grid_view autocall ' fnc='GridView.zebra(this);'>
<form name='frm_busca' action='<?php echo URL::link(H::modulo(),H::acao());?>' method='get' > 
<tr class='busca'> 
	<th><input type='text' name='busca[Nome]' value='<?php echo $model->Nome;?>' /></th>
	<th><input type='text' name='busca[URL]' value='<?php echo $model->URL;?>'/></th>
	<th style='width: 80px;'><input type='submit' value='buscar' /></th>
</tr>
<tr> 
	<th>Nome do Site</th>
	<th colspan='2'>Domínio</th>
</tr>
</form>
<?php 
	foreach($sites as $S):
	echo "
	<tr class='grid'> 
		<td>
			".tag::a(H::link(H::modulo(),'site_selected',$S->IDSite),$S->Nome,'Selecionar site')."
		</td>
		<td colspan='2'>
			".tag::a(H::link(H::modulo(),'site_selected',$S->IDSite),$S->URL,'Selecionar site')."
		</td>
	</tr>";
	endforeach;
	if(count($sites) == 0) echo "<tr><td colspan='3'>Nenhum site encontrado.</td></tr>";
	echo "
	<tr> 
		<td class='pagination' colspan='3'>
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
