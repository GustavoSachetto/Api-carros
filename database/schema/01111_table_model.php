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
        (new Database)->create('model', function(Blueprint $table) {
            $table->id();
            $table->varchar('name', 50)->notNull();
            $table->bigInt('brand_id', true)->notNull();
            $table->constraint('FK_brand_model', 'foreign key', ['brand_id', 'brand', 'id']);
            $table->constraint('UQ_model', 'unique', ['name', 'brand_id']);
            $table->boolean('deleted')->default('false');
        });
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database)->dropIfExists('model');
    }
};
