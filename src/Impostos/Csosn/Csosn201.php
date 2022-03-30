<?php

namespace PhpTributos\Impostos\Csosn;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcmsSt;
use PhpTributos\Impostos\Tributavel;

class Csosn201 extends Csosn101
{

    /**
     * @var ModalidadeDeterminacaoBcIcmsSt
     */
    public $modalidadeDeterminacaoBcIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualMva = 0;

    /**
     * @var float
     */
    public $percentualReducaoSt = 0;

    /**
     * @var float
     */
    public $valorBcIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualIcmsSt = 0;

    /**
     * @var float
     */
    public $valorIcmsSt = 0;

    /**
     * @var Csosn
     */
    protected $csosn = Csosn::Csosn201;

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
        parent::calcula($tributavel);
        $this->percentualMva = $tributavel->percentualMva;
        $this->percentualReducaoSt = $tributavel->percentualReducaoSt;
        $this->percentualIcmsSt = $tributavel->percentualIcmsSt;

        $facade = new FacadeCalculadoraTributacao(
            $tributavel,
            $this->tipoDesconto
        );

        $tributavel->valorIpi = $facade->calculaIpi()->valor;

        $resultadoCalculoIcmsSt = $facade->calculaIcmsSt();

        $this->valorBcIcmsSt = $resultadoCalculoIcmsSt->baseCalculoIcmsSt;
        $this->valorIcmsSt = $resultadoCalculoIcmsSt->valorIcmsSt;
    }

}
