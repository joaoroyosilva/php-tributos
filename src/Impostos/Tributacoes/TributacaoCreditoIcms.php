<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Documento;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcms;
use PhpTributos\Impostos\ResultadoCalculoCredito;
use PhpTributos\Impostos\Tributavel;

class TributacaoCreditoIcms
{
    /**
     * @var CalculaBaseCalculoIcms
     */
    private $calculaBaseCalculoIcms;

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
    }

    public function calcula(): ResultadoCalculoCredito
    {
        return $this->calculaIcms();
    }

    private function calculaIcms(): ResultadoCalculoCredito
    {
        $baseCalculo = round($this->calculaBaseCalculoIcms->calculaBaseCalculoBase(), 2);
        $valorIcms = round($this->calculaCredito($baseCalculo), 2);

        return new ResultadoCalculoCredito($baseCalculo, $valorIcms);
    }

    private function calculaCredito(float $baseCalculo): float
    {
        switch ($this->tributavel->documento) {
            case Documento::NFe:
                return ($baseCalculo * $this->tributavel->percentualCredito) / 100;
                break;
            case Documento::CTe:
                $facade = new FacadeCalculadoraTributacao(
                    $this->tributavel,
                    $this->tipoDesconto
                );
                $resultadoIcms = $facade->calculaIcmsSt();
                return $resultadoIcms->valorIcmsSt * $this->tributavel->percentualCredito / 100;
                break;

            default:
                return 0;
                break;
        }
    }
}
