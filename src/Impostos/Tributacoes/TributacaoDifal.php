<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcms;
use PhpTributos\Impostos\ResultadoCalculoDifal;
use PhpTributos\Impostos\Tributavel;

class TributacaoDifal
{
    /**
     * @var CalculaBaseCalculoIcms
     */
    private $calculaBaseCalculoIcms;
    /**
     * @var TributacaoFcp
     */
    private $tributacaoFcp;

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
        $this->calculaBaseCalculoIcms = new CalculaBaseCalculoIcms($tributavel, $tipoDesconto);
        $this->tributacaoFcp = new TributacaoFcp($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoDifal
    {
        return $this->calculaDifal();
    }

    private function calculaDifal(): ResultadoCalculoDifal
    {
        $baseCalculo = $this->calculaBaseCalculoIcms->calculaBaseCalculoBase();

        $resultadoFcp = $this->tributacaoFcp->calcula();
        $difal = $this->calculaValorDifal($baseCalculo);

        $percentualRateioOrigem = 0;
        $percentualRateioDestino = 100;

        $aliquotaOrigem = $difal * ($percentualRateioOrigem / 100);
        $aliquotaDestino = $difal * ($percentualRateioDestino / 100);

        return new ResultadoCalculoDifal(
            $baseCalculo,
            $difal,
            $resultadoFcp->valor,
            $aliquotaDestino,
            $aliquotaOrigem
        );
    }

    private function calculaValorDifal(float $baseCalculo): float
    {
        return $baseCalculo *
            (($this->tributavel->percentualDifalInterna -
            $this->tributavel->percentualDifalInterstadual
        ) / 100);
    }
}
