<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    
    private $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher) 
    
    {
        $this -> hasher = $hasher;    
    
    }

    public function load(ObjectManager $manager)
    {
        $admin=new User();
        $admin->setUsername("admin");
        $admin->setPassword($this->hasher->hashPassword($admin,"123"));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $admin=new User();
        $admin->setUsername("user");
        $admin->setPassword($this->hasher->hashPassword($admin,"123"));
        $admin->setRoles(['ROLE_USER']);
        $manager->persist($admin);

        $manager->flush();
    }
}
