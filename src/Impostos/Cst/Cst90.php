<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\Documento;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcms;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcmsSt;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst90 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst90;

    /**
     * @var ModalidadeDeterminacaoBcIcms
     */
    public $modalidadeDeterminacaoBcImcs;

    /**
     * @var ModalidadeDeterminacaoBcIcmsSt
     */
    public $modalidadeDeterminacaoBcImcsSt;

    /**
     * @var float
     */
    public $valorBcIcms = 0;

    /**
     * @var float
     */
    public $percentualReducaoIcmsBc = 0;

    /**
     * @var float
     */
    public $percentualIcms = 0;

    /**
     * @var float
     */
    public $valorIcms = 0;

    /**
     * @var float
     */
    public $percentualMva = 0;

    /**
     * @var float
     */
    public $percentualReducaoSt = 0;

    /**
     * @var float
     */
    public $valorBcIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualIcmsSt = 0;

    /**
     * @var float
     */
    public $valorIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualCredito = 0;

    /**
     * @var float
     */
    public $valorCredito = 0;

    /**
     * @var float
     */
    public $valorBcFcp = 0;

    /**
     * @var float
     */
    public $percentualFcp = 0;

    /**
     * @var float
     */
    public $valorFcp = 0;

    /**
     * @var float
     */
    public $valorBcFcpSt = 0;

    /**
     * @var float
     */
    public $percentualFcpSt = 0;

    /**
     * @var float
     */
    public $valorFcpSt = 0;

    public function calcula(Tributavel $tributavel): void
    {
        $this->calculaIcms($tributavel);
        $this->calculaIcmsSt($tributavel);
        $this->calculaCredito($tributavel);
        $this->calculaFcp($tributavel);
        $this->calculaFcpSt($tributavel);
    }

    private function calculaCredito(Tributavel $tributavel): void
    {
        $this->percentualCredito = $tributavel->percentualCredito;

        switch ($tributavel->documento) {
            case Documento::NFe:
                $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);
                $resultadoCalculoCredito = $facade->calculaCreditoIcms();
                $this->valorCredito = $resultadoCalculoCredito->valor;
                break;
            case Documento::CTe:
                $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);
                $resultadoIcms = $facade->calculaIcms();
                $this->valorCredito = $resultadoIcms->valor * $tributavel->percentualCredito / 100;
                break;
            default:
                break;
        }
    }

    private function calculaIcmsSt(Tributavel $tributavel)
    {
        $this->percentualMva = $tributavel->percentualMva;
        $this->percentualReducaoSt = $tributavel->percentualReducaoSt;
        $this->percentualIcmsSt = $tributavel->percentualIcmsSt;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $tributavel->valorIpi = $facade->calculaIpi()->valor;

        $resultadoCalculoIcmsSt = $facade->calculaIcmsSt();
        $this->valorBcIcmsSt = $resultadoCalculoIcmsSt->baseCalculoIcmsSt;
        $this->valorIcmsSt = $resultadoCalculoIcmsSt->valorIcmsSt;
    }

    private function calculaIcms(Tributavel $tributavel)
    {
        $this->percentualReducao = $tributavel->percentualReducao;
        $this->percentualIcms = $tributavel->percentualIcms;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $tributavel->valorIpi = $facade->calculaIpi()->valor;

        $resultadoCalculoIcms = $facade->calculaIcms();
        $this->valorBcIcms = $resultadoCalculoIcms->baseCalculo;
        $this->valorIcms = $resultadoCalculoIcms->valor;
    }

    private function calculaFcp(Tributavel $tributavel)
    {
        $this->percentualFcp = $tributavel->percentualFcp;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $resultadoCalculoFcp = $facade->calculaFcp();
        $this->valorBcFcp = $resultadoCalculoFcp->baseCalculo;
        $this->valorFcp = $resultadoCalculoFcp->valor;
    }

    private function calculaFcpSt(Tributavel $tributavel)
    {
        $this->percentualFcpSt = $tributavel->percentualFcpSt;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $resultadoCalculoFcpSt = $facade->calculaFcpSt();
        $this->valorBcFcpSt = $resultadoCalculoFcpSt->baseCalculo;
        $this->valorFcpSt = $resultadoCalculoFcpSt->valorFcpSt;
    }
}
