<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Flags\Cst;
use PhpTributos\Flags\TipoCalculoIcmsDesonerado;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoIcms;
use PhpTributos\Impostos\ResultadoCalculoIcmsDesonerado;
use PhpTributos\Impostos\Tributavel;

class TributacaoIcmsDesonerado
{
    /**
     * @var CalculaBaseCalculoIcms
     */
    private $calculaBaseCalculoIcms;

    /**
     * @param Tributavel $tributavel
     * @param string $tipoDesconto
     * @param string $tipoCalculoIcmsDesonerado
     */
    public function __construct(
        public Tributavel $tributavel,
        public string $tipoDesconto,
        public string $tipoCalculoIcmsDesonerado
    ) {
        $this->calculaBaseCalculoIcms = new CalculaBaseCalculoIcms($tributavel, $tipoDesconto);
    }

    public function calcula(): ResultadoCalculoIcmsDesonerado
    {
        return $this->calculaIcmsDesonerado();
    }

    private function calculaIcmsDesonerado(): ResultadoCalculoIcmsDesonerado
    {
        $subtotalProduto = $this->tributavel->valorProduto * $this->tributavel->quantidadeProduto;

        $baseCalculo = $this->calculaBaseCalculoIcms->calculaBaseDeCalculo();

        $valorIcmsDesonerado = $this->calculaDesoneracao(
            $this->tipoCalculoIcmsDesonerado == TipoCalculoIcmsDesonerado::BaseSimples
            ? $baseCalculo : $subtotalProduto,
            $this->tipoCalculoIcmsDesonerado
        );

        return new ResultadoCalculoIcmsDesonerado($baseCalculo, $valorIcmsDesonerado);
    }

    private function calculaDesoneracao(
        int $valorBase,
        string $tipoCalculo
    ): float {
        $aliquota = $this->tributavel->percentualIcms / 100;

        if(
            $tipoCalculo == TipoCalculoIcmsDesonerado::BaseSimples
        ) {
            return $valorBase * $aliquota;
        } elseif(
            $tipoCalculo == TipoCalculoIcmsDesonerado::BasePorDentro
        ) {
            if(
                $this->tributavel->cst == Cst::Cst20
                || $this->tributavel->cst == Cst::Cst70
            ) {
                return (
                    ($valorBase *
                      (1 - $aliquota * (1 - $this->tributavel->percentualReducao / 100))) /
                      (1 - $aliquota) -
                    $valorBase
                );
            } else {
                return ($valorBase / (1 - $aliquota)) * $aliquota;
            }
        }

        return 0;
    }
}
