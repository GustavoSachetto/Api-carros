<?php

namespace App\Common;

use Exception;

class Environment
{
    /**
     * Método responsável por verificar a existência do arquivo .env
     * @param string $dir
     * @return void
     */
    private static function verifyFileExists($dir)
    {
        if (!file_exists($dir.'/.env')) {
            throw new Exception("Não foi possivel carregar as variáveis de ambiente do servidor.", 500);
        }
    }

    /**
     * Método responsável por carregar as variáveis de ambiente
     * @param string $dir
     * @return void
     */
    private static function loadFile($dir)
    {
        $lines = file($dir.'/.env');
        foreach ($lines as $line) {
            putenv(trim($line));
        }
    }

    /**
     * Método resonsável por carregar o arquivo .env
     * @param string $dir
     * @return void
     */
    public static function load($dir) 
    {
        try {
            self::verifyFileExists($dir);
            self::loadFile($dir);
        } catch (\Exception $e) {
            die('ERROR: '.$e->getMessage());
        }
    }
}
