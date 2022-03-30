<?php

namespace PhpTributos\Tests\Cst;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\Cst\Cst00;
use PHPUnit\Framework\TestCase;

class Cst00Test extends TestCase
{
    public function testaCalculoIcms()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIcms = 18;

        $cst = new Cst00();
        $cst->calcula($produto);

        $this->assertEquals(1000, $cst->valorBcIcms);
        $this->assertEquals(180, $cst->valorIcms);
    }

    public function testaCalculoIcmsComDescontoIncondicional()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1100;
        $produto->percentualIcms = 18;
        $produto->desconto = 100;

        $cst = new Cst00();
        $cst->calcula($produto);

        $this->assertEquals(1000, $cst->valorBcIcms);
        $this->assertEquals(180, $cst->valorIcms);
    }

    public function testaCalculoIcmsComDescontoCondicional()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIcms = 18;
        $produto->desconto = 100;

        $cst = new Cst00();
        $cst->tipoDesconto = TipoDesconto::Condicional;
        $cst->calcula($produto);

        $this->assertEquals(1100, $cst->valorBcIcms);
        $this->assertEquals(198, $cst->valorIcms);
    }
}
