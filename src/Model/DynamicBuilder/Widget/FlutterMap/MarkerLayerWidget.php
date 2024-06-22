<?php

namespace App\Model\DynamicBuilder\Widget\FlutterMap;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;

/**
 * Widget para mapas
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class MarkerLayerWidget extends BaseWidget
{   
    /**
     * Elemento tipo id
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("id")
     */
    protected $id = 0;

    /**
     * Elemento tipo latitude
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("latitude")
     */
    protected $latitude = 0;

    /**
     * Elemento tipo longitude
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("longitude")
     */
    protected $longitude = 0;

	public function __construct()
	{
        parent::__construct("market_layer");
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }
}
