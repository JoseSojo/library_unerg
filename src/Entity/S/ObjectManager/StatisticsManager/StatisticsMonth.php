<?php

namespace App\Entity\S\ObjectManager\StatisticsManager;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ObjectManager\StatisticManager\DoctrineORM\StatisticsMonth as ModelStatisticsMonth;
use Maximosojo\ToolsBundle\Model\ObjectManager\StatisticManager\StatisticsYearInterface;

/**
 * Contador mensual enteros
 */
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'object_manager_statistic_manager_monthly')]
class StatisticsMonth extends ModelStatisticsMonth
{
    /**
     * @var StatisticsYear
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\S\ObjectManager\StatisticsManager\StatisticsYear', inversedBy: 'months')]
    #[ORM\JoinColumn(nullable: false)]
    protected $yearEntity;

    public function getYearEntity() 
    {
        return $this->yearEntity;
    }

    public function setYearEntity(StatisticsYearInterface $yearEntity)
    {
        $this->yearEntity = $yearEntity;
        return $this;
    }

    public function totalize() 
    {
        return parent::totalize();
    }
}
