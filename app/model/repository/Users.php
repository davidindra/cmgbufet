<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\User;

class Users extends Nette\Object
{
    private $em;
    private $users;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->users = $em->getRepository(User::class);
    }

    public function add(User $user)
    {
        if(!isset($user->email, $user->name)){
            throw new \Exception('User must have an email and a name.');
        }
        $this->em->persist($user)->flush();
    }

    public function getAll(){
        return $this->users->findAll();
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getByEmail($email){
        return $this->users->findOneBy(['email' => $email]);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getById($id){
        return $this->users->findOneBy(['id' => $id]);
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}
