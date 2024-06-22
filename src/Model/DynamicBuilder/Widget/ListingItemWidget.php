<?php

namespace App\Model\DynamicBuilder\Widget;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\TitleTrait;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\UriActionTrait;

/**
 * Widget para mapas
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class ListingItemWidget extends BaseWidget
{   
    /**
     * Elemento tipo imagen
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("image")
     */
    protected $image;

    /**
     * Elemento tipo tag
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("tag_title")
     */
    protected $tagTitle;

    /**
     * Elemento tipo tag top
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("tag_top")
     */
    protected $tagTop;

    /**
     * Elemento tipo info
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("info")
     */
    protected $info;

    /**
     * Elemento tipo address
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("address")
     */
    protected $address;

    /**
     * Elemento tipo phone
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("phone")
     */
    protected $phone;

    use TitleTrait;
    use UriActionTrait;

	public function __construct()
	{
        parent::__construct("listing_item");
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function setTagTitle($tagTitle)
    {
        $this->tagTitle = $tagTitle;

        return $this;
    }

    public function setTagTop($tagTop)
    {
        $this->tagTop = $tagTop;

        return $this;
    }

    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
}
