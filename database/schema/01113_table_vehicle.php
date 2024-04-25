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
        (new Database)->create('vehicle', function(Blueprint $table) {
            $table->id();
            $table->decimal('price', 11.2)->notNull();
            $table->varchar('version', 50)->notNull();

            $table->varchar('primary_image')->notNull();
            $table->varchar('secondary_image');
            $table->varchar('tertiary_image');

            $table->year('production_year')->notNull();
            $table->year('release_year')->notNull();
            
            $table->tinyInt('doors', true)->notNull();
            $table->decimal('motor', 2.1)->notNull();
            $table->char('bodywork', 20)->notNull();

            $table->boolean('automatic_pilot');
            $table->boolean('air_conditioner');
            $table->boolean('automatic_glass');
            $table->boolean('am_fm');
            $table->boolean('auxiliary_input');
            $table->boolean('bluetooth');
            $table->boolean('cd_player');
            $table->boolean('dvd_player');
            $table->boolean('mp3_reader');
            $table->boolean('usb_port');

            $table->bigInt('model_id', true)->notNull();
            $table->constraint('FK_model_vehicle', 'foreign key', ['model_id', 'model', 'id']);

            $table->bigInt('fuel_id', true)->notNull();
            $table->constraint('FK_fuel_vehicle', 'foreign key', ['fuel_id', 'fuel', 'id']);

            $table->bigInt('transmission_id', true)->notNull();
            $table->constraint('FK_transmission_vehicle', 'foreign key', ['transmission_id', 'transmission', 'id']);

            $table->constraint('UQ_vehicle', 'unique', ['version', 'model_id', 'fuel_id', 'transmission_id']);
            $table->boolean('deleted')->default('false');
        });
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database)->dropIfExists('vehicle');
    }
};
