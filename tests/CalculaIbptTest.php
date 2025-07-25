<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculaIbptTest extends TestCase
{
    public function testCalculoIbpt()
    {
        $produto = new Produto();
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->percentualFederal = 10;
        $produto->percentualFederalImportados = 20;
        $produto->percentualEstadual = 15;
        $produto->percentualMunicipal = 0;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultadoCalculoIbpt = $facade->calculaIbpt($produto);

        $this->assertEquals(1000, $resultadoCalculoIbpt->baseCalculo);
        $this->assertEquals(100, $resultadoCalculoIbpt->tributacaoFederal);
        $this->assertEquals(200, $resultadoCalculoIbpt->tributacaoFederalImportados);
        $this->assertEquals(150, $resultadoCalculoIbpt->tributacaoEstadual);
        $this->assertEquals(0, $resultadoCalculoIbpt->tributacaoMunicipal);
    }
}
