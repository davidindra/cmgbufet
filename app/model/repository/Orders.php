<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Order;

class Orders extends Nette\Object
{
    private $em;
    private $orders;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->orders = $em->getRepository(Order::class);
    }

    public function add(Order $order)
    {
        $this->em->persist($order)->flush();
    }

    /**
     * @return Order[]
     */
    public function getAll(){
        return $this->orders->findAll();
    }

    /**
     * @param int $id
     * @return Order|null
     */
    public function getById($id){
        return $this->orders->findOneBy(['id' => $id]);
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}
