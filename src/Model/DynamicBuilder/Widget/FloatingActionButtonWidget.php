<?php

namespace App\Model\DynamicBuilder\Widget;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\TitleTrait;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\UriActionTrait;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\IconTrait;

/**
 * Widget para botones
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class FloatingActionButtonWidget extends BaseWidget
{
    use TitleTrait;
	use UriActionTrait;
    use IconTrait;
    
    /**
     * Elemento tipo disabled
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("disabled")
     */
    protected $disabled = false;

	public function __construct()
	{
        parent::__construct("floating_action_button");
    }

    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }
}
