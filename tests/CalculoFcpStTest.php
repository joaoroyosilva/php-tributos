<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculaFcpStTest extends TestCase
{
    public function testaCalculaFcpSt()
    {
        $produto = new Produto();
        $produto->percentualFcpSt = 2;
        $produto->valorProduto = 2000;
        $produto->percentualMva = 40;
        $produto->quantidadeProduto = 1;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaFcpSt();
        $this->assertEquals(56, $resultado->valorFcpSt);

    }
}
