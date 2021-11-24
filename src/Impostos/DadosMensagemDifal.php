<?php
namespace PhpTributos\Impostos;

class DadosMensagemDifal
{
    /**
     * @var float
     */
    public $fcp;

    /**
     * @var float
     */
    public $valorIcmsDestino;

    /**
     * @var float
     */
    public $valorIcmsOrigem;

    public function __construct(
        float $fcp,
        float $valorIcmsDestino,
        float $valorIcmsOrigem
    ) {
        $this->fcp = $fcp;
        $this->valorIcmsDestino = $valorIcmsDestino;
        $this->valorIcmsOrigem = $valorIcmsOrigem;
    }
}
