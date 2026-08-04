<?php

namespace PhpTributos\Impostos;

/**
 * Resultado do grupo `gTribRegular` (NT 2025.002-RTC, UB68): a tributação que valeria se a
 * condição resolutiva ou suspensiva não fosse cumprida.
 */
class ResultadoCalculoTribRegular
{
    public function __construct(
        public float $baseCalculo = 0,
        public float $percentualEfetivoRegIbsUf = 0,
        public float $valorTribRegIbsUf = 0,
        public float $percentualEfetivoRegIbsMun = 0,
        public float $valorTribRegIbsMun = 0,
        public float $percentualEfetivoRegCbs = 0,
        public float $valorTribRegCbs = 0,
    ) {
    }
}
