<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIssqn;
use PhpTributos\Impostos\ResultadoCalculoIssqn;
use PhpTributos\Impostos\Tributavel;

class TributacaoIssqn
{
    /**
     * @var CalculaBaseCalculoIssqn
     */
    private $calculaBaseCalculoIssqn;

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
        $this->calculaBaseCalculoIssqn = new CalculaBaseCalculoIssqn($tributavel, $tipoDesconto);
    }

    public function calcula(bool $calcularRetencoes): ResultadoCalculoIssqn
    {
        return $this->calculaIssqn($calcularRetencoes);
    }

    private function calculaIssqn(bool $calcularRetencoes): ResultadoCalculoIssqn
    {
        $baseCalculo = $this->calculaBaseCalculoIssqn->calculaBaseCalculoBase();
        $valorIss = $this->calculaValorIssqn($baseCalculo);

        return !$calcularRetencoes
        ? new ResultadoCalculoIssqn($baseCalculo, $valorIss) :
        $this->calcularRetencoes($baseCalculo, $valorIss);
    }

    private function calcularRetencoes(float $baseCalculo, float $valorIss): ResultadoCalculoIssqn
    {
        $baseCalculoIssn = $baseCalculo;
        $baseCalculoIrrf = $baseCalculo;
        $calcularRetencoes = $this->calcularValorTotalTributacao($baseCalculo);

        $valorRetPis = $calcularRetencoes ?
        $this->calculaValorRetPis($baseCalculo) : 0;

        $valorRetCofins = $calcularRetencoes ?
        $this->calculaValorRetCofins($baseCalculo) : 0;

        $valorRetCsll = $calcularRetencoes ?
        $this->calculaValorRetCsll($baseCalculo) : 0;

        $valorRetIrrf = $calcularRetencoes ?
        $this->calculaValorRetIrrf($baseCalculo) : 0;

        $valorRetInss = $calcularRetencoes ?
        $this->calculaValorRetInss($baseCalculo) : 0;

        return new ResultadoCalculoIssqn(
            $baseCalculo,
            $valorIss,
            $baseCalculoIssn,
            $baseCalculoIrrf,
            $valorRetPis,
            $valorRetCofins,
            $valorRetCsll,
            $valorRetIrrf,
            $valorRetInss
        );

    }

    private function calculaValorIssqn(float $baseCalculo): float
    {
        return round($baseCalculo * $this->tributavel->percentualIssqn / 100, 2);
    }

    private function calculaValorRetPis(float $baseCalculo): float
    {
        return round(($baseCalculo * $this->tributavel->percentualRetPis) / 100, 2);
    }

    private function calculaValorRetCofins(float $baseCalculo): float
    {
        return round(($baseCalculo * $this->tributavel->percentualRetCofins) / 100, 2);
    }

    private function calculaValorRetCsll(float $baseCalculo): float
    {
        return round(($baseCalculo * $this->tributavel->percentualRetCsll) / 100, 2);
    }

    private function calculaValorRetIrrf(float $baseCalculo): float
    {
        return round($baseCalculo * $this->tributavel->percentualRetIrrf / 100, 2);
    }

    private function calculaValorRetInss(float $baseCalculo): float
    {
        return round($baseCalculo * $this->tributavel->percentualRetInss / 100, 2);
    }

    private function calcularValorTotalTributacao(float $baseCalculo): bool
    {
        $percentualTotal =
        $this->tributavel->percentualRetPis +
        $this->tributavel->percentualRetCofins +
        $this->tributavel->percentualRetCsll;

        return round($baseCalculo * $percentualTotal / 100, 2);
    }
}
