<?php header ('Content-type: text/html; charset=ISO-8859-1');?>
<div id='popup_quantidade' style='width: 400px;min-height: 200px'>
	<?php
	$caixa = URL::friend(2) == 'caixa' ? true : false;
	$preco = !$caixa ? $produto->Preco : $produto->PrecoCaixa*$produto->ItensCaixa;
	?>
	<h2>Produto: <?php echo $produto->Nome;?></h2>
	<?php if($caixa): ?>
	<h2>Quantidade por caixa: <?php echo $produto->ItensCaixa;?></h2>
	<h2>Preço unitário: R$ <?php echo number_format($produto->PrecoCaixa, 2, ',', '');?></h2>
	<h2>Preço por caixa: R$ <?php echo number_format($preco, 2, ',', '');?></h2>
	<?php else:?>
	<h2>Preço unitário: R$ <?php echo number_format($produto->Preco, 2, ',', '');?></h2>
	<?php endif;?>
	
	<form class='autocall' fnc='Carrinho.quantidade()' id='form_quantidade' action='<?php echo $action;?>'>
	<label for='qtd_caixa'><?php echo ($caixa ? 'Número de Caixas' : 'Unidades'); ?></label>
	<input type='text' value='1' name='quantidade' name='cart_item_quantidade' id='qtd_caixa'/>
	<input type='submit' value='OK' />
	</form>
</div>