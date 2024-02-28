<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\OrigemMercadoria;
use PhpTributos\Flags\TipoCalculoIcmsDesonerado;
use PhpTributos\Flags\TipoDesconto;
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

    /**
     * @var float
     */
    public $valorIcmsDesonerado = 0;

    public function __construct(
        int $origemMercadoria = OrigemMercadoria::Nacional,
        string $tipoDesconto = TipoDesconto::Incondicional,
        public TipoCalculoIcmsDesonerado $tipoCalculoIcmsDesonerado = TipoCalculoIcmsDesonerado::BasePorDentro
    ) {
        parent::__construct($origemMercadoria, $tipoDesconto);
    }


    public function calcula(Tributavel $tributavel): void
    {
        parent::calcula($tributavel);
        $this->percentualReducao = $tributavel->percentualReducao;

        $facade = new FacadeCalculadoraTributacao(
            $tributavel,
            $this->tipoDesconto,
            $this->tipoCalculoIcmsDesonerado
        );
        $this->valorIcmsDesonerado = $facade->calculaIcmsDesonerado()->valor;
    }
}
