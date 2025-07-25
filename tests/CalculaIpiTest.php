<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Documento;
use PhpTributos\Flags\TipoDesconto;
use PHPUnit\Framework\TestCase;

class CalculaIpiTest extends TestCase
{
    public function testCalculoIpi()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIpi = 17;

        $facade = new FacadeCalculadoraTributacao($produto);
        $resultado = $facade->calculaIpi();
        $this->assertEquals(1000, $resultado->baseCalculo);
        $this->assertEquals(170, $resultado->valor);
    }

    public function testCalculoIpiComQuantidade2()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 1000;
        $produto->percentualIpi = 17;

        $facade = new FacadeCalculadoraTributacao($produto);
        $resultado = $facade->calculaIpi();
        $this->assertEquals(2000, $resultado->baseCalculo);
        $this->assertEquals(340, $resultado->valor);
    }

    public function testCalculoIpiComDescontoCondicional()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIpi = 12;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIpi();
        $this->assertEquals(4000, $resultado->baseCalculo);
        $this->assertEquals(480, $resultado->valor);
    }

    public function testCalculoIpiComFrete()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIpi = 15;
        $produto->frete = 373.5;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIpi();
        $this->assertEquals(4373.5, $resultado->baseCalculo);
        $this->assertEquals(656.03, $resultado->valor);
    }

    public function testCalculoIpiComOutrasDespesasESeguro()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIpi = 12;
        $produto->frete = 373.5;
        $produto->outrasDespesas = 233.1;
        $produto->seguro = 5.73;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIpi();
        $this->assertEquals(4612.33, $resultado->baseCalculo);
        $this->assertEquals(553.48, $resultado->valor);
    }

    public function testCalculoIpiEmNfce()
    {
        $produto = new Produto();
        $produto->documento = Documento::NFCe;
        $produto->quantidadeProduto = 2;
        $produto->valorProduto = 2000;
        $produto->desconto = 1000;
        $produto->percentualIpi = 12;
        $produto->frete = 373.5;
        $produto->outrasDespesas = 233.1;
        $produto->seguro = 5.73;

        $facade = new FacadeCalculadoraTributacao($produto, TipoDesconto::Condicional);
        $resultado = $facade->calculaIpi();
        $this->assertEquals(0, $resultado->baseCalculo);
        $this->assertEquals(0, $resultado->valor);
    }

}
