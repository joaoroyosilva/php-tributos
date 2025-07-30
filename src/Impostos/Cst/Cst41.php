<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Flags\Cst;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst41 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst41;

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
    }
}
