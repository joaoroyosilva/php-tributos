<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\CstPisCofins;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\Csosn\Csosn202;
use PhpTributos\Impostos\Cst\Cst10;
use PhpTributos\Impostos\ResultadoTributacao;
use PHPUnit\Framework\TestCase;

/**
 * Fórmula da base do ICMS-ST: desconto e redução ST aplicados uma vez só, e ST nunca negativo.
 * Casos C1–C4, C6, C7, C10 e C16 da change correcao-formula-icms-st (Tabela C).
 */
class CalculaIcmsStFormulaTest extends TestCase
{
    private function criaProduto(
        float $percentualIcms = 12,
        float $percentualIcmsSt = 18,
        float $percentualMva = 70,
        float $desconto = 0,
        float $percentualReducaoSt = 0
    ): Produto {
        $produto = new Produto();
        $produto->valorProduto = 100;
        $produto->quantidadeProduto = 1;
        $produto->percentualIcms = $percentualIcms;
        $produto->percentualIcmsSt = $percentualIcmsSt;
        $produto->percentualMva = $percentualMva;
        $produto->desconto = $desconto;
        $produto->percentualReducaoSt = $percentualReducaoSt;

        return $produto;
    }

    public static function casos(): array
    {
        // [icms, icmsSt, mva, desconto, reducaoSt, baseSt esperada, ST esperado]
        return [
            'C1 sem desconto, sem redução' => [12, 18, 70, 0, 0, 170.00, 18.60],
            'C2 desconto 10' => [12, 18, 70, 10, 0, 153.00, 16.74],
            'C3 redução ST 30%' => [12, 18, 70, 0, 30, 119.00, 9.42],
            'C4 redução 30% + desconto 10' => [12, 18, 70, 10, 30, 107.10, 8.48],
            'C6 ST abaixo do ICMS próprio vira 0' => [17, 12, 0, 0, 0, 100.00, 0.00],
            'C10a 17/17 desconto 10' => [17, 17, 70, 10, 0, 153.00, 10.71],
            'C10b 17/17 redução 30%' => [17, 17, 70, 0, 30, 119.00, 3.23],
        ];
    }

    /**
     * @dataProvider casos
     */
    public function testCsosn202(
        float $icms,
        float $icmsSt,
        float $mva,
        float $desconto,
        float $reducaoSt,
        float $baseEsperada,
        float $stEsperado
    ) {
        $csosn = new Csosn202();
        $csosn->calcula($this->criaProduto($icms, $icmsSt, $mva, $desconto, $reducaoSt));

        $this->assertEquals($baseEsperada, round($csosn->valorBcIcmsSt, 2));
        $this->assertEquals($stEsperado, round($csosn->valorIcmsSt, 2));
    }

    /**
     * @dataProvider casos
     */
    public function testCst10DaOMesmoQueCsosn202(
        float $icms,
        float $icmsSt,
        float $mva,
        float $desconto,
        float $reducaoSt,
        float $baseEsperada,
        float $stEsperado
    ) {
        $cst = new Cst10();
        $cst->calcula($this->criaProduto($icms, $icmsSt, $mva, $desconto, $reducaoSt));

        $this->assertEquals($baseEsperada, round($cst->valorBcIcmsSt, 2));
        $this->assertEquals($stEsperado, round($cst->valorIcmsSt, 2));
    }

    public function testC6StNuncaNegativoMantemABase()
    {
        $produto = $this->criaProduto(17, 12, 0);
        $resultado = (new FacadeCalculadoraTributacao($produto))->calculaIcmsSt();

        $this->assertSame(0.0, (float) $resultado->valorIcmsSt);
        $this->assertEquals(100, $resultado->baseCalculoIcmsSt);
        $this->assertEquals(17, $resultado->valorIcmsProprio);
    }

    public function testC7FcpStUsaAMesmaBaseDoSt()
    {
        $produto = $this->criaProduto(12, 18, 70, 10);
        $produto->percentualFcpSt = 2;

        $resultado = (new FacadeCalculadoraTributacao($produto))->calculaFcpSt();

        $this->assertEquals(153.00, round($resultado->baseCalculoFcpSt, 2));
        $this->assertEquals(3.06, round($resultado->valorFcpSt, 2));
    }

    public function testC16AliquotaStZeroZeraTudo()
    {
        $csosn = new Csosn202();
        $csosn->calcula($this->criaProduto(17, 0, 70));

        $this->assertEquals(0, $csosn->valorBcIcmsSt);
        $this->assertEquals(0, $csosn->valorIcmsSt);

        $resultado = (new FacadeCalculadoraTributacao($this->criaProduto(17, 0, 70)))->calculaIcmsSt();
        $this->assertEquals(0, $resultado->valorIcmsProprio);
    }

    /**
     * Cst10 gravava o objeto ResultadoCalculoIpi em valorIpi; PIS/COFINS 01/02 somam valorIpi
     * e estouravam TypeError (float + ResultadoCalculoIpi).
     */
    public function testCst10ComIpiEPisCofins01NaoEstoura()
    {
        $produto = new Produto();
        $produto->cst = Cst::Cst10;
        $produto->cstPisCofins = CstPisCofins::Cst01;
        $produto->valorProduto = 100;
        $produto->quantidadeProduto = 1;
        $produto->percentualIcms = 17;
        $produto->percentualIcmsSt = 17;
        $produto->percentualMva = 40;
        $produto->percentualIpi = 10;
        $produto->percentualPis = 1.65;
        $produto->percentualCofins = 7.6;

        $resultado = (new ResultadoTributacao(
            $produto,
            Crt::RegimeNormal,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Juridica
        ))->calcular();

        $this->assertIsFloat($produto->valorIpi);
        $this->assertEquals(10, $produto->valorIpi);
        $this->assertEquals(10, $resultado->valorIpi);
        $this->assertGreaterThan(0, $resultado->valorPis);
        $this->assertGreaterThan(0, $resultado->valorCofins);
        $this->assertEquals(6.8, round($resultado->valorIcmsSt, 2));
    }
}
