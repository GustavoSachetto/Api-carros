<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\CarModel as ExceptionCarmodel;
use App\Model\Entity\CarModel as EntityCarmodel;

class CarmodelController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionCarmodel::class;
    }

    /** 
     * Método responsável por setar os campos do modelo de veículo
    */
    private static function setCarmodelFields(EntityCarmodel $obCarmodel, array $vars): void
    {
        $obCarmodel->name     = $vars['name'] ?? $obCarmodel->name;
        $obCarmodel->brand_id = $vars['brand_id'] ?? $obCarmodel->brand_id;
        $obCarmodel->deleted  = $vars['deleted'] ?? $obCarmodel->deleted;
    }

    /** 
     * Método responsável por pegar os itens do modelo de veículo em formato de array associativo
    */
    private static function getArrayItens(object|string $results): array
    {
        $itens = [];
        while($obCarmodel = $results->fetchObject(EntityCarmodel::class)) {
            $itens[] = [
                'id'       => $obCarmodel->id,
                'name'     => $obCarmodel->name,
                'brand_id' => $obCarmodel->brand_id,
            ];
        }
        
        Examiner::checkArrayItens($itens);
        return $itens;
    }

    /**
     * Método responsável por retornar os modelos de veículos existentes
     */
    public static function get(Request $request): array
    {   
        self::init();

        $results = EntityCarmodel::getCarmodels('deleted = false', 'id ASC');    

        return self::getArrayItens($results);
    }

     /**
     * Método responsável por retornar os modelos de veículos existentes pelo id da marca
     */
    public static function fetchBrand(Request $request, int|string $brand_id): array
    {
        self::init();

        Examiner::checkId($brand_id);

        $results = EntityCarmodel::getCarmodels('deleted = false and brand_id = '.$brand_id, 'id ASC');

        return self::getArrayItens($results);
    }

    /**
     * Método responsável por retornar um modelo de veículo pelo seu id
     */
    public static function fetch(Request $request, int|string $id): array
    {   
        self::init();

        Examiner::checkId($id);
        $obCarmodel = EntityCarmodel::getCarmodelById($id);
        Examiner::checkObjectExists($obCarmodel, EntityCarmodel::class);
        
        return [
            'id'            => $obCarmodel->id,
            'name'          => $obCarmodel->name,
            'brand_id'      => $obCarmodel->brand_id,
            'deleted'       => $obCarmodel->deleted
        ];;
    }

    /**
     * Método responsável por setar uma nova marca
     */
    public static function set(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields([
            'name'     => $vars['name'] ?? null,
            'brand_id' => $vars['brand_id'] ?? null
        ]);

        $obCarmodel = EntityCarmodel::getCarmodelByNameAndId($vars['name'], $vars['brand_id']);
        Examiner::checkObjectNotExists($obCarmodel, EntityCarmodel::class);

        $obCarmodel = new EntityCarmodel;
        self::setCarmodelFields($obCarmodel, $vars);
        $obCarmodel->create();

        return [
            'id'      => $obCarmodel->id,
            'success' => true
        ];
    }   
    
    /**
     * Método responsável por editar uma marca pelo seu id
     */
    public static function edit(Request $request, int|string $id): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkId($id);
        Examiner::checkRequiredFields([
            'name'     => $vars['name'] ?? null,
            'brand_id' => $vars['brand_id'] ?? null
        ]);

        $obCarmodel = EntityCarmodel::getCarmodelByNameAndId($vars['name'], $vars['brand_id']);
        Examiner::checkDuplicateObject($obCarmodel, EntityCarmodel::class, $id);

        $obCarmodel = EntityCarmodel::getCarmodelById($id);
        Examiner::checkObjectExists($obCarmodel, EntityCarmodel::class);

        self::setCarmodelFields($obCarmodel, $vars);
        $obCarmodel->update();

        return [
            'id'      => $obCarmodel->id,
            'success' => true
        ];
    }
    
    /**
     * Método responsável por deletar uma marca pelo seu id
     */
    public static function delete(Request $request, int|string $id): array
    {
        self::init();

        Examiner::checkId($id);
        $obCarmodel = EntityCarmodel::getCarmodelById($id);
        Examiner::checkObjectExists($obCarmodel, EntityCarmodel::class);

        $obCarmodel->delete();

        return [
            'success' => true
        ];
    }
}
