$(document).ready(function(){
	
	var camera = $('#camera'),
		photos = $('#photos'),
		screen =  $('#screen');

	
	/*----------------------------------
		Setting up the web camera
	----------------------------------*/
	var newDateID = new Date;
	var URL_UPLOAD = ROOT+'produto/snapshot/'+Produto.COD+'?uniqid='+newDateID.getTime();
	
	webcam.set_swf_url(ROOT+'arquivos/webcam/webcam.swf');
	webcam.set_api_url(URL_UPLOAD);	// The upload script
	webcam.set_quality(80); // JPEG Photo Quality
	webcam.set_shutter_sound(false, '');

	
	// Generating the embed code and adding it to the page:	
	screen.html(
		webcam.get_html(screen.width(), screen.height())
	);


	/*----------------------------------
		Binding event listeners
	----------------------------------*/
	
	var shootEnabled = false;
		
	$('#shootButton').click(function(){
		
		if(!shootEnabled){
			return false;
		}
		
		webcam.freeze();
		togglePane();
		return false;
	});
	
	$('#cancelButton').click(function(){
		webcam.reset();
		togglePane();
		return false;
	});
	
	$('#uploadButton').click(function(){
		webcam.upload(URL_UPLOAD,function(){
			$("#fotos").html('<H1>Aguarde</H1>');
			Produto.fotos(Produto.COD);
		});
		webcam.reset();
		togglePane();
		return false;
	});


	camera.find('.settings').click(function(){
		if(!shootEnabled){
			return false;
		}
		
		webcam.configure('camera');
	});

	/*---------------------- 
		Callbacks
	----------------------*/
	
	
	webcam.set_hook('onLoad',function(){
		// When the flash loads, enable
		// the Shoot and settings buttons:
		shootEnabled = true;
	});
	
	webcam.set_hook('onComplete', function(msg){
		msg = $.parseJSON(msg);
		if(msg.error){	
			alert(msg.message);	
		}
		
	});
	
	webcam.set_hook('onError',function(e){  screen.html(e);	});
	
});
function togglePane(){
	var visible = $('#camera .buttonPane:visible:first');
	var hidden = $('#camera .buttonPane:hidden:first');
	
	visible.fadeOut('fast',function(){
		hidden.show();
	});
}