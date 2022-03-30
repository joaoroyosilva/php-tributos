<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoCofins;
use PhpTributos\Impostos\ResultadoCalculoCofins;
use PhpTributos\Impostos\Tributavel;

class TributacaoCofins
{
    /**
     * @var CalculaBaseCalculoCofins
     */
    private $calculaBaseCalculoCofins;

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
        $this->calculaBaseCalculoCofins = new CalculaBaseCalculoCofins($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoCofins
    {
        return $this->calculaCofins();
    }

    private function calculaCofins(): ResultadoCalculoCofins
    {
        $baseCalculo = $this->calculaBaseCalculoCofins->calculaBaseCalculoBase() + $this->tributavel->valorIpi;
        $valorCofins = round($this->calculaValorCofins($baseCalculo), 2);

        return new ResultadoCalculoCofins($baseCalculo, $valorCofins);
    }

    private function calculaValorCofins(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualCofins) / 100;
    }
}
