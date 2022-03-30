<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoPis;
use PhpTributos\Impostos\ResultadoCalculoPis;
use PhpTributos\Impostos\Tributavel;

class TributacaoPis
{
    /**
     * @var CalculaBaseCalculoPis
     */
    private $calculaBaseCalculoPis;

    /**
     * @var Tributavel
     */
    private $tributavel;

    /**
     * @var string TipoDesconto
     */
    private $tipoDesconto;

    /**
     * @param Tributavel $tributavel
     * @param string $tipoDesconto
     */
    public function __construct(Tributavel $tributavel, string $tipoDesconto)
    {
        $this->tributavel = $tributavel;
        $this->tipoDesconto = $tipoDesconto;
        $this->calculaBaseCalculoPis = new CalculaBaseCalculoPis($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoPis
    {
        return $this->calculaPis();
    }

    private function calculaPis(): ResultadoCalculoPis
    {
        $baseCalculo = round(
            $this->calculaBaseCalculoPis->calculaBaseCalculoBase() + $this->tributavel->valorIpi,
            2
        );
        $valorPis = round($this->calculaValorPis($baseCalculo), 2);

        return new ResultadoCalculoPis($baseCalculo, $valorPis);
    }

    private function calculaValorPis(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualPis) / 100;
    }
}
