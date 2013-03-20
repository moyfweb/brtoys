<?php 
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
