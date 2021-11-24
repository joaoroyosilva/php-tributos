<?php

namespace PhpTributos\Tests\Csosn;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Impostos\DadosMensagemDifal;
use PHPUnit\Framework\TestCase;

class CalculaDifalFcpTest extends TestCase
{
    public function testaCalculaDifalJuntoComFcp()
    {
        $produto = new Produto();
        $produto->valorProduto = 845;
        $produto->quantidadeProduto = 1;
        $produto->frete = 35;
        $produto->outrasDespesas = 80;
        $produto->desconto = 10;
        $produto->valorIpi = 50;
        $produto->percentualFcp = 2;
        $produto->percentualDifalInterna = 18;
        $produto->percentualDifalInterstadual = 12;

        $facade = new FacadeCalculadoraTributacao($produto);
        $result = $facade->calculaDifal();

        $this->assertEquals(1000, $result->baseCalculo);
        $this->assertEquals(60, $result->difal);
        $this->assertEquals(60, $result->valorIcmsDestino);
        $this->assertEquals(0, $result->valorIcmsOrigem);
        $this->assertEquals(20, $result->fcp);

        $this->assertEquals(
            'Valores totais do ICMS interstadual: DIFAL da UF destino 60,00 + FCP 20,00; DIFAL da UF Origem 0,00',
            $result->getObservacao(
                new DadosMensagemDifal(
                    $result->fcp,
                    $result->valorIcmsDestino,
                    $result->valorIcmsOrigem
                )
            )
        );
    }
}
