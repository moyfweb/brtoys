
<?php 
$model = new Produto();
$model->IDProduto = H::cod();
$produto = $model->findOne();


printf('
<div class="p-detalhe">
	<h1>%1$S</h1>
	<div style="clear: both"></div>	
	<div class="direita">
	<div class="foto" href="produto_detalhe.php" style="background-image: url(%2$s)">&nbsp;</div>
	</div>
	<div class="esquerda">
	<p>%3$s</p>
	<p class="unidade">Valor Unitário: <span> %4$s</span></p>
	<a class="c_unidade" href="%7$s/unidade">COMPRAR UNIDADES</a>
	<p class="caixa">Caixa com %5$s: <span class="atual">por %6$s</span></p>
	<a class="c_caixa" href="%7$s/caixa">COMPRAR CAIXAS</a>
	</div>
	<div style="clear: both"></div>
</div>
<hr/>',
$produto->Nome,
File::resize($produto->SRC(),400,600),
$produto->Descricao,	
'R$ '.number_format($produto->Preco,2,',',''),
$produto->ItensCaixa,
'R$ '.number_format($produto->PrecoCaixa*$produto->ItensCaixa,2,',',''),
H::link('quantidade',$produto->IDProduto)
);


 
$model = new Produto();
$produtos = $model->findAll();
foreach($produtos as $p):
	printf('
		<div class="p-box">
			<a class="titulo" href="%1$s">%2$s</a>
			<a class="foto" href="%1$s" style="background-image: url(%3$s)">&nbsp;</a>
			<a class="unidade" href="%1$s">Unidade: <span>%4$s</span></a>
			<a class="c_unidade" href="%7$s/unidade">COMPRAR UNIDADES</a>
			<a class="caixa" href="%1$s">
			Caixa com %5$s por <span>%6$s</span>
			</a>
			<a class="c_caixa" href="%7$s/caixa">COMPRAR CAIXAS</a>
		</div>
	',
	H::link('produto',$p->IDProduto),
	$p->Nome,
	File::resize($p->SRC(),213,150),
	'R$ '.number_format($p->Preco,2,',',''),
	$p->ItensCaixa,
	'R$ '.number_format($p->PrecoCaixa*$p->ItensCaixa,2,',',''),
	H::link('quantidade',$p->IDProduto)
	);
endforeach;
?>
<div style='clear: both'></div>	