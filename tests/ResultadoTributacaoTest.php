<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\ResultadoTributacao;
use PHPUnit\Framework\TestCase;

class ResultadoTributacaoTest extends TestCase
{
    public function testResultadoTributacao()
    {
        $produto = new Produto();
        $produto->cst = Cst::Cst00;
        $produto->csosn = Csosn::Csosn102;
        $produto->percentualCofins = 15;
        $produto->percentualFcp = 1;
        $produto->percentualIcms = 18;
        $produto->percentualPis = 5;
        $produto->quantidadeProduto = 9;
        $produto->valorProduto = 23;
        $produto->percentualDifalInterna = 18;
        $produto->percentualDifalInterstadual = 12;

        //RTC
        $produto->percentualCbs = 0.9;
        $produto->percentualIbsUf = 0.1;

        $tributacao = new ResultadoTributacao(
            $produto,
            Crt::RegimeNormal,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Juridica
        );

        $result = $tributacao->calcular();

        $this->assertEquals(2.07, $result->fcp);
        $this->assertEquals(37.26, $result->valorIcms);

        $this->assertEquals(1.51, $result->valorCbs);
        $this->assertEquals(0.17, $result->valorIbsUF);
    }

    public function testResultadoTributacaoComReducaoCbs()
    {
        $produto = new Produto();
        $produto->cst = Cst::Cst00;
        $produto->csosn = Csosn::Csosn102;
        $produto->percentualCofins = 15;
        $produto->percentualFcp = 1;
        $produto->percentualIcms = 18;
        $produto->percentualPis = 5;
        $produto->quantidadeProduto = 9;
        $produto->valorProduto = 23;
        $produto->percentualDifalInterna = 18;
        $produto->percentualDifalInterstadual = 12;

        //RTC
        $produto->percentualCbs = 0.9;
        $produto->percentualIbsUf = 0.1;
        $produto->reducaoCbs = 60;

        $tributacao = new ResultadoTributacao(
            $produto,
            Crt::RegimeNormal,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Juridica
        );

        $result = $tributacao->calcular();

        $this->assertEquals(2.07, $result->fcp);
        $this->assertEquals(37.26, $result->valorIcms);

        $this->assertEquals(1.51, $result->valorCbs);
        $this->assertEquals(0.36, $result->percentualEfetivoCbs);
        $this->assertEquals(0.17, $result->valorIbsUF);
    }

    public function testResultadoTributacaoSimplesNacional()
    {
        $produto = new Produto();
        $produto->cst = Cst::Cst00;
        $produto->csosn = Csosn::Csosn102;
        $produto->percentualCofins = 15;
        $produto->percentualFcp = 1;
        $produto->percentualIcms = 18;
        $produto->percentualPis = 5;
        $produto->quantidadeProduto = 9;
        $produto->valorProduto = 23;
        $produto->percentualDifalInterna = 18;
        $produto->percentualDifalInterstadual = 12;

        //RTC
        $produto->percentualCbs = 0.9;
        $produto->percentualIbsUf = 0.1;

        $tributacao = new ResultadoTributacao(
            $produto,
            Crt::SimplesNacional,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Juridica
        );

        $result = $tributacao->calcular();

        $this->assertEquals(0, $result->fcp);
        $this->assertEquals(0, $result->valorIcms);

        $this->assertEquals(0.9, $result->percentualEfetivoCbs);
        $this->assertEquals(0.21, $result->valorIbsUF);
    }
}
