<?php

use App\Model\DatabaseManager\Database;
use App\Common\CommandLine\Required\Interaction;

return new class extends Interaction
{
    /**
     * Informações a serem inseridas na tabela
     */
    private array $informations = [
        ['name' => 'Gasolina'],
        ['name' => 'Gasolina e Álcool'],
        ['name' => 'Álcool'],
        ['name' => 'Diesel'],
        ['name' => 'Gás Natural'],
        ['name' => 'Elétrico'],
        ['name' => 'Hidrogênio']
    ];

    /** 
     * Método responsável por subir a infomação no banco de dados.
    */
    public function up(): void
    {
        foreach ($this->informations as $information) {
            (new Database('fuel'))->insert($information);
        }
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database('fuel'))->delete('id <= 7');
    }
};
