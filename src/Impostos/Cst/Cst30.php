<?php

namespace PhpTributos\Impostos\Cst;

use PhpTributos\Facade\FacadeCalculadoraTributacao;
use PhpTributos\Flags\Cst;
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

        $this->valorBcIcmsSt = $resultadoCalculoIcmsSt->baseCalculoIcmsSt;
        $this->valorIcmsSt = $resultadoCalculoIcmsSt->valorIcmsSt;
        $this->valorBcFcpSt = $resultadoCalculoFcpSt->baseCalculoFcpSt;
        $this->valorFcpSt = $resultadoCalculoFcpSt->valorFcpSt;

    }
}
