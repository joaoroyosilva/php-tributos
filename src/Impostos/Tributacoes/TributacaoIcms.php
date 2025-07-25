<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcms;
use PhpTributos\Impostos\ResultadoCalculoIcms;
use PhpTributos\Impostos\Tributavel;

class TributacaoIcms
{
    /**
     * @var CalculaBaseCalculoIcms
     */
    private $calculaBaseCalculoIcms;

    /**
     * @var Tributavel
     */
    private $tributavel;

    /**
     * @param Tributavel $tributavel
     * @param string $tipoDesconto
     */
    public function __construct(Tributavel $tributavel, string $tipoDesconto)
    {
        $this->tributavel = $tributavel;
        $this->calculaBaseCalculoIcms = new CalculaBaseCalculoIcms($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoIcms
    {
        return $this->calculaIcms();
    }

    private function calculaIcms(): ResultadoCalculoIcms
    {
        $baseCalculo = round($this->calculaBaseCalculoIcms->calculaBaseCalculoBase(), 2);
        $valorIcms = round($this->calculaValorIcms($baseCalculo), 2);

        return new ResultadoCalculoIcms($baseCalculo, $valorIcms);
    }

    private function calculaValorIcms(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualIcms) / 100;
    }
}
