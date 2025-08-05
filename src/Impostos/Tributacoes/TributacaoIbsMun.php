<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoCbsIbs;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIbsMun;
use PhpTributos\Impostos\ResultadoCalculoCbsIbs;
use PhpTributos\Impostos\ResultadoTributacao;
use PhpTributos\Impostos\Tributavel;

class TributacaoIbsMun
{
    /**
     * @var CalculaBaseCalculoIbsMun
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
        return $this->calculaIbsMun();
    }

    private function calculaIbsMun(): ResultadoCalculoCbsIbs
    {
        $baseCalculo = $this->calculaBaseCalculo->calculaBaseCalculoBase();
        $valorIbsMun = $this->calculaValorIbsMun($baseCalculo);
        $valorDiferido = $this->calculaValorDiferido($baseCalculo);
        $percentualEfetivo = $this->calculaAliquotaEfetiva();
        $valorEfetivo = $this->calculaValorEfetivo($baseCalculo, $percentualEfetivo);

        return new ResultadoCalculoCbsIbs(
            $baseCalculo,
            $valorIbsMun,
            $valorDiferido,
            $percentualEfetivo,
            $valorEfetivo
        );
    }

    private function calculaValorIbsMun(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualIbsMun) / 100,
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaValorDiferido(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualDiferimentoIbsMun) / 100,
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaAliquotaEfetiva(): float
    {
        if ($this->tributavel->reducaoIbsMun == 0 && $this->tributavel->percentualRedutorCompraGov == 0) {
            return $this->tributavel->reducaoIbsMun;
        }

        if ($this->tributavel->percentualRedutorCompraGov > 0) {
            return round(
                $this->tributavel->reducaoIbsMun
                * (1 - $this->tributavel->reducaoIbsMun / 100)
                * (1 - $this->tributavel->percentualRedutorCompraGov / 100),
                2,
                PHP_ROUND_HALF_EVEN
            );
        }



        return round(
            $this->tributavel->percentualIbsMun * (1 - $this->tributavel->reducaoIbsMun / 100),
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaValorEfetivo(float $baseCalculo, float $percentualEfetivo): float
    {
        return round(($baseCalculo * $percentualEfetivo) / 100, 2, PHP_ROUND_HALF_EVEN);
    }
}
