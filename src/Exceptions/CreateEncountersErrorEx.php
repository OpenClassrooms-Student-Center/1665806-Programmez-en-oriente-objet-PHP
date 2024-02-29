<?php

namespace App\Domain\Exceptions;

class CreateEncountersErrorEx extends \RuntimeException
{
    public $message = 'Le nombre de joueurs est insuffisant pour créer une rencontre :(';
}