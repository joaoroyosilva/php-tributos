<?php

namespace PhpTributos\Impostos\Tributacoes;

use PhpTributos\Exceptions\ArgumentException;
use PhpTributos\Impostos\CalculosDeBc\CalculaBaseCalculoCbsIbs;
use PhpTributos\Impostos\ResultadoCalculoTribRegular;
use PhpTributos\Impostos\ResultadoTributacao;
use PhpTributos\Impostos\Tributavel;

/**
 * Tributação regular — grupo `gTribRegular` do `gIBSCBS` (NT 2025.002-RTC, UB68).
 *
 * É um cálculo **independente** sobre a mesma base do item, não uma variação do cálculo do
 * item: quando o `cClassTrib` do item tem o indicador de tributação regular, a alíquota do
 * item é zero por definição (Exceção 1 das RVs UB18-10/1026, UB37-10/1036 e UB56-10/20/1037),
 * então não há de onde derivar. As alíquotas nominais e as reduções chegam pelo par regular
 * (`percentualRegular*` / `reducaoRegular*`), que descreve outro `cClassTrib`.
 *
 * A alíquota efetiva segue a mesma fórmula de `TributacaoCbs::calculaAliquotaEfetiva`
 * (`nominal × (1 - redução/100)`, 2 casas), aplicada ao par regular. O redutor de compra
 * governamental NÃO entra: ele reduz o imposto efetivamente devido, e o grupo declara a
 * tributação cheia hipotética.
 */
class TributacaoTribRegular
{
    /**
     * @var CalculaBaseCalculoCbsIbs|null
     */
    private $calculaBaseCalculo;

    /**
     * @var Tributavel
     */
    private $tributavel;

    /**
     * O `ResultadoTributacao` só é necessário para compor a base de cálculo (que desconta
     * ICMS/ISS/PIS/COFINS/FCP já apurados). Quem já tem o `vBC` do item na mão usa
     * `calculaSobreBase()` e dispensa o parâmetro.
     */
    public function __construct(Tributavel $tributavel, ?ResultadoTributacao $resultadoTributacao = null)
    {
        $this->tributavel = $tributavel;
        $this->calculaBaseCalculo = $resultadoTributacao
            ? new CalculaBaseCalculoCbsIbs($tributavel, $resultadoTributacao)
            : null;
    }

    public function calcula(): ResultadoCalculoTribRegular
    {
        if (! $this->calculaBaseCalculo) {
            throw new ArgumentException(
                'Sem ResultadoTributacao não há como compor a base — use calculaSobreBase().'
            );
        }

        if (! $this->tributavel->possuiTributacaoRegular) {
            return new ResultadoCalculoTribRegular();
        }

        return $this->calculaComBase($this->calculaBaseCalculo->calculaBaseCalculoBase());
    }

    /**
     * Mesma conta com a base de cálculo vinda de fora — para quem já tem o `vBC` do item
     * apurado e não quer refazer a composição da base (é o caso do backend, que grava a base
     * do item e depois resolve o grupo regular a partir dela).
     */
    public function calculaSobreBase(float $baseCalculo): ResultadoCalculoTribRegular
    {
        if (! $this->tributavel->possuiTributacaoRegular) {
            return new ResultadoCalculoTribRegular();
        }

        return $this->calculaComBase($baseCalculo);
    }

    private function calculaComBase(float $baseCalculo): ResultadoCalculoTribRegular
    {
        $percentualIbsUf = $this->calculaAliquotaEfetiva(
            $this->tributavel->percentualRegularIbsUf,
            $this->tributavel->reducaoRegularIbsUf
        );

        $percentualIbsMun = $this->calculaAliquotaEfetiva(
            $this->tributavel->percentualRegularIbsMun,
            $this->tributavel->reducaoRegularIbsMun
        );

        $percentualCbs = $this->calculaAliquotaEfetiva(
            $this->tributavel->percentualRegularCbs,
            $this->tributavel->reducaoRegularCbs
        );

        return new ResultadoCalculoTribRegular(
            $baseCalculo,
            $percentualIbsUf,
            $this->calculaValor($baseCalculo, $percentualIbsUf),
            $percentualIbsMun,
            $this->calculaValor($baseCalculo, $percentualIbsMun),
            $percentualCbs,
            $this->calculaValor($baseCalculo, $percentualCbs)
        );
    }

    /**
     * Sem redução a alíquota efetiva É a nominal — não se arredonda o que não passou por conta,
     * senão uma alíquota de 4 casas (0,0975) perderia casas por engano.
     */
    private function calculaAliquotaEfetiva(float $nominal, float $reducao): float
    {
        if ($reducao == 0) {
            return $nominal;
        }

        return round($nominal * (1 - $reducao / 100), 2);
    }

    /**
     * `vTribReg = vBC × pAliqEfetReg / 100`, 2 casas — RVs UB72-10 (1040), UB72b-10 (1051) e
     * UB72d-10 (1068), que aceitam tolerância de R$ 0,01.
     */
    private function calculaValor(float $baseCalculo, float $aliquota): float
    {
        return round(($baseCalculo * $aliquota) / 100, 2);
    }
}
