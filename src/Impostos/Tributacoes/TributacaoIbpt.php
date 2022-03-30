<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Impostos\ResultadoCalculoIbpt;
use PhpTributos\Impostos\Tributavel;

class TributacaoIbpt
{

    /**
     * @var Tributavel
     */
    private $tributavel;

    /**
     * @param Tributavel $tributavel
     */
    public function __construct(Tributavel $tributavel)
    {
        $this->tributavel = $tributavel;
    }

    public function calcula(): ResultadoCalculoIbpt
    {
        $baseCalculo =
        ($this->tributavel->valorProduto * $this->tributavel->quantidadeProduto) -
        $this->tributavel->desconto;

        $impostoAproximadoFederal = $baseCalculo * $this->tributavel->percentualFederal / 100;
        $impostoAproximadoEstadual = $baseCalculo * $this->tributavel->percentualEstadual / 100;
        $impostoAproximadoMunicipal = $baseCalculo * $this->tributavel->percentualMunicipal / 100;
        $impostoAproximadoImportado = $baseCalculo * $this->tributavel->percentualFederalImportados / 100;

        return new ResultadoCalculoIbpt(
            $impostoAproximadoFederal,
            $impostoAproximadoEstadual,
            $impostoAproximadoMunicipal,
            $impostoAproximadoImportado,
            $baseCalculo
        );
    }

}
