<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-br">
<head>
<?php include("paginas/head.php"); ?>
</head>
<body>
<div id='site'><!-- SITE -->


<div id='topo'><!-- TOPO -->
	<div class='contato'>
	Login Info!
	</div>
</div><!-- TOPO FIM -->

<div id='meio'><!-- MEIO -->
	<ul class='menu'>
		<?php 
		if(CLogin::id() > 0):
			echo '<li>'.tag::a(H::link('usuario'),'Usuarios',true).'</li>';
			echo '<li>'.tag::a(H::link('cliente'),'Clientes',true).'</li>';
			echo '<li>'.tag::a(H::link('produto'),'Produtos',true).'</li>';
			echo '<!--li>'.tag::a(H::link('compras'),'Compras',true).'</li-->';
			echo '<hr/>';
			echo '<li  class="logout">'.tag::a(H::link('login','logout'),'Logout',true).'</li>';
		else: 
			echo '<li>'.tag::a(H::link('login','index'),'Login',true).'</li>';
		endif;		
		?>
	</ul>
	<div class='content'><!-- CONTEUDO -->
		<?php if(isset($menu_options)) include(H::path().$menu_options); //pagina onde fica o conteudo ?> 
		<div class='content-in'>
			<div class='content-margin'>
			<?php include(H::path().H::file()); //pagina onde fica o conteudo ?>  
			</div>
		</div>
	</div><!-- CONTEUDO FIM -->
	<br style='clear: both;'/>
</div><!-- MEIO FIM -->

<div id='rodape'><!-- CONTEUDO -->	
	<div class='menu_rodape' >
		<ul class='HRZ'>
		<li><?php echo tag::a(H::link('usuario'),'Usuarios',true);?></li>
		<li><?php echo tag::a(H::link('produto'),'Produtos',true);?></li>
		<li><?php echo tag::a(H::link('clientes'),'Clientes',true);?></li>
		<li><?php echo tag::a(H::link('compras'),'Compras',true);?></li>
		<li><?php echo tag::a(H::link('contato'),'Contato',true);?></li>
		</ul>
	</div>
	<div class='texto_rodape' >
	<p></p>
	</div>
	<div style='clear: both;'></div>
	<div class='max_creation' >
		<p>Desenvolvido por <a href='#'>MaxCreation</a></p>
	</div>
</div><!-- CONTEUDO FIM -->

</div><!-- SITE FIM-->
</body>
</html>