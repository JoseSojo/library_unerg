<?php

namespace App\Traits\ORM;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\ORM\PriorityInterface;

/**
 * Description of PriorityTrait
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait PriorityTrait 
{    
    /**
     * @var integer
     */
    #[ORM\Column(type: 'integer')]
    protected $priority = 0;

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public static function getPriorityArray()
    {
        $array = [
            "label.priority.low" => PriorityInterface::PRIORITY_LOW,
            "label.priority.medium" => PriorityInterface::PRIORITY_MEDIUM,
            "label.priority.high" => PriorityInterface::PRIORITY_HIGH
        ];

        return $array;
    }

    public function getPriorityLabel()
    {
        $priorityArray = self::getPriorityArray();
        return $priorityArray === null ? : array_search($this->getPriority(),$priorityArray);
    }

    public function getPriorityColorsArray()
    {
        $array = [
            "success" => PriorityInterface::PRIORITY_LOW,
            "info" => PriorityInterface::PRIORITY_MEDIUM,
            "warning" => PriorityInterface::PRIORITY_HIGH
        ];

        return $array;
    }
	
	public function getPriorityColor()
    {
        $colorArray = self::getPriorityColorsArray();
        return $colorArray === null ? : array_search($this->getPriority(),$colorArray);
    }
}