<?php


namespace AppBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{

    public function createNewEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistEntity($user)
    {
        return $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateEntity($user)
    {
        return $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}