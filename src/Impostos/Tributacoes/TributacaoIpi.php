<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\Documento;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIpi;
use PhpTributos\Impostos\ResultadoCalculoIpi;
use PhpTributos\Impostos\Tributavel;

class TributacaoIpi
{
    /**
     * @var CalculaBaseCalculoIpi
     */
    private $calculaBaseCalculoIpi;

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
        $this->calculaBaseCalculoIpi = new CalculaBaseCalculoIpi($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoIpi
    {
        return $this->calculaIpi();
    }

    private function calculaIpi(): ResultadoCalculoIpi
    {
        $baseCalculo = round($this->calculaBaseCalculoIpi->calculaBaseDeCalculo(), 2);
        $valorIpi = round($this->calculaValorIpi($baseCalculo), 2);

        if ($this->tributavel->documento == Documento::NFCe) {
            return new ResultadoCalculoIpi(0, 0);
        }

        return new ResultadoCalculoIpi($baseCalculo, $valorIpi);
    }

    private function calculaValorIpi(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualIpi) / 100;
    }
}
