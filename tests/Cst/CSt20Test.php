<?php

namespace PhpTributos\Tests\Cst;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Cst;
use PhpTributos\Impostos\Cst\Cst20;
use PHPUnit\Framework\TestCase;

class Cst20Test extends TestCase
{
    public function testCalculoIcmsDesonerado()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIcms = 20;
        $produto->percentualReducao = 10;
        $produto->cst = Cst::Cst20;

        $cst = new Cst20();
        $cst->calcula($produto);

        $this->assertEquals(900, $cst->valorBcIcms);
        $this->assertEquals(25, $cst->valorIcmsDesonerado);
    }


}
