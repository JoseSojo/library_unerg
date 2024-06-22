<?php

/*
 * This file is part of the Maxtoan Tools package.
 * 
 * (c) https://maxtoan.github.io/tools-bundle
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Traits;

/**
 * DoctrineTrait
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait DoctrineTrait 
{
    /**
     * entityManager
     * @required
     */
    public function setEntityManager(\Doctrine\ORM\EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Retorna el repositorio principal
     * @return \Maximosojo\ToolsBundle\Model\Base\EntityRepository
     */
    protected function getRepository($repository = null)
    {
        $em = $this->getEntityManager();
        
        if (!$repository) {
            $repository = $this->getClass();
        }

        return $em->getRepository($repository);
    }

    protected function doPersist($entity, $andFlush = true)
    {
        try {
            $this->getEntityManager()->persist($entity);
            if($andFlush === true){
                $this->getEntityManager()->flush();
            }
        } catch (Exception $e) {
            $this->getEntityManager()->rollBack();
        }
    }

    protected function doFlush()
    {
        try {
            $this->getEntityManager()->flush();
        } catch (Exception $e) {
            $this->getEntityManager()->rollBack();
        }
    }
}