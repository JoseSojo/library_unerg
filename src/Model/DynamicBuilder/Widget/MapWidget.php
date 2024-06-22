<?php

namespace App\Model\DynamicBuilder\Widget;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;

/**
 * Widget para mapas
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class MapWidget extends BaseWidget
{   
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

    /**
     * Elemento tipo zoom
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("zoom")
     */
    protected $zoom = 14.0; // 9.2

    /**
     * Elemento tipo minZoom
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("minZoom")
     */
    protected $minZoom = 5.0;

    /**
     * Elemento tipo maxZoom
     * @var boolean|null
     * @JMS\Expose
     * @JMS\SerializedName("maxZoom")
     */
    protected $maxZoom = 18.0;

    /**
     * Elemento titulo
     * @var array
     * @JMS\Expose
     * @JMS\SerializedName("markers")
     */
    protected $markers;

	public function __construct()
	{
        parent::__construct("map");
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

    public function setZoom($zoom)
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function setMinZoom($minZoom)
    {
        $this->minZoom = $minZoom;

        return $this;
    }

    public function setMaxZoom($maxZoom)
    {
        $this->maxZoom = $maxZoom;

        return $this;
    }

    public function addMarker($markers)
    {
        $this->markers[] = $markers;

        return $this;
    }
}
