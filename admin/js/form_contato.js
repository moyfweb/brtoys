jQuery.extend(jQuery.validator.messages, {
    required: "Este campo é obrigatório.",
    remote: "Please fix this field.",
    email: "E-mail invalido.",
    url: "UR invalida.",
    date: "Data invalida.",
    dateISO: "Data invalida.",
    number: "Número inválido",
    digits: "Insira apenas digitos.",
    creditcard: "Insira um numero de cartão de credito valido.",
    equalTo: "Insira novamente este mesmo valor.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Por favor insira menos que {0} caracteres."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});
/*
jQuery.validator.addMethod("defaultInvalid", function(value, element) {
	if (element.value == element.defaultValue)
		  return false;
	else
		return true;
		
	},'Este campo é obrigatório.');

jQuery.validator.addMethod("valid_captcha", function(value, element){
	var result = ajaxCaptcha(element); // método ajax que será descrito a seguir
	return eval(result); // usa-se eval porque o ajax retorna uma string e params é um boolean, então o eval resolve isso.
});
*/

function ajaxCaptcha(element) {
	var result = $.ajax({
		type: "POST",
		url: ROOT+"captcha_validate?uniqueid="+newDate.getTime(),
		data: "captcha="+element.value,
		async: false,
		global: false
		}).responseText;
	return result;
}

function valorDefault(campo)
{
	$(campo).focus(function() {
		if ($(this).attr('value') == $(this).attr('defaultValue'))
			$(this).attr('value','');
	});
	$(campo).attr('defaultValue',$(this).attr('value'));
	$(campo).addClass('defaultInvalid');
}
$(document).ready(function() {
	
	valorDefault("form.validar input:text.required");
	valorDefault("form.validar textarea.required");
	$.metadata.setType("attr", "validate");
	$("form.validar").validate({
    errorPlacement: function(error,element) {
						if(error.html().length > 0)
						{
							if($(element).attr('type') == 'radio')
							{ 
								$(element).parent().addClass('error');
							}					
						}
						if($(element).attr('type') == 'radio')
						{ 
							//$(element).parent().parent().find('span.erro').html(error);
						}
						else
						{
							//$(element).parent().find('span.erro').html(error);
						}
						return true;
                    },
	showErrors: function(errorMap, errorList) {
			//$('#message').html(errorList.length);
			this.defaultShowErrors();
		  }
	});
	$("form.validar input:radio").change(function(){
		$(this).parent().removeClass('error');
	});
	
	$("#summary").html("Os campos em vermelho são obrigatórios.");

	$("form.validar").submit();
	$(".orcamento").hide();
});