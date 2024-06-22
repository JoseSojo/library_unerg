<?php

namespace App\Model\DynamicBuilder\Widget;

use App\Model\DynamicBuilder\Widget\Chat\MessageWidget;
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
class ChatWidget extends BaseWidget
{
    use TitleTrait;
    use SubTitleTrait;

    /**
     * Elemento tipo messages
     * @var array|null
     * @JMS\Expose
     * @JMS\SerializedName("messages")
     */
    private $messages = [];

    /**
     * Elemento tipo form
     * @var object|null
     * @JMS\Expose
     * @JMS\SerializedName("form")
     */
    private $form;

    /**
     * URI de la pagina a cargar al tocar el elemento
     * @var string|null
     * @JMS\Expose
     * @JMS\SerializedName("uri_action")
     */
    protected $uriAction;

	public function __construct()
	{
        parent::__construct("chat");
    }

    public function addMessage(MessageWidget $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    public function setUriAction(string $uriAction)
    {
        $this->uriAction = $uriAction;

        return $this;
    }
}
