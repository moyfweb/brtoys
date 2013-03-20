$(document).ready(function(){
	/*
	$('#menu_principal li').hide();
	$('#menu_principal li.bt_show').show();
	$('#menu_principal li.bt_show').click(function(){
		if($('#menu_principal li:hidden').length > 0) {
			$('#menu_principal li').show();
			$('#menu_principal li.bt_show').show();
		} else {
			$('#menu_principal li').hide();
			$('#menu_principal li.bt_show').show();
		}
	});
		*/
	$('.fancybox-buttons').fancybox({
		openEffect  : 'none',
		closeEffect : 'none',
		prevEffect : 'none',
		nextEffect : 'none',
		scrolling : 'no',
		closeBtn  : false,
		helpers : {
			title : {
				type : 'inside'
				},
		buttons	: {}
		},
		afterLoad : function() {
			this.title = 'Imagem ' + (this.index + 1) + ' de ' + this.group.length + (this.title ? ' - ' + this.title : '');
		}
	});
	$('#menu_produtos').hide();
	$('#menu_principal li a.produtos').click(function(){
		H.popup.open("<div id='menu_pop_up'>" + $('#menu_produtos').html() + "</div>");
		return false;
	});
	
	$('#menu_principal li a.carrinho').click(function(){
		H.popup.page(this);
		return false;
	});
	
	$('.p-box a.c_unidade, .p-box a.c_caixa, .p-detalhe a.c_unidade, .p-detalhe a.c_caixa').click(function(){
		H.popup.page(this);
		return false;
	});
	H.CallEveryone();
});

var Carrinho = {
	quantidade: function(){
		$('#form_quantidade').submit(function(){
			H.popup.post(this);
			return false;
		});
	}
}