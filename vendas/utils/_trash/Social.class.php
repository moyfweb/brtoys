<?php
class Social
{
	/*
		$type = icon			= ICONE
		$type = button			= BOTAO
		$type = button_count	= BOTAO + CONTADOR
		$type = box_count		= BOX + CONTADOR
	*/
	public static function Like($nome_botao='Share',$pagina=null,$type='icon')
	{
		$pagina = empty($pagina) ? 'data:post.url' : $pagina;
		return "";
		
		/*"
		<script src='http://connect.facebook.net/pt_BR/all.js#xfbml=1'></script>
		<fb:like layout='button_count' show_faces='false' href='$pagina'>$nome_botao</fb:like>
		";*/
	}
	
	/*
		$type = icon			= ICONE
		$type = button			= BOTAO
		$type = button_count	= BOTAO + CONTADOR
		$type = box_count		= BOX + CONTADOR
	*/
	public static function Share($nome_botao='Share',$pagina=null,$type='icon')
	{
		
		$pagina = empty($pagina) ? 'data:post.url' : $pagina;
		return "
		<!-- Facebook share button Start -->
			<b:if cond='data:blog.pageType != &quot;static_page&quot;'>
			<a expr:share_url='$pagina' href='http://www.facebook.com/sharer.php' name='fb_share' type='$type'>$nome_botao</a>
			<script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>
			</b:if>
		<!-- Facebook share button End -->
		";
		
	}
	
	public static function Tweet()
	{
		return "
		<a href='https://twitter.com/share' class='twitter-share-button'>Tweet</a>
		<script>
			!function(d,s,id)
			{
				var js,fjs=d.getElementsByTagName(s)[0];
				if(!d.getElementById(id))
				{
					js=d.createElement(s);
					js.id=id;js.src='//platform.twitter.com/widgets.js';
					fjs.parentNode.insertBefore(js,fjs);
				}
			}(document,'script','twitter-wjs');
		</script>
		";
	}
}