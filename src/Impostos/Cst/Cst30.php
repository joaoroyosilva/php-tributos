<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
use PhpTributos\Flags\OrigemMercadoria;
use PhpTributos\Flags\TipoCalculoIcmsDesonerado;
use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\Cst\Base\CstBase;
use PhpTributos\Impostos\Tributavel;

class Cst30 extends CstBase
{
    /**
     * @var Cst
     */
    public $cst = Cst::Cst30;

    /**
     * @var float
     */
    public $percentualMva = 0;

    /**
     * @var float
     */
    public $percentualReducaoSt = 0;

    /**
     * @var float
     */
    public $valorBcIcmsSt = 0;

    /**
     * @var float
     */
    public $valorBcFcpSt = 0;

    /**
     * @var float
     */
    public $percentualIcmsSt = 0;

    /**
     * @var float
     */
    public $valorIcmsSt = 0;

    /**
     * @var float
     */
    public $percentualFcpSt = 0;

    /**
     * @var float
     */
    public $valorFcpSt = 0;

    /**
     * @var float
     */
    public $valorIcmsDesonerado = 0;

    public function __construct(
        int $origemMercadoria = OrigemMercadoria::Nacional,
        string $tipoDesconto = TipoDesconto::Incondicional,
        public string $tipoCalculoIcmsDesonerado = TipoCalculoIcmsDesonerado::BasePorDentro
    ) {
        parent::__construct($origemMercadoria, $tipoDesconto);
    }


    public function calcula(Tributavel $tributavel): void
    {
        $this->percentualMva = $tributavel->percentualMva;
        $this->percentualReducaoSt = $tributavel->percentualReducaoSt;
        $this->percentualIcmsSt = $tributavel->percentualIcmsSt;
        $this->percentualFcpSt = $tributavel->percentualFcpSt;

        $facade = new FacadeCalculadoraTributacao($tributavel, $this->tipoDesconto);

        $tributavel->valorIpi = $facade->calculaIpi()->valor;

        $resultadoCalculoIcmsSt = $facade->calculaIcmsSt();
        $resultadoCalculoFcpSt = $facade->calculaFcp();
        $resultadoCalculoDesonerado = $facade->calculaIcmsDesonerado();

        $this->valorBcIcmsSt = $resultadoCalculoIcmsSt->baseCalculoIcmsSt;
        $this->valorIcmsSt = $resultadoCalculoIcmsSt->valorIcmsSt;
        $this->valorBcFcpSt = $resultadoCalculoFcpSt->baseCalculo;
        $this->valorFcpSt = $resultadoCalculoFcpSt->valor;
        $this->valorIcmsDesonerado = $resultadoCalculoDesonerado->valor;

    }
}
