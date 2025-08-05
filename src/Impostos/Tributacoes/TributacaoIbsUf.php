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
     * @var CalculaBaseCalculoIbsUf
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
        $valorEfetivo = $this->calculaValorEfetivo($baseCalculo, $percentualEfetivo);

        return new ResultadoCalculoCbsIbs(
            $baseCalculo,
            $valorIbsUf,
            $valorDiferido,
            $percentualEfetivo,
            $valorEfetivo
        );
    }

    private function calculaValorIbsUf(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualIbsUf) / 100,
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaValorDiferido(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualDiferimentoIbsUf) / 100,
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaAliquotaEfetiva(): float
    {
        if ($this->tributavel->reducaoIbsUf == 0 && $this->tributavel->percentualRedutorCompraGov == 0) {
            return $this->tributavel->reducaoIbsUf;
        }

        if ($this->tributavel->percentualRedutorCompraGov > 0) {
            return round(
                $this->tributavel->reducaoIbsUf
                * (1 - $this->tributavel->reducaoIbsUf / 100)
                * (1 - $this->tributavel->percentualRedutorCompraGov / 100),
                2,
                PHP_ROUND_HALF_EVEN
            );
        }



        return round(
            $this->tributavel->percentualIbsUf * (1 - $this->tributavel->reducaoIbsUf / 100),
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaValorEfetivo(float $baseCalculo, float $percentualEfetivo): float
    {
        return round(($baseCalculo * $percentualEfetivo) / 100, 2, PHP_ROUND_HALF_EVEN);
    }
}
