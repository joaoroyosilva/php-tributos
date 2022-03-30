<?php

namespace PhpTributos\Impostos\Csosn;

use PhpTributos\Flags\Csosn;
use PhpTributos\Impostos\Csosn\Base\CsosnBase;
use PhpTributos\Impostos\Tributavel;

class Csosn500 extends CsosnBase
{
    /**
     * @var float
     */
    public $percentualBcRetido = 0;
    /**
     * @var float
     */
    public $valorBcRetido = 0;
    /**
     * @var float
     */
    public $percentualSt = 0;

    /**
     * @var Csosn
     */
    protected $csosn = Csosn::Csosn500;

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
        $this->percentualSt = $tributavel->percentualIcmsSt + $tributavel->percentualFcpSt;
    }

}
