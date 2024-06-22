<?php

namespace App\Model\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\IdentifiableTrait;
use App\Traits\ORM\TimestampableTrait;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\EnableableTrait;

/**
 * Modelo base de clases
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelBaseMaster
{
    use IdentifiableTrait;
    use TimestampableTrait;
    use SoftDeleteableTrait;
    use EnableableTrait;
}