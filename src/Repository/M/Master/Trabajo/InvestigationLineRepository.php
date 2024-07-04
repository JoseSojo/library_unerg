<?php

namespace App\Repository\M\Master\Trabajo;

use App\Entity\M\Master\Trabajo\InvestigationLine;
use App\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InvestigationLine>
 *
 * @method InvestigationLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvestigationLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvestigationLine[]    findAll()
 * @method InvestigationLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvestigationLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InvestigationLine::class);
    }
}
