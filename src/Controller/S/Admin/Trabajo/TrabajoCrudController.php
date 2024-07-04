<?php

namespace App\Controller\S\Admin\Trabajo;

use App\Entity\M\Trabajo\Trabajo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\FormBuilderInterface;
use App\Model\EasyAdmin\Field\DocumentField;
use App\Repository\M\Trabajo\TrabajoRepository;

class TrabajoCrudController extends AbstractCrudController
{
    private $workRepository;

    public static function getEntityFqcn(): string
    {
        return Trabajo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Work')
            ->setEntityLabelInPlural('Works')
            ->setSearchFields(['title', 'resumen'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('resumenText')
            ->add('program')
            ->add('investigationLine')
            ->add('category')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $tabAuthor = FormField::addTab('Autor');
        $tabWork = FormField::addTab('Trabajo');
        $tabData = FormField::addTab('Datos Extra');

        $document = DocumentField::new('document')->setColumns(6)->setLabel('Trabajo');
        $resumenDoc = DocumentField::new('resumenDoc')->setColumns(6)->setLabel('Resumen');
        $title = TextField::new('title')->setColumns(6)->setLabel('Título');
        $category = AssociationField::new('category')->setColumns(6)->setLabel('Categoria');
        $investigationLine = AssociationField::new('investigationLine')->setColumns(6)->setLabel('InvestigationLine');
        $program = AssociationField::new('program')->setColumns(6)->setLabel('Program');
        $resumenText = TextareaField::new('resumenText')->setColumns(12)->setLabel('Resumen');
        $user = AssociationField::new('user')
            ->setColumns(6) 
            ->setLabel('Autor')
        ;
        $keyword = TextField::new('keyword')->setColumns(6)->setLabel('Palabras clave');
        $downloader = Field::new('downloader')->setColumns(6)->setLabel('Descargable');
        $isPublic = Field::new('public')->setColumns(6)->setLabel('Público');
        $date = DateField::new('date')->setColumns(6)->setLabel('Fecha');

        $createdAt = DateTimeField::new('createdAt')->setColumns(6);
        $createdBy = AssociationField::new('createdBy')->setColumns(6);
        $updatedAt = DateTimeField::new('updatedAt')->setColumns(6);
        $updatedBy = AssociationField::new('updatedBy')->setColumns(6);
        $createdIp = TextField::new('createdIp')->setColumns(6);
        $updatedIp = TextField::new('updatedIp')->setColumns(6);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $category, $investigationLine, $program];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            // $currentEntity = $this->getContext()->getEntity()->getInstance();
            return [
                $tabWork, $title, $category, $investigationLine, $resumenText, $keyword, $downloader, $isPublic, $date,
                $tabAuthor, $user,
                $tabData, $createdAt, $createdBy, $updatedAt, $updatedBy, $createdIp, $updatedIp
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $user, $title, 
                $program, $category, $investigationLine, $keyword, 
                $downloader, $isPublic, $resumenDoc, $document,
                $date, $resumenText,
        ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$user, $title, $program, $category, $investigationLine, $keyword, $keyword, $downloader, $isPublic, $resumenDoc, $resumenText,];
        }
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setWorkRepository(TrabajoRepository $workRepository)
    {
        $this->workRepository = $workRepository;
    }
}
