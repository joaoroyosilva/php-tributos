<?php

namespace PhpTributos\Impostos\CalculosDeBc;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\Base\CalculaBaseCalculoBase;
use PhpTributos\Impostos\Tributavel;

class CalculaBaseCalculoIcmsSt extends CalculaBaseCalculoBase
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

    /**
     * Base do ICMS-ST: (produto + frete + seguro + outras [+ IPI]) ± desconto,
     * reduzida pela redução ST e acrescida do MVA. Desconto e redução entram uma vez só.
     */
    public function calculaBaseCalculoBase(): float
    {
        $baseCalculo = $this->tributavel->icmsSobreIpi ?
            parent::calculaBaseDeCalculo() + $this->tributavel->valorIpi :
            parent::calculaBaseDeCalculo();

        $baseCalculo = $this->tipoDesconto == TipoDesconto::Condicional ?
        $this->calculaBaseComDescontoCondicional($baseCalculo) :
        $this->calculaBaseComDescontoIncondicional($baseCalculo);

        $baseCalculo = $baseCalculo -
            ($baseCalculo * $this->tributavel->percentualReducaoSt / 100);

        return $this->calculaBaseCalculoBaseSt($baseCalculo);
    }

    /**
     * Aplica o MVA sobre a base já com desconto e redução ST.
     */
    public function calculaBaseCalculoBaseSt(float $baseCalculoIcms): float
    {
        return $baseCalculoIcms * (1 + $this->tributavel->percentualMva / 100);
    }

    private function calculaBaseComDescontoCondicional(float $baseCalculoInicial): float
    {
        return $baseCalculoInicial + $this->tributavel->desconto;
    }

    private function calculaBaseComDescontoIncondicional(float $baseCalculoInicial): float
    {
        return $baseCalculoInicial - $this->tributavel->desconto;
    }
}
