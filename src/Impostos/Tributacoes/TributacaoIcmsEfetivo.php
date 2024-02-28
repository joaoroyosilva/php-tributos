<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcmsEfetivo;
use PhpTributos\Impostos\ResultadoCalculoIcmsEfetivo;
use PhpTributos\Impostos\Tributavel;

class TributacaoIcmsEfetivo
{
    /**
     * @var CalculaBaseCalculoIcmsEfetivo
     */
    private $calculaBaseCalculoIcmsEfetivo;

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
        $this->calculaBaseCalculoIcmsEfetivo = new CalculaBaseCalculoIcmsEfetivo($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoIcmsEfetivo
    {
        return $this->calculaIcmsEfetivo();
    }

    private function calculaIcmsEfetivo(): ResultadoCalculoIcmsEfetivo
    {
        $baseCalculo = round($this->calculaBaseCalculoIcmsEfetivo->calculaBaseCalculoBase(), 2);
        $valorIcmsEfetivo = round($this->calculaValorIcmsEfetivo($baseCalculo), 2);

        return new ResultadoCalculoIcmsEfetivo($baseCalculo, $valorIcmsEfetivo);
    }

    private function calculaValorIcmsEfetivo(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualIcmsEfetivo) / 100;
    }
}
