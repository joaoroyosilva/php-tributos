<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoCbsIbs
{
    /**
     * @param float $baseCalculo;
     * @param float $valor;
     */
    public function __construct(
        public float $baseCalculo = 0,
        public float $valor = 0,
        public float $valorDiferido = 0,
        public float $percentualEfetivo = 0,
        public float $valorEfetivo = 0,
        public float $valorCreditoPresumido = 0,
    ) {
    }
}
