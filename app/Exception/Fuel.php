<?php

namespace App\Exception;

enum Fuel: string
{
    case ALREADYEXISTS = "O combustível já existe.";
    case EMPTY         = "Nenhum combustível foi encontrado.";
    case NOTFOUND      = "O combustível não foi encontrado.";
    case DUPLICATE     = "Combustível já existente. Nome duplicado.";
}
