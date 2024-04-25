<?php

namespace App\Exception;

enum Brand: string
{
    case ALREADYEXISTS = "A Marca já existe.";
    case EMPTY         = "Nenhuma marca foi encontrada.";
    case NOTFOUND      = "A marca não foi encontrada.";
    case DUPLICATE     = "Marca já existente. Nome duplicado.";
}
