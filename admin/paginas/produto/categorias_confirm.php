<div id='h_js_confirm'>
	<div class='h_js_confirm_msg'>
		Tem certeza que deseja remover a categoria '<?php echo $C->Categoria;?>'
	</div>
	<div class='h_js_confirm_botoes'>
		<?php 
			echo tag::a(H::link('produto','categorias_delete',$C->IDCategoria),'Sim','Sim',"class='h_update h_js_confirm_yes' target='#categoria' ");
			echo tag::a(H::link('produto','categorias').'?update=true','Não','Não',"class='h_update h_js_confirm_no' target='#categoria' ");
		?>
	</div>
</div>