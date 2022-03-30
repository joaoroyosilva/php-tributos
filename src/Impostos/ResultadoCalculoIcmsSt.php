<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoIcmsSt
{

    /**
     * @var float
     */
    public $baseCalculoOperacaoPropria;

    /**
     * @var float
     */
    public $valorIcmsProprio;

    /**
     * @var float
     */
    public $baseCalculoIcmsSt;

    /**
     * @var float
     */
    public $valorIcmsSt;

    /**
     * @param float $baseCalculoOperacaoPropria;
     * @param float $valorIcmsProprio;
     * @param float $baseCalculoIcmsSt;
     * @param float $valorIcmsSt;
     */
    public function __construct(
        float $baseCalculoOperacaoPropria,
        float $valorIcmsProprio,
        float $baseCalculoIcmsSt,
        float $valorIcmsSt
    ) {
        $this->baseCalculoOperacaoPropria = $baseCalculoOperacaoPropria;
        $this->valorIcmsProprio = $valorIcmsProprio;
        $this->baseCalculoIcmsSt = $baseCalculoIcmsSt;
        $this->valorIcmsSt = $valorIcmsSt;
    }
}
