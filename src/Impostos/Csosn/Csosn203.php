<?php

namespace PhpTributos\Impostos\Csosn;

use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcmsSt;

class Csosn203 extends Csosn202
{
    /**
     * @var Csosn
     */
    protected $csosn = Csosn::Csosn203;

    /**
     * @var ModalidadeDeterminacaoBcIcmsSt
     */
    public $modalidadeDeterminacaoBcIcmsSt = ModalidadeDeterminacaoBcIcmsSt::MargemValorAgregado;

}
