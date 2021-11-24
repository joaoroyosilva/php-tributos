<?php

namespace PhpTributos\Impostos\Csosn;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Csosn;
use PhpTributos\Impostos\Csosn\Base\CsosnBase;
use PhpTributos\Impostos\Tributavel;

class Csosn101 extends CsosnBase
{
    /**
     * @var float
     */
    public $percentualCredito = 0;

    /**
     * @var float
     */
    public $valorCredito = 0;

    /**
     * @var Csosn
     */
    protected $csosn = Csosn::Csosn101;

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
        $facade = new FacadeCalculadoraTributacao(
            $tributavel,
            $this->tipoDesconto
        );

        $resultadoCalculoIcmsCredito = $facade->calculaCreditoIcms();

        $this->percentualCredito = $tributavel->percentualCredito;
        $this->valorCredito = $resultadoCalculoIcmsCredito->valor;
    }

}
