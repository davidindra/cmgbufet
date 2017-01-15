<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\CreditRecord;

class CreditRecords extends Nette\Object
{
    private $em;
    private $creditRecords;
    private $users;

    public function __construct(EntityManager $em, Users $users)
    {
        $this->em = $em;
        $this->creditRecords = $em->getRepository(CreditRecord::class);
        $this->users = $users;
    }

    /**
     * Get user's actual credit balance
     * @param int $userId
     * @return int
     */
    public function getBalance($userId){
        $balance = 0;
        foreach($this->getByUser($userId) as $creditRecord){
            $balance += $creditRecord->value;
        }
        return $balance;
    }

    public function add(CreditRecord $creditRecord)
    {
        $this->em->persist($creditRecord)->flush();
    }

    /**
     * @return CreditRecord[]
     * @param bool $fromNewest order setting
     */
    public function getAll($fromNewest = false){
        return $this->creditRecords->findBy([], ['datetime' => $fromNewest ? 'DESC' : 'ASC']);
    }

    /**
     * @return CreditRecord[]
     * @param int $userId
     * @param bool $fromNewest order setting
     */
    public function getByUser($userId, $fromNewest = false){
        //return $this->users->getById($userId)->credits;
        return $this->creditRecords->findBy(['user' => $this->users->getById($userId)], ['datetime' => $fromNewest ? 'DESC' : 'ASC']);
    }

    /**
     * @param int $id
     * @return CreditRecord|null
     */
    public function getById($id){
        return $this->creditRecords->findOneBy(['id' => $id]);
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}
