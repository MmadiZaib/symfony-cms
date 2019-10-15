<?php


namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUserData implements FixtureInterface, ContainerAwareInterface {


    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        //add admin user
        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@zcms.test');
        $admin->setPlainPassword('admin');
        $userManager->updatePassword($admin);
        $admin->setEnabled(1);
        $admin->setFirstName('Admin FirstName');
        $admin->setLastName('Admin LastName');
        $admin->setRoles(array('ROLE_SUPER_ADMIN'));
        $userManager->updateUser($admin);


        //add test user 1
        $test1 = $userManager->createUser();
        $test1->setUsername('test1');
        $test1->setEmail('test1@zcms.test');
        $test1->setPlainPassword('test1');
        $userManager->updatePassword($test1);
        $test1->setEnabled(1);
        $test1->setFirstName('test1 FirstName');
        $test1->setLastName('test1 LastName');
        $userManager->updateUser($test1);

        //add test user 2
        $test2 = $userManager->createUser();
        $test2->setUsername('test2');
        $test2->setEmail('test2@zcms.test');
        $test2->setPlainPassword('test1');
        $userManager->updatePassword($test2);
        $test2->setEnabled(1);
        $test2->setFirstName('test2 FirstName');
        $test2->setLastName('test2 LastName');
        $userManager->updateUser($test2);
    }

    /**
     * Sets the container.
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}