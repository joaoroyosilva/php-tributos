<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculaIcmsStTest extends TestCase
{
    public function testCalculoIcmsSt()
    {
        $produto = new Produto();
        $produto->percentualIcms = 18;
        $produto->percentualIcmsSt = 18;
        $produto->percentualIpi = 15;
        $produto->valorProduto = 2000;
        $produto->quantidadeProduto = 1;
        $produto->percentualMva = 40;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaIcmsSt();

        $this->assertEquals(2000, $resultado->baseCalculoOperacaoPropria);
        $this->assertEquals(360, $resultado->valorIcmsProprio);
        $this->assertEquals(2800, $resultado->baseCalculoIcmsSt);
        $this->assertEquals(144, $resultado->valorIcmsSt);
    }
}
