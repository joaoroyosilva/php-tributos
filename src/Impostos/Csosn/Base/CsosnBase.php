<?php

namespace PhpTributos\Impostos\Csosn\Base;

use PhpTributos\Exceptions\ArgumentException;
use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\OrigemMercadoria;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\Tributavel;

abstract class CsosnBase
{
    /**
     * @var Csosn
     */
    protected $csosn;

    /**
     * @var int
     */
    protected $origemMercadoria;

    /**
     * @var string TipoDesconto
     */
    public $tipoDesconto;

    public function __construct(
        int $origemMercadoria = OrigemMercadoria::Nacional,
        string $tipoDesconto = TipoDesconto::Incondicional
    ) {
        $this->origemMercadoria = $origemMercadoria;
        $this->tipoDesconto = $tipoDesconto;
    }

    /**
     * @param Tributavel $tributavel
     */
    public function calcula(Tributavel $tributavel): void
    {
        throw new ArgumentException();
    }
}
