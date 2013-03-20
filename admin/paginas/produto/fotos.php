<?php 
$titulo = sprintf('%s_%s',$produto->Nome,str_pad(count($fotos),3,0, STR_PAD_LEFT));
?>
<div class='into autocall' fnc='Produto.INIT();'>
<div class='tirar_foto'><a href='<?php echo H::link('produto','camera',H::cod());?>' class='h_update' target='#fotos'>Tirar uma foto</a></div>
<div class='tirar_foto'><a href='#' class='enviar_foto' target='#fotos'>Enviar Foto</a></div>
<form id="fileupload" action="<?php echo H::link('produto','upload',H::cod());?>" method="POST" target='#fotos' enctype="multipart/form-data">
	<p>
		<input id="foto_nome" type="text" name="foto[Nome]" value='<?php echo $titulo;?>' />
		<span class="file-wrapper">
		<input type="file" name="file" />
		<span><span>Selecionar arquivo</span></span>
		</span>
		
		<input type="submit" name="" value='Enviar' />
	</p>
</form>
</div>
<div class='album'>
<div class='clear'></div>
<?php 	
foreach($fotos as $k=>$F):
	$rm_msg = 'Tem certeza que deseja remover esta imagem?';
	$edit_action = H::link(H::modulo(),'upload',$F->IDProduto,$F->IDFoto);
	$edit_link = H::link('produto','foto_pop_up',H::cod(),$F->IDFoto).'?action='.$edit_action;
	printf('
		<div>
			<p class="options">
				%s
			</p>
			<a href="%s" target="#fotos" class="h_update">
				%s
			</a>
		</div>'
		,
		tag::a(H::link(H::modulo(),'foto_rm',H::cod(),$F->ID),'DELETE','DELETE',"class='delete' msg=\"$rm_msg\" target='#fotos'"),
		H::link(H::modulo(),'foto',H::cod(),$F->ID),
		tag::img(File::resize($F->SRC(),140,130),$F->Nome)
		);
	if($k%5==4) echo "<div class='clear'></div>";
endforeach;

?>
<div class='clear'></div>
</div>