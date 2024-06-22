<?php

namespace App\Model\DynamicBuilder\Widget;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;

/**
 * Widget para iframe
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class IframeWidget extends BaseWidget
{   
    /**
     * Elemento tipo src
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("src")
     */
    protected $src;

	public function __construct()
	{
        parent::__construct("iframe");
    }

    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }
}
