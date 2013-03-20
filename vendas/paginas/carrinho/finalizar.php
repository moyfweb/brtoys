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
<table>
<?php 
	$fields = array('Descricao','Pais','Estado','Cidade','Bairro','Logadouro','Numero','Complemento','CEP');
	foreach($fields as $k):
		echo "<tr><td style='width:150px;font-weight: bold;'>".$endereco->getLabel($k)."</td><td>".$endereco->{$k}."</td></tr>";
	endforeach;
?>
</table>
<h2>DADOS ADICIONAIS</h2>
<form>
<input type='hidden' name='Carrinho[EnderecoEntrega]' value='<?php echo $endereco->IDEndereco;?>' />

<p>
<label>E-mail de cobrança</label>
<input type='text' name='Carrinho[EmailCobranca]' value='<?php echo $cliente->Email;?>'/>
</p>
<p>
<label>Data de entrega</label>
<input type='text' name='Carrinho[DataEntrega]' value=''/>
</p>

<p>
<label>Horario ou Periodo de entrega</label>
<input type='text' name='Carrinho[HoraEntrega]' value=''/>
</p>

<p>
<label>Observações</label>
<textarea name='Carrinho[Observacoes]'></textarea>
</p>

<p>
<label>Forma de pagamento</label>
<select name='Carrinho[FormaPagamento]' >
	<option>Selecione uma opção</option>
	<option>Antecipado</option>
	<option>Na Entrega</option>
	<option>Doc</option>
	<option>Pag Seguro</option>
</select>
</p>
<p style='text-align: right;'>
<input type='submit' value='FINALIZAR COMPRA'/>
</p>

</div>

