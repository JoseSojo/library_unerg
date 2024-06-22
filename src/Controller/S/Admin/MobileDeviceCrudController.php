<?php

namespace App\Controller\S\Admin;

use App\Entity\M\User\MobileDevice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MobileDeviceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MobileDevice::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'user.firstname', 'user.lastname', 'user.email'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id', 'ID');
        $type = TextField::new('type');
        $deviceId = TextField::new('deviceId');
        $osVersion = TextField::new('osVersion');
        $appVersion = TextField::new('appVersion');
        $model = TextField::new('model');
        $deviceInfo = TextField::new('deviceInfo');
        $registerId = TextField::new('registerId');
        $user = AssociationField::new('user');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $type, $deviceId, $osVersion, $appVersion, $model, $deviceInfo, $registerId, $user];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $type, $deviceId, $osVersion, $appVersion, $model, $deviceInfo, $registerId, $user];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [];
        }
    }
}
