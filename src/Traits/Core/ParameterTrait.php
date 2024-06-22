<?php

namespace App\Traits\Core;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campos de parametros
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait ParameterTrait 
{
    /**
     * @var string
     */
    #[ORM\Column(name: 'item_key')]
    private $itemKey;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'item_value', nullable: true)]
    private $itemValue;

    /**
     * @var string
     */
    #[ORM\Column(name: 'item_help')]
    private $itemHelp;

    /**
     * Set itemKey.
     *
     * @param string $itemKey
     *
     * @return Parameter
     */
    public function setItemKey($itemKey)
    {
        $this->itemKey = $itemKey;

        return $this;
    }

    /**
     * Get itemKey.
     *
     * @return string
     */
    public function getItemKey()
    {
        return $this->itemKey;
    }

    /**
     * Set itemValue.
     *
     * @param string $itemValue
     *
     * @return Parameter
     */
    public function setItemValue($itemValue)
    {
        $this->itemValue = $itemValue;

        return $this;
    }

    /**
     * Get itemValue.
     *
     * @return string
     */
    public function getItemValue()
    {
        return $this->itemValue;
    }

    /**
     * Set itemHelp.
     *
     * @param string $itemHelp
     *
     * @return Parameter
     */
    public function setItemHelp($itemHelp)
    {
        $this->itemHelp = $itemHelp;

        return $this;
    }

    /**
     * Get itemHelp.
     *
     * @return string
     */
    public function getItemHelp()
    {
        return $this->itemHelp;
    }
}
