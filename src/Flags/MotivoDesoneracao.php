<?php

namespace PhpTributos\Flags;

abstract class MotivoDesoneracao extends BasicFlag
{
    const Taxi = 1;
    const DeficienteFisico = 2;
    const ProdutoAgropecuario = 3;
    const FrotistaLocadora = 4;
    const DiplomaticoConsular = 5;
    const Utilitario = 6;
    const Suframa = 7;
    const VendaOrgaoPublico = 8;
    const Outros = 9;
}
