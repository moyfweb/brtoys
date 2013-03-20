<div id='categoria'>
<h1>Categorias</h1>

<div><a class='bt_create h_update' href='<?php echo URL::link(H::modulo(),'categorias_form');?>' target='#categoria'>Adicionar Categorias</a></div>
<!--
<table class='grid_view autocall ' fnc=''>
<form name='frm_busca' action='<?php echo URL::link(H::modulo(),H::acao());?>' method='get'>
<tr class='busca'> 
	<th><input type='text' name='Categoria[Nome]' value='<?php echo $model->Categoria;?>'/></th>
	<th><input type='text' name='Categoria[Descricao]' value='<?php echo H::limit($model->Descricao,70);?>' /></th>
	<th style='width: 80px;'>
		<input type='submit' value='buscar' />
		<input type='hidden' value='true' name='update'/>
	</th>
</tr>
</form>
</table>
-->

<?php 
foreach($categorias as $C):
	echo "
	<div class='item'> 
		<h2>".$C->Categoria."</h2>
		<p>". $C->Descricao."</p>
		<div class='actions'>
			".tag::a(H::link('produto','categorias_form',$C->IDCategoria),'Editar','Editar'," class='ed h_update' target='#categoria' ")."
			".tag::a(H::link('produto','categorias_confirm',$C->IDCategoria),'Remover','Remover',"class='h_update' target='#categoria' ")."
			<div style='clear: both;'> </div>
		</div>
	</div>";
endforeach;
?>


</div>
