<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\ResultadoTributacao;
use PHPUnit\Framework\TestCase;

/**
 * Defeitos do IBS que o CBS não tinha, corrigidos junto com a tributação regular. Os três
 * cálculos (CBS, IBS UF, IBS Mun) são a MESMA fórmula com parâmetros diferentes — quando um
 * diverge dos outros dois, é erro de digitação, e o teste passa a segurar isso.
 */
class CalculoIbsCorrecoesTest extends TestCase
{
    private function produtoBase(): Produto
    {
        $produto = new Produto();
        $produto->cst               = Cst::Cst00;
        $produto->quantidadeProduto = 1;
        $produto->valorProduto      = 1000;
        $produto->percentualCbs     = 8.8;
        $produto->percentualIbsUf   = 11.2;
        $produto->percentualIbsMun  = 1.8;

        return $produto;
    }

    private function calcula(Produto $produto): ResultadoTributacao
    {
        return (new ResultadoTributacao(
            $produto,
            Crt::RegimeNormal,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Juridica
        ))->calcular();
    }

    /**
     * O diferimento do IBS UF usava `(percentual - 100)` onde CBS e IBS Mun usam `/ 100` — com
     * 50% de diferimento o valor diferido saía R$ -25.000 em vez de R$ 56,00.
     */
    public function testDiferimentoDoIbsUfUsaPercentualEnaoSubtracao(): void
    {
        $produto = $this->produtoBase();
        $produto->percentualDiferimentoCbs    = 50;
        $produto->percentualDiferimentoIbsUf  = 50;
        $produto->percentualDiferimentoIbsMun = 50;

        $resultado = $this->calcula($produto);

        $this->assertEquals(44.0, $resultado->valorDiferidoCbs);
        $this->assertEquals(56.0, $resultado->valorDiferidoIbsUF);
        $this->assertEquals(9.0, $resultado->valorDiferidoIbsMun);
    }

    /**
     * No ramo de compra governamental, IBS UF e IBS Mun partiam da REDUÇÃO em vez da alíquota
     * nominal — com redução de 20% e redutor de 30%, a efetiva do IBS UF saía 11,20 em vez de
     * 6,27.
     */
    public function testCompraGovernamentalPartemDaAliquotaNominal(): void
    {
        $produto = $this->produtoBase();
        $produto->percentualRedutorCompraGov = 30;
        $produto->reducaoCbs                 = 20;
        $produto->reducaoIbsUf               = 20;
        $produto->reducaoIbsMun              = 20;

        $resultado = $this->calcula($produto);

        $this->assertEquals(4.93, $resultado->percentualEfetivoCbs);
        $this->assertEquals(6.27, $resultado->percentualEfetivoIbsUF);
        $this->assertEquals(1.01, $resultado->percentualEfetivoIbsMun);
    }
}
