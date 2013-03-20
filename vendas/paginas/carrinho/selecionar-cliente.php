<h1>SELECIONAR CLIENTE</h1>
<div id='clientes'>
<form method='' action='<?php echo URL::uri();?>'>
<input name='busca' value='<?php if(isset($_GET['busca'])) echo $_GET['busca'];?>' type='text'/>
<input value='buscar' type='submit'/>
</form>

<ul>
<?php  
foreach($clientes as $C):
	printf('<li>%s<li>',tag::a(H::link('carrinho_endereco',$C->IDCliente),$C->Nome,$C->Nome));
endforeach;	
printf('<li>%s<li>',tag::a(H::link('cadastro'),'Novo Cliente','Novo Cliente'));
?>
</ul>
</div>