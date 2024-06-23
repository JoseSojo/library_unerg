<?php

namespace App\Controller\S\Admin;

use App\Entity\M\Group;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Group::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'name', 'description', 'roles'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name')->setLabel('Nombre');
        $description = TextField::new('description')->setLabel('Descripción');
        // $parents = AssociationField::new('parents')->setLabel('Parent');
        // $roles = ArrayField::new('roles')->setTemplatePath('bundles/EasyAdminBundle/fields/field_roles.html.twig');

        $roles = self::getRoles($this->getParameter("security.role_hierarchy.roles"));
        unset($roles["ROLE_ADMIN"]);
        unset($roles["ROLE_SUPER_ADMIN"]);
        unset($roles["ROLE_USER"]);

        $roles = ChoiceField::new('roles')->setChoices($roles)->renderExpanded()->allowMultipleChoices();

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $description, $roles];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$name, $description, $roles];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $description, $roles];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $description, $roles];
        }
    }

    /**
     * Retorna todos los roles disponibles para el usuario
     * @staticvar type $roles
     * @param array $rolesHierarchy
     * @return type
     */
    private static  function getRoles(array $rolesHierarchy,array $unset = ["ROLE_APP"])
    {
        static $roles = null;
        if(is_array($roles)){
            return $roles;
        }

        $roles = array();
        foreach ($rolesHierarchy as $key => $value) {
            $roles[$key] = $key;
        }
        array_walk_recursive($rolesHierarchy, function($val,$key) use (&$roles) {
            $roles[$val] = $val;
        });
        foreach ($unset as $val) {
            unset($roles[$val]);
        }
        return $roles = array_unique($roles);
    }
}
