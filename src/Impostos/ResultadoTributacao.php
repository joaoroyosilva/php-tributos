<?php

namespace PhpTributos\Impostos;

use PhpTributos\Flags\Crt;
use PhpTributos\Flags\Csosn;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\CstIpi;
use PhpTributos\Flags\CstPisCofins;
use PhpTributos\Flags\ModalidadeDeterminacaoBcIcmsSt;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Flags\TipoOperacao;
use PhpTributos\Flags\TipoPessoa;
use PhpTributos\Impostos\Csosn\Base\CsosnBase;
use PhpTributos\Impostos\Csosn\Csosn101;
use PhpTributos\Impostos\Csosn\Csosn102;
use PhpTributos\Impostos\Csosn\Csosn103;
use PhpTributos\Impostos\Csosn\Csosn201;
use PhpTributos\Impostos\Csosn\Csosn202;
use PhpTributos\Impostos\Csosn\Csosn203;
use PhpTributos\Impostos\Csosn\Csosn300;
use PhpTributos\Impostos\Csosn\Csosn400;
use PhpTributos\Impostos\Csosn\Csosn500;
use PhpTributos\Impostos\Csosn\Csosn900;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Cst\Cst00;
use PhpTributos\Impostos\Cst\Cst10;
use PhpTributos\Impostos\Cst\Cst20;
use PhpTributos\Impostos\Cst\Cst30;
use PhpTributos\Impostos\Cst\Cst41;
use PhpTributos\Impostos\Cst\Cst50;
use PhpTributos\Impostos\Cst\Cst51;
use PhpTributos\Impostos\Cst\Cst60;
use PhpTributos\Impostos\Cst\Cst70;
use PhpTributos\Impostos\Cst\Cst90;
use PhpTributos\Impostos\Tributacoes\TributacaoCbs;
use PhpTributos\Impostos\Tributacoes\TributacaoCofins;
use PhpTributos\Impostos\Tributacoes\TributacaoDifal;
use PhpTributos\Impostos\Tributacoes\TributacaoFcp;
use PhpTributos\Impostos\Tributacoes\TributacaoIbpt;
use PhpTributos\Impostos\Tributacoes\TributacaoIbsMun;
use PhpTributos\Impostos\Tributacoes\TributacaoIbsUf;
use PhpTributos\Impostos\Tributacoes\TributacaoIpi;
use PhpTributos\Impostos\Tributacoes\TributacaoIssqn;
use PhpTributos\Impostos\Tributacoes\TributacaoPis;

class ResultadoTributacao
{
    /**
     * @var CstBase
     */
    private $icms;

    /**
     * @var CsosnBase
     */
    private $csosn;

    /**
     * @var TributacaoPis
     */
    private $pis;

    /**
     * @var TributacaoCofins
     */
    private $cofins;

    /**
     * @var TributacaoIpi
     */
    private $ipi;

    /**
     * @var TributacaoDifal
     */
    private $difal;

    /**
     * @var TributacaoFcp
     */
    private $tributacaoFcp;

    /**
     * @var TributacaoIssqn
     */
    private $issqn;

    /**
     * @var TributacaoIbpt
     */
    private $ibpt;

    /**
     * @var TributacaoCbs
     */
    private $tributacaoCbs;

    /**
     * @var TributacaoIbsUf
     */
    private $tributacaoIbsUf;

    /**
     * @var TributacaoIbsMun
     */
    private $tributacaoIbsMun;

    /**
     * @var float
     */
    public $percentualReducao = 0;

    /**
     * @var float
     */
    public $percentualIcms = 0;

    /**
     * @var float
     */
    public $percentualIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $percentualCredito = 0;

    /**
     * @var float
     */
    public $percentualReducaoSt = 0;

    /**
     * @var float
     */
    public $percentualMva = 0;

    /**
     * @var float
     */
    public $percentualIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualReducaoIcmsBc = 0;

    /**
     * @var float
     */
    public $percentualBcStRetido = 0;

    /**
     * @var float
     */
    public $percentualDiferimento = 0;

    /**
     * @var float
     */
    public $valorIcmsDiferido = 0;

    /**
     * @var float
     */
    public $valorIcmsOperacao = 0;

    /**
     * @var float
     */
    public $valorBcIcms = 0;

