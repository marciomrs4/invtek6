<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Entity\User;

class UserFixtures extends Fixture
{
    private $userHash;
    
    public function __construct(UserPasswordHasherInterface $userHash)
    {
        $this->userHash = $userHash;
    }
    
    public function load(ObjectManager $manager): void
    {        
        $usuario1 = new User();
        
        $pass1 = $this->userHash->hashPassword($usuario1,'admin');
        
        $usuario1->setUsername('admin')
            ->setPassword($pass1)
            ->setRoles(array('ROLE_SUPER_ADMIN','ROLE_ADMIN','ROLE_USER'))
            ->eraseCredentials();

        $usuario2 = new User();

        $pass2 = $this->userHash->hashPassword($usuario1,'user');
        
        $usuario2->setUsername('user')
            ->setPassword($pass2)
            ->setRoles(['ROLE_USER'])
            ->eraseCredentials();

        $manager->persist($usuario1);
        $manager->persist($usuario2);


        $manager->flush();
    }
}
