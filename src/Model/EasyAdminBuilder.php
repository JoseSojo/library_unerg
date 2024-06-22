<?php 

namespace App\Model;

use Maximosojo\Bundle\BaseAdminBundle\Model\EasyAdminBuilder as BaseEasyAdminBuilder;
use App\Entity\M\Group;
use App\Entity\M\Core\Notifier\Mailer\Component;
use App\Entity\M\Core\Notifier\Mailer\Template;
use App\Entity\M\Master\Term;
use App\Entity\M\User;
use App\Entity\M\User\MobileDevice;
use App\Entity\M\Trabajo\Trabajo;
use App\Entity\M\Master\Trabajo\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Maximosojo\ToolsBundle\Entity\Option;

/**
 * 
 * EasyAdminBuilder
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class EasyAdminBuilder extends BaseEasyAdminBuilder
{
    public function configureAssets(): Assets
    {
        $assets = $this->buildAssets(self::EASYADMIN_THEME_CORK);
        return $assets;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Libreria')
            ->disableDarkMode()
            ;
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy h:mm:ss a')
            ->setTimeFormat('HH:mm');
    }

    public function configureMenuItems(): iterable
    {
        $menuUser = [
            MenuItem::linkToCrud('User', '', User::class)->setPermission('ROLE_ADMIN_USER_LIST'),
            MenuItem::linkToCrud('UserGroup', '', Group::class)->setPermission('ROLE_ADMIN_USER_GROUP_LIST'),
            // MenuItem::linkToCrud('MobileDevice', '', MobileDevice::class)->setPermission('ROLE_ADMIN_USER_DEVICE_LIST'),
        ];

        $menuTrabajo = [
            MenuItem::linkToCrud('Work', '', Trabajo::class)->setPermission('ROLE_ADMIN_WORK_LIST'),
            MenuItem::linkToCrud('Category', '', Category::class)->setPermission('ROLE_ADMIN_WORK_CATEGORY_LIST'),
        ];

        $menuCore = [
            MenuItem::linkToCrud('Option', '', Option::class),
            // MenuItem::linkToCrud('Term', '', Term::class),
        ];

        // $submenu5 = [
        //     MenuItem::linkToCrud('MailerTemplate', '', Template::class),
        //     MenuItem::linkToCrud('MailerComponent', '', Component::class),
        // ];

        yield MenuItem::subMenu('menu.user', 'fas fa-users')->setSubItems($menuUser);
        yield MenuItem::subMenu('menu.blog', 'fas fa-shield-alt')->setSubItems($menuTrabajo);
        yield MenuItem::subMenu('menu.core', 'fas fa-cog')->setSubItems($menuCore);
        // yield MenuItem::subMenu('menu.setting.email', 'fas fa-envelope')->setSubItems($submenu5);
        // yield MenuItem::linktoRoute('Stats', 'fa fa-chart-bar', 'fos_user_profile_show')->setPermission('ROLE_ADMIN_sUSER_LIST');
    }
}