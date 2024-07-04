<?php

namespace App\Entity\M\Trabajo;

use App\Entity\M\Master\Trabajo\Program;
use App\Traits\ORM\EnableableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Model\User\ModelTrabajo;
use App\Entity\M\Master\Trabajo\Category;
use App\Entity\M\Master\Trabajo\InvestigationLine;
use App\Entity\M\User;
use App\Traits\ORM\UserTrait;
use App\Traits\ORM\Basic\ExtraDataTrait;
use App\Entity\M\Core\Document;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Timestampable\Traits\Timestampable;

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
     * Documento
     * @var \App\Entity\M\Core\Document
     */
    #[ORM\OneToOne(targetEntity: 'App\Entity\M\Core\Document', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $document;

    /**
     * Resumen Documento
     * @var \App\Entity\M\Core\Document
     */
    #[ORM\OneToOne(targetEntity: 'App\Entity\M\Core\Document', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private $resumenDoc;

    /**
     * Categoria
     * @var \App\Entity\M\Master\Trabajo\Category
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Master\Trabajo\Category')]
    #[ORM\JoinTable(name: 'work_category_work', joinColumns: [new ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')])]
    private $category;

    /**
     * InvestigationLineRepository
     * @var \App\Entity\M\Master\Trabajo\InvestigationLine
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Master\Trabajo\InvestigationLine')]
    #[ORM\JoinTable(name: 'work_investigation_line_work', joinColumns: [new ORM\JoinColumn(name: 'investigation_line_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'investigation_line_id', referencedColumnName: 'id')])]
    private $investigationLine;

    /**
     * InvestigationLineRepository
     * @var \App\Entity\M\Master\Trabajo\InvestigationLine
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\Master\Trabajo\Program')]
    #[ORM\JoinTable(name: 'work_program_work', joinColumns: [new ORM\JoinColumn(name: 'program_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'program_id', referencedColumnName: 'id')])]
    private $program;

    use UserTrait;
    use EnableableTrait;
    use SoftDeleteable;
    use Timestampable;

    /**
     * ¿EL documento se puede descargar?
     * @var boolean
     */
    #[ORM\Column(name: 'downloader', type: 'boolean')]
    protected $downloader = true;

     /**
     * ¿EL objeto se puede utilizar por API?
     * @var boolean
     */
    #[ORM\Column(name: 'public', type: 'boolean')]
    protected $public = true;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $keyword;

    /**
     * @var string
     */
    #[ORM\Column(type: 'datetime', length: 50)]
    private $date;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255, unique:true)]
    private $title;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 800, unique:true, nullable: true)]
    private $resumenText;
    
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 20)]
    private $status = self::STATUS_IN_PROGRESS;

    public function __construct()
    {
        // $this->category = new ArrayCollection();
        $this->status = self::STATUS_IN_PROGRESS;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setResumenDoc(?Document $resumenDoc): static
    {
        $this->resumenDoc = $resumenDoc;

        return $this;
    }

    public function getResumenDoc(): ?Document
    {
        return $this->resumenDoc;
    }

    public function setDocument(?Document $document): static
    {
        $this->document = $document;

        return $this;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): static
    {
        $this->keyword = $keyword;

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

    public function getInvestigationLine(): ?InvestigationLine
    {
        return $this->investigationLine;
    }

    public function setInvestigationLine(?InvestigationLine $investigationLine): static
    {
        $this->investigationLine = $investigationLine;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): static
    {
        $this->program = $program;

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

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        // die();
        return $this;
    }

    public function getResumenText(): ?string
    {
        return $this->resumenText;
    }

    public function setResumenText(?string $resumenText)
    {
        $this->resumenText = $resumenText;

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

    /**
     * Is downloader?
     * @return boolean
     */
    public function isDownloader() 
    {
        return $this->downloader;
    }
    
    /**
     * Get downloader
     *
     * @return boolean
     */
    public function getDownloader()
    {
        return $this->downloader;
    }

    /**
     * Set downloader
     * @param boolean $downloader
     * @return $this
     */
    public function setDownloader($downloader)
    {
        $this->downloader = (boolean)$downloader;
        
        return $this;
    }

    /**
     * Is downloader?
     * @return boolean
     */
    public function isPublic() 
    {
        return $this->public;
    }
    
    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set public
     * @param boolean $public
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = (boolean)$public;
        
        return $this;
    }
}
