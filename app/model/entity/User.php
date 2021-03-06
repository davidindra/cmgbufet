<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class User
{
    use MagicAccessors, Identifier;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isAdmin;

    /**
     * @ORM\OneToMany(targetEntity="CreditRecord", mappedBy="user")
     */
    protected $credits;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="maintainedBy")
     */
    protected $maintainedOrders;

    public function __construct()
    {
        $this->isAdmin = false;
    }

    /**
     * Creates new pre-filled instance of this class
     * @param string $email
     * @param string $name
     * @return User
     */
    public static function create($email, $name)
    {
        $user = new User();
        $user->email = $email;
        $user->name = $name;
        return $user;
    }
}
