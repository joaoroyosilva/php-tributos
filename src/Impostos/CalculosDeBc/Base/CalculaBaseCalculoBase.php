<?php

namespace PhpTributos\Impostos\CalculosDeBc\Base;

use PhpTributos\Impostos\Tributavel;

class CalculaBaseCalculoBase
{
    /**
     * @var Tributavel
     */
    protected $tributavel;

    /**
     * @param Tributavel
     */
    public function __construct(Tributavel $tributavel)
    {
        $this->tributavel = $tributavel;
    }

    public function calculaBaseDeCalculo(): float
    {
        $baseCalculo =
        ($this->tributavel->valorProduto * $this->tributavel->quantidadeProduto) +
        $this->tributavel->frete +
        $this->tributavel->seguro +
        $this->tributavel->outrasDespesas;

        return $baseCalculo;
    }
}
