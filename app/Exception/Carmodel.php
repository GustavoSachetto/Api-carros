<?php

namespace App\Exception;

enum Carmodel: string
{
    case ALREADYEXISTS = "O modelo já existe.";
    case EMPTY         = "Nenhum modelo foi encontrado.";
    case NOTFOUND      = "O modelo não foi encontrado.";
    case DUPLICATE     = "Modelo já existente. Nome ou Brand_ID duplicado.";
}
