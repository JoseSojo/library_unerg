<?php

namespace App\Model\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\IdentifiableTrait;
use App\Traits\ORM\BlameableTrait;
use App\Traits\ORM\TimestampableTrait;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\IpTraceableTrait;

/**
 * Modelo base de clases
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelBase implements ModelBaseInterface
{
    use IdentifiableTrait;
    use BlameableTrait;
    use TimestampableTrait;
    use SoftDeleteableTrait;
    use IpTraceableTrait;
}