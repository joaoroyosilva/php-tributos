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
}