    /**
     * @var float
     */
    public $valorBcIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $valorIcms = 0;

    /**
     * @var float
     */
    public $valorIcmsEfetivo = 0;

    /**
     * @var float
     */
    public $valorBcIcmsSt = 0;

    /**
     * @var float
     */
    public $valorIcmsSt = 0;

    /**
     * @var float
     */
    public $valorCredito = 0;

    /**
     * @var float
     */
    public $valorBcStRetido = 0;

    /**
     * @var float
     */
    public $valorIcmsDesonerado = 0;

    /**
     * @var float
     */
    public $valorBcCofins = 0;

    /**
     * @var float
     */
    public $valorCofins = 0;

    /**
     * @var float
     */
    public $valorBcPis = 0;

    /**
     * @var float
     */
    public $valorPis = 0;

    /**
     * @var float
     */
    public $valorBcIpi = 0;

    /**
     * @var float
     */
    public $valorIpi = 0;

    /**
     * @var float
     */
    public $valorBcDifal = 0;

    /**
     * @var float
     */
    public $valorBcFcp = 0;

    /**
     * @var float
     */
    public $fcp = 0;

    /**
     * @var float
     */
    public $valorDifal = 0;

    /**
     * @var float
     */
    public $valorIcmsOrigem = 0;

    /**
     * @var float
     */
    public $valorIcmsDestino = 0;

    /**
     * @var float
     */
    public $valorIss = 0;

    /**
     * @var float
     */
    public $baseCalculoIss = 0;

    /**
     * @var float
     */
    public $percentualIss = 0;

    /**
     * @var float
     */
    public $baseCalculoInss = 0;

    /**
     * @var float
     */
    public $baseCalculoIrrf = 0;

    /**
     * @var float
     */
    public $valorRetCofins = 0;

    /**
     * @var float
     */
    public $valorRetPis = 0;

    /**
     * @var float
     */
    public $valorRetIrrf = 0;

    /**
     * @var float
     */
    public $valorRetInss = 0;

    /**
     * @var float
     */
    public $valorRetCsll = 0;

    /**
     * @var float
     */
    public $valorTributacaoFederal = 0;

    /**
     * @var float
     */
    public $valorTributacaoFederalImportados = 0;

    /**
     * @var float
     */
    public $valorTributacaoEstadual = 0;

    /**
     * @var float
     */
    public $valorTributacaoMunicipal = 0;

    /**
     * @var float
     */
    public $valorTotalTributos = 0;

    /**
     * @var TributavelProduto
     */
    private $produto;

    /**
     * @var int
     */
    private $crt;

    /**
     * @var int
     */
    private $tipoOperacao;

    /**
     * @var string
     */
    private $tipoPessoa;

    /**
     * @var string
     */
    private $tipoDesconto;

    /**
     * @var float
     *  */
    public float $baseCalculoCbs = 0;
    /**
     * @var float
     */
    public float $valorCbs = 0;
    /**
     * @var float
     *
     */
    public float $valorDiferidoCbs = 0;
    /**
     * @var float
     *
     */
    public float $percentualEfetivoCbs = 0;
    /**
     * @var float
     *
     */
    public float $valorEfetivoCbs = 0;

    /**
     * @var float
     *  */
    public float $baseCalculoIbsUF = 0;
    /**
     * @var float
     */
    public float $valorIbsUF = 0;
    /**
     * @var float
     *
     */
    public float $valorDiferidoIbsUF = 0;
    /**
     * @var float
     *
     */
    public float $percentualEfetivoIbsUF = 0;
    /**
     * @var float
     *
     */
    public float $valorEfetivoIbsUF = 0;

    /**
     * @var float
     *  */
    public float $baseCalculoIbsMun = 0;
    /**
     * @var float
     */
    public float $valorIbsMun = 0;
    /**
     * @var float
     *
     */
    public float $valorDiferidoIbsMun = 0;
    /**
     * @var float
     *
     */
    public float $percentualEfetivoIbsMun = 0;
    /**
     * @var float
     *
     */
    public float $valorEfetivoIbsMun = 0;

