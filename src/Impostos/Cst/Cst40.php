<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Flags\Cst;
use PhpTributos\Flags\MotivoDesoneracao;
use PhpTributos\Impostos\Cst\Base\CstBase;

class Cst40 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst40;

    /**
     * @var MotivoDesoneracao
     */
    public $motivoDesoneracao;

    /**
     * @var float
     */
    public $valorIcmsDesonerado = 0;
}
