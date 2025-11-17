<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoCbsIbs;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIbsUf;
use PhpTributos\Impostos\ResultadoCalculoCbsIbs;
use PhpTributos\Impostos\ResultadoTributacao;
use PhpTributos\Impostos\Tributavel;

class TributacaoIbsUf
{
    /**
     * @var CalculaBaseCalculoCbsIbs
     */
    private $calculaBaseCalculo;

    /**
     * @var Tributavel
     */
    private $tributavel;

    /**
     * @param Tributavel $tributavel
     * @param ResultadoTributacao $resultadoTributacao
     */
    public function __construct(Tributavel $tributavel, ResultadoTributacao $resultadoTributacao)
    {
        $this->tributavel = $tributavel;
        $this->calculaBaseCalculo = new CalculaBaseCalculoCbsIbs($tributavel, $resultadoTributacao);
    }

    public function calcula(): ResultadoCalculoCbsIbs
    {
        return $this->calculaIbsUf();
    }

    private function calculaIbsUf(): ResultadoCalculoCbsIbs
    {
        $baseCalculo = $this->calculaBaseCalculo->calculaBaseCalculoBase();
        $valorIbsUf = $this->calculaValorIbsUf($baseCalculo);
        $valorDiferido = $this->calculaValorDiferido($baseCalculo);
        $percentualEfetivo = $this->calculaAliquotaEfetiva();
        $valorEfetivo = $this->calculaValorEfetivo($baseCalculo, $percentualEfetivo, $valorDiferido);
        $valorCreditoPresumido = $this->calculaValorCreditoPresumido($valorEfetivo);

        return new ResultadoCalculoCbsIbs(
            $baseCalculo,
            $valorIbsUf,
            $valorDiferido,
            $percentualEfetivo,
            $valorEfetivo,
            $valorCreditoPresumido
        );
    }

    private function calculaValorIbsUf(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualIbsUf) / 100,
            2,
        );
    }

    private function calculaValorDiferido(float $baseCalculo): float
    {
        if ($this->tributavel->percentualDiferimentoIbsUf == 0) {
            return 0;
        }

        return round(
            ($baseCalculo)
            * ($this->tributavel->percentualIbsUf / 100)
            * ($this->tributavel->percentualDiferimentoIbsUf - 100),
            2,
        );
    }

    private function calculaValorCreditoPresumido(float $valorIbs): float
    {
        return round(
            ($valorIbs * $this->tributavel->percentualCreditoPresumidoIbs) / 100,
            2,
        );
    }

    private function calculaAliquotaEfetiva(): float
    {
        if ($this->tributavel->reducaoIbsUf == 0 && $this->tributavel->percentualRedutorCompraGov == 0) {
            return $this->tributavel->percentualIbsUf;
        }

        if ($this->tributavel->percentualRedutorCompraGov > 0) {
            return round(
                $this->tributavel->reducaoIbsUf
                * (1 - $this->tributavel->reducaoIbsUf / 100)
                * (1 - $this->tributavel->percentualRedutorCompraGov / 100),
                2,
            );
        }

        return round(
            $this->tributavel->percentualIbsUf * (1 - $this->tributavel->reducaoIbsUf / 100),
            2,
        );
    }

    private function calculaValorEfetivo(float $baseCalculo, float $percentualEfetivo, float $valorDiferido): float
    {
        return round(
            (($baseCalculo * $percentualEfetivo) / 100) - $valorDiferido,
            2,
        );
    }
}
