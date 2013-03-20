$(document).ready(function(){
	Produto.INIT();
});

var Produto = {
	INIT: function(){
		$("input[type=text].integer").maskMoney({symbol:'',decimal:'.',thousands: '',precision:0})
		$("input[type=text].decimal_2").maskMoney({symbol:'',decimal:'.',thousands: '',precision:2})
		$('input[type=text].decimal_3').maskMoney({symbol:'',decimal:'.',thousands: '',precision:3});
		$('input[type=text].integer').each(function(i){ if($(this).val() == '') $(this).val('0')	});
		$('input[type=text].decimal_2').each(function(i){ if($(this).val() == '') $(this).val('0.00')	});
		$('input[type=text].decimal_3').each(function(i){ if($(this).val() == '') $(this).val('0.000')	});
		
		if($('.Promocao input:checked').val() == 0) $('.fields_promocoes').hide();
		
		$('.Promocao input').change(function(){
			if($('.Promocao input:checked').val() == 0) { 
				$('.fields_promocoes').hide();
				$('.fields_promocoes input').attr("disabled","disabled"); 
			 } else { 
				$('.fields_promocoes').show();
				$('.fields_promocoes input').removeAttr("disabled"); 
			}
		});
		
		$( "input.date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "2012:1930" 
		});
		
		$('#fileupload').ajaxForm({  // target element(s) to be updated with server response 
			type: 'POST',
			beforeSubmit:  function() {$('#fotos').html('<h1>AGUARDE</h1>')},  // pre-submit callback 
			success:  function(responseText, statusText, xhr, $form) {
				$('#produto').html(responseText);
				H.CallEveryone();
			}
		});
		$('#fotos .delete').click(function(){
			if(confirm('Tem certeza que deseja deletar a foto?'))
				H.update.page(this);
				
			return false;
		});
		$('#fileupload input[type=submit]').hide();
		$('#fileupload input[type=file]').change(function(){
			$('#fileupload input[type=submit]').show();
		});
		
	},
	fotos: function(COD){
		var tmp_options = { url: ROOT+'produto/fotos/'+COD, dataType: 'html', async: false };
		tmp_options.success = function(html) { $('#fotos').html(html);  H.CallEveryone();};
		$.ajax(tmp_options);
		return false;
	}
}