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
        // 1010 × 1,65% = 16,665 (empate) → 16,66 por half-even (NT 007), não 16,67.
        $this->assertEquals(16.66, $resultado->valor);
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

    /**
     * NT SE/CGNFS-e 007: vPis usa arredondamento bancário (half-even).
     * Base 100 × 1,625% = 1,625 (empate diádico) → 1,62 (half-even), não 1,63 (half-up).
     */
    public function testCalculoPisArredondamentoBancarioHalfEven()
    {
        $produto = new Produto();
        $produto->percentualPis = 1.625;
        $produto->valorProduto = 100;
        $produto->quantidadeProduto = 1;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaPis();
        $this->assertEquals(1.62, $resultado->valor);
    }
}
