<?php

namespace App\Controller\S\Admin;

use App\Entity\M\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, KeyValueStore};
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{Field, IdField, DateField, DateTimeField, EmailField, TextField, TextareaField, AssociationField, FormField, NumberField};
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use Symfony\Component\Form\Extension\Core\Type\{PasswordType, RepeatedType};
use Symfony\Component\Form\{FormBuilderInterface, FormEvent, FormEvents};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('User')
            ->setSearchFields(['username', 'email', 'roles', 'firstname', 'lastname', 'identification', 'city', 'postalCode', 'address', 'phone'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;

        return parent::configureActions($actions)
            ->setPermission(Action::INDEX,'ROLE_ADMIN_USER_LIST')
            ->setPermission(Action::DETAIL,'ROLE_ADMIN_USER_SHOW')
            ->setPermission(Action::EDIT,'ROLE_ADMIN_USER_UPDATE')
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('username')
            ->add('email')
            ->add('firstname')
            ->add('identification')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $tabAuthor = FormField::addTab('Autor');
        $tabWork = FormField::addTab('Trabajo');
        $tabData = FormField::addTab('Datos Extra');

        $firstname = TextField::new('firstname')->setColumns(6)->setLabel('Nombre');
        $lastname = TextField::new('lastname')->setColumns(6)->setLabel('Apellido');
        $username = TextField::new('username')->setColumns(6)->setLabel('Usuario');
        $identification = TextField::new('identification')->setColumns(6)->setLabel('Identificación');
        $address = TextareaField::new('address')->setColumns(12)->setLabel('Dirección');
        $groups = AssociationField::new('groups')->setColumns(6)->setLabel('Permiso');
        // $enabled = Field::new('enabled')->setColumns(6)->setLabel('Activo');
        //$locked = Field::new('locked')->setColumns(6)->setLabel('Bloqueado');
        $lastLogin = DateTimeField::new('lastLogin')->setColumns(6)->setLabel('Ultima sesión');
        $passwordRequestedAt = DateTimeField::new('passwordRequestedAt')->setColumns(6)->setLabel('Petición contraseña');
        $createdAt = DateTimeField::new('createdAt')->setColumns(6)->setLabel('Creado el');
        $createdBy = AssociationField::new('createdBy')->setColumns(6)->setLabel('Creado por');
        $updatedAt = DateTimeField::new('updatedAt')->setColumns(6)->setLabel('Actualizado el');
        $updatedBy = AssociationField::new('updatedBy')->setColumns(6)->setLabel('Actualizado por');
        $email = TextField::new('email')->setColumns(6)->setLabel('Correo');

        $password = TextField::new('password')
            ->setColumns(6)
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => [ 'label' => 'Password' ],
                'second_options' => [ 'label' => 'Repeat Password' ],
            ])
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->onlyOnForms()
            ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$identification, $firstname, $lastname, $email];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$firstname, $lastname, $username, $email, $groups, $address, $lastLogin, $passwordRequestedAt, $createdAt, $createdBy, $updatedAt, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$firstname, $lastname, $username, $email, $groups, $identification, $password, $address,];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$firstname, $lastname, $username, $email, $identification, $groups, $password, $address];
        }
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addPasswordEventListener($formBuilder);
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() {
        return function($event) {
            $form = $event->getForm();
            if (!$form->isValid()) {
                return;
            }
            $password = $form->get('password')->getData();
            if ($password === null) {
                return;
            }

            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
    }
}
