<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcmsSt;
use PhpTributos\Impostos\Tributavel;

class Cst10 extends Cst00
{

    /**
     * @var Cst
     */
    public $cst = Cst::Cst10;

    /**
     * @var ModalidadeDeterminacaoBcIcmsSt
     */
    public $modalidadeDeterminacaoBcIcmsSt = ModalidadeDeterminacaoBcIcmsSt::MargemValorAgregado;

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
    public $valorBcFcp = 0;

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
        parent::calcula($tributavel);

        $this->percentualMva = $tributavel->percentualMva;
        $this->percentualReducaoSt = $tributavel->percentualReducaoSt;
        $this->percentualIcmsSt = $tributavel->percentualIcmsSt;
        $this->percentualFcpSt = $tributavel->percentualFcpSt;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $tributavel->valorIpi = $facade->calculaIpi();

        $resultadoCalculoIcmsSt = $facade->calculaIcmsSt();
        $resultadoCalculoFcpSt = $facade->calculaFcpSt();

        $this->valorBcIcmsSt = $resultadoCalculoIcmsSt->baseCalculoIcmsSt;
        $this->valorIcmsSt = $resultadoCalculoIcmsSt->valorIcmsSt;

        $this->valorBcFcp = $facade->calculaFcp()->baseCalculo;
        $this->valorBcFcpSt = $resultadoCalculoFcpSt->baseCalculoFcpSt;
        $this->valorFcpSt = $resultadoCalculoFcpSt->valorFcpSt;
    }
}
