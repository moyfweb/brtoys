<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('head.php');?>
</head>
<body>

<div id='menu_principal' class='middle'>
	<ul>
		<li><a href='#' class='produtos'>PRODUTOS</a></li>
		<li><?php echo tag::a(H::link('carrinho'),'CARRINHO','Carrinho', " class='carrinho'");?></li>
		<li><a href='#'>VENDEDOR</a></li>
		<li><a href='#'>FERRAMENTAS</a></li>
		<div style='clear: both'></div>	
	</ul>
</div>
<div id='content' class='middle'>
	<?php include(H::path().H::file()); //pagina onde fica o conteudo ?> 
	<div style='clear: both'></div>	
</div>
<div id='menu_produtos'>
	<ul>
		<li><?php echo tag::a(H::link('produtos','brinquedos'),'Brinquedos',true);?></li>
		<li><?php echo tag::a(H::link('produtos','eletronicos'),'Eletrônicos',true);?></li>
		<li><?php echo tag::a(H::link('produtos','bijous'),'Bijous',true);?></li>
		<li><?php echo tag::a(H::link('produtos','ceramicas'),'Cerâmica',true);?></li>
	</ul>
</div>
</body>
</html>