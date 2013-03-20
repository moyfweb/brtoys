var GridView = {
	zebra: function(elm) {
		$(elm).find('tr.grid').each(function(e){
			if(e%2 == 1) $(this).addClass('gray');
		});
	}
};