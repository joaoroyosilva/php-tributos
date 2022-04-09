<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcmsSemIpi;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcmsSt;
use PhpTributos\Impostos\ResultadoCalculoIcmsSt;
use PhpTributos\Impostos\Tributavel;

class TributacaoIcmsSt
{
    /**
     * @var CalculaBaseCalculoIcmsSt
     */
    private $calculaBaseCalculoIcmsSt;
    /**
     * @var CalculaBaseCalculoIcmsSemIpi
     */
    private $calculaBaseCalculoIcmsSemIpi;

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
        $this->calculaBaseCalculoIcmsSemIpi = new CalculaBaseCalculoIcmsSemIpi($tributavel, $tipoDesconto);
        $this->calculaBaseCalculoIcmsSt = new CalculaBaseCalculoIcmsSt($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoIcmsSt
    {
        return $this->calculaIcmsSt();
    }

    private function calculaIcmsSt(): ResultadoCalculoIcmsSt
    {
        $baseCalculoOperacaoPropria = $this->calculaBaseCalculoIcmsSemIpi->calculaBaseCalculoBase();

        $valorIcmsProprio = $this->calculaValorIcms($baseCalculoOperacaoPropria);

        $baseCalculoIcmsSt = $this->calculaBaseCalculoIcmsSt->calculaBaseCalculoBase();

        $valorIcmsSt = ($baseCalculoIcmsSt *
            ($this->tributavel->percentualIcmsSt / 100)) -
            $valorIcmsProprio;

        if ($this->tributavel->percentualIcmsSt == 0) {
            return new ResultadoCalculoIcmsSt(
                $baseCalculoOperacaoPropria, 0, 0, 0);
        }

        return new ResultadoCalculoIcmsSt(
            $baseCalculoOperacaoPropria,
            $valorIcmsProprio,
            $baseCalculoIcmsSt,
            $valorIcmsSt
        );
    }

    private function calculaValorIcms(float $baseCalculo): float
    {
        return ($baseCalculo * $this->tributavel->percentualIcms) / 100;
    }
}
