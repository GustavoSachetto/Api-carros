<?php

namespace App\Exception;

enum Car: string
{
    case ALREADYEXISTS = "O veículo já existe.";
    case EMPTY         = "Nenhum veículo foi encontrado.";
    case NOTFOUND      = "O veículo não foi encontrado.";
    case DUPLICATE     = "Veículo já existente. Versão, modelo, combustível e transmissão foram duplicados.";
}
