<?php

namespace App\Services\User\Security\Processor;

use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\M\Master\User\Security\Method;
use App\Form\A\User\Security\Method\Email\UpdateType;
use App\Form\A\User\Security\Method\Email\ValidateType;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\TitleWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\CardWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\SubTitleWidget;

/**
 * EmailProcessor
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class EmailProcessor extends BaseProcessor
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
        $titleWidget->setTitle($this->trans("title.email.update"));
        $this->dynamicBuilderManager->addWidget($titleWidget);

        $subTitleWidget = new SubTitleWidget();
        $subTitleWidget->setSubTitle($this->trans("title.email.update.help"));
        $this->dynamicBuilderManager->addWidget($subTitleWidget);
    }

    public function persistFormUpdate()
    {
        $entity = $this->getUser();
        $this->dispatch(\App\AppEvents::APP_USER_EMAIL_UPDATE_PRE_SUCCESS,$this->newGenericEvent($entity));
        $this->userManager->updateUser($entity);
        $this->dispatch(\App\AppEvents::APP_USER_EMAIL_UPDATE_POST_SUCCESS,$this->newGenericEvent($entity));
        // Response
        $jsonResponse = $this->newJsonResponse();
        $jsonResponse->setFlash(self::TYPE_SUCCESS,$this->trans('flash.update.success'));
        $jsonResponse->setBackRedirect();
        return $jsonResponse;
    }

    /**
     * Retorna la clase de formulario
     *
     * @return  Class
     */
    public function getFormValidateClass()
    {
        return ValidateType::class;
    }

    public function renderFormValidate()
    {
        $entity = $this->getUser();
        $titleWidget = new TitleWidget();
        $titleWidget->setTitle($this->trans("title.email.validate"));
        $this->dynamicBuilderManager->addWidget($titleWidget);

        $subTitleWidget = new SubTitleWidget();
        $subTitleWidget->setSubTitle($this->trans("title.email.validate.help",["%email%" => $entity->getEmail()]));
        $this->dynamicBuilderManager->addWidget($subTitleWidget);

        // $this->dispatch(\App\AppEvents::APP_USER_EMAIL_VALIDATE_PRE_SUCCESS,$this->newGenericEvent($entity));
    }

    public function persistFormValidate()
    {
        $entity = $this->getUser();
        // $this->dispatch(\App\AppEvents::APP_USER_EMAIL_VALIDATE_POST_SUCCESS,$this->newGenericEvent($entity));
        $this->userManager->updateUser($entity);
        // Response
        $jsonResponse = $this->newJsonResponse();
        $jsonResponse->setFlash(self::TYPE_SUCCESS,$this->trans('flash.validate.success'));
        $jsonResponse->setRedirect("/settings/security");
        $jsonResponse->setRefresh("refresh_session");
        return $jsonResponse;
    }

    public static function getName()
    {
        return "email";
    }
}
