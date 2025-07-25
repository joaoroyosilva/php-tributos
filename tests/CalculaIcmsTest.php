<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\TipoDesconto;
use PHPUnit\Framework\TestCase;

class CalculaIcmsTest extends TestCase
{
    public function testCalculoIcms()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIcms = 17;

        $facade = new FacadeCalculadoraTributacao($produto);
        $resultado = $facade->calculaIcms();
        $this->assertEquals(1000, $resultado->baseCalculo);
        $this->assertEquals(170, $resultado->valor);
    }

    public function testCalculoIcmsComQuantidade2()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 1000;
        $produto->percentualIcms = 17;

        $facade = new FacadeCalculadoraTributacao($produto);
        $resultado = $facade->calculaIcms();
        $this->assertEquals(2000, $resultado->baseCalculo);
        $this->assertEquals(340, $resultado->valor);
    }

    public function testCalculoIcmsComDescontoCondicional()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIcms = 12;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIcms();
        $this->assertEquals(5000, $resultado->baseCalculo);
        $this->assertEquals(600, $resultado->valor);
    }

    public function testCalculoIcmsComReducao()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIcms = 7;
        $produto->percentualReducao = 25;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIcms();
        $this->assertEquals(3750, $resultado->baseCalculo);
        $this->assertEquals(262.5, $resultado->valor);
    }

    public function testCalculoIcmsComFrete()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIcms = 15;
        $produto->percentualReducao = 25;
        $produto->frete = 373.5;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIcms();
        $this->assertEquals(4030.13, $resultado->baseCalculo);
        $this->assertEquals(604.52, $resultado->valor);
    }

    public function testCalculoIcmsComOutrasDespesasESeguro()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIcms = 12;
        $produto->percentualReducao = 25;
        $produto->frete = 373.5;
        $produto->outrasDespesas = 233.1;
        $produto->seguro = 5.73;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIcms();
        $this->assertEquals(4209.25, $resultado->baseCalculo);
        $this->assertEquals(505.11, $resultado->valor);
    }

}
