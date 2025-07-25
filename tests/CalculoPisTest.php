<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculoPisTest extends TestCase
{
    public function testCalculoPis()
    {
        $produto = new Produto();
        $produto->percentualPis = 1.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaPis();
        $this->assertEquals(1000, $resultado->baseCalculo);
        $this->assertEquals(16.5, $resultado->valor);
    }

    public function testCalculoPisComIpi()
    {
        $produto = new Produto();
        $produto->percentualPis = 1.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->valorIpi = 10;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaPis();
        $this->assertEquals(1010, $resultado->baseCalculo);
        $this->assertEquals(16.67, $resultado->valor);
    }

    public function testCalculoPisComIpiZero()
    {
        $produto = new Produto();
        $produto->percentualPis = 1.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->valorIpi = 0;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaPis();
        $this->assertEquals(1000, $resultado->baseCalculo);
        $this->assertEquals(16.5, $resultado->valor);
    }
}
