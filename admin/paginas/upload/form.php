<form id="fileupload" action="<?php echo $_GET['action'];?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="foto[IDFoto]" value='<?php echo URL::friend(3);?>' />
	<div>
		<label for="foto_nome">Nome do Arquivo</label>
		<input id="foto_nome" type="text" name="foto[Nome]" value='<?php echo $data->Nome;?>' />
	</div>
	
	<div>
		<span class="file-wrapper">
		<input type="file" name="file" />
		<span><div>Selecionar arquivo</div></span>
		</span>
		<div class='file_progress_bar'>
			<div style='width: 100%;'>&nbsp;</div>
		</div>
	</div>
	
	<div>
		<label for="foto_desc">Descricao</label>
		<textarea id="foto_desc" type="text" name="foto[Descricao]"><?php echo $data->Descricao;?></textarea>
	</div>
	
	<div class='enviar'>
	<input id="botao_enviar" type="submit" name="" value='Enviar' style='padding: 5px 10px;' />
	</div>
	
</form>