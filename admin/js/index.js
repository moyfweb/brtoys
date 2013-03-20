$(document).ready(function() {
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
	H.CallEveryone();
	
});
	