<?php

namespace PhpTributos\Tests\Csosn;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\Csosn\Csosn101;
use PHPUnit\Framework\TestCase;

class Csosn101Test extends TestCase
{
    private function criaProduto(): Produto
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualCredito = 17;
        return $produto;
    }

    public function testCalculoDeCsosn101()
    {
        $produto = $this->criaProduto();

        $csosn = new Csosn101();
        $csosn->calcula($produto);

        $this->assertEquals(170, $csosn->valorCredito);
        $this->assertEquals(17, $csosn->percentualCredito);
    }

    public function testCalculoComDescontoIncondicional()
    {
        $produto = $this->criaProduto();
        $produto->desconto = 100;

        $csosn = new Csosn101();
        $csosn->calcula($produto);

        $this->assertEquals(153, $csosn->valorCredito);
        $this->assertEquals(17, $csosn->percentualCredito);
    }

    public function testCalculoComDescontoCondicional()
    {
        $produto = $this->criaProduto();
        $produto->desconto = 100;

        $csosn = new Csosn101();
        $csosn->tipoDesconto = TipoDesconto::Condicional;
        $csosn->calcula($produto);

        $this->assertEquals(187, $csosn->valorCredito);
        $this->assertEquals(17, $csosn->percentualCredito);
    }
}