    public function __construct(
        Tributavel $produto,
        int $crt,
        int $tipoOperacao,
        string $tipoPessoa,
        string $tipoDesconto = TipoDesconto::Incondicional
    ) {
        $this->produto = $produto;
        $this->crt = $crt;
        $this->tipoOperacao = $tipoOperacao;
        $this->tipoPessoa = $tipoPessoa;
        $this->tipoDesconto = $tipoDesconto;
    }

    public function calcular(): ResultadoTributacao
    {
        if ($this->produto->isServico) {
            $calcularRetencao = ($this->crt == Crt::RegimeNormal || $this->crt == Crt::SimplesNacionalExcesso) &&
            $this->tipoPessoa != TipoPessoa::Fisica;
            $this->calcularIssqn($calcularRetencao);
        } else {
            $this->calcularIcms();
            $this->calcularDifal();
            $this->calcularFcp();
            $this->calcularIpi();
        }

        $this->calcularPis();
        $this->calcularCofins();
        $this->calcularIbpt();

        //RTC
        $this->calcularCbs();
        $this->calcularIbsUF();
        $this->calcularIbsMun();

        return $this;
    }

    private function calcularICms()
    {
        if (($this->crt == Crt::RegimeNormal || $this->crt == Crt::SimplesNacionalExcesso)) {
            switch ($this->produto->cst) {
                case Cst::Cst00:
                    $this->icms = new Cst00();
                    $this->icms->calcula($this->produto);

                    /** @var Cst00 */
                    $resultado =  $this->icms;

                    $this->valorBcIcms = $resultado->valorBcIcms;
                    $this->percentualIcms = $resultado->percentualIcms;
                    $this->valorIcms = $resultado->valorIcms;
                    break;

                case Cst::Cst10:
                    $this->icms = new Cst10();
                    $this->icms->calcula($this->produto);

                    /** @var Cst10 */
                    $resultado =  $this->icms;

                    $this->valorBcIcms = $resultado->valorBcIcms;
                    $this->percentualIcms = $resultado->percentualIcms;
                    $this->valorIcms = $resultado->valorIcms;
                    $this->percentualMva = $resultado->percentualMva;
                    $this->percentualReducaoSt = $resultado->percentualReducaoSt;
                    $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                    $this->percentualIcmsSt = $resultado->percentualIcmsSt;
                    $this->valorIcmsSt = $resultado->valorIcmsSt;
                    break;

                case Cst::Cst20:
                    $this->icms = new Cst20();
                    $this->icms->calcula($this->produto);

                    /** @var Cst20 */
                    $resultado =  $this->icms;

                    $this->valorBcIcms = $resultado->valorBcIcms;
                    $this->percentualIcms = $resultado->percentualIcms;
                    $this->valorIcms = $resultado->valorIcms;
                    $this->percentualReducao = $resultado->percentualReducao;
                    $this->valorIcmsDesonerado = $resultado->valorIcmsDesonerado;

                    break;
                case Cst::Cst30:
                    $this->icms = new Cst30();
                    $this->icms->calcula($this->produto);

                    /** @var Cst30 */
                    $resultado =  $this->icms;

                    $this->percentualMva = $resultado->percentualMva;
                    $this->percentualReducaoSt = $resultado->percentualReducaoSt;
                    $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                    $this->percentualIcmsSt = $resultado->percentualIcmsSt;
                    $this->valorIcmsSt = $resultado->valorIcmsSt;
                    $this->valorIcmsDesonerado = $resultado->valorIcmsDesonerado;
                    break;
                case Cst::Cst41:
                    $this->icms = new Cst41();
                    $this->icms->calcula($this->produto);

                    break;

                case Cst::Cst50:
                    $this->icms = new Cst50();
                    $this->icms->calcula($this->produto);

                    break;
                case Cst::Cst51:
                    $this->icms = new Cst51();
                    $this->icms->calcula($this->produto);

                    /** @var Cst51 */
                    $resultado =  $this->icms;

                    $this->percentualIcms = $resultado->percentualIcms;
                    $this->valorIcms = $resultado->valorIcms;
                    $this->percentualReducao = $resultado->percentualReducao;
                    $this->percentualDiferimento = $resultado->percentualDiferimento;
                    $this->valorIcmsDiferido = $resultado->valorIcmsDiferido;
                    $this->valorIcmsOperacao = $resultado->valorIcmsOperacao;


                    break;

                case Cst::Cst60:
                    $this->icms = new Cst60();
                    $this->icms->calcula($this->produto);

                    /** @var Cst60 */
                    $resultado =  $this->icms;

                    $this->percentualBcStRetido = $resultado->percentualBcStRetido;
                    $this->valorBcStRetido = $resultado->valorBcStRetido;
                    $this->valorBcIcmsEfetivo = $resultado->baseCalculoIcmsEfetivo;
                    $this->percentualIcmsEfetivo = $resultado->percentualIcmsEfetivo;
                    $this->valorIcmsEfetivo = $resultado->valorIcmsEfetivo;

                    break;

                case Cst::Cst70:
                    $this->icms = new Cst70();
                    $this->icms->calcula($this->produto);

                    /** @var Cst70 */
                    $resultado =  $this->icms;

                    $this->percentualReducao = $resultado->percentualReducao;
                    $this->valorIcmsDesonerado = $resultado->valorIcmsDesonerado;

                    break;

                case Cst::Cst90:
                    $this->icms = new Cst90();
                    $this->icms->calcula($this->produto);

                    /** @var Cst90 */
                    $resultado =  $this->icms;

                    $this->valorBcIcms = $resultado->valorBcIcms;
                    $this->percentualIcms = $resultado->percentualIcms;
                    $this->valorIcms = $resultado->valorIcms;
                    $this->percentualMva = $resultado->percentualMva;
                    $this->percentualReducaoSt = $resultado->percentualReducaoSt;
                    $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                    $this->percentualIcmsSt = $resultado->percentualMva;
                    $this->valorIcmsSt = $resultado->valorIcmsSt;
                    $this->percentualReducaoIcmsBc = $resultado->percentualReducaoSt;
                    $this->percentualCredito = $resultado->percentualCredito;
                    $this->valorCredito = $resultado->valorCredito;

                    break;

                default:
                    # code...
                    break;
            }
        } else {
            switch ($this->produto->csosn) {
                case Csosn::Csosn101:
                    $this->csosn = new Csosn101();
                    $this->csosn->calcula($this->produto);

                    /** @var Csosn101 */
                    $resultado =  $this->csosn;

                    $this->valorCredito = $resultado->valorCredito;
                    $this->percentualCredito = $resultado->percentualCredito;

                    break;

                case Csosn::Csosn102:
                    $this->csosn = new Csosn102();

                    break;

                case Csosn::Csosn103:
                    $this->csosn = new Csosn103();
                    break;

                case Csosn::Csosn201:
                    $this->csosn = new Csosn201();
                    $this->csosn->calcula($this->produto);

                    /** @var Csosn201 */
                    $resultado =  $this->csosn;

                    $this->valorCredito = $resultado->valorCredito;
                    $this->percentualCredito = $resultado->percentualCredito;

                    switch ($resultado->modalidadeDeterminacaoBcIcmsSt) {
                        case ModalidadeDeterminacaoBcIcmsSt::MargemValorAgregado:
                            $this->percentualMva = $resultado->percentualMva;
                            $this->percentualReducaoSt = $resultado->percentualReducaoSt;
                            $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                            $this->percentualIcmsSt = $resultado->percentualIcmsSt;
                            $this->valorIcmsSt = $resultado->valorIcmsSt;
                            break;
                        default:
                            # code...
                            break;
                    }
                    break;

                case Csosn::Csosn202:
                    $this->csosn = new Csosn202();
                    $this->csosn->calcula($this->produto);

                    /** @var Csosn202 */
                    $resultado =  $this->csosn;

                    switch ($resultado->modalidadeDeterminacaoBcIcmsSt) {
                        case ModalidadeDeterminacaoBcIcmsSt::MargemValorAgregado:
                            $this->percentualMva = $resultado->percentualMvaSt;
                            $this->percentualReducaoSt = $resultado->percentualReducaoSt;
                            $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                            $this->percentualIcmsSt = $resultado->percentualIcmsSt;
                            $this->valorIcmsSt = $resultado->valorIcmsSt;
                            break;
                        default:
                            # code...
                            break;
                    }
                    break;

                case Csosn::Csosn203:
                    $this->csosn = new Csosn203();
                    $this->csosn->calcula($this->produto);

                    /** @var Csosn203 */
                    $resultado =  $this->csosn;

                    switch ($resultado->modalidadeDeterminacaoBcIcmsSt) {
                        case ModalidadeDeterminacaoBcIcmsSt::MargemValorAgregado:
                            $this->percentualMva = $resultado->percentualMvaSt;
                            $this->percentualReducaoSt = $resultado->percentualReducaoSt;
                            $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                            $this->percentualIcmsSt = $resultado->percentualIcmsSt;
                            $this->valorIcmsSt = $resultado->valorIcmsSt;
                            break;
                        default:
                            # code...
                            break;
                    }
                    break;

                case Csosn::Csosn300:
                    $this->csosn = new Csosn300();
                    break;

                case Csosn::Csosn400:
                    $this->csosn = new Csosn400();
                    break;

                case Csosn::Csosn500:
                    $this->csosn = new Csosn500();
                    $this->csosn->calcula($this->produto);

                    /** @var Csosn500 */
                    $resultado =  $this->csosn;

                    $this->valorBcIcmsEfetivo = $resultado->baseCalculoIcmsEfetivo;
                    $this->percentualIcmsEfetivo = $resultado->percentualIcmsEfetivo;
                    $this->valorIcmsEfetivo = $resultado->valorIcmsEfetivo;

                    break;

                case Csosn::Csosn900:
                    $this->csosn = new Csosn900();
                    $this->csosn->calcula($this->produto);

                    /** @var Csosn900 */
                    $resultado =  $this->csosn;

                    $this->valorBcIcms = $resultado->valorBcIcms;
                    $this->percentualIcms = $resultado->percentualIcms;
                    $this->valorIcms = $resultado->valorIcms;
                    $this->percentualMva = $resultado->percentualMva;
                    $this->percentualReducaoSt = $resultado->percentualReducaoIcmsStBc;
                    $this->valorBcIcmsSt = $resultado->valorBcIcmsSt;
                    $this->valorIcmsSt = $resultado->valorIcmsSt;
                    $this->percentualReducaoIcmsBc = $resultado->percentualReducaoIcmsBc;
                    $this->valorCredito = $resultado->valorCredito;
                    $this->percentualCredito = $resultado->percentualCredito;

                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    private function calcularDifal()
    {
        $this->difal = new TributacaoDifal($this->produto, $this->tipoDesconto);

        $calcular = $this->crt == Crt::SimplesNacional ? $this->csosnGeraDifal($this->produto->csosn) :
        $this->cstGeraDifal($this->produto->cst);

        if (
            $this->tipoOperacao == TipoOperacao::OperacaoInterestadual &&
            $calcular &&
            $this->produto->percentualDifalInterna != 0 &&
            $this->produto->percentualDifalInterstadual != 0
        ) {
            $result = $this->difal->calcula();
            $this->valorBcDifal = $result->baseCalculo;
            $this->valorDifal = $result->difal;
            $this->valorIcmsOrigem = $result->valorIcmsOrigem;
            $this->valorIcmsDestino = $result->valorIcmsDestino;
        }
    }

    private function calcularFcp()
    {
        $this->tributacaoFcp = new TributacaoFcp($this->produto, $this->tipoDesconto);
        $result = $this->tributacaoFcp->calcula();

        $this->fcp = $result->valor;
        $this->valorBcFcp = $result->baseCalculo;
    }

    private function calcularIpi()
    {
        $this->ipi = new TributacaoIpi($this->produto, $this->tipoDesconto);

        if (
            $this->produto->cstIpi == CstIpi::Cst00 ||
            $this->produto->cstIpi == CstIpi::Cst49 ||
            $this->produto->cstIpi == CstIpi::Cst50 ||
            $this->produto->cstIpi == CstIpi::Cst99
        ) {
            $result = $this->ipi->calcula();
            $this->valorBcIpi = $result->baseCalculo;
            $this->valorIpi = $result->valor;
        }
    }

    private function calcularPis()
    {
        $this->pis = new TributacaoPis($this->produto, $this->tipoDesconto);
        $this->produto->valorIcms = $this->valorIcms;

        if (
            $this->produto->cstPisCofins == CstPisCofins::Cst01 ||
            $this->produto->cstPisCofins == CstPisCofins::Cst02
        ) {
            $result = $this->pis->calcula();
            $this->valorBcPis = $result->baseCalculo;
            $this->valorPis = $result->valor;
        }
    }

    private function calcularCofins()
    {
        $this->cofins = new TributacaoCofins($this->produto, $this->tipoDesconto);
        $this->produto->valorIcms = $this->valorIcms;

        if (
            $this->produto->cstPisCofins == CstPisCofins::Cst01 ||
            $this->produto->cstPisCofins == CstPisCofins::Cst02
        ) {
            $result = $this->cofins->calcula();
            $this->valorBcCofins = $result->baseCalculo;
            $this->valorCofins = $result->valor;
        }

    }

    private function calcularIbpt()
    {
        $this->ibpt = new TributacaoIbpt($this->produto);
        $result = $this->ibpt->calcula();

        $this->valorTributacaoEstadual = $result->tributacaoEstadual;
        $this->valorTributacaoFederal = $result->tributacaoFederal;
        $this->valorTributacaoFederalImportados = $result->tributacaoFederalImportados;
        $this->valorTributacaoMunicipal = $result->tributacaoMunicipal;
        $this->valorTotalTributos = $result->valorTotalTributos;
    }

    private function calcularIssqn(bool $calcularRetencao)
    {
        $this->issqn = new TributacaoIssqn($this->produto, $this->tipoDesconto);
        $result = $this->issqn->calcula($calcularRetencao);

        $this->baseCalculoInss = $result->baseCalculoInss;
        $this->baseCalculoIrrf = $result->baseCalculoIrrf;
        $this->valorRetCofins = $result->valorRetCofins;
        $this->valorRetPis = $result->valorRetPis;
        $this->valorRetIrrf = $result->valorRetIrrf;
        $this->valorRetInss = $result->valorRetInss;
        $this->valorRetCsll = $result->valorRetCsll;
        $this->valorIss = $result->valor;
    }

    private function calcularCbs(): void
    {
        $this->tributacaoCbs = new TributacaoCbs($this->produto, $this);

        /** @var ResultadoCalculoCbs */
        $resultado = $this->tributacaoCbs->calcula();

        $this->baseCalculoCbs = $resultado->baseCalculo;
        $this->valorCbs = $resultado->valor;
        $this->valorDiferidoCbs = $resultado->valorDiferido;
        $this->percentualEfetivoCbs = $resultado->percentualEfetivo;
        $this->valorEfetivoCbs = $resultado->valorEfetivo;
    }

    private function calcularIbsUf(): void
    {
        $this->tributacaoIbsUf = new TributacaoIbsUf($this->produto, $this);

        /** @var ResultadoCalculoIbsUf */
        $resultado = $this->tributacaoIbsUf->calcula();

        $this->baseCalculoIbsUF = $resultado->baseCalculo;
        $this->valorIbsUF = $resultado->valor;
        $this->valorDiferidoIbsUF = $resultado->valorDiferido;
        $this->percentualEfetivoIbsUF = $resultado->percentualEfetivo;
        $this->valorEfetivoIbsUF = $resultado->valorEfetivo;
    }

    private function calcularIbsMun(): void
    {
        $this->tributacaoIbsMun = new TributacaoIbsMun($this->produto, $this);

        /** @var ResultadoCalculoIbsMun */
        $resultado = $this->tributacaoIbsMun->calcula();

        $this->baseCalculoIbsMun = $resultado->baseCalculo;
        $this->valorIbsMun = $resultado->valor;
        $this->valorDiferidoIbsMun = $resultado->valorDiferido;
        $this->percentualEfetivoIbsMun = $resultado->percentualEfetivo;
        $this->valorEfetivoIbsMun = $resultado->valorEfetivo;
    }

    private function csosnGeraDifal($csosn): bool
    {
        return (
            $csosn == Csosn::Csosn102 ||
            $csosn == Csosn::Csosn103 ||
            $csosn == Csosn::Csosn400 ||
            $csosn == Csosn::Csosn500
        );
    }

    private function cstGeraDifal($cst): bool
    {
        return (
            $cst == Cst::Cst00 ||
            $cst == Cst::Cst20 ||
            $cst == Cst::Cst40 ||
            $cst == Cst::Cst41 ||
            $cst == Cst::Cst60
        );
    }

}
