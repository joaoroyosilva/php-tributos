<?php

namespace PhpTributos\Exceptions;

use Throwable;

class ArgumentException extends \InvalidArgumentException
{
    public function __construct($message = "Não exite cálculo", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
