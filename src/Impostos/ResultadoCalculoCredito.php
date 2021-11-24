<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoCredito
{
    /**
     * @var float
     */
    public $baseCalculo;

    /**
     * @var float
     */
    public $valor;

    /**
     * @param float $baseCalculo;
     * @param float $valor;
     */
    public function __construct(float $baseCalculo, float $valor)
    {
        $this->baseCalculo = $baseCalculo;
        $this->valor = $valor;
    }
}
