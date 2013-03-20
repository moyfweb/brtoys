<?php header ('Content-type: text/html; charset=ISO-8859-1');?>
<div id='carrinho_de_compras' style='width: 600px;min-height: 400px'>
<H1>Carrinho de Compras</H1>
<table>
<tr><th>ID</th><th>Nome</th><th>Preço</th><th>Unidades</th><th> Tipo de Compra </th><th>Soma</th></tr>
<?php 
foreach($itens as $i):
printf('
<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
$i->IDProduto,$i->produto()->Nome,number_format($i->PrecoPacote,2,',','') ,$i->Unidades,
($i->QuantidadePacote == 1 ? 'UNIDADE' : 'CAIXA COM '.$i->QuantidadePacote), 
number_format($i->PrecoPacote*$i->Unidades,2,',','') 
);
endforeach;

?>
</table>
<?php echo tag::a(H::link('selecionar-cliente'),'FINALIZAR COMPRA',true," class='finalizar_compra' ");?>

</div>