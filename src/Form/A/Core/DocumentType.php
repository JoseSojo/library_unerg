<?php

namespace App\Form\A\Core;

use App\Form\AbstractFormApiType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormBuilderInterface as FormBuilderInterface2;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\M\Core\Document;

/**
 * Formulario de documento
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class DocumentType extends AbstractFormApiType
{
    /**
     * @param FormBuilderInterface2 $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('file', FileType::class, array(
                    'label' => 'Documento',
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Document::class
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'document';
    }
}
