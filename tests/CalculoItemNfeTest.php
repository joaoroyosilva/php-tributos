<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\CstIpi;
use PhpTributos\Flags\CstPisCofins;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\ResultadoTributacao;
use PHPUnit\Framework\TestCase;

class CalculoItemNfeTest extends TestCase
{
    public function testaCalculoItem()
    {
        $produto = new Produto();
        $produto->valorProduto = 1000;
        $produto->quantidadeProduto = 1;
        $produto->cst = Cst::Cst00;
        $produto->percentualIcms = 17;

        $produto->cstPisCofins = CstPisCofins::Cst01;
        $produto->percentualCofins = 3;
        $produto->percentualPis = 1.65;

        $produto->cstIpi = CstIpi::Cst50;
        $produto->percentualIpi = 5;

        $calculo = new ResultadoTributacao(
            $produto,
            Crt::RegimeNormal,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Fisica
        );

        $resultado = $calculo->calcular();

        $this->assertEquals(1000, $resultado->valorBcIcms);
        $this->assertEquals(170, $resultado->valorIcms);
        $this->assertEquals(50, $resultado->valorIpi);
        $this->assertEquals(30, $resultado->valorCofins);
        $this->assertEquals(16.5, $resultado->valorPis);

    }
}
