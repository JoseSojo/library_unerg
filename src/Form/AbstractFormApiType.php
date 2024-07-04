<?php

namespace App\Form;

use App\Form\AbstractFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

/**
 * Modelo de formulario base para la API
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class AbstractFormApiType extends AbstractFormType
{   
    protected $csrfProtection = false;
    
}
