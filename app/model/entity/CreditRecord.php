<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Kdyby\Doctrine\Entities\MagicAccessors;
use Nette\Utils\DateTime;

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

    public function __construct()
    {
        $this->datetime = new DateTime();
    }

    /**
     * Is this record positive?
     * @return bool
     */
    public function isPositive(){
        return $this->value >= 0;
    }

    /**
     * Is this record negative?
     * @return bool
     */
    public function isNegative(){
        return $this->value < 0;
    }
}
