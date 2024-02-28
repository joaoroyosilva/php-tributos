<?php

namespace PhpTributos\Tests\Cst;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Csosn;
use PhpTributos\Impostos\Csosn\Csosn500;
use PHPUnit\Framework\TestCase;

class Cst60Test extends TestCase
{
    public function testaCalculoIcmsDesonerado()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIcmsEfetivo = 20;
        $produto->csosn = Csosn::Csosn500;

        $cst = new Csosn500();
        $cst->calcula($produto);

        $this->assertEquals(1000, $cst->baseCalculoIcmsEfetivo);
        $this->assertEquals(200, $cst->valorIcmsEfetivo);
    }


}
