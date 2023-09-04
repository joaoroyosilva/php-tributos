<?php

namespace PhpTributos\Impostos\CalculosDeBc;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\Base\CalculaBaseCalculoBase;
use PhpTributos\Impostos\Tributavel;

class CalculaBaseCalculoIpi extends CalculaBaseCalculoBase
{
    /**
     * @var string TipoDesconto
     */
    protected $tipoDesconto;

    /**
     * @param Tributavel
     * @param TipoDesconto
     */
    public function __construct(Tributavel $tributavel, string $tipoDesconto)
    {
        parent::__construct($tributavel);
        $this->tipoDesconto = $tipoDesconto;
    }

    public function calculaBaseDeCalculo(): float
    {
        $baseCalculo = parent::calculaBaseDeCalculo() - $this->tributavel->desconto;

        return $baseCalculo;
    }
}
