<?php

namespace App\Entity\M\Core;

use App\Model\Core\ModelDocument;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Services\Util\StringUtil;

/**
 * Documentos
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\Entity()]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'core_documents')]
class Document extends ModelDocument
{
    public const SUB_DIR = "/uploads/";

    /**
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $name;

    /**
     */
    #[ORM\Column(type: 'text')]
    public $path;

    /**
     */
    #[ORM\Column(type: 'text', nullable: true)]
    public $absolutePath;
    
    /**
     * Tenia el valor por defecto "def" pero daba error al generar path colocandole por defecto "def"
     */
    #[ORM\Column(type: 'text', nullable: true)]
    public $subDir = null;
    
    /**
     * hash
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public $hash;
    
    /**
     * Extension del archivo
     */
    #[ORM\Column(type: 'string', length: 10)]
    public $extension;
    
    /**
     * Mime Type
     */
    #[ORM\Column(type: 'string', length: 40)]
    public $mimeType;

    public $file;

    private $temp;

    private $old;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAbsolutePath(): ?string
    {
        return $this->absolutePath;
    }

    public function setAbsolutePath(string $absolutePath): self
    {
        $this->absolutePath = $absolutePath;

        return $this;
    }

    public function getSubDir(): ?string
    {
        return $this->subDir;
    }

    public function setSubDir(?string $subDir): self
    {
        $this->subDir = $subDir;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(?string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     */
    #[ORM\PrePersist()]
    #[ORM\PreUpdate()]
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = $this->generateUniqueID();
            
            $this->hash = $this->generateUniqueID();
            
            $extension = pathinfo($this->name,PATHINFO_EXTENSION);
            if($extension === null){
                $extension = $this->getFile()->getExtension();
            }
            if(empty($extension)){
                $extension = $this->getFile()->guessExtension();
            }
            $date = new \DateTime();
            $dPath = sprintf("%s/%s/%s/%s/%s/%s",$date->format("Y"),$date->format("m"),$date->format("d"),$date->format("H"),$date->format("i"), substr(md5($date->getTimestamp()),0, 3));
            $path = sprintf("%s/%s/%s/%s.%s",$_ENV["APP_ENV"],$this->subDir,$dPath,$filename,$extension);
            $path = StringUtil::pathNormalize($path);
            $this->path = $path;
            $this->extension = $extension;
            $this->mimeType = $this->getFile()->getMimeType();
            $this->subDir = null;
        }
    }
    
    #[ORM\PrePersist()]
    public function preRemove() {
        $this->old = clone $this;
    }

    #[ORM\PostRemove()]
    public function removeUpload()
    {
        $old = $this->old;
        $this->old = null;
        if($old){
            $old->old = null;
            $old->removeUpload();
            return;
        }
        if (($file = $this->getAbsPath()) && file_exists($file)) {
            @unlink($file);
        }
    }
    
    #[ORM\PostPersist()]
    #[ORM\PostUpdate()]
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $dir = pathinfo($this->path,PATHINFO_DIRNAME);
        $filename = pathinfo($this->path,PATHINFO_FILENAME);
        if($this->extension){
            $filename = $filename.".".$this->extension;
        }
        $this->getFile()->move($this->getUploadRootDir().$dir,$filename);

        // check if we have an old image
        if ($this->temp) {
            // delete the old image
            @unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }
}
