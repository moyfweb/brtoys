
$(document).ready(function(){
	Atributo.valor_extra = 1*$('#atributos .extra').html();
	Pericia.valor_extra = 1*$('#pericias .extra').html();
	Atributo.atualizar();
	Pericia.atualizar();
	
	$('#botao_infos').click(function(){ 
		Planilha.openForm($(this).attr('href'),'#form_info form',function(){
			return false;
		});
		return false; 
	});
	$('a.fancybox_ajax').click( Planilha.fBoxAjax);
});



var Planilha = {
	timer: 0,
	fBox: function(html){
		$.fancybox(
			html,
			{
				autoSize		: false,
				autoDimensions	: false,
				width         	: 600,
				height        	: 400,
				transitionIn	: 'none',
				transitionOut	: 'none',
				centerOnScroll  : true
			}
		);
	},
	openForm: function(page, form,funcao_submit) {
		$.ajax({
			  url: page,
			  data: '',
			  dataType: 'html',
			  success: function(html){
					Planilha.fBox(html);
					$('#form_info form').submit(funcao_submit);
				}
			});
		return false;
	
	},
	fBoxAjax: function(){
		newDate = new Date;
		var page = $(this).attr('href');
		Planilha.fBox('<h1>Aguarde</h1>');
		if(newDate.getTime() > Planilha.timer  + 1000) {
			$.ajax({
				  url: page,
				  data: '',
				  dataType: 'html',
				  success: Planilha.fBox
			});
			Planilha.timer = newDate.getTime();
		}
		return false;
	},
	getHTML: function(){
		
		var page = $(this).attr('href');
		Planilha.fBox('<h1>Aguarde</h1>');
		$.ajax({
			  url: page,
			  data: '',
			  dataType: 'html',
			  success: Planilha.fBox
			});
		return false;
	},
	updateHTML: function(page,target,aguarde){
		$(target).html(aguarde);
		$.ajax({
			  url: page,
			  data: '',
			  dataType: 'html',
			  async: false,
			  success: function(html){$(target).html(html);  }
			});
		return false;
	}
}

var Pericia = {
	valor_exced: 0,
	new_extra: 0,
	valor_extra: 0,
	soma: 0,
	soma_original: 0,
	onChange: function(e) {
		newDate = new Date;
		var page = ROOT+'planilha/pericia_categoria/'+$(e).val()+'?uniqueid='+newDate.getTime();
		Planilha.updateHTML(page,'#pericia_pericia',"<option value=''>Aguarde</option>");
		Pericia.rmSemelhant();
	},
	rmSemelhant: function(){
		$('#pericias .lista>div span').each(function(e){ 
			$('#pericia_pericia option[value='+$(this).attr('idpericia')+']').remove(); 
		});
	},
	adicionar: function() { 
		var id = $('#pericia_pericia').val();
		var ITEM = { id: id,	nome: $('#idpericia_'+id).val()	};
			
		var html = "<div>"+ITEM.nome;
		html += "<span id='pr_"+ITEM.id+"' nivel='1' original='1' idpericia='"+ITEM.id+"'> </span>";
		html += "</div>";
		if($('#pr_'+id).length == 0) $('#pericias .lista').append(html);
		$.fancybox.close();
		Pericia.atualizar();
		return false; 
	},
	atualizar: function ()
	{
		var elementos = '#pericias .lista>div span';
		Barra.gerar(elementos, Pericia.atribuir);
		Pericia.soma = 0;
		$(elementos).each(function (i) { Pericia.soma += (1*$(this).attr('nivel')); });
		$('#pericias .total').html(Pericia.soma);
		Pericia.soma_original = 0;
		$(elementos).each(function (i) { Pericia.soma_original += (1*$(this).attr('original')); });
		$('#pericias .extra').html(Pericia.valor_extra - (Pericia.soma - Pericia.soma_original));
	},
	atribuir: function(){ 
			valor_exced = $(this).parent().attr('nivel') - $(this).parent().attr('original');
			Pericia.new_extra = Pericia.valor_extra - (Pericia.soma - Pericia.soma_original) + 1*$(this).parent().attr('nivel') - 1*$(this).attr('href');
			
			if(Pericia.new_extra  >= 0 ) {
			$(this).parent().attr('nivel',$(this).attr('href')); Pericia.atualizar();
			} else { alert('os pontos excedem o valor maximo permitido');} 
			return false;
		}	
}
var Atributo = {
	valor_exced: 0,
	new_extra: 0,
	valor_extra: 0,
	soma: 0,
	soma_original: 0,
	atualizar: function ()
	{
		var elementos = '#atributos .atr span';
		Barra.gerar(elementos, Atributo.atribuir);
		Atributo.soma = 0;
		$(elementos).each(function (i) { Atributo.soma += (1*$(this).attr('nivel')); });
		$('#atributos .total').html(Atributo.soma);
		Atributo.soma_original = 0;
		$(elementos).each(function (i) { Atributo.soma_original += (1*$(this).attr('original')); });
		$('#atributos .extra').html(Atributo.valor_extra - (Atributo.soma - Atributo.soma_original));
	},
	atribuir: function(){ 
			Atributo.valor_exced = $(this).parent().attr('nivel') - $(this).parent().attr('original');
			Atributo.new_extra = Atributo.valor_extra - (Atributo.soma - Atributo.soma_original) + 1*$(this).parent().attr('nivel') - 1*$(this).attr('href');
			
			if(Atributo.new_extra  >= 0 ) {
			$(this).parent().attr('nivel',$(this).attr('href')); Atributo.atualizar();
			} else { alert('os pontos excedem o valor maximo permitido');} 
			return false;
		}
}

var Barra = {
	gerar: function(elementos,atribuirValor){
		var img_nivel = new Array();
		img_nivel[0] = "item_ficha2.png";
		img_nivel[1] = "item_ficha.png";
		$(elementos).each(function (i) {
			var nivel = $(this).attr('nivel');
			var original = $(this).attr('original');
			$(this).html('');
			if(original == 0) {$(this).html("<a href='0'>X</a>"); }
			for(i=0;i<5;i++)  {
				var img_type = '';
				if(i<nivel) img_type = img_nivel[0];
				else img_type = img_nivel[1];
			
				if(i<(original-1)) $(this).append("<img src='"+ROOT+"arquivos/site/"+img_type+"'>");
				else $(this).append("<a href='"+(i+1)+"'><img src='"+ROOT+"arquivos/site/"+img_type+"'></a>");
			}
		});
		$(elementos+' a').click( atribuirValor );
	}
	
}