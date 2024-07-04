<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ButtonDownloadPdfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('downloadPdf', 'a', array(
            'label' => 'Descargar PDF',
            'attr' => array(
                'class' => 'btn btn-primary',
                'download' => 'Trabajo',
            ),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // No hay opciones para configurar
    }
}