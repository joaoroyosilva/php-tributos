<?php

namespace PhpTributos\Impostos\Csosn;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcms;
use PhpTributos\Impostos\Csosn\Base\CsosnBase;
use PhpTributos\Impostos\Tributavel;

class Csosn900 extends CsosnBase
{
    /**
     * @var Csosn
     */
    protected $csosn = Csosn::Csosn900;

    /**
     * @var ModalidadeDeterminacaoBcIcms
     */
    public $modalidadeDeterminacaoBcIcms;

    /**
     * @var float
     */
    public $valorBcIcms;

    /**
     * @var float
     */
    public $percentualReducaoIcmsBc;

    /**
     * @var float
     */
    public $percentualIcms;

    /**
     * @var float
     */
    public $valorIcms;

    /**
     * @var ModalidadeDeterminacaoBcIcmsSt
     */
    public $modalidadeDeterminacaoBcIcmsSt;

    /**
     * @var float
     */
    public $valorBcIcmsSt;

    /**
     * @var float
     */
    public $percentualReducaoIcmsStBc;

    /**
     * @var float
     */
    public $percentualIcmsSt;

    /**
     * @var float
     */
    public $valorIcmsSt;

    /**
     * @var float
     */
    public $percentualMva;

    /**
     * @var float
     */
    public $percentualCredito;

    /**
     * @var float
     */
    public $valorCredito;

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
        $this->calculaIcms($tributavel);
        $this->calculaIcmsSt($tributavel);
        $this->calculaCredito($tributavel);
    }

    private function calculaCredito(Tributavel $tributavel)
    {
        $this->percentualCredito = $tributavel->percentualCredito;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $resultadoCalculoCredito = $facade->calculaCreditoIcms();
        $this->valorCredito = $resultadoCalculoCredito->valor;
    }

    private function calculaIcms(Tributavel $tributavel)
    {
        $this->percentualIcms = $tributavel->percentualIcms;
        $this->percentualReducaoIcmsBc = $tributavel->percentualReducao;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $tributavel->valorIpi = $facade->calculaIpi()->valor;

        $resultadoCalculoIcms = $facade->calculaIcms();
        $this->valorBcIcms = $resultadoCalculoIcms->baseCalculo;
        $this->valorIcms = $resultadoCalculoIcms->valor;
    }

    private function calculaIcmsSt(Tributavel $tributavel)
    {
        $this->percentualIcmsSt = $tributavel->percentualIcmsSt;
        $this->percentualReducaoIcmsStBc = $tributavel->percentualReducaoIcmsStBc;
        $this->percentualMva = $tributavel->percentualMva;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $tributavel->valorIpi = $facade->calculaIpi()->valor;

        $resultadoCalculoIcmsSt = $facade->calculaIcmsSt();
        $this->valorBcIcmsSt = $resultadoCalculoIcmsSt->baseCalculoIcmsSt;
        $this->valorIcmsSt = $resultadoCalculoIcmsSt->valorIcmsSt;
    }
}
