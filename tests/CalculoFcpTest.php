<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculaFcpTest extends TestCase
{
    public function testaCalculaFcp()
    {
        $produto = new Produto();
        $produto->percentualFcp = 2;
        $produto->valorProduto = 90;
        $produto->desconto = 2.9;
        $produto->quantidadeProduto = 1;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaFcp();
        $this->assertEquals(87.1, $resultado->baseCalculo);
        $this->assertEquals(1.74, $resultado->valor);

    }
}
