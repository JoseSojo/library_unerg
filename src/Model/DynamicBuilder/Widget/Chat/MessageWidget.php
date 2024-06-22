<?php

namespace App\Model\DynamicBuilder\Widget\Chat;

use JMS\Serializer\Annotation as JMS;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\BaseWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\TitleTrait;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Traits\SubTitleTrait;

/**
 * Widget para chat
 *
 * @author Máximo Sojo <mxsojo13@gmail.com>
 * @JMS\ExclusionPolicy("ALL");
 */
class MessageWidget extends BaseWidget
{
    const ALIGN_LEFT = "left";
    const ALIGN_RIGHT = "right";

    /**
     * Elemento tipo content
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("content")
     */
    private $content;

    /**
     * Elemento tipo date
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("date")
     */
    private $date;

    /**
     * Elemento tipo author
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("author")
     */
    private $author;

    /**
     * Elemento tipo align
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("align")
     */
    private $align = self::ALIGN_LEFT;

	public function __construct()
	{
        parent::__construct("chat_message");
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function setAlign($align)
    {
        $this->align = $align;

        return $this;
    }
}
