<?php

use App\Model\DatabaseManager\Database;
use App\Common\CommandLine\Required\Interaction;

return new class extends Interaction
{
    /**
     * Informações a serem inseridas na tabela
     */
    private array $informations = [
        [
            'name' => 'Usuário admin',
            'email' => 'admin@email.com',
            'admin_access' => true,
            'password_hash' => '$2y$10$mUsr/jxR6XXs8lgXeaukPu/zkkOTIsX2dUus43h9sDBCuDu/upY/e'
        ],
        [
            'name' => 'Usuário padrão',
            'email' => 'default@email.com',
            'admin_access' => false,
            'password_hash' => '$2y$10$R4iNbyE5R7WY7rB592SpRe8fpdoCpqNbU1sAR16o9gaA6GmFfdUri'
        ]
    ];

    /** 
     * Método responsável por subir a infomação no banco de dados.
    */
    public function up(): void
    {
        foreach ($this->informations as $information) {
            (new Database('user'))->insert($information);
        }
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database('user'))->delete('id <= 2');
    }
};
