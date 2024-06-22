<?php

namespace App\Services\User\Security\Processor;

use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\HttpFoundation\Request;
use App\Services\User\Security\SecurityProcessorInterface;
use Maximosojo\ToolsBundle\Component\FOS\RestBundle\View\FOSRestViewTrait;
use App\Services\BaseProcessor as MasterBaseProcessor;
use App\Entity\M\Master\User\Security\Method;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\FormWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\TitleWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\CardWidget;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\Widget\ButtonWidget;

/**
 * BaseProcessor
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class BaseProcessor extends MasterBaseProcessor implements SecurityProcessorInterface
{
    use FOSRestViewTrait;

    /**
     * Actualizar un método
     */
    public function update(Request $request, Method $entity)
    {
        $view = $this->view();
        $options = [];
        $options["action"] = $this->generateUrl("app_route_api_user_security_update",["id" => $entity->getId()]);
        $form = $this->createForm($this->getFormUpdateClass(),$this->getUser(),$options);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->persistFormUpdate();
            } else {
                $view->setData($form);
            }
        } else {
            $this->renderFormUpdate();
            
            $formWidget = new FormWidget();
            $formWidget->setData($form);
            $this->dynamicBuilderManager->addWidget($formWidget);

            $buttonWidget = new ButtonWidget();
            $buttonWidget->setTitle($this->trans("button.update"));
            $this->dynamicBuilderManager->addWidget($buttonWidget);
            
            $view->setData($this->dynamicBuilderManager->getWidgets());
        }
                
        return $view;
    }

    /**
     * Actualizar un método
     */
    public function validate(Request $request, Method $entity)
    {
        $view = $this->view();
        $options = [];
        $options["action"] = $this->generateUrl("app_route_api_user_security_validate",["id" => $entity->getId()]);
        $form = $this->createForm($this->getFormValidateClass(),$this->getUser(),$options);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                return $this->persistFormValidate();
            } else {
                $this->doFlush();
                $view->setData($form);
            }
        } else {
            $this->renderFormValidate();
            
            $formWidget = new FormWidget();
            $formWidget->setData($form);
            $this->dynamicBuilderManager->addWidget($formWidget);
            $view->setData($this->dynamicBuilderManager->getWidgets());
        }
                
        return $view;
    }

    public function getFormUpdateClass()
    {
        throw new NotImplementedException("Not implemented methor 'getFormUpdateClass'", 1);
    }

    public function renderFormUpdate()
    {
        throw new NotImplementedException("Not implemented methor 'renderFormUpdate'", 1);
    }

    public function persistFormUpdate()
    {
        throw new NotImplementedException("Not implemented methor 'persistFormUpdate'", 1);
    }

    public function getFormValidateClass()
    {
        throw new NotImplementedException("Not implemented methor 'getFormValidateClass'", 1);
    }

    public function renderFormValidate()
    {
        throw new NotImplementedException("Not implemented methor 'renderFormValidate'", 1);
    }

    public function persistFormValidate()
    {
        throw new NotImplementedException("Not implemented methor 'persistFormValidate'", 1);
    }

    /**
     * Valida un codigo segun el string enviado
     *
     * @param   Code    $code
     * @param   string  $string
     * @return  Bool    $success
     */
    public function isValidCode(Code $code, string $string):bool
    {
        // Valida codigo
        $success = (string)$string === (string)$code->getCode();
        if ($success == false) {
            $this->addError($this->trans("validators.security.code.invalid",[],"validators"));
        }

        return $success;
    }

    protected function getDefaultOptionsForm()
    {
        return [];
    }

    /**
     * Returns a NotFoundHttpException.
     *
     * This will result in a 404 response code. Usage example:
     *
     *     throw $this->createNotFoundException('Page not found!');
     *
     * @param string          $message  A message
     * @param \Exception|null $previous The previous exception
     *
     * @return NotFoundHttpException
     *
     * @final since version 3.4
     */
    protected function createNotFoundException($message = 'Not Found', \Exception $previous = null)
    {
        return new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException($message, $previous);
    }
}
