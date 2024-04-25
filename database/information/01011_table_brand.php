<?php

use App\Model\DatabaseManager\Database;
use App\Common\CommandLine\Required\Interaction;

return new class extends Interaction
{
    /**
     * Informações a serem inseridas na tabela
     */
    private array $informations = [
        ['name' => 'Audi'],
        ['name' => 'Bmw'],
        ['name' => 'Chevrolet'],
        ['name' => 'Citroen'],
        ['name' => 'Fiat'],
        ['name' => 'Ford'],
        ['name' => 'Gurgel'],
        ['name' => 'Honda'],
        ['name' => 'Hyundai'],
        ['name' => 'JAC'],
        ['name' => 'Jeep'],
        ['name' => 'KIA'],
        ['name' => 'Land Rover'],
        ['name' => 'Mercedes-Benz'],
        ['name' => 'Mitsubishi'],
        ['name' => 'Nissan'],
        ['name' => 'Peugeot'],
        ['name' => 'Puma'],
        ['name' => 'Renault'],
        ['name' => 'Subaru'],
        ['name' => 'Suzuki'],
        ['name' => 'Toyota'],
        ['name' => 'Volvo'],
        ['name' => 'Volkswagen']
    ];

    /** 
     * Método responsável por subir a infomação no banco de dados.
    */
    public function up(): void
    {
        foreach ($this->informations as $information) {
            (new Database('brand'))->insert($information);
        }
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database('brand'))->delete('id <= 24');
    }
};
