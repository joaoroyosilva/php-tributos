<?php

namespace PhpTributos\Flags;

abstract class TipoOperacao extends BasicFlag
{
    const OperacaoInterna = 1;
    const OperacaoInterestadual = 2;
    const OperacaoExterior = 3;
}
