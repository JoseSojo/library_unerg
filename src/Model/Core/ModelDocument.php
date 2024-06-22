<?php

namespace App\Model\Core;

use App\Model\Base\ModelBase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\Util\StringUtil;

/**
 * Base de documentos
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelDocument extends ModelBase
{
    public function getAbsolutePath()
    {
        $path = null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
        $path = StringUtil::pathNormalize($path);
        return $path;
    }

    public function getWebPath()
    {
        $path = null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
        $path = StringUtil::pathNormalize($path);
        return $path;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        $this->name = $file->getClientOriginalName();
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Genera identificador unico
     *
     * @return  Sring id
     */
    protected function generateUniqueID()
    { 
        return sprintf("%s-%s",$this->strRandom(),$this->strRandom());
    }
    
    /**
     * Genera string dinamico
     *
     * @param   int  $length
     * 
     * @return  string
     */
    protected function strRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        $uploadPath = __DIR__.'/../../../var/'.$this->getUploadDir();
        if(!is_dir($uploadPath)){
            mkdir($uploadPath, 0777, true);
        }
        return $uploadPath;
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        $dir = 'uploads/';
        if($this->id && !empty($this->subDir)){
            $dir = $dir.$this->subDir;
        }
        return $dir;
    }
}
