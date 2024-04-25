<?php

namespace App\Exception;

enum User: string
{
    case ALREADYEXISTS = "Usuário já existente.";
    case NOTFOUND      = "O usuário não foi encontrado.";
    case DUPLICATE     = "Usuário já existente. E-mail duplicado.";
}
