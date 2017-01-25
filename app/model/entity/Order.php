<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;
use Nette\Utils\DateTime;

/**
 * @ORM\Entity
 */
class Order
{
    use MagicAccessors, Identifier;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdOn;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    protected $customer;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $prepaid;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="orders")
     */
    protected $products;

    /**
     * @ORM\Column(type="float")
     */
    protected $priceTotal;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="maintainedOrders")
     */
    protected $maintainedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $completedOn;

    public function __construct(User $customer, bool $prepaid, array $products, float $priceTotal)
    {
        $this->createdOn = new DateTime();
        $this->customer = $customer;
        $this->prepaid = $prepaid;
        $this->products = $products;
        $this->priceTotal = $priceTotal;
        $this->maintainedBy = null;
        $this->completedOn = null;
    }
}
