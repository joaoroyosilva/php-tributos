<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Impostos\Tributavel;

class Cst20 extends Cst00
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst20;

    /**
     * @var float
     */
    public $percendualRecucao = 0;

    /**
     * @var float
     */
    public $valorBcFcp = 0;

    public function calcula(Tributavel $tributavel): void
    {
        parent::calcula($tributavel);

        $this->percendualRecucao = $tributavel->percentualReducao;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $this->valorBcFcp = $facade->calculaFcp()->baseCalculo;
    }
}
