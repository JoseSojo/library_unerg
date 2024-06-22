<?php

namespace App\Entity\M\Trabajo;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Model\User\ModelTrabajo;
use App\Entity\M\Master\Trabajo\Category;
use Doctrine\Common\Collections\ArrayCollection;
use App\Traits\ORM\Basic\ExtraDataTrait;
use App\Entity\M\Core\Document;

/**
 * Trabajo
 *
 * @author Jose Sojo <jsojo346@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\Trabajo\TrabajoRepository')]
#[ORM\Table(name: 'trabajo')]
class Trabajo extends ModelTrabajo
{
    /**
     * Imagen publicacion
     * @var \App\Entity\M\Core\Document
     */
    #[ORM\OneToOne(targetEntity: 'App\Entity\M\Core\Document', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private $document;

    /**
     * Categoria
     * @var \App\Entity\M\Master\Trabajo\Category
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Master\Trabajo\Category')]
    #[ORM\JoinTable(name: 'work_category_work', joinColumns: [new ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')])]
    private $category;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $authorName;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $authorLastname;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $authorCi;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $authorEmail;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $resumen;
    
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 20)]
    private $status = self::STATUS_IN_PROGRESS;
    
    use ExtraDataTrait;

    public function __construct()
    {
        // $this->category = new ArrayCollection();
        $this->status = self::STATUS_IN_PROGRESS;
        $this->extraData = [];
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): static
    {
        $this->document = $document;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorLastname(): ?string
    {
        return $this->authorLastname;
    }

    public function setAuthorLastname(string $authorLastname)
    {
        $this->authorLastname = $authorLastname;

        return $this;
    }

    public function getAuthorCi(): ?string
    {
        return $this->authorCi;
    }

    public function setAuthorCi(string $authorCi)
    {
        $this->authorCi = $authorCi;

        return $this;
    }

    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(string $authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getResumen(): ?string
    {
        return $this->resumen;
    }

    public function setResumen(?string $resumen)
    {
        $this->resumen = $resumen;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }
}
