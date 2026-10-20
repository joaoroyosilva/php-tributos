<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\CstIpi;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\ResultadoTributacao;
use PHPUnit\Framework\TestCase;

/**
 * Composição do `vProd` com IBS/CBS a partir de 2027 (NT 2026.008) e IBS/CBS na base do ICMS
 * (opção do lojista). Os vetores canônicos são os mesmos rodados pela `ts-tributos` e pelos
 * portes dos PDVs. Ao mexer no arquivo de vetores, mexer nos DOIS repos.
 */
class RtcComposicaoVprodTest extends TestCase
{
    private const CAMPOS_UNITARIOS = ['valorUnitarioBruto', 'valorUnitarioLiquido'];

    /**
     * @return array<string, array{0: array<string, mixed>, 1: array<string, float>, 2: string}>
     */
    public static function vetoresCanonicos(): array
    {
        $json = json_decode(
            file_get_contents(__DIR__ . '/Fixtures/rtc-composicao-vprod-vectors.json'),
            true
        );

        $casos = [];

        foreach ($json['vetores'] as $vetor) {
            $casos[$vetor['id']] = [$vetor['entrada'], $vetor['esperado'], $vetor['descricao']];
        }

        return $casos;
    }

    /**
     * @dataProvider vetoresCanonicos
     *
     * @param array<string, mixed> $entrada
     * @param array<string, float> $esperado
     */
    public function testVetorCanonico(array $entrada, array $esperado, string $descricao): void
    {
        $resultado = self::calcular($entrada);

        foreach ($esperado as $campo => $valor) {
            $casas = in_array($campo, self::CAMPOS_UNITARIOS, true) ? 10 : 2;

            $this->assertEquals($valor, round((float) $resultado->{$campo}, $casas), "{$descricao} — {$campo}");
        }
    }

    /**
     * Rodar `calcular()` duas vezes no mesmo resultado não pode acumular: o laço do RTC recalcula
     * tudo várias vezes, e o crédito presumido do IBS era somado com `+=`.
     */
    public function testRecalculoNaoAcumulaCreditoPresumido(): void
    {
        $produto = self::produto([
            'cst'                    => Cst::Cst00,
            'valorProduto'           => 1000,
            'percentualIcms'         => 18,
            'percentualCbs'          => 8.7,
            'percentualIbsUf'        => 0.05,
            'percentualIbsMun'       => 0.05,
            'rtcCompoeValorProduto'  => true,
            'rtcNaBaseIcms'          => true,
        ]);
        $produto->percentualCreditoPresumidoIbs = 50;

        $resultado = new ResultadoTributacao($produto, Crt::RegimeNormal, TipoOperacao::OperacaoInterna, TipoPessoa::Fisica);
        $resultado->calcular();
        $primeiro = $resultado->valorCreditoPresumidoIbs;
        $resultado->calcular();

        $this->assertGreaterThan(0, $primeiro);
        $this->assertEquals($primeiro, $resultado->valorCreditoPresumidoIbs);
        $this->assertEquals(
            round($resultado->valorCreditoPresumidoIbsUF + $resultado->valorCreditoPresumidoIbsMun, 2),
            round($resultado->valorCreditoPresumidoIbs, 2)
        );
    }

    /**
     * O RTC que entra na base do ICMS é calculado pela própria lib: um valor deixado no item por
     * quem chama não pode vazar para a base quando as entradas estão desligadas.
     */
    public function testValorRtcDeixadoNoItemNaoEntraNaBaseComEntradasDesligadas(): void
    {
        $produto = self::produto(['cst' => Cst::Cst00, 'valorProduto' => 100, 'percentualIcms' => 18, 'percentualCbs' => 8.7]);
        $produto->valorRtcBaseIcms = 50;

        $resultado = (new ResultadoTributacao($produto, Crt::RegimeNormal, TipoOperacao::OperacaoInterna, TipoPessoa::Fisica))
            ->calcular();

        $this->assertEquals(100.0, $resultado->valorBcIcms);
        $this->assertEquals(18.0, $resultado->valorIcms);
    }

