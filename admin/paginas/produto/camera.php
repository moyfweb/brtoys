<div id="camera">    
	<script type='text/javascript'> Produto.COD = '<?php echo H::cod();?>';</script>
	<div class='voltar'>
		<a href='<?php echo H::link('produto','fotos',H::cod());?>' target='#fotos' class='h_update' id='camera_voltar' >VOLTAR</a>
	</div>
	<span class="camTop">
		<span class="settings"></span>
	</span>
    <div id="screen"></div>
    <div id="buttons">
    	<div class="buttonPane">
        	<a id="shootButton" href="" class="blueButton">Shoot!</a>
        </div>
        <div class="buttonPane hidden">
        	<a id="cancelButton" href="" class="blueButton">Cancel</a> <a id="uploadButton" href="" class="greenButton">Upload!</a>
        </div>
    </div>
    <!--span class="settings"></span-->
</div>
<script src="<?php echo H::root();?>arquivos/webcam/webcam.js" type="text/javascript"></script>
<script src="<?php echo H::root();?>js/webcam_scripts.js" type="text/javascript"></script>