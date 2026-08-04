<?php

namespace PhpTributos\Impostos;

use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\CstIpi;
use PhpTributos\Flags\CstPisCofins;
use PhpTributos\Flags\Documento;

abstract class Tributavel
{
    /**
     * @var Documento
     */
    public $documento = Documento::NFe;

    /**
     * @var Cst
     */
    public $cst;

    /**
     * @var Csosn
     */
    public $csosn;

    /**
     * @var CstPisCofins
     */
    public $cstPisCofins;

    /**
     * @var CstIpi
     */
    public $cstIpi;

    /**
     * @var bool
     */
    public $isServico = false;

    /**
     * @var bool
     */
    public $deduzIcmsPisCofins = false;

    /**
     * @var float
     */
    public $valorProduto = 0;

    /**
     * @var float
     */
    public $frete = 0;

    /**
     * @var float
     */
    public $seguro = 0;

    /**
     * @var float
     */
    public $outrasDespesas = 0;

    /**
     * @var float
     */
    public $desconto = 0;

    /**
     * @var float
     */
    public $valorIpi = 0;

    /**
     * @var float
     */
    public $valorIcms = 0;

    /**
     * @var float
     */
    public $percentualReducao = 0;

    /**
     * @var float
     */
    public $percentualReducaoIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $quantidadeProduto = 0;

    /**
     * @var float
     */
    public $percentualIcms = 0;

    /**
     * @var float
     */
    public $percentualIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $percentualCredito = 0;

    /**
     * @var float
     */
    public $percentualDiferimento = 0;

    /**
     * @var float
     */
    public $percentualDifalInterna = 0;

    /**
     * @var float
     */
    public $percentualDifalInterstadual = 100;

    /**
     * @var float
     */
    public $percentualFcp = 0;

    /**
     * @var float
     */
    public $percentualMva = 0;

    /**
     * @var float
     */
    public $percentualIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualIpi = 0;

    /**
     * @var bool
     */
    public $icmsSobreIpi = false;

    /**
     * @var float
     */
    public $percentualCofins = 0;

    /**
     * @var float
     */
    public $percentualPis = 0;

    /**
     * @var float
     */
    public $percentualReducaoSt = 0;

    /**
     * @var float
     */
    public $percentualIssqn = 0;

    /**
     * @var float
     */
    public $percentualRetPis = 0;

    /**
     * @var float
     */
    public $percentualRetCofins = 0;

    /**
     * @var float
     */
    public $percentualRetCsll = 0;

    /**
     * @var float
     */
    public $percentualRetIrrf = 0;

    /**
     * @var float
     */
    public $percentualRetInss = 0;

    /**
     * @var float
     */
    public $percentualFcpSt = 0;

    /**
     * @var float
     */
    public $percentualFederal = 0;

    /**
     * @var float
     */
    public $percentualFederalImportados = 0;

    /**
     * @var float
     */
    public $percentualEstadual = 0;

    /**
     * @var float
     */
    public $percentualMunicipal = 0;

    /**
     * @var float
     */
    public $percentualCbs = 0;

    /**
     * @var float
     */
    public $reducaoCbs = 0;

    /**
     * @var float
     */
    public $percentualRedutorCompraGov = 0;

    /**
     * @var float
     */
    public $percentualCreditoPresumidoCbs = 0;

    /**
     * @var float
     */
    public $percentualCreditoPresumidoIbs = 0;

    /**
     * @var float
     */
    public $percentualDiferimentoCbs = 0;

    /**
     * @var float
     */
    public $percentualIbsUf = 0;

    /**
     * @var float
     */
    public $reducaoIbsUf = 0;

    /**
     * @var float
     */
    public $percentualDiferimentoIbsUf = 0;

    /**
     * @var float
     */
    public $percentualIbsMun = 0;

    /**
     * @var float
     */
    public $reducaoIbsMun = 0;

    /**
     * @var float
     */
    public $percentualDiferimentoIbsMun = 0;

    /**
     * O `cClassTrib` do item exige o grupo `gTribRegular`? (indicador de tributação regular do
     * catálogo). Quando falso, o cálculo da tributação regular devolve tudo zerado.
     *
     * @var bool
     */
    public $possuiTributacaoRegular = false;

    /**
     * Alíquota NOMINAL de IBS estadual que valeria para o `cClassTribReg`. Vem de fora zerada
     * ou não conforme a geografia — NÃO é `percentualIbsUf`: quando há tributação regular a
     * alíquota do item é zero por definição, então não há de onde derivar.
     *
     * @var float
     */
    public $percentualRegularIbsUf = 0;

    /**
     * @var float
     */
    public $reducaoRegularIbsUf = 0;

    /**
     * @var float
     */
    public $percentualRegularIbsMun = 0;

    /**
     * @var float
     */
    public $reducaoRegularIbsMun = 0;

    /**
     * @var float
     */
    public $percentualRegularCbs = 0;

    /**
     * @var float
     */
    public $reducaoRegularCbs = 0;
}
