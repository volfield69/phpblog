<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * UserFixtures constructor.
     *
     * @param ObjectManager                $manager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        ObjectManager $manager,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->manager = $manager;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getAllData() as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword($this->userPasswordEncoder->encodePassword(
                $user,
                $data['password']
            ));
            $user->setRoles($data['role']);
            $user->setActive($data['active']);

            $user->setNom($data['nom']);
            $user->setPrenom($data['prenom']);

            $this->manager->persist($user);
        }

        $this->manager->flush();
    }

    /**
     * @throws \Exception
     *
     * @return array
     */
    private function getAllData(): array
    {
        return [
            [
                'password' => 'test',
                'email' => 'nicolas@familleduc.fr',
                'role' => ['ROLE_USER', 'ROLE_ADMIN'],
                'active' => true,
                'nom' => 'Duc',
                'prenom' => 'Nicolas',
            ],
        ];
    }
}
