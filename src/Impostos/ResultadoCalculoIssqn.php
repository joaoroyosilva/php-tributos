<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoIssqn
{
    /**
     * @var float
     */
    public $baseCalculo;

    /**
     * @var float
     */
    public $baseCalculoInss;

    /**
     * @var float
     */
    public $valor;

    /**
     * @var float
     */
    public $baseCalculoIrrf;

    /**
     * @var float
     */
    public $valorRetPis;

    /**
     * @var float
     */
    public $valorRetCofins;

    /**
     * @var float
     */
    public $valorRetCsll;

    /**
     * @var float
     */
    public $valorRetInss;

    /**
     * @var float
     */
    public $valorRetIrrf;

    /**
     * @param float $baseCalculo;
     * @param float $valor;
     * @param float $baseCalculoInss;
     * @param float $baseCalculoIrrf;
     * @param float $valorRetPis;
     * @param float $valorRetCofins;
     * @param float $valorRetCsll;
     * @param float $valorRetIrrf;
     * @param float $valorRetInss;
     */
    public function __construct(
        float $baseCalculo,
        float $valor,
        float $baseCalculoInss = 0,
        float $baseCalculoIrrf = 0,
        float $valorRetPis = 0,
        float $valorRetCofins = 0,
        float $valorRetCsll = 0,
        float $valorRetIrrf = 0,
        float $valorRetInss = 0
    ) {
        $this->baseCalculo = $baseCalculo;
        $this->valor = $valor;
        $this->baseCalculoInss = $baseCalculoInss;
        $this->baseCalculoIrrf = $baseCalculoIrrf;
        $this->valorRetPis = $valorRetPis;
        $this->valorRetCofins = $valorRetCofins;
        $this->valorRetCsll = $valorRetCsll;
        $this->valorRetIrrf = $valorRetIrrf;
        $this->valorRetInss = $valorRetInss;
    }
}
