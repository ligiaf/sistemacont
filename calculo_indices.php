<?php

function calcula_indices($conexao)
{
    $resultados = array();

//Cobertura de juros com caixa = FCO antes de juros e impostos / juros
    $consulta = "SELECT ano1_dfc FROM DFC WHERE conta_dfc = 'ATIVIDADES OPERACIONAIS'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $fco = (float)$v['ano1_dfc'];
    $consulta = "SELECT ano1_dfc FROM DFC WHERE conta_dfc = 'Pagamentos de impostos e juros'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pj = (float)$v['ano1_dfc'];
    $cjc = ($fco - $pj) / $pj;
    $resultados[0] = $cjc;

//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível
    $consulta = "SELECT ano1_dfc FROM DFC WHERE conta_dfc = 'Recebimento de juros e dividendos'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $dividendos = (float)$v['ano1_dfc'];
    $consulta = "SELECT ano1_bp FROM BP WHERE conta_bp = 'PASSIVO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pc = (float)$v['ano1_bp'];
    $consulta = "SELECT ano1_bp FROM BP WHERE conta_bp = 'PASSIVO NAO CIRCULANTE'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pnc = (float)$v['ano1_bp'];
    $passivo = $pc + $pnc;
    $cdc = ($fco - $dividendos) / $passivo;
    $resultados[1] = $cdc;


//Cobertura de dividendos com caixa = FCO / dividendos totais
    $cddc = $fco / $dividendos;
    $resultados[2] = $cddc;

//Qualidade das vendas = caixa das vendas / vendas
    $consulta = "SELECT ano1_dre FROM DRE WHERE conta_dre = 'Receita Liquida'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $rl = (float)$v['ano1_dre'];
    $consulta = "SELECT ano1_dre FROM DRE WHERE conta_dre = 'Receita Bruta'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $rb = (float)$v['ano1_dre'];
    $qv = $rb / $rl;
    $resultados[3] = $qv;

//Qualidade do resultado =  FCO / resultado operacional
    $consulta = "SELECT ano1_dre FROM DRE WHERE conta_dre = 'Lucro Operacional'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $lo = (float)$v['ano1_dre'];
    $qr = $fco / $lo;
    $resultados[4] = $qr;

//Aquisições de capital = (FCO - dividendo total) / caixa pago por investimento de capital
    $consulta = "SELECT ano1_bp FROM BP WHERE conta_bp = 'Imobilizado'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $imob = (float)$v['ano1_bp'];
    $aqc = ($fco - $passivo) / $imob;
    $resultados[5] = $aqc;

//Investimento/financiamento = fluxo de caixa líquido para investimentos / fluxo de caixa líquido de financiamentos
    $consulta = "SELECT ano1_dfc FROM DFC WHERE conta_dfc = 'ATIVIDADES DE INVESTIMENTO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $investimento = (float)$v['ano1_dfc'];
    $consulta = "SELECT ano1_dfc FROM DFC WHERE conta_dfc = 'ATIVIDADES DE FINANCIAMENTO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $financiamento = (float)$v['ano1_dfc'];
    $invfin = $investimento / $financiamento;
    $resultados[6] = $invfin;

//Retorno do caixa sobre os ativos =  FCO antes juros e impostos / ativos totais
    $consulta = "SELECT ano1_bp FROM BP WHERE conta_bp = 'ATIVO CIRCULANTE'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $ac = (float)$v['ano1_bp'];
    $consulta = "SELECT ano1_bp FROM BP WHERE conta_bp = 'ATIVO NAO CIRCULANTE'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $anc = (float)$v['ano1_bp'];
    $ativo = $ac + $anc;
    $rcsa = ($fco - $pj) / $ativo;
    $resultados[7] = $rcsa;

//Retorno sobre passivo e patrimônio líquido = FCO / (patrimônio líquido + exigível a longo prazo)
    $consulta = "SELECT ano1_bp FROM BP WHERE conta_bp = 'PATRIMONIO LIQUIDO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pl = (float)$v['ano1_bp'];
    $rsppl = $fco / ($pl + $pnc);
    $resultados[8] = $rsppl;

//Retorno sobre o patrimônio líquido = FCO / patrimônio líquido
    $rspl = $fco / $pl;
    $resultados[9] = $rspl;

//-------------------Ano 2--------------------------------------

//Cobertura de juros com caixa = FCO antes de juros e impostos / juros
    $consulta = "SELECT ano2_dfc FROM DFC WHERE conta_dfc = 'ATIVIDADES OPERACIONAIS'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $fco2 = (float)$v['ano2_dfc'];
    $consulta = "SELECT ano2_dfc FROM DFC WHERE conta_dfc = 'Pagamentos de impostos e juros'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pj2 = (float)$v['ano2_dfc'];
    $cjc2 = ($fco2 - $pj2) / $pj2;
    $resultados[10] = $cjc2;

//Cobertura de dívidas com caixa= (FCO – dividendo total) / exigível
    $consulta = "SELECT ano2_dfc FROM DFC WHERE conta_dfc = 'Recebimento de juros e dividendos'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $dividendos2 = (float)$v['ano2_dfc'];
    $consulta = "SELECT ano2_bp FROM BP WHERE conta_bp = 'PASSIVO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pc2 = (float)$v['ano2_bp'];
    $consulta = "SELECT ano2_bp FROM BP WHERE conta_bp = 'PASSIVO NAO CIRCULANTE'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pnc2 = (float)$v['ano2_bp'];
    $passivo2 = $pc2 + $pnc2;
    $cdc2 = ($fco2 - $dividendos2) / $passivo2;
    $resultados[11] = $cdc2;


//Cobertura de dividendos com caixa = FCO / dividendos totais
    $cddc2 = $fco2 / $dividendos2;
    $resultados[12] = $cddc2;

//Qualidade das vendas = caixa das vendas / vendas
    $consulta = "SELECT ano2_dre FROM DRE WHERE conta_dre = 'Receita Liquida'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $rl2 = (float)$v['ano2_dre'];
    $consulta = "SELECT ano2_dre FROM DRE WHERE conta_dre = 'Receita Bruta'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $rb2 = (float)$v['ano2_dre'];
    $qv2 = $rb2 / $rl2;
    $resultados[13] = $qv2;

//Qualidade do resultado =  FCO / resultado operacional
    $consulta = "SELECT ano2_dre FROM DRE WHERE conta_dre = 'Lucro Operacional'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $lo2 = (float)$v['ano2_dre'];
    $qr2 = $fco2 / $lo2;
    $resultados[14] = $qr2;

//Aquisições de capital = (FCO - dividendo total) / caixa pago por investimento de capital
    $consulta = "SELECT ano2_bp FROM BP WHERE conta_bp = 'Imobilizado'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $imob2 = (float)$v['ano2_bp'];
    $aqc2 = ($fco2 - $passivo2) / $imob2;
    $resultados[15] = $aqc2;

//Investimento/financiamento = fluxo de caixa líquido para investimentos / fluxo de caixa líquido de financiamentos
    $consulta = "SELECT ano2_dfc FROM DFC WHERE conta_dfc = 'ATIVIDADES DE INVESTIMENTO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $investimento2 = (float)$v['ano2_dfc'];
    $consulta = "SELECT ano2_dfc FROM DFC WHERE conta_dfc = 'ATIVIDADES DE FINANCIAMENTO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $financiamento2 = (float)$v['ano2_dfc'];
    $invfin2 = $investimento2 / $financiamento2;
    $resultados[16] = $invfin2;

//Retorno do caixa sobre os ativos =  FCO antes juros e impostos / ativos totais
    $consulta = "SELECT ano2_bp FROM BP WHERE conta_bp = 'ATIVO CIRCULANTE'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $ac2 = (float)$v['ano2_bp'];
    $consulta = "SELECT ano2_bp FROM BP WHERE conta_bp = 'ATIVO NAO CIRCULANTE'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $anc2 = (float)$v['ano2_bp'];
    $ativo2 = $ac2 + $anc2;
    $rcsa2 = ($fco2 - $pj2) / $ativo2;
    $resultados[17] = $rcsa2;

//Retorno sobre passivo e patrimônio líquido = FCO / (patrimônio líquido + exigível a longo prazo)
    $consulta = "SELECT ano2_bp FROM BP WHERE conta_bp = 'PATRIMONIO LIQUIDO'";
    $resultado = mysqli_query($conexao, $consulta) or die(mysqli_error());
    while ($v = mysqli_fetch_assoc($resultado))
        $pl2 = (float)$v['ano2_bp'];
    $rsppl2 = $fco / ($pl2 + $pnc2);
    $resultados[18] = $rsppl2;

//Retorno sobre o patrimônio líquido = FCO / patrimônio líquido
    $rspl2 = $fco2 / $pl2;
    $resultados[19] = $rspl2;

    return $resultados;
}

