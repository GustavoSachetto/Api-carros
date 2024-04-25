<?php

namespace App\Exception;

enum Transmission: string
{
    case ALREADYEXISTS = "A Transmissão já existe.";
    case EMPTY         = "Nenhuma transmissão foi encontrada.";
    case NOTFOUND      = "A transmissão não foi encontrada.";
    case DUPLICATE     = "Transmissão já existente. Nome duplicado.";
}
