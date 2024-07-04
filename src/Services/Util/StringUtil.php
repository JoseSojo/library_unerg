<?php

namespace App\Services\Util;

/**
 * Util de string
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class StringUtil
{
    /**
     * Normaliza un path para eliminar caracteres de mas /
     * @param string $path
     * @return boolean
     */
    public static function pathNormalize($path)
    {
        if (!empty($path)) {
            $prefix = "";
            if ($path[0] === "/") {
                $prefix = "/";
            }
            $path = str_replace('\\', '/', $path);
            $blocks = preg_split('#/#', $path, null, PREG_SPLIT_NO_EMPTY);
            $res = array();

            foreach(array_keys($blocks) as $k) {
                $block = $blocks[$k];
                if ($block == '.') {
                    if ($k == 0)
                        $res = explode('/', path_normalize(getcwd()));
                } elseif($block == '..'){
                    if (!$res)
                        return false;
                    array_pop($res);
                } else {
                    $res[] = $block;
                }
            }
            
            return $prefix . implode('/', $res);
        }
        return $path;
    }

    // 34
    public static function truncateText(string $string, int $length = 25)
    {
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length).'...';
        }

        return $string;
    }
}