<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcms;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst00 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst00;

    /**
     * @var ModalidadeDeterminacaoBcIcms
     */
    public $modalidadeDeterminacaoBcIcms = ModalidadeDeterminacaoBcIcms::ValorOperacao;

    /**
     * @var float
     */
    public $valorBcIcms;

    /**
     * @var float
     */
    public $percentualIcms;

    /**
     * @var float
     */
    public $valorIcms;

    /**
     * @var float
     */
    public $percentualFcp;

    /**
     * @var float
     */
    public $valorFcp;

    public function calcula(Tributavel $tributavel): void
    {
        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $resultadoCalculoIcms = $facade->calculaIcms();
        $resultadoCalculoFcp = $facade->calculaFcp();

        $this->valorBcIcms = $resultadoCalculoIcms->baseCalculo;
        $this->percentualIcms = $tributavel->percentualIcms;
        $this->valorIcms = $resultadoCalculoIcms->valor;
        $this->percentualFcp = $tributavel->percentualFcp;
        $this->valorFcp = $resultadoCalculoFcp->valor;
    }
}
