<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class Product
{
    use MagicAccessors, Identifier;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $visible;

    /**
     * @ORM\Column(type="integer")
     */
    protected $order;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $image;

    /**
     * @ORM\Column(type="float")
     */
    protected $priceBetter;

    /**
     * @ORM\Column(type="float")
     */
    protected $priceWorse;

    /**
     * @ORM\ManyToMany(targetEntity="Order", mappedBy="products")
     */
    protected $orders;

    public function __construct()
    {
        $this->visible = true;
    }
}
