<?php

namespace App\Entity\S\ObjectManager\StatisticsManager\User;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ObjectManager\StatisticManager\DoctrineORM\StatisticsYear as ModelStatisticsYear;
use Maximosojo\ToolsBundle\Model\ObjectManager\StatisticManager\StatisticsYearInterface;
use Maximosojo\ToolsBundle\Model\ObjectManager\StatisticManager\StatisticsMonthInterface;

/**
 * Estadistica de un año
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'object_manager_statistic_manager_user_year')]
class StatisticsYear extends ModelStatisticsYear
{
    /**
     * Meses
     * @var StatisticsMonth
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\S\ObjectManager\StatisticsManager\User\StatisticsMonth', cascade: ['persist', 'remove'], mappedBy: 'yearEntity')]
    protected $months;

    /**
     * Add month
     *
     * @param StatisticsMonth $month
     *
     * @return StatisticsYear
     */
    public function addMonth(StatisticsMonthInterface $month)
    {
        $this->months->set($month->getMonth(),$month);

        return $this;
    }

    /**
     * Remove month
     *
     * @param StatisticsMonth $month
     */
    public function removeMonth(StatisticsMonthInterface $month)
    {
        $this->months->removeElement($month);
    }

    /**
     * Get months
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMonths()
    {
        return $this->months;
    }
    
    public function getMonth($month)
    {
        $month = (int)$month;
        $found = null;
        foreach ($this->getMonths() as $value) {
            if($value->getMonth() === $month){
                $found = $value;
                break;
            }
        }
        
        return $found;
    }
    
    public function totalize()
    {
        $total = 0.0;
        foreach ($this->getMonths() as $month) {
                $month->totalize();
                $totalMonth = $month->getTotal();
                $setTotalMonth = sprintf("setTotalMonth%s",$month->getMonth());
                $this->$setTotalMonth($totalMonth);
                $total = $total + $totalMonth;
        }

        $this->total = $total;
    }
}
