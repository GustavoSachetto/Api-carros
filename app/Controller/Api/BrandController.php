<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Controller\Api;
use App\Utils\Examiner;
use App\Exception\Brand as ExceptionBrand;
use App\Model\Entity\Brand as EntityBrand;

class BrandController extends Api
{
    /** 
     * Método responsável por definir as possíveis mensagens das exceções
    */
    private static function init(): void
    {
        Examiner::$exception = ExceptionBrand::class;
    }

    /** 
     * Método responsável por setar os campos da marca
    */
    private static function setBrandFields(EntityBrand $obBrand, array $vars): void
    {
        $obBrand->name    = $vars['name'] ?? $obBrand->name;
        $obBrand->deleted = $vars['deleted'] ?? $obBrand->deleted;
    }

    /**
     * Método responsável por retornar as marcas existentes
     */
    public static function get(): array
    {   
        self::init();

        $itens = [];
        $results = EntityBrand::getBrands('deleted = false', 'id ASC');

        while($obBrand = $results->fetchObject(EntityBrand::class)) {
            $itens[] = [
                'id'           => $obBrand->id,
                'name'         => $obBrand->name,
            ];
        }
        
        Examiner::checkArrayItens($itens);
        return $itens;
    }

    /**
     * Método responsável por retornar uma marca pelo seu id
     */
    public static function fetch(Request $request, int|string $id): array
    {   
        self::init();
        
        Examiner::checkId($id);
        $obBrand = EntityBrand::getBrandById($id);
        Examiner::checkObjectExists($obBrand, EntityBrand::class);
        
        return [
            'id'            => $obBrand->id,
            'name'          => $obBrand->name,
            'deleted'       => $obBrand->deleted
        ];;
    }

    /**
     * Método responsável por setar uma nova marca
     */
    public static function set(Request $request): array
    {
        self::init();

        $vars = $request->getPostVars();

        Examiner::checkRequiredFields(['name' => $vars['name'] ?? null]);

        $obBrand = EntityBrand::getBrandByName($vars['name']);
        Examiner::checkObjectNotExists($obBrand, EntityBrand::class);

        $obBrand = new EntityBrand;
        self::setBrandFields($obBrand, $vars);
        $obBrand->create();

        return [
            'id'      => $obBrand->id,
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
        Examiner::checkRequiredFields(['name' => $vars['name'] ?? null]);

        $obBrand = EntityBrand::getBrandByName($vars['name']);
        Examiner::checkDuplicateObject($obBrand, EntityBrand::class, $id);

        $obBrand = EntityBrand::getBrandById($id);
        Examiner::checkObjectExists($obBrand, EntityBrand::class);

        self::setBrandFields($obBrand, $vars);
        $obBrand->update();

        return [
            'id'      => $obBrand->id,
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
        $obBrand = EntityBrand::getBrandById($id);
        Examiner::checkObjectExists($obBrand, EntityBrand::class);

        $obBrand->delete();

        return [
            'success' => true
        ];
    }
}
