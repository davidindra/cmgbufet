<?php
namespace App\Model\Repository;

use Nette;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Product;

class Products extends Nette\Object
{
    private $em;
    private $products;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->products = $em->getRepository(Product::class);
    }

    public function add(Product $product)
    {
        $this->em->persist($product)->flush();
    }

    /**
     * @return Product[]
     */
    public function getAll(){
        return $this->products->findBy(['visible' => true], ['order' => 'ASC']);
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function getById($id){
        return $this->products->findOneBy(['id' => $id]);
    }

    public function __destruct()
    {
        $this->em->flush();
    }
}
