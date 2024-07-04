<?php

namespace App\Model\EasyAdmin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use App\Form\A\Core\DocumentType;

class DocumentField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            // ->setTemplateName('crud/field/integer')
            ->setFormType(DocumentType::class)
            // ->addCssClass('field-integer')
            // ->setDefaultColumns('col-md-4 col-xxl-3')
            ;
    }
}