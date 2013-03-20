<?php
define('PAC',41106);
define('SEDEX',40010);
define('SEDEX_COBRAR',40045);
define('SEDEX_10',40045);

class correio
{	
	public static function frete($cod_servico, $cep_origem, $cep_destino, $peso, $altura='2', $largura='11', $comprimento='16', $valor_declarado='0.50')
	{
		#OFICINADANET###############################
		# Código dos Serviços dos Correios
		# 41106 PAC sem contrato
		# 40010 SEDEX sem contrato
		# 40045 SEDEX a Cobrar, sem contrato
		# 40215 SEDEX 10, sem contrato
		############################################

		$correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";
		$xml = simplexml_load_file($correios);
		if($xml->cServico->Erro == '0')
			return $xml->cServico->Valor;
		else
			return false;
	}
	public static function endereco($cep){	
		$action="http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do" ;
		
		$ch = curl_init($action);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_POST, true );
		curl_setopt($ch, CURLOPT_POSTFIELDS, "CEP=".$cep."&Metodo=listaLogradouro&TipoConsulta=cep&StartRow=1&EndRow=10");
		
		$r=curl_exec($ch);
		curl_close($ch);
		
		$dados = (object)array('uf'=>null,'cidade'=>null,'bairro'=>null,'logadouro'=>null,'msg'=>null);
		
		//EXTRAINDO VALORES
		if($pos   = strpos($r, '<table border="0" cellspacing="1" cellpadding="5" bgcolor="gray">')):
			$table = substr($r,$pos,500);
			$table = $table;
			$break = explode('</td>',$table);
			$lista = array();
			foreach($break as $B) $lista[] = end(explode('>',$B));
			#list($logradouro,$bairro,$cidade,$estado) = explode("    ",trim(strip_tags($table)));
			list($logradouro,$bairro,$cidade,$estado) = $lista;
			#list($tipoLogr,$nomeLogr) = explode(" ",$logradouro,2);
			
			$dados->uf = utf8_encode($estado);
			$dados->cidade = utf8_encode($cidade);
			$dados->bairro = utf8_encode($bairro);
			$dados->logadouro = utf8_encode($logradouro);
			$dados->msg = 1;
			
			#echo $dados->cidade;die;
			#var_dump($dados);die;
		else:
			$dados->msg = 'Não encontrado!';
		endif;
		return $dados;
	}
}