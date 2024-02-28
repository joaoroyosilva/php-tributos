<?php

namespace PhpTributos\Tests\Csosn;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\Csosn\Csosn202;
use PHPUnit\Framework\TestCase;

class Csosn202Test extends TestCase
{
    private function criaProduto(): Produto
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 2000;
        $produto->percentualIcms = 18;
        $produto->percentualIcmsSt = 18;
        $produto->percentualIpi = 15;
        $produto->percentualMva = 40;
        $produto->icmsSobreIpi = true;

        return $produto;
    }

    public function testaCalculo()
    {
        $produto = $this->criaProduto();
        $csosn = new Csosn202();
        $csosn->calcula($produto);

        $this->assertEquals(18, $csosn->percentualIcmsSt);
        $this->assertEquals(0, $csosn->percentualReducaoSt);
        $this->assertEquals(3220, $csosn->valorBcIcmsSt);
        $this->assertEquals(219.6, round($csosn->valorIcmsSt, 2));
    }

    public function testaCalculoComDescontoCondicional()
    {
        $produto = $this->criaProduto();
        $produto->valorProduto = 1900;
        $produto->desconto = 100;

        $csosn = new Csosn202();
        $csosn->tipoDesconto = TipoDesconto::Condicional;
        $csosn->calcula($produto);

        $this->assertEquals(18, $csosn->percentualIcmsSt);
        $this->assertEquals(0, $csosn->percentualReducaoSt);
        $this->assertEquals(3339, $csosn->valorBcIcmsSt);
        $this->assertEquals(241.02, round($csosn->valorIcmsSt, 2));
    }
}
