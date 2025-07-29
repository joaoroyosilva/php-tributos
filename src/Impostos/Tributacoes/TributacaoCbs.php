<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoCbsIbs;
use PhpTributos\Impostos\ResultadoCalculoCbsIbs;
use PhpTributos\Impostos\ResultadoTributacao;
use PhpTributos\Impostos\Tributavel;

class TributacaoCbs
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
        return $this->calculaCbsIbs();
    }

    private function calculaCbsIbs(): ResultadoCalculoCbsIbs
    {
        $baseCalculo = $this->calculaBaseCalculo->calculaBaseCalculoBase();
        $valorCbs = $this->calculaValorCbs($baseCalculo);
        $valorDiferido = $this->calculaValorDiferido($baseCalculo);
        $percentualEfetivo = $this->calculaAliquotaEfetiva();
        $valorEfetivo = $this->calculaValorEfetivo($baseCalculo, $percentualEfetivo);

        return new ResultadoCalculoCbsIbs(
            $baseCalculo,
            $valorCbs,
            $valorDiferido,
            $percentualEfetivo,
            $valorEfetivo
        );
    }

    private function calculaValorCbs(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualCbs) / 100,
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaValorDiferido(float $baseCalculo): float
    {
        return round(
            ($baseCalculo * $this->tributavel->percentualDiferimentoCbs) / 100,
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaAliquotaEfetiva(): float
    {
        if ($this->tributavel->reducaoCbs == 0) {
            return $this->tributavel->percentualCbs;
        }

        return round(
            $this->tributavel->percentualCbs * (1 - $this->tributavel->reducaoCbs / 100),
            2,
            PHP_ROUND_HALF_EVEN
        );
    }

    private function calculaValorEfetivo(float $baseCalculo, float $percentualEfetivo): float
    {
        return round(($baseCalculo * $percentualEfetivo) / 100, 2, PHP_ROUND_HALF_EVEN);
    }
}
