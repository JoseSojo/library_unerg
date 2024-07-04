<?php

namespace App\Entity\M\Master\Trabajo;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use App\Model\Master\Trabajo\ModelType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\Basic\NameTrait;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\EnableableTrait;
use App\Traits\ORM\TimestampableTrait;

/**
 * Program
 *
 * @author José Sojo <jsojo346@gmail.com>
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\Master\Trabajo\ProgramRepository')]
#[ORM\Table(name: 'master_trabajo_program')]
class Program extends ModelType
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 36)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected $id;

    use NameTrait;
    use EnableableTrait;
    use SoftDeleteableTrait;
    use TimestampableTrait;

    public function __construct()
    {
        $this->enabled = true;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}