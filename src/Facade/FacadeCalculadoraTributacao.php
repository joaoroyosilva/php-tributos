<?php

namespace PhpTributos\Facade;

use PhpTributos\Flags\TipoCalculoIcmsDesonerado;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\ResultadoCalculoCofins;
use PhpTributos\Impostos\ResultadoCalculoCredito;
use PhpTributos\Impostos\ResultadoCalculoDifal;
use PhpTributos\Impostos\ResultadoCalculoFcp;
use PhpTributos\Impostos\ResultadoCalculoFcpSt;
use PhpTributos\Impostos\ResultadoCalculoIbpt;
use PhpTributos\Impostos\ResultadoCalculoIcms;
use PhpTributos\Impostos\ResultadoCalculoIcmsDesonerado;
use PhpTributos\Impostos\ResultadoCalculoIcmsEfetivo;
use PhpTributos\Impostos\ResultadoCalculoIcmsSt;
use PhpTributos\Impostos\ResultadoCalculoIpi;
use PhpTributos\Impostos\ResultadoCalculoPis;
use PhpTributos\Impostos\Tributacoes\TributacaoCofins;
use PhpTributos\Impostos\Tributacoes\TributacaoCreditoIcms;
use PhpTributos\Impostos\Tributacoes\TributacaoDifal;
use PhpTributos\Impostos\Tributacoes\TributacaoFcp;
use PhpTributos\Impostos\Tributacoes\TributacaoFcpSt;
use PhpTributos\Impostos\Tributacoes\TributacaoIbpt;
use PhpTributos\Impostos\Tributacoes\TributacaoIcms;
use PhpTributos\Impostos\Tributacoes\TributacaoIcmsDesonerado;
use PhpTributos\Impostos\Tributacoes\TributacaoIcmsEfetivo;
use PhpTributos\Impostos\Tributacoes\TributacaoIcmsSt;
use PhpTributos\Impostos\Tributacoes\TributacaoIpi;
use PhpTributos\Impostos\Tributacoes\TributacaoPis;
use PhpTributos\Impostos\Tributavel;

class FacadeCalculadoraTributacao
{
    /**
     * @param Tributavel $tributavel
     * @param string $tipoDesconto
     * @param string $tipoCalculoIcmsDesonerado
     */
    public function __construct(
        public Tributavel $tributavel,
        public string $tipoDesconto = TipoDesconto::Incondicional,
        public string $tipoCalculoIcmsDesonerado = TipoCalculoIcmsDesonerado::BasePorDentro
    ) {
    }

    public function calculaIcms(): ResultadoCalculoIcms
    {
        $icms = new TributacaoIcms($this->tributavel, $this->tipoDesconto);
        return $icms->calcula();
    }

    public function calculaIcmsEfetivo(): ResultadoCalculoIcmsEfetivo
    {
        $icms = new TributacaoIcmsEfetivo($this->tributavel, $this->tipoDesconto);
        return $icms->calcula();
    }

    public function calculaIcmsDesonerado(): ResultadoCalculoIcmsDesonerado
    {
        $icms = new TributacaoIcmsDesonerado(
            $this->tributavel,
            $this->tipoDesconto,
            $this->tipoCalculoIcmsDesonerado
        );
        return $icms->calcula();
    }

    public function calculaIpi(): ResultadoCalculoIpi
    {
        $ipi = new TributacaoIpi($this->tributavel, $this->tipoDesconto);
        return $ipi->calcula();
    }

    public function calculaCreditoIcms(): ResultadoCalculoCredito
    {
        $credito = new TributacaoCreditoIcms($this->tributavel, $this->tipoDesconto);
        return $credito->calcula();
    }

    public function calculaCofins(): ResultadoCalculoCofins
    {
        $cofins = new TributacaoCofins($this->tributavel, $this->tipoDesconto);
        return $cofins->calcula();
    }

    public function calculaPis(): ResultadoCalculoPis
    {
        $pis = new TributacaoPis($this->tributavel, $this->tipoDesconto);
        return $pis->calcula();
    }

    public function calculaDifal(): ResultadoCalculoDifal
    {
        $difal = new TributacaoDifal($this->tributavel, $this->tipoDesconto);
        return $difal->calcula();
    }

    public function calculaIcmsSt(): ResultadoCalculoIcmsSt
    {
        $icmsSt = new TributacaoIcmsSt($this->tributavel, $this->tipoDesconto);
        return $icmsSt->calcula();
    }

    public function calculaIbpt(): ResultadoCalculoIbpt
    {
        $ibpt = new TributacaoIbpt($this->tributavel);
        return $ibpt->calcula();
    }

    public function calculaFcp(): ResultadoCalculoFcp
    {
        $fcp = new TributacaoFcp($this->tributavel, $this->tipoDesconto);
        return $fcp->calcula();
    }

    public function calculaFcpSt(): ResultadoCalculoFcpSt
    {
        $fcpSt = new TributacaoFcpSt($this->tributavel, $this->tipoDesconto);
        return $fcpSt->calcula();
    }
}
