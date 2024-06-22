<?php

namespace App\Model\DynamicBuilder\Widget\NavsTabs;

use App\Model\DynamicBuilder\Widget\Chat\MessageWidget;
use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;

/**
 * Widget para chat
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class ItemWidget extends BaseWidget
{
    /**
     * Elemento tipo id
     * @var object|null
     * @JMS\Expose
     * @JMS\SerializedName("id")
     */
    private $id;

    /**
     * Elemento tipo title
     * @var object|null
     * @JMS\Expose
     * @JMS\SerializedName("title")
     */
    private $title;

    /**
     * Elemento tipo active
     * @var object|null
     * @JMS\Expose
     * @JMS\SerializedName("active")
     */
    private $active;

    /**
     * URI de la pagina a cargar al tocar el elemento
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("uri_action")
     */
    protected $uriAction;

	public function __construct()
	{
        parent::__construct("nav_tabs_item");
        $this->active = false;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    public function setUriAction(string $uriAction)
    {
        $this->uriAction = $uriAction;

        return $this;
    }
}
