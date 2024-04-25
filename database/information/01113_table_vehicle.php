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
            'price'           => '66900.00',
            'version'         => '1.4 MPFI LT V8',
            'primary_image'   => 'https: //image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17445058936.jpg?s = fill&w = 1920&h = 1440&q = 75',
            'secondary_image' => 'https: //image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17445015235.jpg?s = fill&w = 1920&h = 1440&q = 75',
            'tertiary_image'  => 'https: //image.webmotors.com.br/_fotos/anunciousados/gigante/2023/202312/20231215/chevrolet-prisma-1.4-mpfi-lt-8v-flex-4p-manual-wmimagem17450436217.jpg?s = fill&w = 1920&h = 1440&q = 75',
            'production_year' => '2018',
            'release_year'    => '2019',
            'doors'           => '4',
            'motor'           => '1.4',
            'bodywork'        => 'Sedã',
            'automatic_pilot' => true,
            'air_conditioner' => false,
            'automatic_glass' => false,
            'am_fm'           => true,
            'auxiliary_input' => false,
            'bluetooth'       => false,
            'cd_player'       => false,
            'dvd_player'      => false,
            'mp3_reader'      => false,
            'usb_port'        => false,
            'model_id'        => 1,
            'fuel_id'         => 2,
            'transmission_id' => 1
        ],
        [
            'price'           => '78890.00',
            'version'         => '1.6 Sport Turbo 4p',
            'primary_image'   => 'https://http2.mlstatic.com/D_NQ_NP_953549-MLB74022792667_012024-O.webp',
            'secondary_image' => 'https://http2.mlstatic.com/D_NQ_NP_655077-MLB73920317892_012024-O.webp',
            'tertiary_image'  => 'https://http2.mlstatic.com/D_NQ_NP_970213-MLB73920181326_012024-O.webp',
            'production_year' => '2014',
            'release_year'    => '2014',
            'doors'           => '4',
            'motor'           => '1.6',
            'bodywork'        => 'Sedã',
            'automatic_pilot' => true,
            'air_conditioner' => true,
            'automatic_glass' => true,
            'am_fm'           => true,
            'auxiliary_input' => true,
            'bluetooth'       => true,
            'cd_player'       => true,
            'dvd_player'      => true,
            'mp3_reader'      => true,
            'usb_port'        => true,
            'model_id'        => 21,
            'fuel_id'         => 1,
            'transmission_id' => 2
        ],
        [
            'price'           => '189900.99',
            'version'         => '6.2 v8 Gasolina ss Automático',
            'primary_image'   => 'https://http2.mlstatic.com/D_NQ_NP_654304-MLA73599919881_122023-O.webp',
            'secondary_image' => 'https://http2.mlstatic.com/D_NQ_NP_798574-MLB73507390372_122023-O.webp',
            'tertiary_image'  => null,
            'production_year' => '2012',
            'release_year'    => '2012',
            'doors'           => '2',
            'motor'           => '6.2',
            'bodywork'        => 'Coupé',
            'automatic_pilot' => true,
            'air_conditioner' => true,
            'automatic_glass' => true,
            'am_fm'           => true,
            'auxiliary_input' => true,
            'bluetooth'       => true,
            'cd_player'       => true,
            'dvd_player'      => true,
            'mp3_reader'      => true,
            'usb_port'        => true,
            'model_id'        => 18,
            'fuel_id'         => 2,
            'transmission_id' => 2
        ],
        [
            'price'           => '77900.80',
            'version'         => '1.4 Ltz 5p',
            'primary_image'   => 'https://http2.mlstatic.com/D_NQ_NP_635613-MLB72695882250_112023-O.webp',
            'secondary_image' => 'https://http2.mlstatic.com/D_NQ_NP_775847-MLB72769680979_112023-O.webp',
            'tertiary_image'  => null,
            'production_year' => '2019',
            'release_year'    => '2019',
            'doors'           => '4',
            'motor'           => '1.4',
            'bodywork'        => 'Hatch',
            'automatic_pilot' => false,
            'air_conditioner' => true,
            'automatic_glass' => true,
            'am_fm'           => false,
            'auxiliary_input' => true,
            'bluetooth'       => true,
            'cd_player'       => true,
            'dvd_player'      => true,
            'mp3_reader'      => true,
            'usb_port'        => false,
            'model_id'        => 3,
            'fuel_id'         => 2,
            'transmission_id' => 1
        ],
        [
            'price'           => '215990.66',
            'version'         => 'Ev 66 kw Elétrico',
            'primary_image'   => 'https://http2.mlstatic.com/D_NQ_NP_657050-MLB73629919458_122023-O.webp',
            'secondary_image' => null,
            'tertiary_image'  => null,
            'production_year' => '2023',
            'release_year'    => '2024',
            'doors'           => '4',
            'motor'           => '0',
            'bodywork'        => 'Hatch',
            'automatic_pilot' => true,
            'air_conditioner' => true,
            'automatic_glass' => true,
            'am_fm'           => true,
            'auxiliary_input' => true,
            'bluetooth'       => true,
            'cd_player'       => true,
            'dvd_player'      => true,
            'mp3_reader'      => true,
            'usb_port'        => true,
            'model_id'        => 18,
            'fuel_id'         => 6,
            'transmission_id' => 2
        ]
    ];

    /** 
     * Método responsável por subir a infomação no banco de dados.
    */
    public function up(): void
    {
        foreach ($this->informations as $information) {
            (new Database('vehicle'))->insert($information);
        }
    }

    /** 
     * Método responsável por descer a infomação no banco de dados.
    */
    public function down(): void
    {
        (new Database('vehicle'))->delete('id <= 5');
    }
};
