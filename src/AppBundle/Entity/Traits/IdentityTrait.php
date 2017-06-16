<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IdentityTrait
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
}
