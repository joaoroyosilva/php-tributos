<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst60 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst60;

    /**
     * @var float
     */
    public $percentualBcStRetido = 0;

    /**
     * @var float
     */
    public $valorBcStRetido = 0;

    /**
     * @var float
     */
    public $valorCreditoOutorgadoOuPresumido = 0;

    /**
     * @var float
     */
    public $valorIcmsStRetido = 0;

    /**
     * @var float
     */
    public $percentualSt = 0;

    public function calcula(Tributavel $tributavel): void
    {
        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $resultadoCalculoIcms = $facade->calculaIcmsSt();

        $this->percentualBcStRetido = $tributavel->percentualReducaoSt;
        $this->valorBcStRetido = $resultadoCalculoIcms->baseCalculoIcmsSt;
        $this->valorIcmsStRetido = $resultadoCalculoIcms->valorIcmsSt;

        $this->valorCreditoOutorgadoOuPresumido = $facade->calculaCreditoIcms()->valor;

        $this->percentualSt = $tributavel->percentualIcmsSt + $tributavel->percentualFcpSt;
    }
}
