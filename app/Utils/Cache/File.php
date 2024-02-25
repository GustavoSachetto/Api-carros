<?php

namespace App\Utils\Cache;

class File
{
    /**
     * Método responsável por validar o tempo de expiração do conteúdo no cache
     * @return boolean
     */
    private static function validateCacheExpiration($cacheFile, $expiration)
    {
        $createTime = filemtime($cacheFile);
        $diffTime = time() - $createTime;
        
        if ($diffTime > $expiration) return false;

        return true;
    }

    /**
     * Método responsável por retornar o caminho até o arquivo de cache
     * @param string
     * @return string
     */
    private static function getFilePath($hash) {
        $dir = getenv('CACHE_DIR');

        if (!file_exists($dir)) {
            mkdir($dir,0755,true);
        }

        return $dir.'/'.$hash;
    }


    /**
     * Método responsável por retornar o conteúdo gravado no cache
     * @param string $hash
     * @param int $expiration
     * @return mixed
     */
    private static function getContentCache($hash, $expiration) {
        $cacheFile = self::getFilePath($hash);

        if (!file_exists($cacheFile)) return false; 
        if (!self::validateCacheExpiration($cacheFile, $expiration)) return false;

        $serialize = file_get_contents($cacheFile);
        return unserialize($serialize);
    }

    /**
     * Método responsável por guardar informações no cache
     * @param string $hash
     * @param mixed $content
     * @return boolean
     */
    private static function storageCache($hash, $content)
    {
        $serialize = serialize($content);
        $cacheFile = self::getFilePath($hash);

        return file_put_contents($cacheFile,$serialize);
    }

    /**
     * Método responsável por obter uma informação do cache
     * @param string $hash
     * @param integer $espiration
     * @param Closure $function
     * @return mixed
     */
    public static function getCache($hash, $expiration, $function)
    {
        if ($content = self::getContentCache($hash, $expiration)) {
            return $content;
        } 

        $content = $function();
        self::storageCache($hash, $content);

        return $content;
    }
}
