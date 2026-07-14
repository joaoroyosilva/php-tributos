<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PHPUnit\Framework\TestCase;

class CalculoCofinsTest extends TestCase
{
    public function testCalculoCofins()
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

    public function testCalculoCofinsComIpi()
    {
        $produto = new Produto();
        $produto->percentualCofins = 0.65;
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->valorIpi = 10;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaCofins();
        $this->assertEquals(1010, $resultado->baseCalculo);
        // 1010 × 0,65% = 6,565 (empate) → 6,56 por half-even (NT 007), não 6,57.
        $this->assertEquals(6.56, $resultado->valor);
    }

    public function testCalculoCofinsComIpiZero()
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

    /**
     * NT SE/CGNFS-e 007: vCofins usa arredondamento bancário (half-even).
     * Base 100 × 1,625% = 1,625 (empate diádico) → 1,62 (half-even), não 1,63 (half-up).
     */
    public function testCalculoCofinsArredondamentoBancarioHalfEven()
    {
        $produto = new Produto();
        $produto->percentualCofins = 1.625;
        $produto->valorProduto = 100;
        $produto->quantidadeProduto = 1;

        $facade = new FacadeCalculadoraTributacao($produto);

        $resultado = $facade->calculaCofins();
        $this->assertEquals(1.62, $resultado->valor);
    }
}
