<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcmsSt;
use PhpTributos\Impostos\ResultadoCalculoFcpSt;
use PhpTributos\Impostos\Tributavel;

class TributacaoFcpSt
{
    /**
     * @var CalculaBaseCalculoIcmsSt
     */
    private $calculaBaseCalculoFcpSt;

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
        $this->calculaBaseCalculoFcpSt = new CalculaBaseCalculoIcmsSt($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoFcpSt
    {
        return $this->calculaFcpSt();
    }

    private function calculaFcpSt(): ResultadoCalculoFcpSt
    {
        $baseCalculo = $this->calculaBaseCalculoFcpSt->calculaBaseCalculoBase();
        $valorFcpSt = $this->calculaValorFcpSt($baseCalculo);

        return new ResultadoCalculoFcpSt($baseCalculo, $valorFcpSt);
    }

    private function calculaValorFcpSt(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualFcpSt) / 100;
    }
}
