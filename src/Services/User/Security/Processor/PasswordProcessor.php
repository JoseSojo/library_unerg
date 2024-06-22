<?php

namespace App\Services\User\Security\Processor;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\M\Master\User\Security\Method;
use App\Form\A\User\Security\Method\Password\UpdateType;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\TitleWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\CardWidget;

/**
 * PasswordProcessor
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class PasswordProcessor extends BaseProcessor
{
    /**
     * Retorna la clase de formulario
     *
     * @return  Class
     */
    public function getFormUpdateClass()
    {
        return UpdateType::class;
    }

    public function renderFormUpdate()
    {
        $titleWidget = new TitleWidget();
        $titleWidget->setTitle($this->trans("title.password.update"));
        $this->dynamicBuilderManager->addWidget($titleWidget);
    }

    public function persistFormUpdate()
    {
        $entity = $this->getUser();
        $this->dispatch(\App\AppEvents::APP_USER_PASSWORD_UPDATE_PRE_SUCCESS,$this->newGenericEvent($entity));
        $this->userManager->updateUser($entity);
        $this->dispatch(\App\AppEvents::APP_USER_PASSWORD_UPDATE_POST_SUCCESS,$this->newGenericEvent($entity));
        // Response
        $jsonResponse = $this->newJsonResponse();
        $jsonResponse->setFlash(self::TYPE_SUCCESS,$this->trans('flash.update.success'));
        $jsonResponse->setBackRedirect();
        return $jsonResponse;
    }

    public static function getName()
    {
        return "password";
    }
}
