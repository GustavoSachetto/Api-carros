<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\Transmission as ExceptionTransmission;
use App\Model\Entity\Transmission as EntityTransmission;

class TransmissionController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionTransmission::class;
    }

    /** 
     * Método responsável por setar os campos da transmissão
    */
    private static function setTransmissionFields(EntityTransmission $obTransmission, array $vars): void
    {
        $obTransmission->name    = $vars['name'] ?? $obTransmission->name;
        $obTransmission->deleted = $vars['deleted'] ?? $obTransmission->deleted;
    }

    /**
     * Método responsável por retornar as transmissões existentes
     */
    public static function get(): array
    {   
        self::init();

        $itens = [];
        $results = EntityTransmission::getTransmissions('deleted = false', 'id ASC');

        while($obTransmission = $results->fetchObject(EntityTransmission::class)) {
            $itens[] = [
                'id'           => $obTransmission->id,
                'name'         => $obTransmission->name,
            ];
        }

        Examiner::checkArrayItens($itens);
        return $itens;
    }

    /**
     * Método responsável por retornar uma transmissão pelo seu id
     */
    public static function fetch(Request $request, int|string $id): array
    {   
        self::init();
        
        Examiner::checkId($id);
        $obTransmission = EntityTransmission::getTransmissionById($id);
        Examiner::checkObjectExists($obTransmission, EntityTransmission::class);
        
        return [
            'id'            => $obTransmission->id,
            'name'          => $obTransmission->name,
            'deleted'       => $obTransmission->deleted
        ];;
    }

    /**
     * Método responsável por setar uma nova transmissão
     */
    public static function set(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields(['name' => $vars['name'] ?? null]);

        $obTransmission = EntityTransmission::getTransmissionByName($vars['name']);
        Examiner::checkObjectNotExists($obTransmission, EntityTransmission::class);

        $obTransmission = new EntityTransmission;
        self::setTransmissionFields($obTransmission, $vars);
        $obTransmission->create();

        return [
            'id'      => $obTransmission->id,
            'success' => true
        ];
    }   
    
    /**
     * Método responsável por editar uma transmissão pelo seu id
     */
    public static function edit(Request $request, int|string $id): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkId($id);
        Examiner::checkRequiredFields(['name' => $vars['name'] ?? null]);

        $obTransmission = EntityTransmission::getTransmissionByName($vars['name']);
        Examiner::checkDuplicateObject($obTransmission, EntityTransmission::class, $id);

        $obTransmission = EntityTransmission::getTransmissionById($id);
        Examiner::checkObjectExists($obTransmission, EntityTransmission::class);

        self::setTransmissionFields($obTransmission, $vars);
        $obTransmission->update();

        return [
            'id'      => $obTransmission->id,
            'success' => true
        ];
    }
    
    /**
     * Método responsável por deletar uma transmissão pelo seu id
     */
    public static function delete(Request $request, int|string $id): array
    {
        self::init();

        Examiner::checkId($id);
        $obTransmission = EntityTransmission::getTransmissionById($id);
        Examiner::checkObjectExists($obTransmission, EntityTransmission::class);

        $obTransmission->delete();

        return [
            'success' => true
        ];
    }
}
