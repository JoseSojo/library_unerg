<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Maximosojo\ToolsBundle\DependencyInjection\ContainerAwareTrait;
use App\Entity\M\User\Account;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario base de la aplicacion
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class AbstractFormType extends AbstractType  
{
    use ContainerAwareTrait;
    
    /**
     * Formato a usar en lo datepicker
     * @var string
     */
    public static $formatDateHtml5 = "yyyy-MM-dd";
    // public function __construct(private \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage $usageTrackingTokenStorage)
    // {
    // }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "csrf_protection" => true,
            "translation_domain" => "messages",
            "cascade_validation" => true,
            "method" => "POST",
            "label" => "",
            "action" => "",
            "info" => "",
            "meta" => []
        ));
    }
    
    protected function getFormatDate()
    {
        return self::$formatDateHtml5;
    }
    
    /**
     * Opcion por defecto "placeholder" para los choices
     * @return string
     */
    protected function getChoiceEmptyValue()
    {
        return 'label.choice.empty';
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     *
     * @final since version 3.4
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        if (null === $token = $this->usageTrackingTokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }

    public function buildAmountAttr(Account $account, array $options = array())
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'help' => null
        ]);

        $options = $resolver->resolve($options);

        $attrs = [];
        $attrs["class"] = "number-format";
        $attrs["suffix"] = (string)$account->getCurrency();
        $attrs["help"] = $this->trans($options["help"],[],"labels");

        return $attrs;
    }
}
