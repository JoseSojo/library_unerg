<?php

namespace App\Repository\M\User;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ServiceEntityRepository;
use App\Entity\M\User\MobileDevice;

/**
 * Repositorio de dispositivos moviles
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
class MobileDeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MobileDevice::class);
    }

    public function findUnUpdate(\DateTime $date)
    {
        $qb = $this->getQueryBuilder();
        $qb
                ->andWhere("md.updatedAt < :lastUpdate")
                ->setParameter("lastUpdate", $date)
                ;
        $qb->orderBy("md.updatedAt","ASC");
        
        return $this->getPaginator($qb);
    }
    
    public function getAlias()
    {
        return "md";
    }
}