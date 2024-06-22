<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

/**
 * Modelo de formulario base para la API
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class AbstractFormApi extends AbstractFormType
{   
    protected $csrfProtection = false;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('accept', ButtonType::class, array(
                'label' => $options["button_accept_label"],
                'translation_domain' => 'messages',
                "attr" => [
                    "type" => "submit",
                    "class" => "btn btn-primary btn-block"
                ]
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            "csrf_protection" => $this->csrfProtection,
            "button_accept_label" => "button.accept"
        ));
    }
}
