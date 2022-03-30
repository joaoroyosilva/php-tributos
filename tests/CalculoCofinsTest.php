<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculoCofinsTest extends TestCase
{
    public function testaCalculoCofins()
    {
        $produto = new Produto();
        $produto->percentualCofins = 0.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaCofins();
        $this->assertEquals(1000, $resultado->baseCalculo);
        $this->assertEquals(6.5, $resultado->valor);
    }

    public function testaCalculoCofinsComIpi()
    {
        $produto = new Produto();
        $produto->percentualCofins = 0.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->valorIpi = 10;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaCofins();
        $this->assertEquals(1010, $resultado->baseCalculo);
        $this->assertEquals(6.57, $resultado->valor);
    }

    public function testaCalculoCofinsComIpiZero()
    {
        $produto = new Produto();
        $produto->percentualCofins = 0.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->valorIpi = 0;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaCofins();
        $this->assertEquals(1000, $resultado->baseCalculo);
        $this->assertEquals(6.5, $resultado->valor);
    }
}
