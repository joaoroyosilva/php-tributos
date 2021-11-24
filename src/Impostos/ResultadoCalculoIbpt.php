<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoIbpt
{

    /**
     * @var float
     */
    public $tributacaoFederal;

    /**
     * @var float
     */
    public $tributacaoFederalImportados;

    /**
     * @var float
     */
    public $tributacaoEstadual;

    /**
     * @var float
     */
    public $tributacaoMunicipal;

    /**
     * @var float
     */
    public $valorTotalTributos;

    /**
     * @var float
     */
    public $baseCalculo;

    /**
     * @param float $tributacaoFederal
     * @param float $tributacaoFederalImportados
     * @param float $tributacaoEstadual
     * @param float $tributacaoMunicipal
     * @param float $valorTotalTributos
     * @param float $baseCalculo
     */
    public function __construct(
        float $impostoAproximadoFederal,
        float $impostoAproximadoEstadual,
        float $impostoAproximadoMunipio,
        float $tributacaoFederalImportados,
        float $baseCalculo
    ) {
        $this->tributacaoFederal = $impostoAproximadoFederal;
        $this->tributacaoFederalImportados = $tributacaoFederalImportados;
        $this->tributacaoEstadual = $impostoAproximadoEstadual;
        $this->tributacaoMunicipal = $impostoAproximadoMunipio;
        $this->baseCalculo = $baseCalculo;

        $this->valorTotalTributos = $this->tributacaoFederal +
        $this->tributacaoEstadual +
        $this->tributacaoMunicipal +
        $this->tributacaoFederalImportados;
    }
}
