<?php

use App\Models\Multban\Empresa\Empresa;
use App\Models\Multban\Produto\Estoqpro;
use App\Models\Multban\Produto\Inventario\Cadasdhi;
use App\Models\Multban\Venda\Estoqmov;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function tirarAcentos($string)
{
    return preg_replace(array("/(ç)/", "/(Ç)/", "/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "c C a A e E i I o O u U n N"), $string);
}

function replicate($expressao, $quantidade)
{
    $result = '';
    for ($i = 1; $i < $quantidade; $i++) {
        $result .= $expressao;
    }
    return $result;
}

function in_array_r($array, $field, $find)
{
    foreach ($array as $item) {
        if ($item[$field] == $find) return true;
    }
    return false;
}

function in($valor, $comparador = array())
{
    return in_array($valor, $comparador);
}

function formatarParaMoeda($valor)
{
    return sprintf('R$ %s', number_format($valor, 2, ',', '.'));
}

function formatarParaQuantidade($valor)
{
    return sprintf('%s', number_format($valor, 2, ',', '.'));
}

function formatarTextoParaDecimal($valor)
{
    $valor = str_replace(["%", "R$", ".", ","], ["", "", "", "."], $valor);

    return $valor > 0 ? number_format((float)$valor, 2, '.', '') : null;
}

function formatarMoneyToDecimal($valor)
{
    return str_replace(["R$", ","], ["", "."], str_replace(".", "", $valor));
}

function removerVirgulaPorPonto($valor)
{
    return str_replace(",", ".",  $valor);
}

function numero($valor)
{
    return number_format(round((float) ($valor), 4), 2);
}

function formatarParaMoedaDecimal($valor)
{
    return sprintf('%s', number_format($valor, 2, ',', ''));
}

function adicionarCodigoEDescricao($model, $idCampo = 'id', $campo = 'descricao')
{
    $retorno = "";
    if ($model != null) {
        if ($model != null && $model[$idCampo])
            $retorno =  $model[$idCampo] . ' - ' . strtoupper($model[$campo]);
        else if ($model['descricao'])
            $retorno =  $model['id'] . ' - ' . strtoupper($model['descricao']);
        else
            $retorno =  $model['id'] . ' - ' . strtoupper($model['razaosocial']);
    }


    return $retorno;
}

function codigoEDescricaoCliente($model)
{
    $retorno = "";
    if ($model != null && $model['id'])
        $retorno =  $model['id'] . ' - ' . strtoupper($model['razaosocial']);

    return $retorno;
}

function formatarData($data, $formato = 'd/m/Y')
{
    return date_format($data, $formato);
}

function formatarDataComHora($date, $date_format = 'd/m/Y H:i:s')
{
    return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($date_format);
    //return date($formato, strtotime($data));
}

function formatarDataDes($data, $formato = 'd M Y H:m')
{
    return date($formato, strtotime($data));
}

function stringZero($string, $valorStr = 6)
{
    $quantidade = strlen($string);
    return str_pad("" . $string, $valorStr, "0", STR_PAD_LEFT);
}

function mascaraGenerica($val, $mask)
{
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function removerCNPJ($cnpj)
{
    return preg_replace("/\D+/", "", $cnpj);
}

function removerMascaraIE($ie)
{
    return preg_replace("/\D+/", "", $ie);
}

function removerMascaraCEP($cep)
{
    return str_replace("-", "", $cep);
}

function removerMascaraTelefone($telefone)
{
    return preg_replace("/[\(\)\.\s-]+/", "", $telefone);
}

function formatarCNPJCPF($cnpj_cpf)
{
    $cnpj_cpf = removerMascaraTelefone($cnpj_cpf);
    return strlen($cnpj_cpf) == 11 ? mascaraGenerica($cnpj_cpf, "###.###.###-##") : mascaraGenerica($cnpj_cpf, "##.###.###/####-##") ;
}

function formatarCNPJ($cnpj)
{
    return mascaraGenerica($cnpj, "##.###.###/####-##");
}

function formatarTelefone($phone)
{
    $phone = removerMascaraTelefone($phone);
    return strlen($phone) == 11 ? mascaraGenerica($phone, "(##) #####-####") : mascaraGenerica($phone, "(##) ####-####");
}

function formatarCPF($cpf)
{
    return mascaraGenerica($cpf, "###.###.###-##");
}

function valida_cnpj($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

    // Valida tamanho
    if (strlen($cnpj) != 14)
        return false;

    // Verifica se todos os digitos são iguais
    if (preg_match('/(\d)\1{13}/', $cnpj))
        return false;

    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
        return false;

    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
}

function valida_cpf($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function custoKit($produto): float
{
    $selecao = '';
    $total = 0.00;
    $custoKit = 0.00;

    try {
        $selecao = "select strqtd as Qtde, ";
        $selecao .= " (select farmed from estoqpro where id = strsec) as Custo ";
        $selecao .= " from cadasstr where ";
        $selecao .= " strpro = (select farkit from estoqpro where id = '" . $produto . "')";

        $result = DB::select(
            DB::raw(
                $selecao
            )
        );

        foreach ($result as $value) {
            $qtd = $value->Qtde ?? 0;
            $cus = $value->Custo ?? 0;
            $total += ($qtd * $cus);
        }

        $custoKit = $total;
    } catch (\Throwable $th) {
        $custoKit = 0.00;
    }

    return $custoKit;
}

function verificaAbertInv($dataB): string
{
    try {
        $selecao = '';
        $verificaAbertInv = '';
        $date = date_create();

        //$Selecao = "Select * from cadasdhi where ";
        $selecao = " dhidab = '" . $dataB . "'";
        $selecao .= " and ((dhihfe is null) "; // tem inventario aberto
        $selecao .= "  or  (dhidfe is null)) ";

        $cadasdhi = DB::table('cadasdhi')->whereRaw($selecao)->first();

        if ($cadasdhi) {
            if ($cadasdhi->dhidab == $date->format("H:i:s")) {
                $verificaAbertInv = $date->format("H:i:s");
            } else {
                $verificaAbertInv = "23:59:00";
            }
        } else {
            $verificaAbertInv = $date->format("H:i:s");
        }
    } catch (\Throwable $th) {
        throw $th;
    }

    return $verificaAbertInv;
}

function selectItens($Lista = [], $Campo = '', $Dig = 0)
{
    $Ret = "";
    for ($i = 0; $i < count((array)$Lista); $i++) {

        if (empty($Lista[$i])) {
            if (empty($Ret)) {
                $Ret .= " AND " . $Campo . " in('" . $Lista[$i] . "',";
            } else {
                $Ret .= $Lista[$i] . "',";
            }
        } else {
            if ($Dig > 0) {
                if (empty($Ret)) {
                    $Ret .= $Campo . " in('" . $Lista[$i] . "',";
                } else {
                    $Ret .= "'" . $Lista[$i] . "',";
                }
            } else {
                if (empty($Ret)) {
                    $Ret .=  $Campo . " in('" . $Lista[$i] . "',";
                } else {
                    $Ret .= "'" . $Lista[$i] . "',";
                }
            }
        }
    }

    if (empty($Ret)) {
        $Ret = "AND " . $Campo . " in('')";
    } else {
        $Ret = substr($Ret, 0, strlen($Ret) - 3) . "')";
    }

    return $Ret;
}

function xml_attribute($object, $attribute)
{
    if (isset($object[$attribute]))
        return (string) $object[$attribute];
}

function CalculaSaldo($Produto, $configID = 1)
{
    $config = Empresa::find($configID);
    $CalculaSaldo = 0;
    $Selecao = '';
    $Invent = 0;
    $Entradas = 0;
    $Saidas = 0;
    $Total = 0;
    try {

        $Selecao = "Select max(invdat) as Data, ";
        $Selecao .= "(Select invqtd as Invent from estoqinv where invdat = ";
        $Selecao .= " (Select max(invdat) from estoqinv where ";
        $Selecao .= " invpro = '" . $Produto . "'";
        $Selecao .= " and estoqinv.idempresafilial = '" . $config->id . "')";
        $Selecao .= " and invpro = '" . $Produto . "'";
        $Selecao .= " and estoqinv.idempresafilial = '" . $config->id . "') as Invent,";
        $Selecao .= " (select sum(movqtd) from estoqmov, estnatop where ";
        $Selecao .= " movope = estnatop.id ";
        $Selecao .= " and movpro = '" . $Produto . "'";
        $Selecao .= " and opetip = 'Entrada'";
        $Selecao .= " and estoqmov.idempresafilial  = '" . $config->id . "'";
        $Selecao .= " and movdat > max(invdat)) as Entradas,";
        $Selecao .= " (select sum(movqtd) from estoqmov, estnatop where ";
        $Selecao .= " movope = estnatop.id ";
        $Selecao .= " and movpro = '" . $Produto . "'";
        $Selecao .= " and opetip = 'Saida'";
        $Selecao .= " and estoqmov.idempresafilial  = '" . $config->id . "'";
        $Selecao .= " and movdat > max(invdat)) as Saidas ";
        $Selecao .= " from estoqinv where ";
        $Selecao .= " invpro = '" . $Produto . "'";
        $Selecao .= " and estoqinv.idempresafilial = '" . $config->id . "'";

        $Visual4 = DB::select($Selecao);

        if (count($Visual4) > 0) {

            $Entradas = $Visual4[0]->Entradas ?? 0;
            $Saidas = $Visual4[0]->Saidas ?? 0;
            $Invent = $Visual4[0]->Invent ?? 0;
        }

        $Total = $Invent + $Entradas - $Saidas;
        $estoqpro = Estoqpro::where('idempresafilial', $config->id)->find($Produto);
        if ($estoqpro) {
            $estoqpro->farsal = $Total;
            $estoqpro->save();
        }

        $CalculaSaldo = $Total;
    } catch (\Throwable $th) {
        throw new Exception("Erro Hekpers CalculaSaldo()\n" . $th->getMessage());
    }

    return $CalculaSaldo;
}

function CalculaMedio($Produto, $DataB, $Loja = 1)
{
    try {
        $Data = date_create();

        //Lelojas(FormAjmed.lojai);
        //FormAjmed.ProdutoI.text       = Produto;
        //FormAjmed.ProdutoF.text       = Produto;
        //FormAjmed.dataInicial.text    = datetostr(Data);
        //FormAjmed.dataFinal.text      = datetostr(DataB);
        //FormAjmed.DataInventario.text = '';
        //FormAjmed.lojai.itemindex     = 0;
        //FormAjmed.BotaoOkClick(nil);
        $cadasdhi = Cadasdhi::whereRaw('length(dhidfe) > 0')->select(DB::raw('max(dhidab) as Data'))->first();
        $cadasdhi2 = Cadasdhi::whereRaw('length(dhidfe) > 0')->select(DB::raw('max(Dhidab) + 1 as Data'))->first();
        // $Selecao = 'select max(dhidab) as Data from cadasdhi where length(dhidfe) > 0';

        $DataInv         = Carbon::parse($cadasdhi->Data);
        $txtDataInicial = Carbon::parse($cadasdhi2->Data);
        $txtDataFinal = Carbon::now();
        $cNomeArqInv      = 'estoqinv';

        //$Selecao  = ' Select ';
        $Selecao  = ' INVDAT as Data, ';
        $Selecao  .= ' Invpro as Produto, ';
        $Selecao  .= ' FARCCM as Ccm, ';
        $Selecao  .= ' FARPEL as Peso, ';
        $Selecao  .= ' Farpqi as Pqi,  ';
        $Selecao  .= ' Invqtd as Saldo, ';
        $Selecao  .= ' Invqtd as SaldoI, ';
        $Selecao  .= ' INVCUS as Unitario,    ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Frete, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Comissao, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Descarga, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as PerdaR, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Terceiros, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as VlIpi, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Entr, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Saida, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Total, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Liquido, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Despesas, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as MedioG, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as VlrEntrada, ';
        $Selecao  .= ' (case when Invqtd > 999999999 then 0.00 end) as Movvcx,     ';
        $Selecao  .=  quotedstr(space(01))    . ' as Openme, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Farbcc, ';
        $Selecao  .=  quotedstr('INVENTARIO') . ' as Nome, ';
        $Selecao  .=  quotedstr(space(12))    . ' as Controle, ';
        $Selecao  .=  quotedstr('INV')        . ' as Tp, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Nf, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Ope, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Unid, ';
        $Selecao  .=  quotedstr(space(01))    . ' as NomeOpe, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Tipo, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Op, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Kit, ';
        $Selecao  .=  quotedstr(space(01))    . ' as Opeccm, ';
        $Selecao  .=  ' CONCAT(' . quotedstr('P') . ' , ';
        $Selecao  .=  '  Invpro , ';
        $Selecao  .=  "  substring(date_format (invdat,'%d/%m/%Y'),7,4) , ";
        $Selecao  .=  "  substring(date_format (invdat,'%d/%m/%Y'),4,2) , ";
        $Selecao  .=  "  substring(date_format (invdat,'%d/%m/%Y'),1,2) , ";
        $Selecao  .=  quotedstr('AAAAAAA') . ' , ';
        $Selecao  .=  quotedstr(space(03)) . ' , ';
        $Selecao  .=  quotedstr(replicate('0', 12)) . ') as cIndice ';
        // $Selecao  .=  ' from                  ';
        // $Selecao  .=  $cNomeArqInv . ',';
        // $Selecao  .=  ' Estoqpro              ';
        // $Selecao  .=  ' where                 ';
        $SelecaoWhere  =  '       invpro  =       '    . quotedstr($Produto);
        $SelecaoWhere  .=  ' and   invdat =        '    . quotedstr($DataInv->format('Y-m-d'));
        $SelecaoWhere  .=  ' and   estoqinv.idempresafilial =        '    . quotedstr($Loja);
        $SelecaoWhere  .=  ' and   invpro = estoqpro.id ';
        $SelecaoWhere  .=  ' and ((farccm =           ' . quotedstr('Sim') . ')';
        $SelecaoWhere  .=  '  or  (farccm is null)    ';
        $SelecaoWhere  .=  '  or  (length(Farccm) = 0))  ';
        $SelecaoWhere  .=  ' and (not exists(Select Strpro from Estoqstr where strpro = estoqpro.id)) ';
        $SelecaoWhere  .=  ' and (length(Farbcc) = 0) ';
        $SelecaoWhere  .=  ' union all ';
        $SelecaoWhere  .=  ' Select Movdat as Data,     ';
        $SelecaoWhere  .=     ' movpro as Produto,  ';
        $SelecaoWhere  .=     ' farccm as Ccm,      ';
        $SelecaoWhere  .=     ' farpel as Peso,     ';
        $SelecaoWhere  .=     ' farpqi as Pqi,      ';
        $SelecaoWhere  .=     ' movqtd as Saldo,    ';
        $SelecaoWhere  .=     ' movqtd as SaldoI,   ';
        $SelecaoWhere  .=     ' (case  ';
        $SelecaoWhere  .=     '    when Opetip = ' . quotedstr('Entrada') . ' then  ifnull(movcus,0) + ';
        $SelecaoWhere  .=     '                                                    (ifnull(movcus,0) * (Movipi/100)) + ';
        $SelecaoWhere  .=     '                                                     ifnull(movvlf,0) + ';
        $SelecaoWhere  .=     '                                                     ifnull(movvlc,0) + ';
        $SelecaoWhere  .=     '                                                     ifnull(movvld,0) + ';
        $SelecaoWhere  .=     '                                                     ifnull(movvcx,0) + ';
        $SelecaoWhere  .=     '                                                     ifnull(movvcr,0) + ';
        $SelecaoWhere  .=     '                                                     ifnull(farvlt,0) + ';
        $SelecaoWhere  .=     '              case ';
        $SelecaoWhere  .=     '                 when   Opetip = ' . quotedstr('Entrada');
        $SelecaoWhere  .=     '                    and estnatop.id = 95 then ';
        $SelecaoWhere  .=     '                        ifnull(Movoud,0) / ifnull(Movqtd,0) ';
        $SelecaoWhere  .=     '              else  ';
        $SelecaoWhere  .=     '                 0  ';
        $SelecaoWhere  .=     '              end   ';
        $SelecaoWhere  .=     ' else               ';
        $SelecaoWhere  .=     '    Movcus          ';
        $SelecaoWhere  .=     ' end) as Unitario,  ';
        $SelecaoWhere  .=     ' (case when Movvlf > 0 then movvlf end) as Frete, ';
        $SelecaoWhere  .=     ' (case when Movvlc > 0 then movvlc end) as Comissao, ';
        $SelecaoWhere  .=     ' (case when Movvld > 0 then movvld end) as Descarga, ';
        $SelecaoWhere  .=     ' (case when Movvcr > 0 then movvcr end) as PerdaR, ';
        $SelecaoWhere  .=     ' (case when Farvlt > 0 then Farvlt end) as Terceiros, ';
        $SelecaoWhere  .=     ' (case when Opetip = ' . quotedstr('Entrada') . ' then (movcus * movqtd) * (ifnull(movipi,0)/100) else 0 end) as Vlipi, ';
        $SelecaoWhere  .=     ' (case when Opetip = ' . quotedstr('Entrada') . ' then movqtd end) as Entr, ';
        $SelecaoWhere  .=     ' (case when Opetip = ' . quotedstr('Saida')   . ' then movqtd end) as Saida, ';
        $SelecaoWhere  .=     ' (case ';
        $SelecaoWhere  .=     '    when Opetip = ' . quotedstr('Entrada') . ' then  (ifnull(movcus,0) + ';
        $SelecaoWhere  .=     '                                                     (ifnull(Movcus,0) * (ifnull(Movipi,0) / 100)) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvlf,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvlc,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvld,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvcx,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvcr,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Farvlt,0)) * ifnull(Movqtd,0) ';
        $SelecaoWhere  .=     ' end) as Total, ';
        $SelecaoWhere  .=     ' (case ';
        $SelecaoWhere  .=     '    when Opetip = ' . quotedstr('Entrada') . ' then  (ifnull(movcus,0) + ';
        $SelecaoWhere  .=     '                                                     (ifnull(Movcus,0) * (ifnull(Movipi,0) / 100)) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvlf,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvlc,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvld,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvcx,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Movvcr,0) + ';
        $SelecaoWhere  .=     '                                                      ifnull(Farvlt,0)) * ifnull(Movqtd,0) ';
        $SelecaoWhere  .=     ' end) as Liquido, ';
        $SelecaoWhere  .=     ' Movoud as Despesas, ';
        $SelecaoWhere  .=     ' Movmed as MedioG,   ';
        $SelecaoWhere  .=     ' Movcus as VlrEntrada, ';
        $SelecaoWhere  .=     ' Movvcx, ';
        $SelecaoWhere  .=     ' Openme, ';
        $SelecaoWhere  .=     ' Farbcc, ';
        $SelecaoWhere  .=     ' Movncl as Nome,     ';
        $SelecaoWhere  .=     ' Movdoc as Controle, ';
        $SelecaoWhere  .=     ' Opetip as Tp,       ';
        $SelecaoWhere  .=     ' Movdc2 as NF,       ';
        $SelecaoWhere  .=     ' Movope as Ope,      ';
        $SelecaoWhere  .=     ' Faruni as Unid,     ';
        $SelecaoWhere  .=     ' Opedes as NomeOpe,  ';
        $SelecaoWhere  .=     ' Fartip as Tipo,     ';
        $SelecaoWhere  .=     ' (Select Mvcnop from estoqmvc where estoqmvc.id = movdoc limit 1) as OP,  ';
        $SelecaoWhere  .=     ' (select strpro from cadasstr where strsec = movpro limit 1) as kit, ';
        $SelecaoWhere  .=     ' (case when length(Opeccm) = 0 then ' . quotedstr('2') . ' else opeccm end)  as Opeccm, ';
        $SelecaoWhere  .=     ' CONCAT(' . quotedstr('P') . ' , ';
        $SelecaoWhere  .=     '  Movpro , ';
        $SelecaoWhere  .=     "  substring(date_format (movdat,'%d/%m/%Y'),7,4) , ";
        $SelecaoWhere  .=     "  substring(date_format (movdat,'%d/%m/%Y'),4,2) , ";
        $SelecaoWhere  .=     "  substring(date_format (movdat,'%d/%m/%Y'),1,2) , ";
        $SelecaoWhere  .=     '  Opetip , ';
        $SelecaoWhere  .=     ' Movope  , ';
        $SelecaoWhere  .=     ' Movdoc) as cIndice  ';


        $SelecaoWhere  .=    ' From Estoqmov, ';
        $SelecaoWhere  .=    ' Estnatop, ';
        $SelecaoWhere  .=    ' Estoqpro  ';

        $SelecaoWhere  .=    ' where     ';


        $SelecaoWhere  .= '      movdat >=           ' . quotedstr($txtDataInicial->format('Y-m-d'));
        $SelecaoWhere  .= ' and  movdat <=           ' . quotedstr($txtDataFinal->format('Y-m-d'));
        $SelecaoWhere  .= ' and  estoqmov.idempresafilial  =           ' . quotedstr($Loja);
        $SelecaoWhere  .= ' and  movpro  =           ' . quotedstr($Produto);
        $SelecaoWhere  .= ' and  movope = estnatop.id     ';
        $SelecaoWhere  .= ' and  movpro = estoqpro.id     ';
        $SelecaoWhere  .= '   and ((Openme =         ' . quotedstr('Nao') . ')';
        $SelecaoWhere  .= '    or  (Openme is null)  ';
        $SelecaoWhere  .= '    or  (length(Openme) = 0))';
        $SelecaoWhere  .= ' and  (Movqtd > 0)        ';
        $SelecaoWhere  .= ' and ((Farccm =           ' . quotedstr('Sim') . ')';
        $SelecaoWhere  .= '  or  (Farccm is null)    ';
        $SelecaoWhere  .= '  or  (length(Farccm) = 0))  ';
        $SelecaoWhere  .= ' and (not exists(Select Strpro from Estoqstr      ';
        $SelecaoWhere  .=                                ' where             ';
        $SelecaoWhere  .=                                ' Strpro = estoqpro.id)) ';
        $SelecaoWhere  .= ' and ((length(Farbcc) = 0)   ';
        $SelecaoWhere  .= '  or  (Farbcc is null ))  ';
        // $Selecao  .= ' order by ';
        //$Selecao  .= ' cIndice  ';
        $dados = DB::table('estoqinv')->select(DB::raw($Selecao))->join('estoqpro', 'estoqinv.invpro', '=', 'estoqpro.id')->whereRaw($SelecaoWhere)->orderBy(DB::raw('cIndice'))->get();

        $SaldoAnterior = 0;
        $MedioAnterior = 0;
        $NomeAnterior = "";
        $nEtapa = 2;
        $Data       = date_create();
        $Medio      = 0;
        $Atual      = 0;
        $Total      = 0;
        $Peso       = 0;
        $cTipo      = '';
        $nTerceiros = 0;
        $teste = 0;
        foreach ($dados as $key => $value) {

            // if netapa = 2 then
            //     BotaoGravaMedioProduto.enabled = false;
            if (trim($value->Nome) == 'INVENTARIO') // inventario
            {

                $value->Saldo = $value->SaldoI;
                $value->Medio = $value->Unitario;

                $SaldoAnterior   = $value->Saldo;
                $MedioAnterior   = $value->Medio;
                $NomeAnterior    = $value->Nome;
            } else {
                $value->Saldo = $SaldoAnterior + $value->Entr - $value->Saida;
            }

            if ($value->Saldo < 0) {
                if ($value->Tp == 'Entrada') {
                    $value->Medio = $value->Unitario;
                    $MedioAnterior   = $value->Medio;
                } else {
                    if ($value->Tp == 'Saida')
                        $value->Medio = $MedioAnterior;
                }
            } else {

                if (
                    ($value->Tp == 'Entrada' && ($value->Ope <= 28 || $value->Ope >= 31))  ||
                    (($value->Ope == 29 || $value->Ope == 30) && $NomeAnterior == 'INVENTARIO' && $SaldoAnterior <= 0)
                ) {
                    if (
                        $value->Opeccm == '1' ||
                        ($value->Ope == 107 && strlen($value->Op) > 0)    ||
                        ($value->Ope == 107 && strlen($value->Kit) > 0)    ||
                        ($value->Ope == 107 && $value->Pqi > 0)
                    ) {
                        //PainelMsg.Caption = 'Calculando Custo Médio Controle: ' + $value->Controle;


                        $T1 = $SaldoAnterior       * $MedioAnterior;
                        $T2 = $value->Entr * $value->Unitario;
                        $T3 = $value->Saldo;

                        try {
                            $value->Medio = ($T1 + $T2) / $T3;
                        } catch (\Throwable $th) {
                            $value->Medio = $MedioAnterior;
                        }

                        $SaldoAnterior   = $value->Saldo;
                        $MedioAnterior   = $value->Medio;
                        $NomeAnterior    = $value->Nome;
                    } else {
                        $value->Medio = $MedioAnterior;

                        $SaldoAnterior   = $value->Saldo;  // adc 13/06/2011
                        $MedioAnterior   = $value->Medio;   // adc 13/06/2011
                        $NomeAnterior    = $value->Nome;
                    }
                } else {
                    $value->Medio = $MedioAnterior;

                    $SaldoAnterior   = $value->Saldo;
                    $MedioAnterior   = $value->Medio;
                    $NomeAnterior    = $value->Nome;
                }
            }
        }

        foreach ($dados as $key => $value) {

            if ($value->Ccm  == 'Nao') {
            } else {

                if ($value->Medio == 0) {
                } else {
                    $Data    = $value->Data;
                    $Produto = $value->Produto;
                    $Medio   = 0;
                    $Peso    = 0;

                    foreach ($dados as $key2 => $value2) {

                        if ($Produto == $value2->Produto && $Data == $value2->Data) {

                            $Medio = $value2->Medio;
                            $Peso  = $value2->Peso;
                            $cTipo = $value2->Tp;
                        }
                    }
                    //**********************************************************************************************************************************************************************
                    //--------------------------------------------------
                    //--- Atualiza o custo medio no cadastro de produtos
                    //--------------------------------------------------
                    //Modsql.Alteracao('Farmed', Medio);
                    //Modsql.Gravacao(Modsql.Estoqpro,'Farpro = ' + quotedstr(Produto));
                    $estoqpro = Estoqpro::where('idempresafilial', $Loja)->where('id', '=', $Produto)->first();
                    $estoqpro->farmed = $Medio;
                    $estoqpro->save();
                    //--------------------------------------------------
                    //--- Atualiza o movimento do produto
                    //--------------------------------------------------
                    $produtoMov = Estoqmov::where('idempresafilial', $Loja)->where('movdat', '>=', $Data)->where('movpro', $Produto)->first();

                    if ($produtoMov) {
                        $produtoMov->movmed = $Medio;
                        $produtoMov->save();
                    }
                    // Modsql.alteracao('Movmed', $Medio);
                    // Modsql.Gravacao(Modsql.Estoqmov, '     idempresafilial  = ' + QuotedStr(Lojai.text) +
                    //                                  ' and Movdat >= ' + QuotedStr(formatdatetime(MascaraData, $Data)) +
                    //                                  ' and Movpro  = ' + quotedstr($Produto));

                    // //**********************************************************************************************************************************************************************
                    // //-------------------------------------------------------------------------------------
                    // //--- Atualiza os produtos do qual é base de calculo ex: batata 50 kg -> atualiza 2kg
                    // //-------------------------------------------------------------------------------------
                    $estoqpros = DB::table('estoqpro')->where('farbcc', '=', $Produto)->get();
                    foreach ($estoqpros as $key => $value) {
                        $valor = ($Medio / $Peso) * $value->farpel;
                        DB::update('update estoqpro set farmed = ' . $valor . ' where farbcc = ?', [$value->id]);
                    }

                    // $Selecao = ' Update estoqpro set ' +
                    //            ' farmed =            ' + quotedstr(strtran(Formatfloat('#####0.00', $Medio / $Peso) ,',','.'))  + ' * X.farpel ' +
                    //            ' from estoqpro X     ' +
                    //            ' where               ' +
                    //            ' farbcc =            ' + quotedstr($Produto);

                    //Modsql.ExecutaInstrucao(Modsql.Estoqpro, Selecao);

                    // //--------------------------------------------------------------------------------------------------
                    // //--- Atualiza o movimento dos produtos do qual é base de calculo   ex: batata 50 kg -> atualiza 2kg
                    // //--------------------------------------------------------------------------------------------------
                    $estoqpros = DB::table('estoqpro')->select(DB::raw('id as Produto, Farpel as Peso'))->where('farbcc', '=', $Produto)->get();

                    foreach ($estoqpros as $key => $value) {
                        DB::update('update estoqmov set movmed = ? where idempresafilial = ? and movdat >= ? and movpro = ?', [($Medio / $Peso) * $value->Peso, $Loja, $Data, $value->Produto]);
                    }

                    // //**********************************************************************************************************************************************************************
                    // //-------------------------------------------------------------------------------------
                    // //--- Atualiza o custo das receitas se o item sendo gravado for uma M/P  -> ex: bandeja
                    // //-------------------------------------------------------------------------------------
                    $receitas = DB::table('estoqstr as X')->select(
                        DB::raw('strpro as Produto,
                        (select Farvlt from estoqpro where estoqpro.id = strpro) as Terceiros,
                        (select sum(Strqtd * Farmed) from estoqpro,estoqstr Y where
                                                          Y.Strsec = estoqpro.id
                                                      and Y.Strpro = X.strpro) as Custo
                        ')
                    )->where('idempresafilial', $Loja)->where('Strsec', '=', $Produto)->groupBy('strpro')->get();

                    foreach ($receitas as $key => $receita) {
                        $nTerceiros = $receita->Terceiros;

                        DB::update('update estoqpro set farmed = ? where id = ?', [$receita->Custo + $nTerceiros, $receita->Produto]);

                        //----------------------------------
                        //--- Atualiza o movimento
                        //----------------------------------
                        DB::update('update estoqmov set movmed = ? where idempresafilial = ? and movdat >= ? and movpro = ?',  [$receita->Custo + $nTerceiros, $Loja, $Data, $receita->Produto]);
                    }

                    // //**********************************************************************************************************************************************************************
                    // //--------------------------------------------------------------------------------------------
                    // //--- Atualiza o custo das receitas se o item sendo gravado for uma M/P de outra materia prima
                    // //--- ex: batata 50kg -> batata 2kg -> usa numa maionese
                    // //--------------------------------------------------------------------------------------------

                    $receitas = DB::table('estoqpro as X')->select(
                        DB::raw(
                            ' farbcc as MP,
                                    (select Fardes from estoqpro where id = X.farbcc) as Nome_MP,
                                    (select Farmed from estoqpro where id = X.farbcc) as Custo_MP,

                                    X.id as Item_Produzido,
                                    fardes as Nome_Item_Produzido,
                                    Farmed as Custo_Item_Produzido,
                                    Strpro as Receita,
                                    (select Fardes from estoqpro where X.id = strpro) as Nome_Receita,
                                    (select sum(strqtd * farmed) from estoqpro,
                                                          estoqstr
                                                          where
                                                              strsec = X.id
                                                          and strpro = Y.strpro) as Custo_Receita'
                        )
                    )->join('estoqstr as Y', 'X.id', '=', 'Y.strsec')

                        ->whereRaw('farbcc = ' . $Produto . ' and strsec = X.id')->get();

                    foreach ($receitas as $key => $receita) {
                        $nTerceiros = $receita->Terceiros;

                        DB::update('update estoqpro set farmed = ? where id = ?', [$receita->Custo_Receita, $receita->Receita]);

                        //----------------------------------
                        //--- Atualiza o movimento
                        //----------------------------------
                        DB::update('update estoqmov set movmed = ? where idempresafilial = ? and movdat >= ? and movpro = ?',  [$receita->Custo_Receita, $Loja, $Data, $receita->Receita]);
                    }
                }
            }
        }
        ////   FormAjmed.BotaoAtualizaMovimentoClick(nil); // isolado para gravar mais rapido ***
        //FormAjmed.BotaoGravaMedioProdutoClick(nil);
    } catch (\Throwable $th) {

        throw new Exception("Erro Helpers CalculaSaldo()\n" . $th->getMessage() . ' - ' . $th->getLine());
    }
}

function returnZero($number)
{
    if ($number < 0)
        return 0;
    return $number;
}

function space($qtd)
{
    $string = "";
    for ($i = 0; $i < intval($qtd); $i++) {
        $string .= " ";
    }

    return $string;
}

function quotedstr($string)
{

    return "'" . $string . "'";
}

function retornaControle()
{
    $id = 0;

    try {

        $id = DB::table('estoqmvc')->insertGetId([]);
    } catch (\Throwable $th) {
        throw new Exception("Erro Helpers retornaControle()\n" . $th->getMessage());
    }
    return $id;
}
