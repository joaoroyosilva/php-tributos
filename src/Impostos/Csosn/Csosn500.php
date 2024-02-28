<?php

namespace PhpTributos\Impostos\Csosn;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Csosn;
use PhpTributos\Impostos\Csosn\Base\CsosnBase;
use PhpTributos\Impostos\Tributavel;

class Csosn500 extends CsosnBase
{
    /**
     * @var float
     */
    public $percentualBcRetido = 0;

    /**
     * @var float
     */
    public $valorBcRetido = 0;

    /**
     * @var float
     */
    public $percentualSt = 0;

    /**
     * @var float
     */
    public $baseCalculoIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $percentualIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $valorIcmsEfetivo = 0;

    /**
     * @var Csosn
     */
    protected $csosn = Csosn::Csosn500;

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
        $this->percentualSt = $tributavel->percentualIcmsSt + $tributavel->percentualFcpSt;

        $this->percentualIcmsEfetivo = $tributavel->percentualIcmsEfetivo;

        $facade = new FacadeCalculadoraTributacao(
            $tributavel,
            $this->tipoDesconto,
        );

        $resultadoIcmsEfetivo = $facade->calculaIcmsEfetivo();
        $this->baseCalculoIcmsEfetivo = $resultadoIcmsEfetivo->baseCalculo;
        $this->valorIcmsEfetivo = $resultadoIcmsEfetivo->valor;
    }

}
