<?php

include_once APP . 'libs/normalize.php';

/// Gera uma palavra de tamanho exatamente ao passado, preenchendo à esquerda com espaços vazios. (ou valor passado por parâmetro)
function formataPalavra($string, $tamanho, $preenchimento = 1){
	
	if($preenchimento == 1){
		return str_pad( substr(strtoupper($string),0,$tamanho) , $tamanho, " ",STR_PAD_RIGHT);
	}else if($preenchimento == 0){
		return str_pad( substr(strtoupper($string),0,$tamanho) , $tamanho, $preenchimento,STR_PAD_LEFT);
	}
	
}

function formata_numdoc($num,$tamanho){
	while(strlen($num)<$tamanho)
	{
		$num="0".$num; 
	}
return $num;
}

//parâmetros: cpf ou cnpj
//retorno[0] == número formatado
//retorno[1] == 1 pessoa juridica
//		2 pessoa fisica
function formataPessoa($cpf_cnpj){
	if($cpf_cnpj != ""){
		
		//array com caracteres de limpeza
		$limpa = array(",","/","-","(",")","."," ");
		
		//retira todos os caracteres diferentes de números
		$cpf_cnpj = str_replace($limpa, "", $cpf_cnpj);
		
		if(strlen($cpf_cnpj) == 14)
			return array($cpf_cnpj, 2);
		else if(strlen($cpf_cnpj) == 11)
			return array($cpf_cnpj, 1);
		else
			return array($cpf_cnpj, 0);
		
	}

	return array();
}


