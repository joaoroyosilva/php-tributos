<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Flags\Cst;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst70 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst70;

    /**
     * @var float
     */
    public $percentualReducao = 0;

    public function calcula(Tributavel $tributavel): void
    {
        parent::calcula($tributavel);
        $this->percentualReducao = $tributavel->percentualReducao;
    }
}
