<?php

namespace App\Model\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\Basic\NameTrait;
use App\Traits\ORM\Basic\DescriptionTrait;

/**
 * Modelo base de carga de traits principales
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelStandardBaseMaster extends ModelBaseMaster
{
    use NameTrait;
    use DescriptionTrait;
}