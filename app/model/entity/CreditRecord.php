<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;

/**
 * @ORM\Entity
 */
class CreditRecord
{
    use MagicAccessors, Identifier;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="credits")
     */
    protected $user;

    /**
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $datetime;
}
