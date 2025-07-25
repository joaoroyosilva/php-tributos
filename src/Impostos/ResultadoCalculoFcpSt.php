<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoFcpSt
{
    /**
     * @var float
     */
    public $baseCalculoFcpSt;

    /**
     * @var float
     */
    public $valorFcpSt;

    /**
     * @param float $baseCalculo
     * @param float $valorFcpSt
     */
    public function __construct(float $baseCalculo, float $valorFcpSt)
    {
        $this->baseCalculoFcpSt = $baseCalculo;
        $this->valorFcpSt = $valorFcpSt;
    }
}
