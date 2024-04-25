<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\Fuel as ExceptionFuel;
use App\Model\Entity\Fuel as EntityFuel;


class FuelController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionFuel::class;
    }

    /** 
     * Método responsável por setar os campos do combustível
    */
    private static function setFuelFields(EntityFuel $obFuel, array $vars): void
    {
        $obFuel->name    = $vars['name'] ?? $obFuel->name;
        $obFuel->deleted = $vars['deleted'] ?? $obFuel->deleted;
    }

    /**
     * Método responsável por retornar os combustíveis existentes
     */
    public static function get(): array
    {   
        self::init();

        $itens = [];
        $results = EntityFuel::getFuels('deleted = false', 'id ASC');

        while($obFuel = $results->fetchObject(EntityFuel::class)) {
            $itens[] = [
                'id'           => $obFuel->id,
                'name'         => $obFuel->name,
            ];
        }

        Examiner::checkArrayItens($itens);
        return $itens;
    }

    /**
     * Método responsável por retornar um combustível pelo seu id
     */
    public static function fetch(Request $request, int|string $id): array
    {   
        self::init();
        
        Examiner::checkId($id);
        $obFuel = EntityFuel::getFuelById($id);
        Examiner::checkObjectExists($obFuel, EntityFuel::class);
        
        return [
            'id'            => $obFuel->id,
            'name'          => $obFuel->name,
            'deleted'       => $obFuel->deleted
        ];;
    }

    /**
     * Método responsável por setar um novo combustível
     */
    public static function set(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields(['name' => $vars['name'] ?? null]);

        $obFuel = EntityFuel::getFuelByName($vars['name']);
        Examiner::checkObjectNotExists($obFuel, EntityFuel::class);

        $obFuel = new EntityFuel;
        self::setFuelFields($obFuel, $vars);
        $obFuel->create();

        return [
            'id'      => $obFuel->id,
            'success' => true
        ];
    }   
    
    /**
     * Método responsável por editar um combustível pelo seu id
     */
    public static function edit(Request $request, int|string $id): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkId($id);
        Examiner::checkRequiredFields(['name' => $vars['name'] ?? null]);

        $obFuel = EntityFuel::getFuelByName($vars['name']);
        Examiner::checkDuplicateObject($obFuel, EntityFuel::class, $id);

        $obFuel = EntityFuel::getFuelById($id);
        Examiner::checkObjectExists($obFuel, EntityFuel::class);

        self::setFuelFields($obFuel, $vars);
        $obFuel->update();

        return [
            'id'      => $obFuel->id,
            'success' => true
        ];
    }
    
    /**
     * Método responsável por deletar um combustível pelo seu id
     */
    public static function delete(Request $request, int|string $id): array
    {
        self::init();

        Examiner::checkId($id);
        $obFuel = EntityFuel::getFuelById($id);
        Examiner::checkObjectExists($obFuel, EntityFuel::class);

        $obFuel->delete();

        return [
            'success' => true
        ];
    }
}
