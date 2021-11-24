<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcms;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst51 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst50;

    /**
     * @var ModalidadeDeterminacaoBcIcms
     */
    public $modalidadeDeterminacaoBcIcms;

    /**
     * @var float
     */
    public $percentualDiferimento = 0;

    /**
     * @var float
     */
    public $valorIcmsDiferido = 0;

    /**
     * @var float
     */
    public $valorIcmsOperacao = 0;

    /**
     * @var float
     */
    public $percentualIcms = 0;

    /**
     * @var float
     */
    public $percentualReducao = 0;

    /**
     * @var float
     */
    public $valorBcIcms = 0;

    /**
     * @var float
     */
    public $valorIcms = 0;

    /**
     * @var float
     */
    public $valorBcFcp = 0;

    /**
     * @var float
     */
    public $percentualFcp = 0;

    /**
     * @var float
     */
    public $valorFcp = 0;

    public function calcula(Tributavel $tributavel): void
    {
        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);
        $resultadoCalculoIcms = $facade->calculaIcms();

        $this->percentualReducao = $tributavel->percentualReducao;
        $this->valorBcIcms = $resultadoCalculoIcms->baseCalculo;
        $this->percentualIcms = $tributavel->percentualIcms;
        $this->valorIcmsOperacao = $this->valorBcIcms * $this->percentualIcms / 100;

        $this->percentualDiferimento = $tributavel->percentualDiferimento;
        $this->valorIcmsDiferido = $this->percentualDiferimento * $this->valorIcmsOperacao / 100;
        $this->valorIcms = $this->valorIcmsOperacao - $this->valorIcmsDiferido;

        $resultadoCalculoFcp = $facade->calculaFcp();
        $this->percentualFcp = $tributavel->percentualFcp;
        $this->valorBcFcp = $resultadoCalculoFcp->baseCalculo;
        $this->valorFcp = $resultadoCalculoFcp->valor;

    }
}
