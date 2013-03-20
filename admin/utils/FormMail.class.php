<?php
require 'phpmailer/class.phpmailer.php';
class FormMail
{
	
	public static function basic($to,$subject,$mailcontent,$from,$nomeusuario='SITE')
	{
		return FormMail::send($to,$subject,$mailcontent,$from,$nomeusuario);
	}
	
	public static function html($to,$subject,$mailcontent,$from,$nomeusuario='SITE')
	{
		return FormMail::send($to,$subject,$mailcontent,$from,$nomeusuario,true);
	}
	
	public static function send($to,$subject,$mailcontent,$from,$nomeusuario='SITE',$isHtml=false,$attachs=array())
	{
		$Email = new PHPMailer();
		// na classe, h� a op��o de idioma, setei como br
		$Email->SetLanguage("br");
		// esta chamada diz que o envio ser� feito atrav�s da fun��o mail do php. Voc� mudar para sendmail, qmail, etc
		// se quiser utilizar o programa de email do seu unix/linux para enviar o email
		$Email->IsMail();
		// ativa o envio de e-mails em HTML, se false, desativa.
		$Email->IsHTML($isHtml);
		// email do remetente da mensagem
		$Email->From = $from;
		// nome do remetente do email
		$Email->FromName = $nomeusuario;
		// Endere�o de destino do emaail, ou seja, pra onde voc� quer que a mensagem do formul�rio v�?
		if(is_array($to)):
			foreach($to as $item_to)
				$Email->AddAddress($item_to);
		else:
			$Email->AddAddress($to);
		endif;
		// informando no email, o assunto da mensagem
		$Email->Subject = $subject; 
		// Define o texto da mensagem (aceita HTML)
		$Email->Body = $mailcontent;
		foreach($attachs as $v):
			if(!empty($_FILES[$v]['tmp_name'])):
				$Email->AddAttachment($_FILES[$v]['tmp_name'],$_FILES[$v]['name']);
			endif;
		endforeach;
		
		if(!$Email->Send()):
			echo "A mensagem n�o foi enviada. <p>";
			echo "Erro: " . $Email->ErrorInfo;
			return false;
		else:
			return true;
		endif;
		
	}

}