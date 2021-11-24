<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoFcp;
use PhpTributos\Impostos\ResultadoCalculoFcp;
use PhpTributos\Impostos\Tributavel;

class TributacaoFcp
{
    /**
     * @var CalculaBaseCalculoFcp
     */
    private $calculaBaseCalculoFcp;

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
        $this->calculaBaseCalculoFcp = new CalculaBaseCalculoFcp($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoFcp
    {
        return $this->calculaFcp();
    }

    private function calculaFcp(): ResultadoCalculoFcp
    {
        $baseCalculo = $this->calculaBaseCalculoFcp->calculaBaseCalculoBase();
        $valorFcp = round($this->calculaValorFcp($baseCalculo), 2);

        return new ResultadoCalculoFcp($baseCalculo, $valorFcp);
    }

    private function calculaValorFcp(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualFcp) / 100;
    }
}
