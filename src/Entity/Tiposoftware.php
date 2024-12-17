<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Tiposoftware
 *
 * @ORM\Table(name="tipoSoftware")
 * @ORM\Entity
 */
#[ORM\Table(name:'tipoSoftware')]
#[ORM\Entity]
class Tiposoftware
{
    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'descricao', length:45, nullable: false)]
    #[Assert\NotBlank(message: 'Este campo não deve ser vazio')]    
    private ?string $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Column(name: 'id')]
    #[ORM\Id]
    #[ORM\GeneratedValue]            
    private $id;



    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Tiposoftware
     */
    public function setDescricao($descricao): Tiposoftware
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getDescricao();
    }
}
