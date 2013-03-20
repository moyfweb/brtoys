
var H  = {
	delay: 0,
	popup: {
		open: function(html) {
			var tmp_options = {	autoSize : true, autoDimensions : true, transitionIn : 'none', transitionOut : 'none', centerOnScroll : true };
			$.fancybox( html, tmp_options);
		},
		open_big: function(html) {
			var tmp_options = {	autoSize : false, autoDimensions : false, transitionIn : 'none', transitionOut : 'none', centerOnScroll : true, width: '820px',height: '95%' };
			$.fancybox( html, tmp_options);
		},
		page: function(elm) {
			var tmp_options = { url: $(elm).attr('href'), dataType: 'html', async: false};
			tmp_options.success = function(html) { H.popup.open(html);  H.CallEveryone();};
			if(H.delay == 0) { H.delay = 1; $.ajax(tmp_options); }
			return false;
		},
		page_big: function(elm) {
			var tmp_options = { url: $(elm).attr('href'), dataType: 'html', async: false};
			tmp_options.success = function(html) { H.popup.open_big(html);  H.CallEveryone();};
			if(H.delay == 0) { H.delay = 1; $.ajax(tmp_options); }
			return false;
		},
		post: function(elm) {
			H.popup.open('carregando');
			var tmp_options = { type: 'POST', url: $(elm).attr('action'),  data: $(elm).serialize(), dataType: 'html', async: false };
			tmp_options.success = function(html) { H.popup.open(html);  H.CallEveryone();};
			if(H.delay == 0) { H.delay = 1; $.ajax(tmp_options); }
			return false;
		},
		confirm: function(elm) {
			var tbm_post_data = { url: $(elm).attr('href'), msg: $(elm).attr('msg') };
			var tmp_options = { type: 'POST', url: ROOT + 'h_js/confirm', dataType: 'html', data: tbm_post_data, async: false};
			tmp_options.success = function(html) { 
				H.popup.open(html);  
				H.CallEveryone();
				$('#h_js_confirm .h_js_confirm_no').click(function(){ $.fancybox.close(); return false;});
			};
			if(H.delay == 0) { H.delay = 1; $.ajax(tmp_options); }
			return false;
		}
	},
	update: {
		page: function(elm) {
			var tmp_target = $(elm).attr('target');
			var tmp_options = { url: $(elm).attr('href'), dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).html(html);  H.CallEveryone();};
			if(H.delay == 0) { H.delay = 1; $.ajax(tmp_options); }
			return false;
		},
		post: function(elm) {
			var tmp_target = $(elm).attr('target');
			var tmp_options = { type: 'POST', url: $(elm).attr('action'), data: $(elm).serialize(), dataType: 'html', async: false };
			tmp_options.success = function(html) { $(tmp_target).html(html);  H.CallEveryone();};
			if(H.delay == 0) { H.delay = 1; $.ajax(tmp_options); }
			return false;
		}		
	},
	CallEveryone: function(){
		$('.autocall').each(function(e){ eval($(this).attr('fnc')); 	});
		$('a.h_popup, a.h_popup_big , a.h_update, a.h_confirm').unbind('click');
		$('form.h_popup, form.h_update').unbind('submit');
		$('a.h_popup').click(function(){ return H.popup.page(this); });
		$('a.h_popup_big').click(function(){ return H.popup.page_big(this); });
		$('a.h_update').click(function(){ return H.update.page(this); });
		$('a.h_confirm').click(function(){ return H.popup.confirm(this); });
		$('form.h_popup').submit(function(){ return H.popup.post(this); });
		$('form.h_update').submit(function(){ return H.update.post(this); });
		H.delay = 0;
	}
}