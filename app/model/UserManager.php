<?php

namespace App\Model;

use App\Model\Entity\User;
use App\Model\Repository\Users;
use Nette;

/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{
    use Nette\SmartObject;

    /** @var Users */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }


    /**
     * Performs an authentication.
     * @param array $credentials ['email'=>$email, 'name'=>$name]
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($email, $name) = $credentials;

        $user = $this->users->getByEmail($email);

        if (!$user) {
            throw new Nette\Security\AuthenticationException('The user is not registered yet.', self::IDENTITY_NOT_FOUND);

        }

        return new Nette\Security\Identity(
            $user->getId(),
            $user->isAdmin ? ['admin'] : [],
            [
                'email' => $user->email,
                'name' => $user->name
            ]
        );
    }


    /**
     * Adds new user.
     * @param string $email
     * @param string $name
     * @return void
     * @throws DuplicateNameException
     */
    public function add($email, $name)
    {
        try {
            $this->users->add(User::create($email, $name));
        } catch (\Exception $e) {
            throw new DuplicateNameException('This email is already registered.');
        }
    }

}


class DuplicateNameException extends \Exception
{
}
