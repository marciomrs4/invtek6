<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marca
 *
 * @ORM\Table(name="marca")
 * @ORM\Entity
 */
#[ORM\Table(name:'marca')]
#[ORM\Entity]
class Marca
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    #[ORM\Column(name:'nome', length:45, nullable: false)]    
    private ?string $nome;

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
     * Set nome
     *
     * @param string $nome
     * @return Marca
     */
    public function setNome($nome): Marca
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome(): string
    {
        return $this->nome;
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
        return $this->getNome();
    }
}