function gerarRemessa($contas, $config){

	//-------------- DADOS --------------------
	$codigoEmpresa = "301442";
	$numeroAutorizacao = "";
	$razaoSocial = utf8_decode($config->cedente);
	$agencia = $config->num_agencia;
    $dv_agencia = $config->dv_agencia;
	$contaCorrente = $config->conta;
	$dv_conta = $config->dv_conta;

	$dataAtual = date('d').date('m').date('y');
	//------------------------------------------

	$nomeArquivo = "RM".time().'.'.'REM';
	
	//$header = '0'.'1'.'REMESSA'.'01'.formataPalavra(utf8_decode('COBRANCA'),15).formataPalavra($codigoEmpresa,20,0).formataPalavra($razaoSocial,30).'237'.formataPalavra('BRADESCO',15).$dataAtual.formataPalavra('',8).'MX'.formataPalavra($sequencial,7,0).formataPalavra('',253).''.formataPalavra($numeroAutorizacao,4,0).formataPalavra($agencia,5,0).formataPalavra($contaCorrente,7,0).$dvContaCorrente.formataPalavra('',7).formataPalavra('000001',6,0).'
//';
$header = '0';
$header .= '1';
$header .= 'REMESSA';
$header .= '01';
$header .= formataPalavra(utf8_decode('COBRANÇA'),8);
$header .= formataPalavra('',7);
$header .= formataPalavra("$agencia",4);
$header .= formataPalavra("$dv_agencia",1);
$header .= formataPalavra("$contaCorrente",8,0);
$header .= formataPalavra("$dv_conta",1);
$header .= formataPalavra('',6);
$header .= formataPalavra($razaoSocial,30);
$header .= formataPalavra('756BANCOOBCED',18);
$header .= formataPalavra($dataAtual,6);
$header .= formataPalavra('1',7,0);
$header .= formataPalavra('',287);
$header .= formataPalavra('000001',6,0);
$header .= '
';

$transacao = "";

$linhaI = 1;

    foreach($contas as $conta_receber) {
        $linhaI++;

	// --- Coleta os dados do Pagamento ---

	// ------ Monta Transaction ------

	

		$cnpjRecebe = $config->cnpj;
		$temp = formataPessoa($config->cnpj);
		$idDuplicata = $conta_receber->id_conta;
		$vencimento = $conta_receber->data_vencimento;
		$valor = str_replace('.','',$conta_receber->valor);
		$cep = str_replace('-','', $conta_receber->cep);
		

        if($conta_receber->comando < 10) {
            $comando = '0'.$conta_receber->comando;
        } else {
            $comando = $conta_receber->comando;
        }

        if($comando != '01'){
            $funcao = formataPalavra($comando,2,0);
        } else {
            $funcao = '01';
        }
		
		// 01 registro, 02 baixa, 06 alteracao vencimento, 34 baixa pgto direto
		
		
		$IdDoSeuSistemaAutoIncremento = $idDuplicata; // Deve informar um numero sequencial a ser passada a função abaixo, Até 6 dígitos
		$agencia = $config->num_agencia; // Num da agencia, sem digito
        $dv_agencia = $config->dv_agencia;
		$conta = $config->conta; // Num da conta, sem digito
		$convenio = $config->convenio; //Número do convênio indicado no frontend

		$NossoNumero = formata_numdoc($IdDoSeuSistemaAutoIncremento,7);
		$qtde_nosso_numero = strlen($NossoNumero);
		$sequencia = formata_numdoc("$agencia",4).formata_numdoc(str_replace("-","",$convenio),10).formata_numdoc($NossoNumero,7);
		$cont=0;
		$calculoDv = '';
			for($num=0;$num<=strlen($sequencia);$num++)
			{
				$cont++;
				if($cont == 1)
				{
					// constante fixa Sicoob » 3197 
					$constante = 3;
				}
				if($cont == 2)
				{
					$constante = 1;
				}
				if($cont == 3)
				{
					$constante = 9;
				}
				if($cont == 4)
				{
					$constante = 7;
					$cont = 0;
				}
				$calculoDv = $calculoDv + (substr($sequencia,$num,1) * $constante);
			}
		$Resto = $calculoDv % 11;
		$Dv = 11 - $Resto;
		$Dv = '-1';
		if($Resto == 1) $Dv = 0;
		if($Resto == 0) $Dv = 0;
		
		if($Dv == '-1'){
			$Dv = 11 - $Resto;
		}
		$nosso_numero_final = $NossoNumero . $Dv;


		$transacao .= "1";
		$transacao .= formataPalavra('02',2,0);
		$transacao .= formataPalavra($cnpjRecebe,14,0);
		$transacao .= formataPalavra("$agencia",4);
		$transacao .= formataPalavra("$dv_agencia",1);
		$transacao .= formataPalavra("$conta",8,0);
		$transacao .= formataPalavra("$dv_conta",1);
		$transacao .= formataPalavra('000000',6);
		$transacao .= formataPalavra('',25);
		$transacao .= formataPalavra($nosso_numero_final,12,0);
		$transacao .= '01';
		$transacao .= '00';
		$transacao .= formataPalavra('',3);
		$transacao .= formataPalavra('',1);
		$transacao .= formataPalavra('',3);
		$transacao .= formataPalavra('000',3);
		$transacao .= formataPalavra('0',1);
		$transacao .= formataPalavra('00000',5);
		$transacao .= formataPalavra('0',1);
		$transacao .= formataPalavra('',6,0);
		$transacao .= formataPalavra('',4);
		$transacao .= formataPalavra('2',1);
		$transacao .= formataPalavra('01',2,0); 
		$transacao .= formataPalavra($funcao,2,0); //comando movimento
		$transacao .= formataPalavra($idDuplicata,10,0);
		$transacao .= formataPalavra($vencimento,6);
		$transacao .= formataPalavra($valor, 13,0);
		$transacao .= formataPalavra("756",3);
		$transacao .= formataPalavra("$agencia",4);
		$transacao .= formataPalavra("$dv_agencia",1); //prefixo da agencia
		$transacao .= formataPalavra('12',2); //duplicata de servico
		$transacao .= formataPalavra('0',1); //aceite
		$transacao .= formataPalavra($dataAtual,6);
		$transacao .= formataPalavra('01',2,0); //primeira instrucao
		$transacao .= formataPalavra('',2,0); //segunda instucao
		$transacao .= formataPalavra('020100',6); //mora mes
		$transacao .= formataPalavra('000000',6); //taxa de multa
		$transacao .= formataPalavra('2',1); //tipo distribuicao
		$transacao .= formataPalavra('000000',6); //data primeiro desconto
		$transacao .= formataPalavra('',13,0); //primeiro desconto
		$transacao .= formataPalavra('9',1); //codigo moeda

        if($conta_receber->comando == '34'){
            $transacao .= formataPalavra($valor,12,0);
        }else{
            $transacao .= formataPalavra('',12,0);
        }
		
		//se for abatimento
		$transacao .= formataPalavra('',13,0);
		$transacao .= formataPalavra($temp[1],2,0);
		$transacao .= formataPalavra($temp[0],14,0);
		$transacao .= formataPalavra(utf8_decode($conta_receber->nome),40);
		$transacao .= formataPalavra(utf8_decode($conta_receber->endereco),37);
		$transacao .= formataPalavra(utf8_decode($conta_receber->bairro),15);
		$transacao .= formataPalavra($cep,8,0);
		$transacao .= formataPalavra(utf8_decode($conta_receber->cidade),15);
		$transacao .= formataPalavra(utf8_decode($conta_receber->estado),2);
		$transacao .= formataPalavra('',40);
		
		//protesto
		$transacao .= formataPalavra('00',2);
		
		$transacao .= formataPalavra('',1);
		
		$transacao .= formataPalavra($linhaI, 6, 0);		
		
		$transacao .= '
';
    }



	$data_hoje = date("Ymd");
	
	
	//$dados = array("id_descricao", "id_fornecedor" , "nr_documento" , "data_cadastro", "data_vencimento", "valor", "obs", "id_status","id_tipo_pagamentos", "nf", "id_conta");
	//$values = array(10, 171, "" , $data_hoje , $data_hoje , $valor_boleto , "Referente a emissao de $linhaI boletos" , 2, 3, "", "");
	//insert_array_sql("contas_pagar",$dados, $values, "", "local");

	$linhaI += 1;
	$trailler = '9'.formataPalavra('',393).formataPalavra($linhaI,6,0);
	
	$fp = fopen(APP.'remessa/'.$nomeArquivo,'w+');
	fwrite($fp, $header.$transacao.$trailler);
	fclose($fp);
	 
	 normalize(APP.'remessa/'.$nomeArquivo);
	 
	 return APP.'remessa/'.$nomeArquivo;
	
}



?>