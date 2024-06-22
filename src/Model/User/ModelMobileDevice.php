<?php

namespace App\Model\User;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Base\ModelBase;

/**
 * Modelo de usuarios push
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
abstract class ModelMobileDevice extends ModelBase
{
    const TYPE_UNKNOWN = "unknown";
    const TYPE_ANDROID = "android";
    const TYPE_IOS = "ios";
    
    public static function getTypes()
    {
        return [
            self::TYPE_UNKNOWN => "choice.type.unknown",
            self::TYPE_ANDROID => "choice.type.android",
            self::TYPE_IOS => "choice.type.ios",
        ];
    }
    
    public function getTypeLabel()
    {
        $types = self::getTypes();
        $label = "";
        if(isset($types[$this->getType()])){
            $label = $types[$this->getType()];
        }
        return $label;
    }
    
    public static function parseOldType($type)
    {
        //Ya esta actualizado
        if(in_array($type,[self::TYPE_UNKNOWN,self::TYPE_ANDROID,self::TYPE_IOS])){
            return $type;
        }
        if($type == "100"){
            $type = self::TYPE_ANDROID;
        }else if($type == "200"){
            $type = self::TYPE_IOS;
        }else {
            $type = self::TYPE_UNKNOWN;
        }
        return $type;
    }
}
