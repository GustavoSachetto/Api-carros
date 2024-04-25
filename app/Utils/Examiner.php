<?php

namespace App\Utils;

use Exception;
use App\Model\Entity\User as EntityUser;

class Examiner
{
    /** 
     * Váriavel que armazena o tipo de exceção gerada
    */
    public static string $exception;

    /** 
     * Método responsável por verificar se o id é numerico
    */
    public static function checkId(mixed $id): void
    {
        if (!is_numeric($id)) throw new Exception("O id '{$id}' não é válido.", 400);
    }

    /** 
     * Método responsável por verificar se o array de itens não está vazio
    */
    public static function checkArrayItens(array $itens): void
    {
        if (empty($itens)) throw new Exception(self::$exception::EMPTY->value, 404);
    }

    /**
     * Método responsável por verificar a senha do usuário
     */
    public static function checkUserPassword(string $password_hash, EntityUser $obUser): void
    {
        if (!password_verify($password_hash, $obUser->password_hash)) {
            throw new Exception("O usuário ou senha são inválidos.", 400);
        }
    }

    /** 
     * Método responsável por verificar se o objeto do id informado é uma instancia do objeto requerido
    */
    public static function checkObjectExists(
        object|string $object, 
        object|string $instance
        ): void
    {
        if (!$object instanceof $instance) throw new Exception(self::$exception::NOTFOUND->value, 404);
    }

    /** 
     * Método responsável por verificar se o objeto do valor informado não é uma instancia do objeto requerido
    */
    public static function checkObjectNotExists(
        object|string $object, 
        object|string $instance
        ): void
    {
        if ($object instanceof $instance) throw new Exception(self::$exception::ALREADYEXISTS->value, 400);
    }

    /** 
     * Método responsável por verificar se o objeto informado foi duplicado
    */
    public static function checkDuplicateObject(
        object|string $object, 
        object|string $instance,
        int $id
        ): void
    {
        if ($object instanceof $instance && $id != $object->id) {
            throw new Exception(self::$exception::DUPLICATE->value, 400);
        }
    }

    /** 
     * Método responsável por verificar se os campos obrigatórios foram preenchidos
    */
    public static function checkRequiredFields(array $fields): void
    {
        $filter = implode(", ", array_keys($fields));

        foreach ($fields as $value) {
            if (!isset($value)) {
                $message = count($fields) > 1 ? "Os campos {$filter} são obrigatórios." : "O campo {$filter} é obrigatório";
                throw new Exception($message, 400);
            } else if (empty($value)) {
                $message = count($fields) > 1 ? "Os campos {$filter} não podem estar vazios." : "O campo {$filter} não pode estar vazio.";
                throw new Exception($message, 400);
            }
        }
    }
}