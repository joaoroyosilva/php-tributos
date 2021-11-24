<?php

namespace PhpTributos\Flags;

abstract class OrigemMercadoria extends BasicFlag
{
    const Nacional = 0;
    const EstrangeiraImportacaoDireta = 1;
    const EstrangeiraInterna = 2;
    const NacionalImportacaoSuperior40 = 3;
    const NacionalConformidadeBasicas = 4;
    const NacionaoImportacaoInferior40 = 5;
    const EstrangeiraImportacaoDiretaSemSimilar = 6;
    const EstrangeiraInternaSemSimilar = 7;
    const NacionalImportacaoSuperior70 = 8;
}
