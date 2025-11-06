<?php

namespace PhpTributos\Impostos\CalculosDeBc;

use PhpTributos\Impostos\CalculosDeBc\Base\CalculaBaseCalculoBase;
use PhpTributos\Impostos\ResultadoTributacao;
use PhpTributos\Impostos\Tributavel;

class CalculaBaseCalculoCbsIbs extends CalculaBaseCalculoBase
{
    /**
     * @param Tributavel
     */
    public function __construct(
        Tributavel $tributavel,
        protected ResultadoTributacao $resultadoTributacao
    ) {
        parent::__construct($tributavel);
    }

    public function calculaBaseCalculoBase(): float
    {
        $baseCalculo =
        ($this->tributavel->valorProduto * $this->tributavel->quantidadeProduto) +
        $this->tributavel->frete +
        $this->tributavel->seguro +
        $this->tributavel->outrasDespesas -
        $this->tributavel->desconto -
        $this->resultadoTributacao->valorIcms -
        $this->resultadoTributacao->valorIss -
        $this->resultadoTributacao->valorPis -
        $this->resultadoTributacao->valorCofins -
        $this->resultadoTributacao->fcp;

        return round($baseCalculo, 2, PHP_ROUND_HALF_EVEN);
    }
}
