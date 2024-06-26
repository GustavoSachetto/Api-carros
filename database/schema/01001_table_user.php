<?php

use App\Model\DatabaseManager\Database;
use App\Common\CommandLine\Required\Interaction;
use App\Model\DatabaseManager\Diagram\Blueprint;

return new class extends Interaction
{
    /** 
     * Método responsável por subir a infomação no banco de dados.
    */
    public function up(): void
    {
        (new Database)->create('user', function(Blueprint $table) {
            $table->id();
            $table->varchar('name', 100)->notNull();
            $table->varchar('email', 255)->unique()->notNull();
            $table->boolean('admin_access')->notNull();
            $table->varchar('password_hash', 255)->notNull();
            $table->boolean('deleted')->default('false');
        });
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database)->dropIfExists('user');
    }
};
