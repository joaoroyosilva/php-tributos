<?php

namespace PhpTributos\Impostos;

class ResultadoCalculoDifal
{
    /**
     * @var float
     */
    public $baseCalculo = 0;

    /**
     * @var float
     */
    public $fcp = 0;

    /**
     * @var float
     */
    public $valorIcmsDestino = 0;

    /**
     * @var float
     */
    public $valorIcmsOrigem = 0;

    /**
     * @var float
     */
    public $difal = 0;

    /**
     * @param float $baseCalculo;
     * @param float $valor;
     */
    public function __construct(
        float $baseCalculo,
        float $difal,
        float $fcp,
        float $valorIcmsDestino,
        float $valorIcmsOrigem
    ) {
        $this->baseCalculo = $baseCalculo;
        $this->fcp = $fcp;
        $this->valorIcmsDestino = $valorIcmsDestino;
        $this->valorIcmsOrigem = $valorIcmsOrigem;
        $this->difal = $difal;
    }

    /**
     * @param DadosMensagemDifal
     * @return string
     */
    public function getObservacao(DadosMensagemDifal $dadosMensagemDifal): string
    {
        return $this->montaMensageDifal($dadosMensagemDifal);
    }

    /**
     * @param DadosMensagemDifal
     * @return string
     */
    public static function getObservacaoDifal(DadosMensagemDifal $dadosMensagemDifal): string
    {
        return self::montaMensageDifal($dadosMensagemDifal);
    }

    /**
     * @param DadosMensagemDifal
     * @return string
     */
    public static function montaMensageDifal(DadosMensagemDifal $dadosMensagemDifal): string
    {
        $mensagem = "Valores totais do ICMS interstadual: DIFAL da UF destino ";
        $mensagem .= number_format($dadosMensagemDifal->valorIcmsDestino, 2, ',', '');
        $mensagem .= " + FCP " . number_format($dadosMensagemDifal->fcp, 2, ',', '');
        $mensagem .= "; DIFAL da UF Origem ";
        $mensagem .= number_format($dadosMensagemDifal->valorIcmsOrigem, 2, ',', '');
        return $mensagem;
    }

}
