<?php

namespace Badger\UserBundle\DataFixtures\ORM;

use Badger\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author    Léo Benoist <leo.benoist@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class LoadUserData extends AbstractFixture
{
    /** @var ObjectManager */
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        
        $this->createUser('admin', 'admin@badger.test', ['ROLE_ADMIN']);
        $this->createUser('user', 'user@badger.test', ['ROLE_USER']);

        $this->manager->flush();
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $email
     * @param array  $roles
     *
     * @return User
     */
    private function createUser($username, $email, array $roles = [])
    {
        $user = new User();

        $user
            ->setUsername($username)
            ->setEmail($email)
            ->setPlainPassword('test')
            ->setEnabled(true)
            ->setRoles($roles)
        ;

        $user->setEmailCanonical($user->getEmail());
        $user->setUsernameCanonical($user->getUsername());

        $this->manager->persist($user);
        $this->addReference('user-'.strtolower($username), $user);

        return $user;
    }
}
