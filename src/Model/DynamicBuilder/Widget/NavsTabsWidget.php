<?php

namespace App\Model\DynamicBuilder\Widget;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;
use App\Model\DynamicBuilder\Widget\NavsTabs\ItemWidget;

/**
 * Widget para chat
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class NavsTabsWidget extends BaseWidget
{
    /**
     * Elemento tipo items
     * @var array|null
     * @JMS\Expose
     * @JMS\SerializedName("items")
     */
    private $items;

	public function __construct()
	{
        parent::__construct("nav_tabs");
        $this->active = false;
    }

    public function addItem(ItemWidget $item)
    {
        $this->items[] = $item;

        return $this;
    }
}
