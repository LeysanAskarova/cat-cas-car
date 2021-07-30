<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->create(User::class, function(User $user){
            $user
                ->setEmail('admin@catcascar.ru')
                ->setFirstname('admin')
                ->setPassword($this->userPasswordEncoder->encodePassword($user, '123456'))
                ->setRoles(['ROLE_ADMIN']);
        });
        $this->createMany(User::class, 10, function(User $user) {
            $user
                ->setEmail($this->faker->email)
                ->setFirstname($this->faker->firstName)
                ->setPassword($this->userPasswordEncoder->encodePassword($user, '123456'));
        });

        $manager->flush();
    }
}
