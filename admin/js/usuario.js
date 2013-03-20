$(document).ready(function(){
	USR.contato.open();
	$('.add_field_contato').click(function(){	return USR.contato.add(); });
});

var USR  = {
	contato: {
		open: function(elm) {
			var tmp_target = '.div_contato_fields';
			var id = $('#IDUsuario').val();
			var tmp_options = { url: ROOT + 'usuario/form_contato/' + id, dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).append(html);  H.CallEveryone();};
			$.ajax(tmp_options);
			return false;
		},
		add: function(elm) {
			var tmp_target = '.div_contato_fields';
			var tmp_options = { url: ROOT + 'usuario/form_contato', dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).append(html);  H.CallEveryone();};
			$.ajax(tmp_options);
			return false;
		},
		retirar: function(elm) { $(elm).parent().parent().remove(); return false; }
	}
}