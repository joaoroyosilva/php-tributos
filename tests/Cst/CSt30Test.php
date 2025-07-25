<?php

namespace PhpTributos\Tests\Cst;

use PhpTributos\Entidades\Produto;
use PhpTributos\Flags\Cst;
use PhpTributos\Impostos\Cst\Cst30;
use PHPUnit\Framework\TestCase;

class Cst30Test extends TestCase
{
    public function testCalculoIcmsDesonerado()
    {
        $produto = new Produto();
        $produto->quantidadeProduto = 1;
        $produto->valorProduto = 1000;
        $produto->percentualIcms = 20;
        $produto->percentualReducao = 10;
        $produto->cst = Cst::Cst30;

        $cst = new Cst30();
        $cst->calcula($produto);

        $this->assertEquals(250, $cst->valorIcmsDesonerado);
    }


}
