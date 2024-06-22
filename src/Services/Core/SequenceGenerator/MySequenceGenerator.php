<?php

namespace App\Services\Core\SequenceGenerator;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Maximosojo\ToolsBundle\Model\SequenceGenerator\SequenceGenerator;
use Maxtoan\Common\Util\StringUtil;
use App\Entity\M\User\Transaction;

/**
 * Configuración de generador de secuencia
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class MySequenceGenerator extends SequenceGenerator
{
    /**
     * Retorna las clases que esta manejando el generador de secuencia
     * @return array
     */
    public function getClassMap()
    {
        return [
            
        ];
    }
}
