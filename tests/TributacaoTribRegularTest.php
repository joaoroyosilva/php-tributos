<?php

namespace PhpTributos\Tests;

use PhpTributos\Entidades\Produto;
use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\ResultadoTributacao;
use PHPUnit\Framework\TestCase;

/**
 * Tributação regular (`gTribRegular`) — os vetores canônicos são os mesmos rodados pela
 * `ts-tributos`. Ao mexer no arquivo de vetores, mexer nos DOIS repos.
 */
class TributacaoTribRegularTest extends TestCase
{
    /**
     * @return array<string, array{0: array<string, mixed>, 1: array<string, float>, 2: string}>
     */
    public static function vetoresCanonicos(): array
    {
        $json = json_decode(
            file_get_contents(__DIR__ . '/Fixtures/tributacao-regular-vectors.json'),
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
        $produto = new Produto();
        $produto->possuiTributacaoRegular = $entrada['possuiTributacaoRegular'];
        $produto->percentualRegularIbsUf  = $entrada['percentualRegularIbsUf'];
        $produto->reducaoRegularIbsUf     = $entrada['reducaoRegularIbsUf'];
        $produto->percentualRegularIbsMun = $entrada['percentualRegularIbsMun'];
        $produto->reducaoRegularIbsMun    = $entrada['reducaoRegularIbsMun'];
        $produto->percentualRegularCbs    = $entrada['percentualRegularCbs'];
        $produto->reducaoRegularCbs       = $entrada['reducaoRegularCbs'];

        $resultado = (new FacadeCalculadoraTributacao($produto))
            ->calculaTribRegular($entrada['baseCalculo']);

        $this->assertEquals($esperado['percentualEfetivoRegIbsUf'], $resultado->percentualEfetivoRegIbsUf, $descricao);
        $this->assertEquals($esperado['valorTribRegIbsUf'], $resultado->valorTribRegIbsUf, $descricao);
        $this->assertEquals($esperado['percentualEfetivoRegIbsMun'], $resultado->percentualEfetivoRegIbsMun, $descricao);
        $this->assertEquals($esperado['valorTribRegIbsMun'], $resultado->valorTribRegIbsMun, $descricao);
        $this->assertEquals($esperado['percentualEfetivoRegCbs'], $resultado->percentualEfetivoRegCbs, $descricao);
        $this->assertEquals($esperado['valorTribRegCbs'], $resultado->valorTribRegCbs, $descricao);
    }

    /**
     * O grupo regular sai do MESMO `calcular()` que o resto do item, sobre a mesma base do
     * IBS/CBS — não é um cálculo à parte que alguém precise lembrar de disparar.
     */
    public function testCalculoIntegradoUsaMesmaBaseDoIbsCbs(): void
    {
        $produto = new Produto();
        $produto->cst               = Cst::Cst00;
        $produto->quantidadeProduto = 1;
        $produto->valorProduto      = 1000;

        // Alíquotas do item zeradas: é o que a NT exige de um item com tributação regular.
        $produto->percentualCbs    = 0;
        $produto->percentualIbsUf  = 0;
        $produto->percentualIbsMun = 0;

        $produto->possuiTributacaoRegular = true;
        $produto->percentualRegularIbsUf  = 11.2;
        $produto->percentualRegularIbsMun = 1.8;
        $produto->percentualRegularCbs    = 8.8;

        $resultado = (new ResultadoTributacao(
            $produto,
            Crt::RegimeNormal,
            TipoOperacao::OperacaoInterna,
            TipoPessoa::Juridica
        ))->calcular();

        $this->assertEquals($resultado->baseCalculoCbs, $resultado->baseCalculoTribRegular);
        $this->assertEquals(0.0, $resultado->valorEfetivoCbs);
        $this->assertEquals(88.0, $resultado->valorTribRegCbs);
        $this->assertEquals(112.0, $resultado->valorTribRegIbsUF);
        $this->assertEquals(18.0, $resultado->valorTribRegIbsMun);
    }
}
