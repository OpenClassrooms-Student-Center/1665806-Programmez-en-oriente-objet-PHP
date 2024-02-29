<?php

namespace App\Domain\Exceptions;

class SetStatusErrorEx extends \RuntimeException
{
    public $message;
    public function __construct ($statusPl, $statusOver) {
        $message = sprintf('$status must one of %s', implode(', ', [$statusPl, $statusOver]));
    }
}