    /**
     * Serviço não tem ICMS: o RTC compõe o valor do item, mas não há laço nem base de ICMS.
     */
    public function testServicoComposicaoSemLacoDeIcms(): void
    {
        $produto = self::produto([
            'valorProduto'          => 200,
            'percentualCbs'         => 8.7,
            'rtcCompoeValorProduto' => true,
            'rtcNaBaseIcms'         => true,
        ]);
        $produto->isServico = true;

        $resultado = (new ResultadoTributacao($produto, Crt::RegimeNormal, TipoOperacao::OperacaoInterna, TipoPessoa::Fisica))
            ->calcular();

        $this->assertEquals(0.0, $resultado->valorBcIcms);
        $this->assertEquals(17.4, round($resultado->valorEfetivoCbs, 2));
        $this->assertEquals(217.4, round($resultado->valorProdutoBruto, 2));
        $this->assertEquals(0.0, (float) $produto->valorRtcBaseIcms);
    }

    /**
     * @param array<string, mixed> $entrada
     */
    private static function calcular(array $entrada): ResultadoTributacao
    {
        $produto = self::produto($entrada);

        return (new ResultadoTributacao(
            $produto,
            $entrada['crt'] ?? Crt::RegimeNormal,
            $entrada['tipoOperacao'] ?? TipoOperacao::OperacaoInterna,
            ($entrada['tipoPessoa'] ?? 'Fisica') === 'Juridica' ? TipoPessoa::Juridica : TipoPessoa::Fisica
        ))->calcular();
    }

    /**
     * @param array<string, mixed> $entrada
     */
    private static function produto(array $entrada): Produto
    {
        $produto = new Produto();
        $produto->cst                         = $entrada['cst'] ?? null;
        $produto->csosn                       = $entrada['csosn'] ?? null;
        $produto->cstPisCofins                = $entrada['cstPisCofins'] ?? 7;
        $produto->cstIpi                      = CstIpi::Cst53;
        $produto->deduzIcmsPisCofins          = $entrada['deduzIcmsPisCofins'] ?? false;
        $produto->valorProduto                = $entrada['valorProduto'] ?? 0;
        $produto->quantidadeProduto           = $entrada['quantidadeProduto'] ?? 1;
        $produto->frete                       = $entrada['frete'] ?? 0;
        $produto->seguro                      = $entrada['seguro'] ?? 0;
        $produto->outrasDespesas              = $entrada['outrasDespesas'] ?? 0;
        $produto->desconto                    = $entrada['desconto'] ?? 0;
        $produto->percentualIcms              = $entrada['percentualIcms'] ?? 0;
        $produto->percentualReducao           = $entrada['percentualReducao'] ?? 0;
        $produto->percentualFcp               = $entrada['percentualFcp'] ?? 0;
        $produto->percentualDiferimento       = $entrada['percentualDiferimento'] ?? 0;
        $produto->percentualMva               = $entrada['percentualMva'] ?? 0;
        $produto->percentualIcmsSt            = $entrada['percentualIcmsSt'] ?? 0;
        $produto->percentualReducaoSt         = $entrada['percentualReducaoSt'] ?? 0;
        $produto->percentualCredito           = $entrada['percentualCredito'] ?? 0;
        $produto->percentualDifalInterna      = $entrada['percentualDifalInterna'] ?? 0;
        $produto->percentualDifalInterstadual = $entrada['percentualDifalInterestadual'] ?? 0;
        $produto->percentualPis               = $entrada['percentualPis'] ?? 0;
        $produto->percentualCofins            = $entrada['percentualCofins'] ?? 0;
        $produto->percentualCbs               = $entrada['percentualCbs'] ?? 0;
        $produto->reducaoCbs                  = $entrada['reducaoCbs'] ?? 0;
        $produto->percentualDiferimentoCbs    = $entrada['percentualDiferimentoCbs'] ?? 0;
        $produto->percentualIbsUf             = $entrada['percentualIbsUf'] ?? 0;
        $produto->reducaoIbsUf                = $entrada['reducaoIbsUf'] ?? 0;
        $produto->percentualDiferimentoIbsUf  = $entrada['percentualDiferimentoIbsUf'] ?? 0;
        $produto->percentualIbsMun            = $entrada['percentualIbsMun'] ?? 0;
        $produto->reducaoIbsMun               = $entrada['reducaoIbsMun'] ?? 0;
        $produto->percentualDiferimentoIbsMun = $entrada['percentualDiferimentoIbsMun'] ?? 0;
        $produto->rtcCompoeValorProduto       = $entrada['rtcCompoeValorProduto'] ?? false;
        $produto->rtcNaBaseIcms               = $entrada['rtcNaBaseIcms'] ?? false;

        return $produto;
    }
}
