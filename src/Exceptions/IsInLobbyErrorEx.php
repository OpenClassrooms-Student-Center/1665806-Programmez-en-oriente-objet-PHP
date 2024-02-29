<?php

namespace App\Domain\Exceptions;

class IsInLobbyErrorEx extends \RuntimeException
{
    public $message = 'Ce joueur ne se trouve pas dans le lobby';
}