$(document).ready(function(){
	$('.add_field_contato').click(function(){	return CLI.contato.add(); });
	$('.add_field_endereco').click(function(){	return CLI.endereco.add(); });
});

var CLI  = {
	contato: {
		open: function(elm) {
			var tmp_target = '.div_contato_fields';
			var id = $('#IDCliente').val();
			var tmp_options = { url: ROOT + 'cliente/form_contato/' + id, dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).append(html);  H.CallEveryone();};
			$.ajax(tmp_options);
			return false;
		},
		add: function(elm) {
			var tmp_target = '.div_contato_fields';
			var tmp_options = { url: ROOT + 'cliente/form_contato', dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).append(html);  H.CallEveryone();};
			$.ajax(tmp_options);
			return false;
		},
		retirar: function(elm) { $(elm).parent().parent().remove(); return false; }
	},
	endereco: {
		open: function(elm) {
			var tmp_target = '.div_endereco_fields';
			var id = $('#IDCliente').val();
			var tmp_options = { url: ROOT + 'cliente/form_endereco/' + id, dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).append(html);  H.CallEveryone();};
			$.ajax(tmp_options);
			return false;
		},
		add: function(elm) {
			var tmp_target = '.div_endereco_fields';
			var tmp_options = { url: ROOT + 'cliente/form_endereco', dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).append(html);  H.CallEveryone();};
			$.ajax(tmp_options);
			return false;
		},
		retirar: function(elm) { $(elm).parent().parent().remove(); return false; }
	}
}