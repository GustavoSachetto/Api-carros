<?php

use App\Model\DatabaseManager\Database;
use App\Common\CommandLine\Required\Interaction;

return new class extends Interaction
{
    /**
     * Informações a serem inseridas na tabela
     */
    private array $informations = [
        ['name' => 'Prisma', 'brand_id'             => 3],        
        ['name' => 'Onix', 'brand_id'               => 3],        
        ['name' => 'Onix Plus', 'brand_id'          => 3],        
        ['name' => 'Cruze', 'brand_id'              => 3],        
        ['name' => 'Cruze Sport6 RS', 'brand_id'    => 3],        
        ['name' => 'Spin', 'brand_id'               => 3],
        ['name' => 'Spin Activ', 'brand_id'         => 3],
        ['name' => 'Tracker', 'brand_id'            => 3],
        ['name' => 'Equinox', 'brand_id'            => 3],
        ['name' => 'Trailblazer', 'brand_id'        => 3],
        ['name' => 'Silverado', 'brand_id'          => 3],
        ['name' => 'Montana', 'brand_id'            => 3],
        ['name' => 'S10 High Country', 'brand_id'   => 3],
        ['name' => 'S10 Cabine Dupla', 'brand_id'   => 3],
        ['name' => 'S10 Cabine Simples', 'brand_id' => 3],
        ['name' => 'S10 Midnight', 'brand_id'       => 3],
        ['name' => 'S10 Z71', 'brand_id'            => 3],
        ['name' => 'Camaro', 'brand_id'             => 3],
        ['name' => 'Bolt EV', 'brand_id'            => 3],
        ['name' => 'Bolt EUV', 'brand_id'           => 3],
        ['name' => 'Classe C', 'brand_id'           => 14]
    ];

    /** 
     * Método responsável por subir a infomação no banco de dados.
    */
    public function up(): void
    {
        foreach ($this->informations as $information) {
            (new Database('model'))->insert($information);
        }
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database('model'))->delete('id <= 20');
    }
};
